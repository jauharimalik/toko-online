@extends('frontend.layouts.app')

@section('content')
    @php
        $status = $order->orderDetails->first()->delivery_status;
    @endphp
    <section class="pt-5 mb-4">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="row aiz-steps arrow-divider">
                        <div class="col done">
                            <div class="text-center text-success">
                                <i class="la-3x mb-2 las la-shopping-cart"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('1. My Cart')}}</h3>
                            </div>
                        </div>
                        <div class="col done">
                            <div class="text-center text-success">
                                <i class="la-3x mb-2 las la-map"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('2. Shipping info')}}</h3>
                            </div>
                        </div>
                        <div class="col done">
                            <div class="text-center text-success">
                                <i class="la-3x mb-2 las la-truck"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('3. Delivery info')}}</h3>
                            </div>
                        </div>
                        <div class="col done">
                            <div class="text-center text-success">
                                <i class="la-3x mb-2 las la-credit-card"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('4. Payment')}}</h3>
                            </div>
                        </div>
                        <div class="col active">
                            <div class="text-center text-primary">
                                <i class="la-3x mb-2 las la-check-circle"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('5. Confirmation')}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-4">
        <div class="container text-left">
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="card shadow-sm border-0 rounded">
                        <div class="card-body">

                            <div class="text-center py-4 mb-4">
                                <i class="la la-check-circle la-3x text-success mb-3"></i>
                                <h1 class="h3 mb-3 fw-600">{{ translate('Terima Kasih sudah Berbelanja!')}}</h1>
                                <h2 class="h5">{{ translate('Order Code:')}} <span class="fw-700 text-primary">{{ $order->code }}</span></h2>
                                <p class="opacity-70 font-italic">{{  translate('A copy or your order summary has been sent to') }} {{ json_decode($order->shipping_address)->email }}</p>
                            </div>
                            <div class="mb-4">
                                <h5 class="fw-600 mb-3 fs-17 pb-2">{{ translate('Ringkasan')}}</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table">
                                            <tr>
                                                <td class="w-50 fw-600">{{ translate('Nomor Faktur')}}:</td>
                                                <td>{{ $order->code }}</td>
                                            </tr>
                                            <tr>
                                                <td class="w-50 fw-600">{{ translate('Nama')}}:</td>
                                                <td>{{ json_decode($order->shipping_address)->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="w-50 fw-600">{{ translate('E-mail')}}:</td>
                                                <td>{{ json_decode($order->shipping_address)->email }}</td>
                                            </tr>
                                            <tr>
                                                <td class="w-50 fw-600">{{ translate('Alamat')}}:</td>
                                                <td>{{ json_decode($order->shipping_address)->address }}, {{ json_decode($order->shipping_address)->city }}, {{ json_decode($order->shipping_address)->country }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table">
                                            <tr>
                                                <td class="w-50 fw-600">{{ translate('Tanggal Pesanan')}}:</td>
                                                <td>{{ date('d-m-Y H:i A', $order->date) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="w-50 fw-600">{{ translate('Status Pesanan')}}:</td>
                                                <td>{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="w-50 fw-600">{{ translate('Total Belanjaan')}}:</td>
                                                <td>{{ single_price($ongkir + $subtotal) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="w-50 fw-600">{{ translate('Pembayaran')}}:</td>
                                                <td>{{ ucfirst(str_replace('_', ' ', $order->metode_pembayaran)) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="w-50 fw-600">Nomor VA  :</td>
                                                <td>{{ ucfirst(str_replace('_', ' ', $order->nomor_pembayaran)) }}</td>
                                            </tr>                                           
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h5 class="fw-600 mb-3 fs-17 pb-2">Informasi Pesanan</h5>
                                <div>
                                    <table class="table table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th width="50%">{{ translate('Produk')}}</th>
                                                <th class="text-center">{{ translate('Jumlah')}}</th>
                                                <th class="text-right">{{ translate('Harga')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order_detail as $key => $orderDetail)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>
                                                        @if ($orderDetail->product != null)
                                                            <a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank" class="text-reset">
                                                                {{ $orderDetail->product->getTranslation('name') }}
                                                            </a>
                                                        @else
                                                            <strong>{{  translate('Product Unavailable') }}</strong>
                                                        @endif 

                                                        @isset($orderDetail->variation)
                                                            @if($orderDetail->variation != "") <strong> - Varian : {{ $orderDetail->variation }} </strong>@endif 
                                                        @endisset
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $orderDetail->quantity }}
                                                    </td>
                                                    <td class="text-right">{{ single_price($orderDetail->price) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-xl-5 col-md-6 ml-auto mr-0">
                                        <table class="table ">
                                            <tbody>
                                                <tr>
                                                    <th>{{ translate('Subtotal')}}</th>
                                                    <td class="text-right">
                                                        <span class="fw-600">{{ single_price($subtotal) }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ translate('Pengiriman')}}</th>
                                                    <td class="text-right">
                                                        <span class="font-italic">{{ single_price($ongkir) }}</span>
                                                    </td>
                                                </tr>
                                                <?php /*
                                                <tr>
                                                    <th>{{ translate('Tax')}}</th>
                                                    <td class="text-right">
                                                        <span class="font-italic">{{ single_price($order->orderDetails->sum('tax')) }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ translate('Coupon Discount')}}</th>
                                                    <td class="text-right">
                                                        <span class="font-italic">{{ single_price($order->coupon_discount) }}</span>
                                                    </td>
                                                </tr>
                                                */ ?>
                                                <tr>
                                                    <th><span class="fw-600">{{ translate('Total')}}</span></th>
                                                    <td class="text-right">
                                                        <strong><span>{{ single_price($ongkir + $subtotal) }}</span></strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8 mx-auto">
                    <div class="card shadow-sm border-0 rounded">
                        <div class="card-body">

                            <div>
                                <h5 class="fw-600 mb-3 fs-17 pb-2">Informasi Pengiriman</h5>
                                <div>
                                    <table class="table table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th width="50%">{{ translate('Lokasi Toko')}}</th>
                                                <th>{{ translate('Kurir')}}</th>
                                                <th class="text-right">{{ translate('Tarif')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $key => $ordersv)
                                                
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td><?php 
                                                        $alamat = \App\Address::where('id',$ordersv->alamattoko)->first();
                                                        if(isset($alamat->penerima)){echo "<strong>".$alamat->penerima."</strong><br>";}
                                                        echo ucwords(strtolower($alamat->city))." - ".$alamat->phone;
                                                    ?></td>
                                                    <td><?php 
                                                        $city = \App\City::where('name',json_decode($ordersv->shipping_address)->city)->first()->id;
                                                        $kurir = \App\Kurir::where('ongkir_tujuan',$city)->where('ongkir_kurir',$ordersv->pengiriman_kurir)
                                                            ->where('ongkir_jenis',$ordersv->pengiriman_jenis)->first();
                                        
                                        if($kurir){
                                        
                                                        echo "<strong>".$kurir->ongkir_kurir." - ".$kurir->ongkir_jenis."</strong> <br><small>".$kurir->ongkir_est."</small>";
                                        }
                                                    ?></td>
                                                    <td  class="text-right">{{ single_price($ordersv->ongkir)}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php // check  batas ?>
                        </div>
                    </div>
                    <a href="{{ $link_wa }}" target="_blank" class="btn btn-primary fw-600 mb-3">
                        <i class="lab la-whatsapp"></i> Konfirmasi Pembayaran
                    </a>
                </div>
                                

            </div>
        </div>
    </section>
@endsection
