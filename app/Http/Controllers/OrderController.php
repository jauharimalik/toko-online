<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AffiliateController;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Address;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\OrderDetail;
use App\Models\CouponUsage;
use App\Models\Coupon;
use App\Models\User;
use App\Models\CombinedOrder;
use App\Models\SmsTemplate;
use Auth;
use Mail;
use App\Mail\InvoiceEmailManager;
use App\Utility\NotificationUtility;
use CoreComponentRepository;
use App\Utility\SmsUtility;
use Illuminate\Support\Facades\Route;


require_once public_path('/mida/Midtrans.php');

use Midtrans\Config;
use Midtrans\Transaction;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource to seller.
     *
     * @return \Illuminate\Http\Response
     */

    
    public function index(Request $request)
    {
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $orders = DB::table('orders')
                    ->orderBy('code', 'desc')
//                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->where('seller_id', Auth::user()->id)
                    ->where('agen_level', "<", 1)
                    ->select('orders.id')
                    ->distinct();

        if ($request->payment_status != null){
            $orders = $orders->where('payment_status', $request->payment_status);
            $payment_status = $request->payment_status;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')){
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%'.$sort_search.'%');
        }

        $orders = $orders->paginate(15);

        foreach ($orders as $key => $value) {
            $order = \App\Order::find($value->id);
            $order->viewed = 1;
            $order->save();
        }

        return view('frontend.user.seller.orders', compact('orders','payment_status','delivery_status', 'sort_search'));
    }

    // All Orders
    public function all_orders(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();

        $date = $request->date;
        $sort_search = null;
        $delivery_status = null;
        $payment_status = '';

        $orders = Order::orderBy('id', 'desc');
        $admin_user_id = User::where('user_type', 'admin')->first()->id;


        if (
            Route::currentRouteName() == 'inhouse_orders.index' &&
            Auth::user()->can('view_inhouse_orders')
        ) {
            $orders = $orders->where('orders.seller_id', '=', $admin_user_id);
        } else if (
            Route::currentRouteName() == 'seller_orders.index' &&
            Auth::user()->can('view_seller_orders')
        ) {
            $orders = $orders->where('orders.seller_id', '!=', $admin_user_id);
        } else if (
            Route::currentRouteName() == 'pick_up_point.index' &&
            Auth::user()->can('view_pickup_point_orders')
        ) {
            $orders->where('shipping_type', 'pickup_point')->orderBy('code', 'desc');
            if (
                Auth::user()->user_type == 'staff' &&
                Auth::user()->staff->pick_up_point != null
            ) {
                $orders->where('shipping_type', 'pickup_point')
                    ->where('pickup_point_id', Auth::user()->staff->pick_up_point->id);
            }
        } else if (
            Route::currentRouteName() == 'all_orders.index' &&
            Auth::user()->can('view_all_orders')
        ) {
        } else {
            abort(403);
        }

        if ($request->search) {
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
        }

        if ($request->payment_status != null) {
            if(strtolower($request->payment_status) == "paid"){

                $orders = $orders->where('payment_status','paid');
            }else{
                $orders = $orders->where('payment_status','!=','paid');
            }
            $payment_status = $request->payment_status;
        }
        
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($date != null) {
            $orders = $orders->where('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])) . '  00:00:00')
                ->where('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])) . '  23:59:59');
        }
        $orders = $orders->paginate(15);
        return view('backend.sales.index', compact('orders', 'sort_search', 'payment_status', 'delivery_status', 'date'));
    }

    public function all_orders_show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        $code = $order->code;

        $order_shipping_address = json_decode($order->shipping_address);
        $delivery_boys = User::where('city', $order_shipping_address->city)
                ->where('user_type', 'delivery_boy')
                ->get();

        $orders = Order::where('code',$code)->get();
        $order_detail = OrderDetail::where('order_id',$order->id);
        foreach($orders as $ork => $orv){
            $order_detail = $order_detail->orwhere('order_id',$orv->id);
        }                
        $order_detail = $order_detail->get();

        $subtotal = array_sum(array_column(json_decode($order_detail), 'price'));
        $tax = array_sum(array_column(json_decode($order_detail), 'tax'));
        $ongkir = array_sum(array_column(json_decode($orders), 'ongkir'));
         
         return view('backend.sales.all_orders.show', compact('orders','subtotal','tax','ongkir','order','order_detail','delivery_boys'));
    }

    // Inhouse Orders
    public function admin_orders(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();

        $date = $request->date;
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $admin_user_id = User::where('user_type', 'admin')->first()->id;
        $orders = DB::table('orders')
                    ->orderBy('code', 'desc')
//                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->where('seller_id', $admin_user_id)
                    ->select('orders.id')
                    ->distinct();

        if ($request->payment_type != null){
            $orders = $orders->where('payment_status', $request->payment_type);
            $payment_status = $request->payment_type;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')){
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%'.$sort_search.'%');
        }
        if ($date != null) {
            $orders = $orders->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }

        $orders = $orders->where('agen_level', "<", 1)->paginate(15);
        return view('backend.sales.inhouse_orders.index', compact('orders','payment_status','delivery_status', 'sort_search', 'admin_user_id', 'date'));
    }
    public function show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        $code = $order->code;
        $order_shipping_address = json_decode($order->shipping_address);
        $delivery_boys = User::where('city', $order_shipping_address->city)
            ->where('user_type', 'delivery_boy')
            ->get();

        $ongkir = ($order->ongkir);
        $order->viewed = 1;
        $order->save();
        
        $orders = Order::where('code',$code)->get();
        $order_detail = OrderDetail::where('order_id',$order->id);
        foreach($orders as $ork => $orv){
            $order_detail = $order_detail->orwhere('order_id',$orv->id);
        }                
        $order_detail = $order_detail->get();

        $subtotal = array_sum(array_column(json_decode($order_detail), 'price'));
        $tax = array_sum(array_column(json_decode($order_detail), 'tax'));
        $ongkir = array_sum(array_column(json_decode($orders), 'ongkir'));

        return view('backend.sales.show',  compact('orders','subtotal','tax','ongkir','order','order_detail','delivery_boys'));
    }


    public function bulk_order_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $order_id) {
                $this->destroy($order_id);
            }
        }

        return 1;
    }

    // Seller Orders
    public function seller_orders(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();

        $date = $request->date;
        $seller_id = $request->seller_id;
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $admin_user_id = User::where('user_type', 'admin')->first()->id;
        $orders = DB::table('orders')
                    ->orderBy('code', 'desc')
//                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->where('orders.seller_id', '!=' ,$admin_user_id)
                    ->select('orders.id')
                    ->distinct();

        if ($request->payment_type != null){
            $orders = $orders->where('orders.payment_status', $request->payment_type);
            $payment_status = $request->payment_type;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')){
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%'.$sort_search.'%');
        }
        if ($date != null) {
            $orders = $orders->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }
        if ($seller_id) {
            $orders = $orders->where('seller_id', $seller_id);
        }

        $orders = $orders->paginate(15);
        return view('backend.sales.seller_orders.index', compact('orders', 'payment_status', 'delivery_status', 'sort_search', 'admin_user_id', 'seller_id', 'date'));
    }

    public function seller_orders_show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        $order->viewed = 1;
        $order->save();
        return view('backend.sales.seller_orders.show', compact('order'));
    }


    // Pickup point orders
    public function pickup_point_order_index(Request $request)
    {
        $date = $request->date;
        $sort_search = null;

        if (Auth::user()->user_type == 'staff' && Auth::user()->staff->pick_up_point != null) {
            //$orders = Order::where('pickup_point_id', Auth::user()->staff->pick_up_point->id)->get();
            $orders = DB::table('orders')
                        ->orderBy('code', 'desc')
                        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                        ->where('order_details.pickup_point_id', Auth::user()->staff->pick_up_point->id)
                        ->select('orders.id')
                        ->distinct();

            if ($request->has('search')){
                $sort_search = $request->search;
                $orders = $orders->where('code', 'like', '%'.$sort_search.'%');
            }
            if ($date != null) {
                $orders = $orders->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
            }

            $orders = $orders->paginate(15);

            return view('backend.sales.pickup_point_orders.index', compact('orders', 'sort_search', 'date'));
        }
        else{
            //$orders = Order::where('shipping_type', 'Pick-up Point')->get();
            $orders = DB::table('orders')
                        ->orderBy('code', 'desc')
                        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                        ->where('order_details.shipping_type', 'pickup_point')
                        ->select('orders.id')
                        ->distinct();

            if ($request->has('search')){
                $sort_search = $request->search;
                $orders = $orders->where('code', 'like', '%'.$sort_search.'%');
            }
            if ($date != null) {
                $orders = $orders->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
            }

            $orders = $orders->paginate(15);

            return view('backend.sales.pickup_point_orders.index', compact('orders', 'sort_search', 'date'));
        }
    }

    public function pickup_point_order_sales_show($id)
    {
        if (Auth::user()->user_type == 'staff') {
            $order = Order::findOrFail(decrypt($id));
            return view('backend.sales.pickup_point_orders.show', compact('order'));
        }
        else{
            $order = Order::findOrFail(decrypt($id));
            return view('backend.sales.pickup_point_orders.show', compact('order'));
        }
    }

    /**
     * Display a single sale to admin.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        foreach($request->asal as $asalk => $asalv){
            
            $kurir0 = ($request->kurir_pengiriman) ? explode("-",$request->kurir_pengiriman[$asalk]) : "";
            $ongkir_kurir = $kurir0[0] ?? 0;
            $ongkir_jenis = $kurir0[1] ?? "";

            $user = Auth::user();
            $order = new Order;
            if(Auth::check()){ $order->user_id = Auth::user()->id; }
            else{ $order->guest_id = mt_rand(100000, 999999);}
            
            $carts = Cart::where('user_id', Auth::user()->id)->where('owner_id', $asalk)->get();
            $subtotal = array_sum(array_column(json_decode($carts), 'price'));
            $tax = array_sum(array_column(json_decode($carts), 'tax')) ?? 0;
            $shipping_info = Address::where('user_id', $user->id)->first();
            $shipping_info->name = Auth::user()->name;
            $shipping_info->email = Auth::user()->email;
            
            $order->alamattoko = $asalv;
            $order->seller_id = $asalk;
            $order->shipping_address = json_encode($shipping_info);
            $shipping = $request->ongkir[$asalv] ?? 0;

            $order->payment_type = $request->payment_option;
            $order->delivery_viewed = '0';
            $order->payment_status_viewed = '0';
            $order->code = $request->code;
            $order->date = strtotime('now');
            $order->ongkir = $shipping;
            $order->pengiriman_kurir = $ongkir_kurir;
            $order->pengiriman_jenis = $ongkir_jenis;
            $order->metode_pembayaran = $request->metode_pembayaran;
            $order->nomor_pembayaran = $request->nomor_pembayaran;
            $order->bantuan_pdf = $request->file_pdf;
            $order->grand_total = $subtotal + $tax + $shipping;

            if($order->save()){
                $subtotal = 0;
                $tax = 0;
                $shipping = 0;
    
                //calculate shipping is to get shipping costs of different types
                $admin_products = array();
                $seller_products = array();
    
                //Order Details Storing
                foreach ($carts as $key => $cartItem){
                    $product = Product::find($cartItem['product_id']);
    
                    if($product->added_by == 'admin') {
                        array_push($admin_products, $cartItem['product_id']);
                    }
                    else {
                        $product_ids = array();
                        if(array_key_exists($product->user_id, $seller_products)){
                            $product_ids = $seller_products[$product->user_id];
                        }
                        array_push($product_ids, $cartItem['product_id']);
                        $seller_products[$product->user_id] = $product_ids;
                    }
    
                    $subtotal += $cartItem['price']*$cartItem['quantity'];
                    $tax += $cartItem['tax']*$cartItem['quantity'];
    
                    $product_variation = $cartItem['variation'];
    
                    $product_stock = $product->stocks->where('variant', $product_variation)->first();
                    if($product->digital != 1 &&  $cartItem['quantity'] > $product_stock->qty) {
                        flash(translate('The requested quantity is not available for ').$product->getTranslation('name'))->warning();
                        $order->delete();
                        return redirect()->route('cart')->send();
                    }
                    else {
                        $product_stock->qty -= $cartItem['quantity'];
                        $product_stock->save();
                    }
    
                    $order_detail = new OrderDetail;
                    $order_detail->order_id  = $order->id;
                    $order_detail->seller_id = $product->user_id;
                    $order_detail->product_id = $product->id;
                    $order_detail->variation = $product_variation;
                    $order_detail->price = $cartItem['price'] * $cartItem['quantity'];
                    $order_detail->tax = $cartItem['tax'] * $cartItem['quantity'];
                    $order_detail->shipping_type = $cartItem['shipping_type'];
                    $order_detail->product_referral_code = $cartItem['product_referral_code'];
                    
                    $order_detail->shipping_cost = $cartItem['shipping_cost'];
                    
                    if($product->is_quantity_multiplied == 1 && get_setting('shipping_type') == 'product_wise_shipping') {
                        $order_detail->shipping_cost = $order_detail->shipping_cost * $cartItem['quantity'];
                    }
                    //$shipping += $order_detail->shipping_cost;
    
                    if ($cartItem['shipping_type'] == 'pickup_point') {
                        $order_detail->pickup_point_id = $cartItem['pickup_point'];
                    }
                    //End of storing shipping cost
    
                    $order_detail->quantity = $cartItem['quantity'];
                    $order_detail->save();
    
                    $product->num_of_sale++;
                    $product->save();
                    
                    if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && 
                            \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {
                                
                        if($order_detail->product_referral_code) {
                            $referred_by_user = User::where('referral_code', $order_detail->product_referral_code)->first();
                            $affiliateController = new AffiliateController;
                            $affiliateController->processAffiliateStats($referred_by_user->id, 0, $order_detail->quantity, 0, 0);
                        }
                    }
                }

    /*
                if ($carts->first()->coupon_code != '') {
    //            if(Session::has('club_point')){
                    $order->grand_total -= $carts->sum('discount');
                    $order->club_point = Session::get('club_point');
                    $order->coupon_discount = $carts->sum('discount');
                    
                    $clubpointController = new ClubPointController;
                    $clubpointController->deductClubPoints($order->user_id, Session::get('club_point'));
                    
                    $coupon_usage = new CouponUsage;
                    $coupon_usage->user_id = Auth::user()->id;
                    $coupon_usage->coupon_id = Coupon::where('code', $carts->first()->coupon_code)->first()->id;
                    $coupon_usage->save();
                }
*/
                $array['view'] = 'emails.invoice';
                $array['subject'] = translate('Your order has been placed').' - '.$order->code;
                $array['from'] = env('MAIL_FROM_ADDRESS');
                $array['order'] = $order;


                foreach($seller_products as $key => $seller_product){
                    try {
                        Mail::to(\App\User::find($key)->email)->queue(new InvoiceEmailManager($array));
                    } catch (\Exception $e) {

                    }
                }

                if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_order')->first()->value){
                    try {
                        $otpController = new OTPVerificationController;
                        $otpController->send_order_code($order);
                    } catch (\Exception $e) {

                    }
                }

                //sends email to customer with the invoice pdf attached
                if(env('MAIL_USERNAME') != null){
                    try {
                        Mail::to(Auth::user()->email)->queue(new InvoiceEmailManager($array));
                        Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new InvoiceEmailManager($array));
                    } catch (\Exception $e) {

                    }
                }
                
            }


            $request->session()->put('order_id', $order->id);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if($order != null){
            foreach($order->orderDetails as $key => $orderDetail){
                try {
                    
                    $product_stock = ProductStock::where('product_id', $orderDetail->product_id)->where('variant', $orderDetail->variation)->first();
                    if($product_stock != null){
                        $product_stock->qty += $orderDetail->quantity;
                        $product_stock->save();
                    }
                    
                } catch (\Exception $e) {

                }

                $orderDetail->delete();
            }
            $order->delete();
            flash(translate('Order has been deleted successfully'))->success();
        }
        else{
            flash(translate('Something went wrong'))->error();
        }
        return back();
    }

    public function order_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->save();
        return view('frontend.user.seller.order_details_seller', compact('order'));
    }


    public function updateresi(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->resi = $request->resi;
        $order->save();
        return 1;
        
    }

    public function update_delivery_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->delivery_viewed = '0';
        $order->delivery_status = $request->status;
        $order->save();

        if ($request->status == 'cancelled' && $order->payment_type == 'wallet') {
            $user = User::where('id', $order->user_id)->first();
            $user->balance += $order->grand_total;
            $user->save();
        }

        if (
            $order->payment_status == 'paid' &&
            $order->delivery_status == 'delivered' &&
            $order->commission_calculated == 0
        ) {
            calculateCommissionAffilationClubPoint($order);
        }

        if (Auth::user()->user_type == 'seller') {
            foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail) {
                $orderDetail->delivery_status = $request->status;
                $orderDetail->save();

                if ($request->status == 'cancelled') {
                    $variant = $orderDetail->variation;
                    if ($orderDetail->variation == null) {
                        $variant = '';
                    }

                    $product_stock = ProductStock::where('product_id', $orderDetail->product_id)
                        ->where('variant', $variant)
                        ->first();

                    if ($product_stock != null) {
                        $product_stock->qty += $orderDetail->quantity;
                        $product_stock->save();
                    }
                }
            }
        } else {
            foreach ($order->orderDetails as $key => $orderDetail) {

                $orderDetail->delivery_status = $request->status;
                $orderDetail->save();

                if ($request->status == 'cancelled') {
                    $variant = $orderDetail->variation;
                    if ($orderDetail->variation == null) {
                        $variant = '';
                    }

                    $product_stock = ProductStock::where('product_id', $orderDetail->product_id)
                        ->where('variant', $variant)
                        ->first();

                    if ($product_stock != null) {
                        $product_stock->qty += $orderDetail->quantity;
                        $product_stock->save();
                    }
                }

                if (addon_is_activated('affiliate_system')) {
                    if (($request->status == 'delivered' || $request->status == 'cancelled') &&
                        $orderDetail->product_referral_code
                    ) {

                        $no_of_delivered = 0;
                        $no_of_canceled = 0;

                        if ($request->status == 'delivered') {
                            $no_of_delivered = $orderDetail->quantity;
                        }
                        if ($request->status == 'cancelled') {
                            $no_of_canceled = $orderDetail->quantity;
                        }

                        $referred_by_user = User::where('referral_code', $orderDetail->product_referral_code)->first();

                        $affiliateController = new AffiliateController;
                        $affiliateController->processAffiliateStats($referred_by_user->id, 0, 0, $no_of_delivered, $no_of_canceled);
                    }
                }
            }
        }
        if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'delivery_status_change')->first()->status == 1) {
            try {
                SmsUtility::delivery_status_change(json_decode($order->shipping_address)->phone, $order);
            } catch (\Exception $e) {
            }
        }

        //sends Notifications to user
        NotificationUtility::sendNotification($order, $request->status);
        if (get_setting('google_firebase') == 1 && $order->user->device_token != null) {
            $request->device_token = $order->user->device_token;
            $request->title = "Order updated !";
            $status = str_replace("_", "", $order->delivery_status);
            $request->text = " Your order {$order->code} has been {$status}";

            $request->type = "order";
            $request->id = $order->id;
            $request->user_id = $order->user->id;

            NotificationUtility::sendFirebaseNotification($request);
        }


        if (addon_is_activated('delivery_boy')) {
            if (Auth::user()->user_type == 'delivery_boy') {
                $deliveryBoyController = new DeliveryBoyController;
                $deliveryBoyController->store_delivery_history($order);
            }
        }

        return 1;
    }

    public function update_tracking_code(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->tracking_code = $request->tracking_code;
        $order->save();

        return 1;
    }

    public function update_payment_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->payment_status_viewed = '0';
        $order->save();

        if (Auth::user()->user_type == 'seller') {
            foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail) {
                $orderDetail->payment_status = $request->status;
                $orderDetail->save();
            }
        } else {
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->payment_status = $request->status;
                $orderDetail->save();
            }
        }

        $status = 'paid';
        foreach ($order->orderDetails as $key => $orderDetail) {
            if ($orderDetail->payment_status != 'paid') {
                $status = 'unpaid';
            }
        }
        $order->payment_status = $status;
        $order->save();


        if (
            $order->payment_status == 'paid' &&
            $order->delivery_status == 'delivered' &&
            $order->commission_calculated == 0
        ) {
            calculateCommissionAffilationClubPoint($order);
        }

        //sends Notifications to user
        NotificationUtility::sendNotification($order, $request->status);
        if (get_setting('google_firebase') == 1 && $order->user->device_token != null) {
            $request->device_token = $order->user->device_token;
            $request->title = "Order updated !";
            $status = str_replace("_", "", $order->payment_status);
            $request->text = " Your order {$order->code} has been {$status}";

            $request->type = "order";
            $request->id = $order->id;
            $request->user_id = $order->user->id;

            NotificationUtility::sendFirebaseNotification($request);
        }


        if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'payment_status_change')->first()->status == 1) {
            try {
                SmsUtility::payment_status_change(json_decode($order->shipping_address)->phone, $order);
            } catch (\Exception $e) {
            }
        }
        return 1;
    }

    public function assign_delivery_boy(Request $request)
    {
        if (addon_is_activated('delivery_boy')) {

            $order = Order::findOrFail($request->order_id);
            $order->assign_delivery_boy = $request->delivery_boy;
            $order->delivery_history_date = date("Y-m-d H:i:s");
            $order->save();

            $delivery_history = \App\Models\DeliveryHistory::where('order_id', $order->id)
                ->where('delivery_status', $order->delivery_status)
                ->first();

            if (empty($delivery_history)) {
                $delivery_history = new \App\Models\DeliveryHistory;

                $delivery_history->order_id = $order->id;
                $delivery_history->delivery_status = $order->delivery_status;
                $delivery_history->payment_type = $order->payment_type;
            }
            $delivery_history->delivery_boy_id = $request->delivery_boy;

            $delivery_history->save();

            if (env('MAIL_USERNAME') != null && get_setting('delivery_boy_mail_notification') == '1') {
                $array['view'] = 'emails.invoice';
                $array['subject'] = translate('You are assigned to delivery an order. Order code') . ' - ' . $order->code;
                $array['from'] = env('MAIL_FROM_ADDRESS');
                $array['order'] = $order;

                try {
                    Mail::to($order->delivery_boy->email)->queue(new InvoiceEmailManager($array));
                } catch (\Exception $e) {
                }
            }

            if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'assign_delivery_boy')->first()->status == 1) {
                try {
                    SmsUtility::assign_delivery_boy($order->delivery_boy->phone, $order->code);
                } catch (\Exception $e) {
                }
            }
        }

        return 1;
    }
}
