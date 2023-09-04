@extends('frontend.layouts.app')

@section('content')
<style>
table{width:100%;}
td{padding:5px;}
.m5{margin:5px;}
</style>

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
                    <div class="col active">
                        <div class="text-center text-primary">
                            <i class="la-3x mb-2 las la-credit-card"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('4. Payment')}}</h3>
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-center">
                            <i class="la-3x mb-2 opacity-50 las la-check-circle"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50">{{ translate('5. Confirmation')}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="mb-4">
    <div class="container text-left">
        <div class="row">
            <div class="col-lg-8">      
                <form action="{{ route('payment.checkout') }}" class="form-default" role="form" method="POST" id="checkout-form">
                    @csrf
                    <input type="hidden" name="shipping" value="{{ $shipping }}">
                    @isset($asal) @foreach ($asal as $asalk => $asalv)
                    <input type="hidden" name="asal[{{$asalk}}]" value="{{ $asalv }}">
                    @endforeach @endisset
                    @isset($ongkir) @foreach ($ongkir as $ongkirk => $ongkirv)
                    <input type="hidden" name="ongkir[{{$ongkirk}}]" value="{{ $ongkirv }}">
                    @endforeach @endisset
                    @isset($shipping_kurir) @foreach ($shipping_kurir as $shipingk => $shippingv)
                    <input type="hidden" name="kurir_pengiriman[{{$shipingk}}]" value="{{ $shippingv }}">
                    @endforeach @endisset
                    <input type="hidden" name="code" value="{{ $code }}">
                    <div id="mdt">
                        <input id="nomor_pembayaran" type="hidden" name="nomor_pembayaran" value="">
                        <input id="metode_pembayaran" type="hidden" name="metode_pembayaran" value="">              
                    </div>

                    <div class="card shadow-sm border-0 rounded">
                        <div class="card-header p-3">
                            <h3 class="fs-16 fw-600 mb-0">
                                {{ translate('Select a payment option')}}
                            </h3>
                        </div>
                        <div class="card-body text-center">
                                <div class="col-md16">
                                    <div class="row gutters-10">
                                        @if(get_setting('paypal_payment') == 1)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="paypal" class="online_payment" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/paypal.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('Paypal')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                        @if(get_setting('stripe_payment') == 1)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="stripe" class="online_payment" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/stripe.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('Stripe')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                        @if(get_setting('sslcommerz_payment') == 1)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="sslcommerz" class="online_payment" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/sslcommerz.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('sslcommerz')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                        @if(get_setting('instamojo_payment') == 1)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="instamojo" class="online_payment" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/instamojo.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('Instamojo')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                        @if(get_setting('razorpay') == 1)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="razorpay" class="online_payment" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/rozarpay.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('Razorpay')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                        @if(get_setting('paystack') == 1)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="paystack" class="online_payment" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/paystack.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('Paystack')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                        @if(get_setting('voguepay') == 1)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="voguepay" class="online_payment" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/vogue.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('VoguePay')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                        @if(get_setting('payhere') == 1)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="payhere" class="online_payment" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/payhere.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('payhere')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                        @if(get_setting('ngenius') == 1)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="ngenius" class="online_payment" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/ngenius.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('ngenius')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                        @if(get_setting('nagad') == 1)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="nagad" class="online_payment" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/nagad.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('Nagad')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                        @if(get_setting('bkash') == 1)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="bkash" class="online_payment" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/bkash.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('Bkash')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                        @if(\App\Addon::where('unique_identifier', 'african_pg')->first() != null && \App\Addon::where('unique_identifier', 'african_pg')->first()->activated)
                                            @if(get_setting('mpesa') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="mpesa" class="online_payment" type="radio" name="payment_option" checked>
                                                        <span class="d-block p-3 aiz-megabox-elem">
                                                            <img src="{{ static_asset('assets/img/cards/mpesa.png')}}" class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span class="d-block fw-600 fs-15">{{ translate('mpesa')}}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if(get_setting('flutterwave') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="flutterwave" class="online_payment" type="radio" name="payment_option" checked>
                                                        <span class="d-block p-3 aiz-megabox-elem">
                                                            <img src="{{ static_asset('assets/img/cards/flutterwave.png')}}" class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span class="d-block fw-600 fs-15">{{ translate('flutterwave')}}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if(get_setting('payfast') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="payfast" class="online_payment" type="radio" name="payment_option" checked>
                                                        <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/payfast.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('payfast')}}</span>
                                                        </span>
                                                    </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endif
                                        @if(\App\Addon::where('unique_identifier', 'paytm')->first() != null && \App\Addon::where('unique_identifier', 'paytm')->first()->activated)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="paytm" class="online_payment" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/paytm.jpg')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('Paytm')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                        @if(get_setting('cash_payment') == 1)
                                            @php
                                                $digital = 0;
                                                $cod_on = 1;
                                                foreach($carts as $cartItem){
                                                    $product = \App\Product::find($cartItem['product_id']);
                                                    if($cartItem['digital'] == 1){
                                                        $digital = 1;
                                                    }
                                                    if($product['cash_on_delivery'] == 0){
                                                        $cod_on = 0;
                                                    }
                                                }
                                            @endphp
                                            @if($digital != 1 && $cod_on == 1)
                                                <div id="pay-button" class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="cash_on_delivery" data-target="mtinfo" class="online_payment tjs" type="radio" name="payment_option">
                                                        <span class="d-block p-3 aiz-megabox-elem">
                                                            <img src="{{ static_asset('icon/gopay.svg')}}" class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span class="d-block fw-600 fs-15">Gopay atau Mandiri VA</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endif
                                        @if (Auth::check())
                                            @if (\App\Addon::where('unique_identifier', 'offline_payment')->first() != null && \App\Addon::where('unique_identifier', 'offline_payment')->first()->activated)
                                                @foreach(\App\ManualPaymentMethod::all() as $method)
                                                    <div class="col-6 col-md-4">
                                                        <label class="aiz-megabox d-block mb-3">
                                                            <input class="tjs" value="{{ $method->heading }}" type="radio" name="payment_option" data-target="manual_payment_info_{{ $method->id }}" data-id="{{ $method->id }}">
                                                            
                                                            <span class="d-block p-3 aiz-megabox-elem">
                                                                <img src="{{ static_asset($method->photo) }}" class="img-fluid mb-2">
                                                                <span class="d-block text-center">
                                                                    <span class="d-block fw-600 fs-15">{{ $method->heading }}</span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endforeach

                                                @foreach(\App\ManualPaymentMethod::all() as $method)
                                                    <div id="manual_payment_info_{{ $method->id }}" class="d-none">
                                                        <div class="text-primary m5"><b>Metode Pembayaran yang dipilih :</b></div>
                                                        @if ($method->bank_info != null)
                                                        <table>
                                                            <tbody>
                                                            @foreach (json_decode($method->bank_info) as $key => $info)
                                                                <tr>
                                                                    <td>Metode Pembayaran</td>
                                                                    <td>:</td>
                                                                    <td><b> Transfer Bank Manual </b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Nama Bank</td>
                                                                    <td>:</td>
                                                                    <td><b> <span id="metode_manual_payment_info_{{ $method->id }}">{{ strtoupper($info->bank_name) }} </span> </b></td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td>Nomor Rekening Tujuan </td>
                                                                    <td>:</td>
                                                                    <td><b><span id="rekening_manual_payment_info_{{ $method->id }}">{{ $info->account_number}} </b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Atas Nama Rekening Tujuan </td>
                                                                    <td>:</td>
                                                                    <td><b> {{ ucwords($info->account_name) }} </b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Nominal Transfer </td>
                                                                    <td>:</td>
                                                                    <td><b> {{ single_price($total) }} </b></td>
                                                                </tr>
                                                                @endforeach 
                                                            </tbody>
                                                        </table>
                                                        <br>
                                                        <div class='text-primary m5'><b>Info : Setelah melakukan transfer harap melakukan konfirmasi pembayaran dengan cara klik Profile > Purchase History > Klik Nomor Faktur > Klik Pay > Lengkapi form konfirmasi berserta upload bukti transfer</b></div>
                                                        @endif
                                                        <?php /*
                                                        @php echo $method->description @endphp
                                                        @if ($method->bank_info != null)
                                                            <ul>
                                                                @foreach (json_decode($method->bank_info) as $key => $info)
                                                                    <li>{{ translate('Bank Name') }} - {{ $info->bank_name }}, {{ translate('Account Name') }} - {{ $info->account_name }}, {{ translate('Account Number') }} - {{ $info->account_number}}, {{ translate('Routing Number') }} - {{ $info->routing_number }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                        */ ?>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="bg-white border mb-3 p-3 rounded text-left d-none" id="pgtw"></div>
                                <div id="mtinfo" class="d-none">
                                <span id="metode_mtinfo"></span>
                                <span id="rekening_mtinfo"></span>
                                </div>
                            @if (Auth::check() && get_setting('wallet_system') == 1)
                                <div class="separator mb-3">
                                    <span class="bg-white px-3">
                                        <span class="opacity-60">{{ translate('Or')}}</span>
                                    </span>
                                </div>
                                <div class="text-center py-4">
                                    <div class="h6 mb-3">
                                        <span class="opacity-80">{{ translate('Your wallet balance :')}}</span>
                                        <span class="fw-600">{{ single_price(Auth::user()->balance) }}</span>
                                    </div>
                                    @if(Auth::user()->balance < $total)
                                        <button type="button" class="btn btn-secondary" disabled>
                                            {{ translate('Insufficient balance')}}
                                        </button>
                                    @else
                                        <button  type="button" onclick="use_wallet()" class="btn btn-primary fw-600">
                                            {{ translate('Pay with wallet')}}
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="pt-3">
                        <label class="aiz-checkbox">
                            <input type="checkbox" required id="agree_checkbox">
                            <span class="aiz-square-check"></span>
                            <span>{{ translate('I agree to the')}}</span>
                        </label>
                        <a href="{{ route('terms') }}">{{ translate('terms and conditions')}}</a>,
                        <a href="{{ route('returnpolicy') }}">{{ translate('return policy')}}</a> &
                        <a href="{{ route('privacypolicy') }}">{{ translate('privacy policy')}}</a>
                    </div>

                    <div class="row align-items-center pt-3">
                        <div class="col-6">
                            <a href="{{ route('home') }}" class="link link--style-3">
                                <i class="las la-arrow-left"></i>
                                {{ translate('Return to shop')}}
                            </a>
                        </div>
                        <div class="col-6 text-right">
                            <button id="paynow" type="button" onclick="submitOrder(this)" class="btn btn-primary fw-600" disabled>{{ translate('Complete Order')}}</button>
                            
                        </div>
                    </div>
                </form>
            </div>
            <div id="payload"></div>
            <div class="col-lg-4 mt-4 mt-lg-0" id="cart_summary">
                @include('frontend.partials.cart_summary')
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script type="text/javascript">
        let snapjs;
        let el = document.getElementById('pgtw');
        let mtinfo = document.getElementById('metode_mtinfo');
        let optc = document.querySelectorAll(".tjs");


        function use_wallet(){
            $('input[name=payment_option]').val('wallet');
            if($('#agree_checkbox').is(":checked")){
                $('#checkout-form').submit();
            }else{
                AIZ.plugins.notify('danger','{{ translate('You need to agree with our policies') }}');
            }
        }
        function submitOrder(el){
            $(el).prop('disabled', true);
            if($('#agree_checkbox').is(":checked")){
                $('#checkout-form').submit();
            }else{
                AIZ.plugins.notify('danger','{{ translate('You need to agree with our policies') }}');
                $(el).prop('disabled', false);
            }
        }

        
        $(document).on("click", "#coupon-apply",function() {
            var data = new FormData($('#apply-coupon-form')[0]);
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{route('checkout.apply_coupon_code')}}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data, textStatus, jqXHR) {
                    AIZ.plugins.notify(data.response_message.response, data.response_message.message);
                    console.log(data.response_message);
                    $("#cart_summary").html(data.html);
                }
            })
        });
        
        $(document).on("click", "#coupon-remove",function() {
            var data = new FormData($('#remove-coupon-form')[0]);
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{route('checkout.remove_coupon_code')}}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data, textStatus, jqXHR) {
                    $("#cart_summary").html(data);
                }
            })
        })
    </script>
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-Q1kCP3AOyqFMJtYt"></script>
    <script type="text/javascript">
        let  torupiah = (angka) =>{
            angka = angka.replace(".00","");
            let rupiah = '';		
            let angkarev = angka.toString().split('').reverse().join('');
            for(let i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
            return 'Rp '+rupiah.split('',rupiah.length-1).reverse().join('');
        };

        let angka = (rupiah) => {
            return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
        };

        let ucwords = (a)=>{
            a = a.toLowerCase().replace(/\b[a-z]/g, function(letter) { return letter.toUpperCase();});
            return a;
        }
        let noinput = document.querySelector("#nomor_pembayaran");
        let metodeinput = document.querySelector("#metode_pembayaran");
        let mdt = document.querySelector("#mdt");
        let paybtn = document.querySelector("#paynow");
        
        let exehasilsnap = (nominal,metode,pdf=null,nomor=null, bank= null, nomor2=null) =>{
            if(metode == "gopay"){ 
                mtinfo.innerHTML = "<div class='text-primary m5'><b>Metode Pembayaran yang dipilih : "+ucwords(metode)+"</b></div>"; 
                mtinfo.innerHTML += "<table><tbody><tr><td>Nominal Pembayaran</td><td>:</td><td><b>"+(nominal)+"</b></td></tr></tbody></table>"; 
            }
            else{
                mtinfo.innerHTML  ="<div class='text-primary m5'><b>Metode Pembayaran yang dipilih :</b></div><table id='polsit'><tbody></tbody></table>";
                
                let elsi = document.getElementById('polsit');
                if(metode == "echannel"){ bank = "Mandiri VA"; }
                if(bank != null){ elsi.innerHTML +="<tr><td>Metode Pembayaran</td><td>:</td><td><b>"+ucwords(metode)+" "+bank.toUpperCase()+"</b></td></tr>"; }
                else{ elsi.innerHTML += "<tr><td>Metode Pembayaran</td><td>:</td><td><b>"+ucwords(metode)+"</b></td></tr>"; }

                if(nomor2 != null){
                    elsi.innerHTML += "<tr><td>Nomor Perusahaan</td><td>:</td><td><b>"+nomor2+"</b></td></tr>";
                }

                elsi.innerHTML += "<tr><td>Nominal Pembayaran</td><td>:</td><td><b>"+(nominal)+"</b></td></tr>"; 

                if(nomor != null){
                    elsi.innerHTML += "<tr><td>Nomor Pembayaran "+ucwords(metode)+"</td><td>:</td><td><b>"+nomor+"</b></td></tr>";
                }
    
                if(pdf != null){
                    elsi.innerHTML += "<tr><td>Panduan Pembayaran </td><td>:</td><td><a href='"+pdf+"' target='_blank'>Download PDF</a></td></tr>";
                }           
            }

            el.innerHTML = mtinfo.innerHTML;

        };       

        let outputsnap = (result)=>{
            console.log(result);
            let metode1 = result.payment_type.replace("_"," ");
            if(result.payment_type == "bank_transfer"){
                metodeinput.value = ucwords(metode1+" "+result.va_numbers[0].bank);
                noinput.value = result.va_numbers[0].va_number; 
                nominal = torupiah(result.gross_amount);      
                exehasilsnap(nominal,metode1,result.pdf_url,result.va_numbers[0].va_number,result.va_numbers[0].bank);             
            }else if(result.payment_type == "echannel"){
                metodeinput.value = ucwords(metode1);
                noinput.value = result.biller_code+" - "+result.bill_key;
                nominal = torupiah(result.gross_amount); 
                exehasilsnap(nominal,metode1,result.pdf_url,result.bill_key,null,result.biller_code);    
            } else{
                metodeinput.value = ucwords(metode1);
                nominal = torupiah(result.gross_amount); 
                exehasilsnap(nominal,metode1);    
            }
                    
             if((metodeinput.value) != ""){ paybtn.removeAttribute("disabled"); }   
             mdt.innerHTML += "<input type='hidden' id='file_pdf' name='file_pdf' value="+result.pdf_url+">";
             //document.getElementById('payload').innerHTML += JSON.stringify(result, null, 2);  
        };
        snapjs = () =>{
            document.getElementById('pay-button').onclick = () =>{
                // SnapToken acquired from previous step
            snap.pay('{{ $snapToken }} ', {
                    // Optional
                    onSuccess: function(result){
                        outputsnap(result);
                    },
                    // Optional
                    onPending: function(result){ 
                        outputsnap(result);           
                    },
                    // Optional
                    onError: function(result){
                        /* You may add your own js here, this is just example  document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2); */
                    }
                });
            };
        };

        optc.forEach(elop =>{
            let dtar = elop.getAttribute("data-target");
            elop.onclick = (a) =>{
                let eltar = document.querySelector("#"+dtar);
                console.log(dtar);
                let metode2 = document.querySelector("#metode_"+dtar).innerHTML;
                let rekening2 = document.querySelector("#rekening_"+dtar).innerHTML;

                el.classList.remove("d-none");
                el.innerHTML = ""; 
                if(elop.value == "cash_on_delivery"){ 
                    if(mtinfo.innerHTML == ""){snapjs();}
                } else{
                    metodeinput.value = ucwords("Transfer Bank "+metode2);
                    noinput.value = rekening2;
                }
                el.innerHTML = eltar.innerHTML;
                paybtn.removeAttribute("disabled"); 
            };
        });
        
    </script>    
@endsection
