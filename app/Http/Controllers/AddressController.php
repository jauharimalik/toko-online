<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;
use App\User;
use App\Shop;
use Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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
        $address = new Address;
        if($request->has('customer_id')){
            $address->user_id = $request->customer_id;
        }
        else{
            $address->user_id = Auth::user()->id;
        }
        $address->address = $request->address;
        $address->country = $request->country;
        $address->city = $request->city;
        $address->kecamatan = $request->kecamatan;
        $address->postal_code = $request->postal_code;
        $address->phone = $request->phone;
        $address->dropship = $request->dropship;
        $address->penerima = $request->penerima;
        $address->set_default = $request->set_default;
        if($address->set_default >= 1){
            $user = User::where('id',$address->user_id)->first();
            $user->address = $address->address.", ".$address->kecamatan;
            $user->country = $address->country;
            $user->city = $address->city;
            $user->postal_code = $address->postal_code;

            if((is_null($user->phone))||($user->phone == "")){
                $user->phone = $address->phone;
            }

            $user->save();

            $address_all = Address::where('user_id',$address->user_id)->where('set_default',$address->set_default)->get();
            foreach ($address_all as $key => $alamat) {
                $alamat->set_default = 0;
                $alamat->save();
            }

            if($address->set_default == 2){
                $shop = Shop::where('user_id', $user->id)->first();
                if(is_null($shop)){ $shop = new Shop; }
                $shop->address = $request->address." ".$request->postal_code.", ".$request->country.", ".$request->city.", Kecamatan ".$request->kecamatan;
                $shop->save();
            }
        }

        $address->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['address_data'] = Address::findOrFail($id);
        $data['address_data']->phone  = $data['address_data']->phone ?? (Address::where('id', $id)->first())->user->phone;
        $data['address_data']->phone  = ($data['address_data']->phone != "") ? $data['address_data']->phone : (Address::where('id', $id)->first())->user->phone;
        
        return view('frontend.user.address.edit_address_modal', $data);
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
        $address = Address::findOrFail($id);
        
        $address->address = $request->address;
        $address->country = $request->country;
        $address->city = $request->city;
        $address->kecamatan = $request->kecamatan;
        $address->postal_code = $request->postal_code;
        $address->phone = $request->phone;
        $address->dropship = $request->dropship;
        $address->penerima = $request->penerima;
        $address->save();

        flash(translate('Address info updated successfully'))->warning();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        if(!$address->set_default){
            $address->delete();
            return back();
        }
        flash(translate('Default address can not be deleted'))->warning();
        return back();
    }

    public function set_default($id){
        $address_id = Address::findOrFail($id);
        $address_all = Address::where('user_id',$address_id->user_id)->where('set_default',1)->get();
        foreach ($address_all as $key => $address) {
            $address->set_default = 0;
            $address->save();
        }
        
        $address_id->set_default = 1;
        if($address_id->save()){
            $shop = Shop::where('user_id', $address_id->user_id)->first();
            if(is_null($shop)){ $shop = new Shop; }
            $shop->address = $address_id->address." ".$address_id->postal_code.", ".$address_id->country.", ".$address_id->city.", Kecamatan ".$address_id->kecamatan;
            $shop->save();
        }
        return back();
    }

    public function set_default_toko($id){
        $address_id = Address::findOrFail($id);
        $address_all = Address::where('user_id',$address_id->user_id)->where('set_default',2)->get();
        foreach ($address_all as $key => $address) {
            $address->set_default = 0;
            $address->save();
        }
        
        $address_id->set_default = 2;
        if($address_id->save()){
            $shop = Shop::where('user_id', $address_id->user_id)->first();
            if(is_null($shop)){ $shop = new Shop; }
            $shop->address = $address_id->address." ".$address_id->postal_code.", ".$address_id->country.", ".$address_id->city.", Kecamatan ".$address_id->kecamatan;
            $shop->save();
        }
        return back();
    }
    
}
