@extends('backend.layouts.app')

@section('content')
<style>
.barcode{
    width: 100%;
    overflow: hidden;
    object-fit: cover;
    opacity: .6;
}
.barcode > a > * {
    margin: 0 auto;
    width: auto;
    max-width: 100%;
    display: block;
    object-fit: cover;
    border-radius: 8px;
    height: 100%;
}
.bkttransfer{margin: 10px 0;border-radius: 8px;}
table{width:100%;}
td{padding:5px;}
.m5{margin:5px;}
.m10{margin:10px;}
.text-bold{font-weight:bold;}
.form-control {
    margin:5px 0;
    padding: 5px 10px
}
.atasan tr:nth-child(odd) {background: #eee;}
@media (max-width:750px){
    .tabelm{display:inline-block;white-space: nowrap;}
    .tabelm .w50{width:100%;}
    .atasan tr{display:flex;}
    .atasan td:first-child{width:40%!important;}
    .atasan td:last-child{width:60%!important;}
}
</style>
@php
    $delivery_status = $order->orderDetails->first()->delivery_status;
    $payment_status = $order->orderDetails->first()->payment_status;
    $status = $order->orderDetails->first()->delivery_status;
    $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();

    $hari = \App\Tanggalan::hari(date('D',strtotime($order->created_at)));
    $tanggal = \App\Tanggalan::tanggalIndonesiaString(date('Y-m-d',strtotime($order->created_at)));
    $jam = date('H:i',strtotime($order->created_at));
    $nowa = json_decode($order->shipping_address) ? json_decode($order->shipping_address)->phone : $order->user->phone; 
@endphp
    <div class="card">
        <div class="card-header">
            <h1 class="h2 fs-16 mb-0">{{ translate('Order Details') }}</h1>
        </div>
        <div class="card-body">
            <div class="row">
                @php
                    $delivery_status = $order->delivery_status;
                    $payment_status = $order->payment_status;
                    $admin_user_id = App\Models\User::where('user_type', 'admin')->first()->id;
                @endphp

                <!--Assign Delivery Boy-->
                @if ($order->seller_id == $admin_user_id || get_setting('product_manage_by_admin') == 1)
                    
                    @if (addon_is_activated('delivery_boy'))
                        <div class="col-md-3">
                            <label for="assign_deliver_boy">{{ translate('Assign Deliver Boy') }}</label>
                            @if (($delivery_status == 'pending' || $delivery_status == 'confirmed' || $delivery_status == 'picked_up') && auth()->user()->can('assign_delivery_boy_for_orders'))
                                <select class="form-control aiz-selectpicker" data-live-search="true"
                                    data-minimum-results-for-search="Infinity" id="assign_deliver_boy">
                                    <option value="">{{ translate('Select Delivery Boy') }}</option>
                                    @foreach ($delivery_boys as $delivery_boy)
                                        <option value="{{ $delivery_boy->id }}"
                                            @if ($order->assign_delivery_boy == $delivery_boy->id) selected @endif>
                                            {{ $delivery_boy->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text" class="form-control" value="{{ optional($order->delivery_boy)->name }}"
                                    disabled>
                            @endif
                        </div>
                    @endif

                    <div class="col-md-@if(addon_is_activated('delivery_boy')){{4}}@else{{6}}@endif">
                        <label for="update_payment_status">{{ translate('Payment Status') }}</label>
                        @if (auth()->user()->can('update_order_payment_status'))
                            <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity"
                                id="update_payment_status">
                                <option value="unpaid" @if ($payment_status == 'unpaid') selected @endif>
                                    {{ translate('Unpaid') }}
                                </option>
                                <option value="paid" @if ($payment_status == 'paid') selected @endif>
                                    {{ translate('Paid') }}
                                </option>
                            </select>
                        @else
                            <input type="text" class="form-control" value="{{ $payment_status }}" disabled>
                        @endif
                    </div>
                    <div class="col-md-@if(addon_is_activated('delivery_boy')){{4}}@else{{6}}@endif">
                        <label for="update_delivery_status">{{ translate('Delivery Status') }}</label>
                            <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity"
                                id="update_delivery_status">
                                <option value="pending" @if ($delivery_status == 'pending') selected @endif>
                                    {{ translate('Pending') }}
                                </option>
                                <option value="confirmed" @if ($delivery_status == 'confirmed') selected @endif>
                                    {{ translate('Confirmed') }}
                                </option>
                                <option value="picked_up" @if ($delivery_status == 'picked_up') selected @endif>
                                    {{ translate('Picked Up') }}
                                </option>
                                <option value="on_the_way" @if ($delivery_status == 'on_the_way') selected @endif>
                                    {{ translate('On The Way') }}
                                </option>
                                <option value="delivered" @if ($delivery_status == 'delivered') selected @endif>
                                    {{ translate('Delivered') }}
                                </option>
                                <option value="cancelled" @if ($delivery_status == 'cancelled') selected @endif>
                                    {{ translate('Cancel') }}
                                </option>
                            </select>
                    </div>
                @endif
            </div>
            <?php /*
            <div class="mb-3">
                @php
                    $removedXML = '<?xml version="1.0" encoding="UTF-8"?>';
                @endphp
                {!! str_replace($removedXML, '', QrCode::size(100)->generate($order->code)) !!}
            </div>
            <div class="row gutters-5">
                <div class="col text-md-left text-center">
                    @if(json_decode($order->shipping_address))
                        <address>
                            <strong class="text-main">
                                {{ json_decode($order->shipping_address)->name }}
                            </strong><br>
                            {{ json_decode($order->shipping_address)->email }}<br>
                            {{ json_decode($order->shipping_address)->phone }}<br>
                            {{ json_decode($order->shipping_address)->address }}, {{ json_decode($order->shipping_address)->city }}, @if(isset(json_decode($order->shipping_address)->state)) {{ json_decode($order->shipping_address)->state }} - @endif {{ json_decode($order->shipping_address)->postal_code }}<br>
                            {{ json_decode($order->shipping_address)->country }}
                        </address>
                    @else
                        <address>
                            <strong class="text-main">
                                {{ $order->user->name }}
                            </strong><br>
                            {{ $order->user->email }}<br>
                            {{ $order->user->phone }}<br>
                        </address>
                    @endif
                    @if ($order->manual_payment && is_array(json_decode($order->manual_payment_data, true)))
                        <br>
                        <strong class="text-main">{{ translate('Payment Information') }}</strong><br>
                        {{ translate('Name') }}: {{ json_decode($order->manual_payment_data)->name }},
                        {{ translate('Amount') }}:
                        {{ single_price(json_decode($order->manual_payment_data)->amount) }},
                        {{ translate('TRX ID') }}: {{ json_decode($order->manual_payment_data)->trx_id }}
                        <br>
                        <a href="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}" target="_blank">
                            <img src="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}" alt=""
                                height="100">
                        </a>
                    @endif
                </div>
                <div class="col-md-4 ml-auto">
                    <table>
                        <tbody>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Order #') }}</td>
                                <td class="text-info text-bold text-right"> {{ $order->code }}</td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Order Status') }}</td>
                                <td class="text-right">
                                    @if ($delivery_status == 'delivered')
                                        <span class="badge badge-inline badge-success">
                                            {{ translate(ucfirst(str_replace('_', ' ', $delivery_status))) }}
                                        </span>
                                    @else
                                        <span class="badge badge-inline badge-info">
                                            {{ translate(ucfirst(str_replace('_', ' ', $delivery_status))) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Order Date') }} </td>
                                <td class="text-right">{{ date('d-m-Y h:i A', $order->date) }}</td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">
                                    {{ translate('Total amount') }}
                                </td>
                                <td class="text-right">
                                    {{ single_price($order->grand_total) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Payment method') }}</td>
                                <td class="text-right">
                                    {{ translate(ucfirst(str_replace('_', ' ', $order->payment_type))) }}</td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Additional Info') }}</td>
                                <td class="text-right">{{ $order->additional_info }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            */?>
            <div class="mb-3"></div>
            <div class="row">
                <div class="col-lg-2 barcode">
                    @isset($order->manual_payment_data)
                    <a href="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}" target="_blank">
                                            <img src="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}" alt=""
                                                height="100">
                    </a>
                    @else
                    @php
                        $removedXML = '<?xml version="1.0" encoding="UTF-8"?>';
                    @endphp
                    { str_replace($removedXML, '', QrCode::size(100)->generate($order->code))}
                    @endisset
                </div>
                <div class="col-lg-10">
                    <h6 class="mb-4 px-3">Informasi Pesanan</h6>
                    <div class="m10 row gutters-5">
                        <div class="col-lg-6 p-0">
                            <table class="table table-borderless atasan">
                                <tr>
                                    <td class="fw-600" width="10%">Nomor:</td>
                                    <td class="text-info text-bold">{{ $order->code }}</td>
                                </tr>
                                
                                <tr>
                                    <td class="fw-600" width="10%">{{ translate('Status')}}:</td>
                                    <td class="delivstatus">
                                        @if($status == 'delivered')
                                            <span class="badge badge-inline badge-success">{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</span>
                                        @else
                                            <span class="badge badge-inline badge-info">{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</span>
                                        @endif
                                    </td>
                                </tr>          
                                @if ($order->user_id != null)                   
                                <tr>
                                    <td class="fw-600" width="10%">{{ translate('Nama')}}:</td>
                                    <td>{{ json_decode($order->shipping_address)->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-600" width="10%">Whatsapp:</td>
                                    <td><a class="badge badge-inline badge-info" href="https://web.whatsapp.com/send?phone={{$nowa}}&text=Hallo..">{{$nowa}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-600" width="10%">{{ translate('E-mail')}}:</td>
                                    <td>{{ $order->user->email }}</td>
                                </tr>                   
                                <tr>
                                    <td class="fw-600" width="10%">{{ translate('Provinsi')}}:</td>
                                    <td>{{ json_decode($order->shipping_address)->country }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-600" width="10%">{{ translate('Kota')}}:</td>
                                    <td>{{ json_decode($order->shipping_address)->city }}</td>
                                </tr>    
                                <tr>
                                    <td class="fw-600" width="10%">{{ translate('Alamat')}}:</td>
                                    <td>{{ json_decode($order->shipping_address)->address }}</td>
                                </tr>
                                @else
                                <tr>
                                    <td class="fw-600" width="10%">Pelanggan </td>
                                    <td><b>Tamu Datang</b></td>
                                </tr>
                                @endif                                    
                            </table>
                        <?php /*
                        <div class="col text-center text-md-left">
                            <address>
                                <strong class="text-main">{{ json_decode($order->shipping_address)->name }}</strong><br>
                                {{ json_decode($order->shipping_address)->email }}<br>
                                {{ json_decode($order->shipping_address)->phone }}<br>
                                {{ json_decode($order->shipping_address)->address }}, {{ json_decode($order->shipping_address)->city }}, {{ json_decode($order->shipping_address)->postal_code }}<br>
                                {{ json_decode($order->shipping_address)->country }}
                                <br><br>
                                <strong class="text-main"> Metode Pengiriman </strong><br>
                                {{ $order->pengiriman_kurir }} - {{ $order->pengiriman_jenis }}
                                <br><br>
                                <strong class="text-main"> Nomor Resi </strong><br>
                                <input id="nomorresi" type="text" value="{{ $order->resi }}" class="form-control" name="name" placeholder="Masukkan Nomor Resi {{ $order->pengiriman_kurir }} - {{ $order->pengiriman_jenis }}">
                            </address>
                            @if ($order->manual_payment && is_array(json_decode($order->manual_payment_data, true)))
                            <br>
                            <strong class="text-main">{{ translate('Payment Information') }}</strong><br>
                            {{ translate('Name') }}: {{ json_decode($order->manual_payment_data)->name }}, {{ translate('Amount') }}: {{ single_price(json_decode($order->manual_payment_data)->amount) }}, {{ translate('TRX ID') }}: {{ json_decode($order->manual_payment_data)->trx_id }}
                            <br>
                            <a href="{{ static_asset(json_deco
                                de($order->manual_payment_data)->photo) }}" target="_blank"><img class="bkttransfer" src="{{ static_asset(json_decode($order->manual_payment_data)->photo) }}" alt="" height="100"></a>
                            @endif
                            */ ?>
                        </div>
                        <div class="col-lg-6 ml-auto">
                            <table class="table table-borderless atasan">
                                <tr>
                                    <td class="fw-600" width="10%">{{ translate('Tanggal')}}:</td>
                                    <td>{{ $hari.", ".$tanggal }}</td>
                                </tr>            
                                <tr>
                                    <td class="fw-600" width="10%">Total :</td>
                                    <td>{{ single_price($subtotal + $tax + $ongkir) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-600" width="10%">Metode :</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $order->metode_pembayaran ?? "Cash")) }}</td>
                                </tr>
                                
                                <tr>
                                    <td class="fw-600" width="10%">Pembayaran:</td>
                                    <td class="paystatus">
                                        @if ($order->payment_status == 'paid')
                                            <span class="badge badge-inline badge-success">{{translate('Lunas')}}</span>
                                        @else
                                            <span class="badge badge-inline badge-danger">{{translate('Belum Dibayar')}}</span>
                                        @endif
                                    </td>
                                </tr>
                                @isset($order->nomor_pembayaran)
                                <tr>
                                    <td class="fw-600" width="10%">Rekening :</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $order->nomor_pembayaran)) }}</td>
                                </tr>   
                                @endisset
                                @isset($order->manual_payment_data)
                                <tr>
                                    <td class="fw-600" width="10%">A.N Rek :</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', json_decode($order->manual_payment_data)->name)) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-600" width="10%">Dari Rek.</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', json_decode($order->manual_payment_data)->trx_id)) }}</td>
                                </tr>
                                @endisset
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="new-section-sm bord-no">
            <div class="row">
                <div class="col-lg-8">
                        <table class="table table-responsive-md table-borderless tabelm">
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
                                    @if ($orderDetail->product != null )
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
                                    <td class="text-center"> {{ $orderDetail->quantity }}</td>
                                    <td class="text-right">{{ single_price($orderDetail->price) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                <div class="col-lg-4">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="w-50 fw-600">{{ translate('Subtotal')}}</td>
                                    <td class="text-right">
                                        <span class="strong-600">{{ single_price($subtotal) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-50 fw-600">{{ translate('Pengiriman')}}</td>
                                    <td class="text-right">
                                        <span class="text-italic">{{ single_price($ongkir) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-50 fw-600">{{ translate('Pajak')}}</td>
                                    <td class="text-right">
                                        <span class="text-italic">{{ single_price($tax) }}</span>
                                    </td>
                                </tr>
                                @if($order->coupon_discount > 0)
                                <tr>
                                    <td class="w-50 fw-600">{{ translate('Coupon')}}</td>
                                    <td class="text-right">
                                        <span class="text-italic">{{ single_price($order->coupon_discount) }}</span>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="w-50 font-weight-bold">{{ ('Total')}}</td>
                                    <td class="text-right">
                                        <strong><span>{{ single_price($subtotal + $ongkir) }}</span></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            </div>
            <div class="clearfix row">
                <div class="col-lg-12">
                    <h6 class="mb-4 px-0">Informasi Pengiriman</h6>
                    <table class="table table-responsive-md aiz-table table-borderless tabelm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th data-breakpoints="lg">{{ translate('Resi')}}</th>
                                <th>{{ translate('Lokasi Toko')}}</th>
                                <th>{{ translate('Kurir')}}</th>
                                <th>{{ translate('Estimasi')}}</th>
                            
                                <th>{{ translate('Resi')}}</th>
                                <th class="text-right">{{ translate('Tarif')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $ordersv)
                            <?php 
                                $citix = \App\City::where('name',json_decode($ordersv->shipping_address)->city)->first();
                                $city = ($citix) ? $citix->id : null;
                                $kurir = \App\Kurir::where('ongkir_tujuan',$city)->where('ongkir_kurir',$ordersv->pengiriman_kurir)->where('ongkir_jenis',$ordersv->pengiriman_jenis)->where('ongkir_tarif',$ordersv->ongkir)->first();
                            ?>
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                    <input type="text" value="{{ $ordersv->resi}}" data-id="{{ $ordersv->id}}" onkeyup="isiresi(this)" class="form-control w-100 isiresi" name="resi" placeholder="Masukkan Nomor Resi JNE - OKE">
                                    </td>  
                                    <td><?php 
                                        $alamat = \App\Address::where('id',$ordersv->alamattoko)->first();
                                        if(isset($alamat->penerima)){echo "<strong>".$alamat->penerima."</strong> - ";}
                                        echo ucwords(strtolower($alamat->city))." - ".$alamat->phone;
                                    ?></td>
                                    <td> @if($kurir) <strong> {{$kurir->ongkir_kurir." - ".$kurir->ongkir_jenis }} </strong> @endif</td>
                                    <td> @if($kurir) <strong> {{ $kurir->ongkir_est }} </strong> @endif</td>
                                    <td> <span class="resi"><b>{{$order->tracking_code}}</b></span></td>
                                    <td  class="text-right">{{ single_price($ordersv->ongkir)}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>   
                </div>
            </div>
        </div>
        
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#assign_deliver_boy').on('change', function() {
            var order_id = {{ $order->id }};
            var delivery_boy = $('#assign_deliver_boy').val();
            $.post('{{ route('orders.delivery-boy-assign') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                delivery_boy: delivery_boy
            }, function(data) {
                AIZ.plugins.notify('success', '{{ translate('Delivery boy has been assigned') }}');
            });
        });
        $('#update_delivery_status').on('change', function() {
            var order_id = {{ $order->id }};
            var status = $('#update_delivery_status').val();
            $.post('{{ route('orders.update_delivery_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            }, function(data) {
                status = status.replaceAll("_"," ");
                status = status.toUpperCase();
                $(".delivstatus span").html(status);
                AIZ.plugins.notify('success', '{{ translate('Delivery status has been updated') }}');
            });
        });
        $('#update_payment_status').on('change', function() {
            var order_id = {{ $order->id }};
            var status = $('#update_payment_status').val();
            $.post('{{ route('orders.update_payment_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            }, function(data) {
                if(status == "paid"){
                    $(".paystatus").html("<span class='badge badge-inline badge-success'>Lunas</span>");
                }else{
                    $(".paystatus").html("<span class='badge badge-inline badge-danger'>Belum Dibayar</span>");
                }
                AIZ.plugins.notify('success', '{{ translate('Payment status has been updated') }}');
            });
        });
        
        $('#update_tracking_code').on('change', function() {
            var order_id = {{ $order->id }};
            var tracking_code = $('#update_tracking_code').val();
            $.post('{{ route('orders.update_tracking_code') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                tracking_code: tracking_code
            }, function(data) {
                $(".resi").html("<b>"+tracking_code+"</b>");
                AIZ.plugins.notify('success', '{{ translate('Order tracking code has been updated') }}');
            });
        });
        
    let delay = (callback, ms) => {
        let arguments, timer = 0;
        return function() {
            let context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
            callback.apply(context, args);
            }, ms || 0);
        };
    };

    let isiresi = delay((rx) =>{
        let order_id = rx.getAttribute("data-id");
        let resi = rx.value;
        $.post('{{ route('orders.updateresi') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,resi:resi}, function(data){
            AIZ.plugins.notify('success', '{{ translate('Nomor Resi Berhasil Dirubah') }}');
        });
    },600);    

    
    
    </script>
@endsection