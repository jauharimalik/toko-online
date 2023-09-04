@extends('frontend.layouts.user_panel')
@php
    $status = $order->orderDetails->first()->delivery_status;
    $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
@endphp
@section('panel_content')
    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('Order id') }}: {{ $order->code }}</h1>
            </div>
        </div>
    </div>

    <div class="py-4">
        <div class="row gutters-5 text-center aiz-steps">
            <div class="col @if($status == 'pending') active @else done @endif">
                <div class="icon">
                    <i class="las la-file-invoice"></i>
                </div>
                <div class="title fs-12">{{ translate('Order placed')}}</div>
            </div>
            <div class="col @if($status == 'confirmed') active @elseif($status == 'on_delivery' || $status == 'picked_up' || $status == 'delivered') done @endif">
                <div class="icon">
                    <i class="las la-newspaper"></i>
                </div>
              <div class="title fs-12">{{ translate('Confirmed')}}</div>
            </div>
            <div class="col @if(($status == 'on_delivery')||($status == 'picked_up')) active @elseif($status == 'delivered') done @endif">
                <div class="icon">
                    <i class="las la-truck"></i>
                </div>
                <div class="title fs-12">{{ translate('On delivery')}}</div>
            </div>
            <div class="col @if($status == 'delivered') done @endif">
                <div class="icon">
                    <i class="las la-clipboard-check"></i>
                </div>
                <div class="title fs-12">{{ translate('Delivered')}}</div>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="h6 mb-0">{{ translate('Order Summary') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-lg-6">
                    <table class="table-borderless table">
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Order Code') }}:</td>
                            <td>{{ $order->code }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Customer') }}:</td>
                            <td>{{ json_decode($order->shipping_address)->name }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Email') }}:</td>
                            @if ($order->user_id != null)
                                <td>{{ $order->user->email }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Shipping address') }}:</td>
                            <td>{{ json_decode($order->shipping_address)->address }},
                                {{ json_decode($order->shipping_address)->city }},
                                @if(isset(json_decode($order->shipping_address)->state)) {{ json_decode($order->shipping_address)->state }} - @endif
                                {{ json_decode($order->shipping_address)->postal_code }},
                                {{ json_decode($order->shipping_address)->country }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-6">
                    <table class="table-borderless table">
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Order date') }}:</td>
                            <td>{{ date('d-m-Y H:i A', $order->date) }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Order status') }}:</td>
                            <td>{{ translate(ucfirst(str_replace('_', ' ', $order->delivery_status))) }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Total order amount') }}:</td>
                            <td>{{ single_price($order->orderDetails->sum('price') + $order->orderDetails->sum('tax')) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Shipping method') }}:</td>
                            <td>{{ translate('Flat shipping rate') }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Payment method') }}:</td>
                            <td>{{ translate(ucfirst(str_replace('_', ' ', $order->payment_type))) }}</td>
                        </tr>

                        <tr>
                            <td class="text-main text-bold">{{ translate('Additional Info') }}</td>
                            <td class="">{{ $order->additional_info }}</td>
                        </tr>
                        @if ($order->tracking_code)
                            <tr>
                                <td class="w-50 fw-600">{{ translate('Tracking code') }}:</td>
                                <td>{{ $order->tracking_code }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-9">
            <div class="card my-0">
                <div class="card-header">
                  <b class="fs-15">{{ translate('Detail Pesanan') }}</b>
                </div>
                <div class="card-body pb-0">
                    <table class="table table-responsive-md table-borderless tabelm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th width="40%">{{ translate('Produk')}}</th>
                                <th class="text-center">{{ translate('Jumlah')}}</th>
                                <th class="text-right">{{ translate('Harga')}}</th>
                                <th class="text-center">Review</th>
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
                                    <td>
                                        @if ($orderDetail->delivery_status == 'delivered')
                                        <a href="javascript:void(0);"
                                                onclick="product_review('{{ $orderDetail->product_id }}')"
                                                class="btn btn-primary btn-sm"> Ulasan </a>
                                        @else
                                        *
                                        @endif
                                        </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card fundx">
                <div class="card-header">
                  <b class="fs-15">{{ translate('Order Ammount') }}</b>
                </div>
                <div class="card-body pb-0">
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
                                <td class="w-50 fw-600">{{ translate('Total')}}</td>
                                <td class="text-right">
                                    <strong><span>{{ single_price($subtotal + $ongkir) }}</span></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($order->manual_payment)
                <button onclick="show_make_payment_modal({{ $order->id }})" class="btn btn-block btn-primary">{{ translate('Make Payment')}}</button>
            @endif
        </div>
        <div class="col-lg-12">
            <div class="card mt-3">
                <div class="card-header">
                  <b class="fs-15">Informasi Pengiriman</b>
                </div>
                <div class="card-body pb-0">
                    <table class="table table-responsive-md table-borderless tabelm">
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
                                        if(isset($alamat->penerima)){echo "<strong>".$alamat->penerima."</strong> - ";}
                                        echo ucwords(strtolower($alamat->city))." - ".$alamat->phone;
                                    ?></td>
                                    <td><?php 
                                        $city = \App\City::where('name',json_decode($ordersv->shipping_address)->city)->first()->id;
                                        $kurir = \App\Kurir::where('ongkir_tujuan',$city)->where('ongkir_kurir',$ordersv->pengiriman_kurir)
                                            ->where('ongkir_jenis',$ordersv->pengiriman_jenis)->where('ongkir_tarif',$ordersv->ongkir)->first();
                                        if($kurir){
                                            echo "<strong>".$kurir->ongkir_kurir." - ".$kurir->ongkir_jenis."</strong> - <small>".$kurir->ongkir_est."</small>";
                                        }
                                        
                                    ?></td>
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

@section('modal')
    <!-- Product Review Modal -->
    <div class="modal fade" id="product-review-modal">
        <div class="modal-dialog">
            <div class="modal-content" id="product-review-modal-content">

            </div>
        </div>
    </div>

    <div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div id="payment_modal_body">

                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script type="text/javascript">
        function show_make_payment_modal(order_id) {
            $.post('{{ route('checkout.make_payment') }}', {
                _token: '{{ csrf_token() }}',
                order_id: order_id,
                nominal:{{ ($subtotal+$ongkir) }}
            }, function(data) {
                $('#payment_modal_body').html(data);
                $('#payment_modal').modal('show');
                $('input[name=order_id]').val(order_id);
            });
        }

        function product_review(product_id) {
            $.post('{{ route('product_review_modal') }}', {
                _token: '{{ @csrf_token() }}',
                product_id: product_id
            }, function(data) {
                $('#product-review-modal-content').html(data);
                $('#product-review-modal').modal('show', {
                    backdrop: 'static'
                });
                AIZ.extra.inputRating();
            });
        }
    </script>
@endsection
