<?php

namespace App\Http\Controllers;

use App\Utility\PayfastUtility;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Category;
use App\City;
use App\Kurir;
use App\Rajaongkir;
use App\Cart;
use App\Product;
use App\Http\Controllers\ClubPointController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PublicSslCommerzPaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AffiliateController;
use App\Order;
use App\OrderDetail;
use App\CommissionHistory;
use App\BusinessSetting;
use App\Coupon;
use App\CouponUsage;
use App\User;
use App\Address;
use Session;
use App\Utility\PayhereUtility;
use App\Mobiledetect;

require_once public_path('/mida/Midtrans.php');

use Midtrans\Config;
use Midtrans\Snap;


class CheckoutController extends Controller
{

    public function __construct()
    {
        //
    }

    //check the selected payment gateway and redirect to that controller accordingly
    public function checkout(Request $request)
    {
        if ($request->payment_option != null) {

            $orderController = new OrderController;

            $orderController->store($request);

            $request->session()->put('payment_type', 'cart_payment');

            if ($request->session()->get('order_id') != null) {
                if ($request->payment_option == 'paypal') {
                    $paypal = new PaypalController;
                    return $paypal->getCheckout();
                } elseif ($request->payment_option == 'stripe') {
                    $stripe = new StripePaymentController;
                    return $stripe->stripe();
                } elseif ($request->payment_option == 'sslcommerz') {
                    $sslcommerz = new PublicSslCommerzPaymentController;
                    return $sslcommerz->index($request);
                } elseif ($request->payment_option == 'instamojo') {
                    $instamojo = new InstamojoController;
                    return $instamojo->pay($request);
                } elseif ($request->payment_option == 'razorpay') {
                    $razorpay = new RazorpayController;
                    return $razorpay->payWithRazorpay($request);
                } elseif ($request->payment_option == 'paystack') {
                    $paystack = new PaystackController;
                    return $paystack->redirectToGateway($request);
                } elseif ($request->payment_option == 'voguepay') {
                    $voguePay = new VoguePayController;
                    return $voguePay->customer_showForm();
                } elseif ($request->payment_option == 'payhere') {
                    $order = Order::findOrFail($request->session()->get('order_id'));

                    $order_id = $order->id;
                    $amount = $order->grand_total;
                    $first_name = json_decode($order->shipping_address)->name;
                    $last_name = 'X';
                    $phone = json_decode($order->shipping_address)->phone;
                    $email = json_decode($order->shipping_address)->email;
                    $address = json_decode($order->shipping_address)->address;
                    $city = json_decode($order->shipping_address)->city;

                    return PayhereUtility::create_checkout_form($order_id, $amount, $first_name, $last_name, $phone, $email, $address, $city);
                } elseif ($request->payment_option == 'payfast') {
                    $order = Order::findOrFail($request->session()->get('order_id'));

                    $order_id = $order->id;
                    $amount = $order->grand_total;

                    return PayfastUtility::create_checkout_form($order_id, $amount);
                } else if ($request->payment_option == 'ngenius') {
                    $ngenius = new NgeniusController();
                    return $ngenius->pay();
                } else if ($request->payment_option == 'iyzico') {
                    $iyzico = new IyzicoController();
                    return $iyzico->pay();
                } else if ($request->payment_option == 'nagad') {
                    $nagad = new NagadController;
                    return $nagad->getSession();
                } else if ($request->payment_option == 'bkash') {
                    $bkash = new BkashController;
                    return $bkash->pay();
                }
                 else if ($request->payment_option == 'flutterwave') {
                    $flutterwave = new FlutterwaveController();
                    return $flutterwave->pay();
                } else if ($request->payment_option == 'mpesa') {
                    $mpesa = new MpesaController();
                    return $mpesa->pay();
                } elseif ($request->payment_option == 'paytm') {
                    $paytm = new PaytmController;
                    return $paytm->index();
                } elseif ($request->payment_option == 'cash_on_delivery') {
                    
                    $request->session()->forget('club_point');

                    flash(translate("Your order has been placed successfully"))->success();
                    return redirect()->route('order_confirmed');
                } elseif ($request->payment_option == 'wallet') {
                    $user = Auth::user();
                    $order = Order::findOrFail($request->session()->get('order_id'));
                    if ($user->balance >= $order->grand_total) {
                        $user->balance -= $order->grand_total;
                        $user->save();
                        return $this->checkout_done($request->session()->get('order_id'), null);
                    }
                } else {
                    $user = Auth::user();
                    $order = Order::findOrFail($request->session()->get('order_id'));
                    $order->ann = $request->ann ?? "Tamu";
                    $order->manual_payment = 1;
                    $order->save();

                    if ($user->balance >= $order->grand_total) {
                        $user->balance -= $order->grand_total;
                        $user->save();
                        //return $this->checkout_done($request->session()->get('order_id'), null);
                    }
                    
                    $request->session()->forget('club_point');

                    flash(translate('Your order has been placed successfully. Please submit payment information from purchase history'))->success();
                    return redirect()->route('order_confirmed');
                }
            }
        } else {
            flash(translate('Select Payment Option.'))->warning();
            return back();
        }
    }

    //redirects to this method after a successfull checkout
    public function checkout_done($order_id, $payment)
    {
        $order = Order::findOrFail($order_id);
        $order->payment_status = 'paid';
        $order->payment_details = $payment;
        $order->save();

        if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {
            $affiliateController = new AffiliateController;
            $affiliateController->processAffiliatePoints($order);
        }

        if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated) {
            if (Auth::check()) {
                $clubpointController = new ClubPointController;
                $clubpointController->processClubPoints($order);
            }
        }
        if (\App\Addon::where('unique_identifier', 'seller_subscription')->first() == null || 
                !\App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated) {
            
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->payment_status = 'paid';
                $orderDetail->save();
                $commission_percentage = 0;
                
                if (get_setting('category_wise_commission') != 1) {
                    $commission_percentage = get_setting('vendor_commission');
                } else if ($orderDetail->product->user->user_type == 'seller') {
                    $commission_percentage = $orderDetail->product->category->commision_rate;
                }
                
                if ($orderDetail->product->user->user_type == 'seller') {
                    $seller = $orderDetail->product->user->seller;
                    $admin_commission = ($orderDetail->price * $commission_percentage)/100;
                    
                    if (get_setting('product_manage_by_admin') == 1) {
                        $seller_earning = ($orderDetail->tax + $orderDetail->price) - $admin_commission;
                        $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->tax + $orderDetail->price) - $admin_commission;
                    } else {
                        $seller_earning = $orderDetail->tax + $orderDetail->shipping_cost + $orderDetail->price - $admin_commission;
                        $seller->admin_to_pay = $seller->admin_to_pay - $admin_commission;
                    }
//                    $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price * (100 - $commission_percentage)) / 100 + $orderDetail->tax + $orderDetail->shipping_cost;
                    $seller->save();

                    $commission_history = new CommissionHistory;
                    $commission_history->order_id = $order->id;
                    $commission_history->order_detail_id = $orderDetail->id;
                    $commission_history->seller_id = $orderDetail->seller_id;
                    $commission_history->admin_commission = $admin_commission;
                    $commission_history->seller_earning = $seller_earning;

                    $commission_history->save();
                }
                
            }
            
        } else {
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->payment_status = 'paid';
                $orderDetail->save();
                if ($orderDetail->product->user->user_type == 'seller') {
                    $seller = $orderDetail->product->user->seller;
                    $seller->admin_to_pay = $seller->admin_to_pay + $orderDetail->price + $orderDetail->tax + $orderDetail->shipping_cost;
                    $seller->save();
                }
            }
        }

        $order->commission_calculated = 1;
        $order->save();
        
        Cart::where('owner_id', $order->seller_id)
                ->where('user_id', $order->user_id)
                ->delete();
        
        Session::forget('club_point');


        flash(translate('Payment completed'))->success();
        return view('frontend.order_confirmed', compact('order'));
    }

    public function get_shipping_info(Request $request)
    {
        $carts = Cart::where('user_id', Auth::user()->id)->get();
//        if (Session::has('cart') && count(Session::get('cart')) > 0) {
        if ($carts && count($carts) > 0) {
            $categories = Category::all();
            return view('frontend.shipping_info', compact('categories', 'carts'));
        }
        flash(translate('Your cart is empty'))->success();
        return back();
    }

    public function cekongkir(Request $request){
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $data_seller = [];

        $pengirim_id = $request->asal;
        $shipping_asal = json_decode(Address::where('id',  $pengirim_id)->first())->city;
        $kota_asal_id = City::where('name', $shipping_asal)->first()->id;

        $kota_id = $request->tujuan;
        $panel = $request->panel;

        // Your Eloquent query executed by using get()
        $cek_ongkir_dulu  = Kurir::where('ongkir_asal', $kota_asal_id)->where('ongkir_tujuan', $kota_id)->get();
        $rong = new Rajaongkir;
        $ongkir = $rong->cekongkir(array($kota_id,"city"),1000,$kota_asal_id);
        $ongkir_decode = json_decode($ongkir);
        

        if($cek_ongkir_dulu->count() < 1){  
           
            
            foreach($ongkir_decode as $key_ongkir => $val_ongkir){
                $ongkir_alur = Kurir::create(array(
                    'ongkir_asal' => $kota_asal_id,
                    'ongkir_tujuan' =>  $kota_id,
                    'ongkir_kurir' =>  $val_ongkir->kurir,
                    'ongkir_jenis' => 
                     $val_ongkir->jenis,
                    'ongkir_tarif' =>  $val_ongkir->tarif,
                    'ongkir_est' =>    $val_ongkir->est,
                ));
                
            }   
            
        }

        $cek_ongkir  = Kurir::where('ongkir_asal', $kota_asal_id)->where('ongkir_tujuan', $kota_id)->get();

        $berat = $request->berat;

        return view('frontend.tarifongkir', compact('cek_ongkir','berat','panel','pengirim_id'));
    }

    public function group_by($key, $data) {
        $result = array();
    
        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }
    
        return $result;
    }

    public function store_shipping_info(Request $request)
    {   
        $tujuan = $request->address_id ?? null;
        
        $shipping_info = json_decode(Address::where('id',  $request->address_id)->first())->city;
        $kota_id = City::where('name', $shipping_info)->first()->id;

        if ($tujuan == null) {
            flash(translate("Please add shipping address"))->warning();
            return back();
        }
        
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $data_seller = [];
        $newarr = [];

        
        foreach ($carts as $key => $cartItem) {
            $cartItem->address_id = $tujuan;
            $info = Product::where('id',$cartItem->product_id)->first();
            $seller['nama_produk'] = $info->name;
            $seller['price'] = $cartItem->price;
            $seller['berat'] = ceil(($cartItem->berat * $cartItem->quantity) / 1000);
            $seller['penjual'] = $info->user_id;
            $seller['gambar'] = $info->thumbnail_img;

            array_push($newarr,$seller);
            /*
            foreach($p
            engirim as $pk=>$pv){
                array_push($data_seller,$pv);
            }
            */
            $cartItem->save();
        }

        
        $newdata = $this->group_by("penjual", $newarr);
        
        $kumpulan_seller = [];
        foreach($newdata as $keyl => $vall){
            $pengirim = Address::where('user_id',$keyl)->get();
            $info_seller["alamat"] = $pengirim;
            $info_seller["produk"] = $vall;
            $info_seller["id"] = $keyl;
            $info_seller["su"] = (($keyl == 1)||($keyl == 9)) ? 1 : 0;
            $info_seller["nama"] = (($keyl == 1)||($keyl == 9)) ? "Veloce Trax" : User::where("id",$keyl)->first()->name;
            $info_seller["berat"] = array_sum(array_column($vall, 'berat')); 
            array_push($kumpulan_seller,$info_seller);
        }

        //echo json_encode($kumpulan_seller);
        return view('frontend.delivery_info', compact('carts','kumpulan_seller','kota_id'));
            
        
        // return view('frontend.payment_select', compact('total'));
    }

    public function store_delivery_info(Request $request)
    {
        
        $shipping_kurir =  $request['shipping_kurir'];
        $asal =  $request['pilgudang'];
        $ongkir =  $request['ongkir'];

        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $user = Auth::user();
        $shipping_info = Address::where('user_id', $user->id)->first();


        $total = 0;
        $tax = 0;
        $subtotal = 0;
        if ($carts && count($carts) > 0) {
                    
        //Set Your server key
        Config::$serverKey = env("midtrans_public_key",null);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $item_details = [];
        $nodei = 0;
        foreach ($carts as $key => $cartItem) {
                $nodei++;
                $iproduk = Product::where('id',$cartItem->product_id)->first();
                $tax += $cartItem['tax'] * $cartItem['quantity'];
                $subtotal += $cartItem['price'] * $cartItem['quantity'];
                // Optional
                $item1_details = array(
                    'id' =>  'a'.$nodei,
                    'price' =>  $cartItem['price'],
                    'quantity' => $cartItem['quantity'],
                    'name' => $iproduk->name
                );
                
                array_push($item_details,$item1_details);

                //$shipping += $cartItem['shipping_cost'];
                $cartItem->save();
                
            }

            $shipping = $request->shipping ?? 0;      
            $total = $subtotal + $tax + $shipping;
            $code = date('Ymd-His').rand(10,99);
            // Required
            $transaction_details = array(
                'order_id' => $code,
                'gross_amount' => $total, // no decimal allowed for creditcard
            );


            // Optional
            $item2_details = array(
                'id' => 'a'.($nodei+1),
                'price' => $shipping,
                'quantity' => 1,
                'name' => "Biaya Pengiriman"
            );

            array_push($item_details,$item2_details);

            
            // Optional
            $billing_address = array(
                'address'       => $shipping_info->address,
                'city'          => $shipping_info->city,
                'country_code'  => 'IDN'
            );

            // Optional, remove this to display all available payment methods
            //$enable_payments = auto;

            $enable_payments = array('bank_transfer','gopay','echannel');

            // Fill transaction details
            $transaction = array(
                'enabled_payments' => $enable_payments,
                'transaction_details' => $transaction_details,
                'item_details' => $item_details,
            );
            
            

            $snapToken = Snap::getSnapToken($transaction);
            $link_wa = Mobiledetect::walink("Hallo, saya ingin mengkonfirmasi pembayaran dengan nomor transaksi".$code);
            return view('frontend.payment_select', compact('carts', 'ongkir','asal','shipping_info', 'code','shipping', 'total','shipping_kurir','snapToken','link_wa'));
            
        } else {
            flash(translate('Your Cart was empty'))->warning();
            return redirect()->route('home');
        }
    }

//    public function get_payment_info(Request $request)
//    {
//        $carts = Cart::where('user_id', Auth::user()->id)
//                ->where('owner_id', $request->owner_id)
//                ->get();
//        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();
//        $total = 0;
//        $tax = 0;
//        $shipping = 0;
//        $subtotal = 0;
//
//        if ($carts && count($carts) > 0) {
//            foreach ($carts as $key => $cartItem) {
//                $tax += $cartItem['tax'] * $cartItem['quantity'];
//                $subtotal += $cartItem['price'] * $cartItem['quantity'];
//
//                if ($request['shipping_type_' . $request->owner_id] == 'pickup_point') {
//                    $cartItem['shipping_type'] = 'pickup_point';
//                    $cartItem['pickup_point'] = $request['pickup_point_id_' . $request->owner_id];
//                } else {
//                    $cartItem['shipping_type'] = 'home_delivery';
//                }
//                $cartItem['shipping_cost'] = 0;
//                if ($cartItem['shipping_type'] == 'home_delivery') {
//                    $cartItem['shipping_cost'] = getShippingCost($carts, $key);
//                }
//
//                if (isset($cartItem['shipping_cost']) && is_array(json_decode($cartItem['shipping_cost'], true))) {
//                    foreach (json_decode($cartItem['shipping_cost'], true) as $shipping_region => $val) {
//                        if ($shipping_info['city'] == $shipping_region) {
//                            $cartItem['shipping_cost'] = (double) ($val);
//                            break;
//                        }
//                    }
//                } else {
//                    if (!$cartItem['shipping_cost'] ||
//                            $cartItem['shipping_cost'] == null ||
//                            $cartItem['shipping_cost'] == 'null') {
//
//                        $cartItem['shipping_cost'] = 0;
//                    }
//                }
//                $shipping += $cartItem['shipping_cost'];
//                $cartItem->save();
//            }
//            $total = $subtotal + $tax + $shipping;
//            return view('frontend.payment_select', compact('carts', 'shipping_info', 'total'));
//        }
//    }

    public function apply_coupon_code(Request $request)
    {
        $shipping = $request->ongkir ?? 0;
        $coupon = Coupon::where('code', $request->code)->first();
        $carts = Cart::where('user_id', Auth::user()->id)
                ->where('owner_id', $request->owner_id)
                ->get();
        $response_message = array();
        
        if ($coupon != null) {
            if (strtotime(date('d-m-Y')) >= $coupon->start_date && strtotime(date('d-m-Y')) <= $coupon->end_date) {
                if (CouponUsage::where('user_id', Auth::user()->id)->where('coupon_id', $coupon->id)->first() == null) {
                    $coupon_details = json_decode($coupon->details);

                    if ($coupon->type == 'cart_base') {
                        $subtotal = 0;
                        $tax = 0;
                        $shipping = 0;
                        foreach ($carts as $key => $cartItem) {
                            $subtotal += $cartItem['price'] * $cartItem['quantity'];
                            $tax += $cartItem['tax'] * $cartItem['quantity'];
                            $shipping += $cartItem['shipping_cost'] * $cartItem['quantity'];
                        }
                        $sum = $subtotal + $tax + $shipping;

                        if ($sum >= $coupon_details->min_buy) {
                            if ($coupon->discount_type == 'percent') {
                                $coupon_discount = ($sum * $coupon->discount) / 100;
                                if ($coupon_discount > $coupon_details->max_discount) {
                                    $coupon_discount = $coupon_details->max_discount;
                                }
                            } elseif ($coupon->discount_type == 'amount') {
                                $coupon_discount = $coupon->discount;
                            }
                            
                        }
                    } elseif ($coupon->type == 'product_base') {
                        $coupon_discount = 0;
                        foreach ($carts as $key => $cartItem) {
                            foreach ($coupon_details as $key => $coupon_detail) {
                                if ($coupon_detail->product_id == $cartItem['product_id']) {
                                    if ($coupon->discount_type == 'percent') {
                                        $coupon_discount += $cartItem['price'] * $coupon->discount / 100;
                                    } elseif ($coupon->discount_type == 'amount') {
                                        $coupon_discount += $coupon->discount;
                                    }
                                }
                            }
                        }
                    }
                    
                    Cart::where('user_id', Auth::user()->id)
                            ->where('owner_id', $request->owner_id)
                            ->update(
                                    [
                                        'discount' => $coupon_discount / count($carts),
                                        'coupon_code' => $request->code,
                                        'coupon_applied' => 1
                                    ]
                    );

                    $response_message['response'] = 'success';
                    $response_message['message'] = translate('Coupon has been applied');
//                    flash(translate('Coupon has been applied'))->success();
                } else {
                    $response_message['response'] = 'warning';
                    $response_message['message'] = translate('You already used this coupon!');
//                    flash(translate('You already used this coupon!'))->warning();
                }
            } else {
                $response_message['response'] = 'warning';
                $response_message['message'] = translate('Coupon expired!');
//                flash(translate('Coupon expired!'))->warning();
            }
        } else {
            $response_message['response'] = 'danger';
            $response_message['message'] = translate('Invalid coupon!');
//            flash(translate('Invalid coupon!'))->warning();
        }
        
        $carts = Cart::where('user_id', Auth::user()->id)
                ->where('owner_id', $request->owner_id)
                ->get();
                
        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();
        
        $returnHTML = view('frontend.partials.cart_summary', compact('coupon', 'carts', 'shipping_info','shipping'))->render();
        return response()->json(array('response_message' => $response_message, 'html'=>$returnHTML));
//        return view('frontend.partials.cart_summary', compact('coupon', 'carts', 'shipping_info', 'response_message'));
    }

    public function remove_coupon_code(Request $request)
    {
        Cart::where('user_id', Auth::user()->id)
                ->where('owner_id', $request->owner_id)
                ->update(
                        [
                            'discount' => 0.00,
                            'coupon_code' => '',
                            'coupon_applied' => 0
                        ]
        );
        
        $coupon = Coupon::where('code', $request->code)->first();
        $carts = Cart::where('user_id', Auth::user()->id)
                ->where('owner_id', $request->owner_id)
                ->get();
//        dd($carts);
        $shipping = $request->ongkir ?? 0;
        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();
        
        return view('frontend.partials.cart_summary', compact('coupon', 'carts', 'shipping_info','shipping'));
//        return back();
    }
    
    public function apply_club_point(Request $request) {
        if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && 
                \App\Addon::where('unique_identifier', 'club_point')->first()->activated){
            
            $point = $request->point;
            
//            if(Auth::user()->club_point->points >= $point) {
            if(Auth::user()->point_balance >= $point) {
                $request->session()->put('club_point', $point);
                flash(translate('Point has been redeemed'))->success();
            }
            else {
                flash(translate('Invalid point!'))->warning();
            }
        }
        return back();
    }
    
    public function remove_club_point(Request $request) {
        $request->session()->forget('club_point');
        return back();
    }

    public function order_confirmed()
    {
        
        $order = Order::findOrFail(Session::get('order_id'));
        $code = $order->code;
        Cart::where('owner_id', $order->seller_id)->where('user_id', $order->user_id)->delete();

        $orders = Order::where('code',$code)->get();
        $order_detail = OrderDetail::where('order_id',$order->id);
        foreach($orders as $ork => $orv){
            $order_detail = $order_detail->orwhere('order_id',$orv->id);
        }
        $order_detail = $order_detail->get();
        $subtotal = array_sum(array_column(json_decode($order_detail), 'price'));
        $tax = array_sum(array_column(json_decode($order_detail), 'tax'));
        $ongkir = array_sum(array_column(json_decode($orders), 'ongkir'));
        
        $link_faktur = "purchase_history#".$code;
        $link_wa = Mobiledetect::walink("Hallo, saya ingin mengkonfirmasi pembayaran dengan nomor transaksi".$code);

        return view('frontend.order_confirmed', compact('orders','subtotal','tax','ongkir','order','order_detail','link_wa'));
    }
}
