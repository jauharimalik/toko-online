@extends('frontend.layouts.app')

@section('content')
<style>
.pilihongkir{
    width: 100%;
    display: inline-block;
    flex: none;
    overflow-x: scroll;
    white-space: nowrap;
}

.pilihongkir>div {
    display: inline-block;
    width: 30%;
    padding: 10px 3px;
    margin: 0;
}
.pilihongkir>div:first-child{ padding-left:0;}
.pilihongkir>div:last-child{ padding-right:0;}
.bootstrap-select .dropdown-toggle {
    color: #000000;
    background-color: transparent !important;
    border-color: var(--primary);
    padding: .5rem 1rem;
}
.tprimary{color:var(--primary);}
.active .tprimary{color:#fff;}
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
                    <div class="col active">
                        <div class="text-center text-primary">
                            <i class="la-3x mb-2 las la-truck"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('3. Delivery info')}}</h3>
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-center">
                            <i class="la-3x mb-2 opacity-50 las la-credit-card"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50">{{ translate('4. Payment')}}</h3>
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

<form class="form-default" action="{{ route('checkout.store_delivery_info') }}" role="form" method="POST">
    @csrf
@foreach($kumpulan_seller as $ks => $vs)

<section class="gry-bg ">
    <div class="container">
        <div class="row cols-xs-space cols-sm-space cols-md-space">
            <div class="col-xxl-8 col-xl-10 mx-auto text-left">
                @php
                    $admin_products = array();
                    $seller_products = array();
                    foreach ($carts as $key => $cartItem){
                        if(\App\Product::find($cartItem['product_id'])->added_by == 'admin'){
                            array_push($admin_products, $cartItem['product_id']);
                        }
                        else{
                            $product_ids = array();
                            if(array_key_exists(\App\Product::find($cartItem['product_id'])->user_id, $seller_products)){
                                $product_ids = $seller_products[\App\Product::find($cartItem['product_id'])->user_id];
                                $seller_products[\App\Product::find($cartItem['product_id'])->user_id] = $product_ids;
                                array_push($admin_products, $cartItem['product_id']);
                            }
                            array_push($product_ids, $cartItem['product_id']);
                            $seller_products2 = "";
                        }
                    }
                @endphp

                    <div class="card mb-3 shadow-sm border-0 rounded">
                        <div class="card-header p-3">
                            <h5 class="fs-16 fw-600 mb-0">Produk {{ $vs['nama'] }}</h5>
                        </div>
                        <div class="card-body pt-0">
                            <div class="d-flex">
                                @foreach ($vs['produk'] as $key => $cartItem)
                                <span class="my-2 mr-2 shadow rounded">
                                    <img
                                        src="{{ uploaded_asset($cartItem['gambar']) }}"
                                        class="img-fit size-60px rounded"
                                        alt="{{  $cartItem['nama_produk']  }}">
                                </span>
                                @endforeach
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-12">
                                    <?php /*
                                    @if($vs['su'] >= 1)
                                    <div class="row gutters-5">                             
                                        <div class="col-6">
                                            <label class="aiz-megabox d-block bg-white mb-0">
                                                <input
                                                    type="radio"
                                                    name="shipping_type_{{ \App\User::where('user_type', 'admin')->first()->id }}"
                                                    value="home_delivery"
                                                    onchange="show_pickup_point(this)"
                                                    data-target=".pilihkurir"
                                                    checked
                                                >
                                                <span class="d-flex p-3 aiz-megabox-elem">
                                                    <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                    <span class="flex-grow-1 pl-3 fw-600">{{  translate('Home Delivery') }}</span>
                                                </span>
                                            </label>
                                        </div>
                                        @if (\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1)
                                        <div class="col-6">
                                            <label class="aiz-megabox d-block bg-white mb-0">
                                                <input
                                                    type="radio"
                                                    name="shipping_type_{{ \App\User::where('user_type', 'admin')->first()->id }}"
                                                    value="pickup_point"
                                                    onchange="show_pickup_point(this)"
                                                    data-target=".pickup_point_id_admin"
                                                >
                                                <span class="d-flex p-3 aiz-megabox-elem">
                                                    <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                    <span class="flex-grow-1 pl-3 fw-600">{{  translate('Local Pickup') }}</span>
                                                </span>
                                            </label>
                                        </div>
                                        @endif
                                    </div>
                                    @endif

                                    */ ?>
                                    
                                    <div class="mt-2 pilihkurir pilihan2">
                                        <h6 class="fs-15 fw-600 mb-3">Lokasi Toko </h6>
                                        <div class="mt-2 pilihgudang">
                                            <select
                                                class="form-control aiz-selectpicker pilgudang lokasigudang"
                                                name="pilgudang[{{$vs['id']}}]"
                                                data-live-search="true"
                                                onchange="getongkirnya(this)"
                                                data-berat="{{ $vs['berat']}}"
                                                data-panel="{{$vs['id']}}"
                                                required
                                            >
                                                <option>Barang Dikirim Dari</option>
                                                @foreach ($vs['alamat'] as $keyg => $valg)
                                                    <option
                                                        @if(max(array($valg->set_default)) > 0)
                                                            selected="selected"
                                                        @else
                                                            @if($keyg == 0)
                                                            selected="selected"
                                                            @endif
                                                        @endif
                                                        value="{{ $valg->id }}"
                                                        data-content="<span class='d-block'>
                                                                        <span class='d-block fs-16 fw-600 mb-1 tprimary'>{{ $valg->city }}</span>
                                                                        <span class='d-block opacity-50 fs-12'><i class='las la-map-marker'></i> {{ $valg->address }}</span>
                                                                        <span class='d-block opacity-50 fs-12'><i class='las la-phone'></i> {{ $valg->phone }}</span>
                                                                    </span>"
                                                    >
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div> 
                                        <div class="mt-4 pilongkir_{{$vs['id']}}"></div>                                                     
                                    </div>

                                    <?php /*
                                    <div class="mt-4 pickup_point_id_admin pilihan2 d-none">
                                        <select
                                            class="form-control aiz-selectpicker"
                                            name="pickup_point_id_{{ \App\User::where('user_type', 'admin')->first()->id }}"
                                            data-live-search="true"
                                        >
                                                <option>{{ translate('Select your nearest pickup point')}}</option>
                                            @foreach (\App\PickupPoint::where('pick_up_status',1)->get() as $key => $pick_up_point)
                                                <option
                                                    value="{{ $pick_up_point->id }}"
                                                    data-content="<span class='d-block'>
                                                                    <span class='d-block fs-16 fw-600 mb-2'>{{ $pick_up_point->getTranslation('name') }}</span>
                                                                    <span class='d-block opacity-50 fs-12'><i class='las la-map-marker'></i> {{ $pick_up_point->getTranslation('address') }}</span>
                                                                    <span class='d-block opacity-50 fs-12'><i class='las la-phone'></i>{{ $pick_up_point->phone }}</span>
                                                                </span>"
                                                >
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    */ ?>
                                </div>
                            </div>
                            
                        </div>
                        <?php /*
                        <div class="card-footer justify-content-end lanjutbayar">
                            <button type="submit" name="owner_id" value="{{ App\User::where('user_type', 'admin')->first()->id }}" class="btn fw-600 btn-primary">{{ translate('Continue to Payment')}}</a>
                        </div>
                        */ ?>
                    </div>
                    
                <?php /*
                @if (!empty($seller_products2))
                        @foreach ($seller_products as $key => $seller_product)
                            <div class="card mb-3 shadow-sm border-0 rounded">
                                <div class="card-header p-3">
                                    <h5 class="fs-16 fw-600 mb-0">Produk {{ $vs['nama'] }} ny</h5>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-flush">
                                        @foreach ($seller_product as $cartItem)
                                        @php
                                            $product = \App\Product::find($cartItem);
                                        @endphp
                                        <li class="list-group-item">
                                            <div class="d-flex">
                                                <span class="mr-2">
                                                    <img
                                                        src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                        class="img-fit size-60px rounded"
                                                        alt="{{  $product->getTranslation('name')  }}"
                                                    >
                                                </span>
                                                <span class="fs-14 opacity-60">{{ $product->getTranslation('name') }}</span>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    
                                    <div class="row border-top pt-3">
                                        <div class="col-md-6">
                                            <h6 class="fs-15 fw-600">{{ translate('Choose Delivery Type') }}</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row gutters-5">
                                                <div class="col-6">
                                                    <label class="aiz-megabox d-block bg-white mb-0">
                                                        <input
                                                            type="radio"
                                                            name="shipping_type_{{ $key }}"
                                                            value="home_delivery"
                                                            onchange="show_pickup_point(this)"
                                                            data-target=".pickup_point_id_{{ $key }}"
                                                            checked
                                                        >
                                                        <span class="d-flex p-3 aiz-megabox-elem">
                                                            <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                            <span class="flex-grow-1 pl-3 fw-600">{{  translate('Home Delivery') }}</span>
                                                        </span>
                                                    </label>
                                                </div>
                                                @if (\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1)
                                                    @if (is_array(json_decode(\App\Shop::where('user_id', $key)->first()->pick_up_point_id)))
                                                    <div class="col-6">
                                                        <label class="aiz-megabox d-block bg-white mb-0">
                                                            <input
                                                                type="radio"
                                                                name="shipping_type_{{ $key }}"
                                                                value="pickup_point"
                                                                onchange="show_pickup_point(this)"
                                                                data-target=".pickup_point_id_{{ $key }}"
                                                            >
                                                            <span class="d-flex p-3 aiz-megabox-elem">
                                                                <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                                <span class="flex-grow-1 pl-3 fw-600">{{  translate('Local Pickup') }}</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    @endif
                                                @endif
                                            </div>
                                            @if (\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1)
                                                @if (is_array(json_decode(\App\Shop::where('user_id', $key)->first()->pick_up_point_id)))
                                                <div class="mt-4 pickup_point_id_{{ $key }} d-none">
                                                    <select
                                                        class="form-control aiz-selectpicker"
                                                        name="pickup_point_id_{{ $key }}"
                                                        data-live-search="true"
                                                    >
                                                            <option>{{ translate('Select your nearest pickup point')}}</option>
                                                        @foreach (json_decode(\App\Shop::where('user_id', $key)->first()->pick_up_point_id) as $pick_up_point)
                                                            @if (\App\PickupPoint::find($pick_up_point) != null)
                                                            <option
                                                                value="{{ \App\PickupPoint::find($pick_up_point)->id }}"
                                                                data-content="<span class='d-block'>
                                                                                <span class='d-block fs-16 fw-600 mb-2'>{{ \App\PickupPoint::find($pick_up_point)->getTranslation('name') }}</span>
                                                                                <span class='d-block opacity-50 fs-12'><i class='las la-map-marker'></i> {{ \App\PickupPoint::find($pick_up_point)->getTranslation('address') }}</span>
                                                                                <span class='d-block opacity-50 fs-12'><i class='las la-phone'></i> {{ \App\PickupPoint::find($pick_up_point)->phone }}</span>
                                                                            </span>"
                                                            >
                                                            </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="card-footer justify-content-end">
                                    
                                </div>
                            </div>
                        @endforeach
                    @endif
                */ ?>
                
            </div>
        </div>
        

    </div>
    
</section>
@endforeach
<input type="text" name="shipping" value="0" class="d-none sipokeh">
<div class="ongkirlist"></div>
<section class="gry-bg mb-4">
    <div class="container">
        <div class="row cols-xs-space cols-sm-space cols-md-space">
            <div class="col-xxl-8 col-xl-10 mx-auto row">
                <div class="col-md-6 text-center text-md-left order-1 order-md-0">
                    <a href="{{ route('checkout.shipping_info') }}" class="btn btn-link"> <i class="las la-arrow-left"></i> Kembali </a>
                </div>
                <div class="col-md-6 text-center text-md-right">
                    <button type="submit" name="owner_id" class="btn fw-600 btn-primary lanjutbayar">{{ translate('Lanjut ke Pembayaran')}}</a>
                </div>
            </div>
        </div>
    </div>
</section>    
</form>

@endsection

@section('script')
    <script type="text/javascript">
        function display_option(key){

        }
        function show_pickup_point(el) {
        	var value = $(el).val();
        	var target = $(el).data('target');

            // console.log(value);
            $(".pilihan2").addClass('d-none'); 
            $(".pilihan2"+target).removeClass('d-none');

        }

        document.querySelector(".lanjutbayar").classList.add("d-none");
        let jmlc = 0;
        let shownext = (x)=>{
            if(x == {{ count($kumpulan_seller) }}){
                document.querySelector(".lanjutbayar").classList.remove("d-none");
            }
        }

        let ongkir = 0;
        let totalpengiriman = () =>{
            document.querySelector(".ongkirlist").innerHTML = "";
            let arrh = [];
            let sump = (accumulator, curr) => accumulator + curr;
            document.querySelectorAll(".infoship:checked").forEach((data)=>{
                ongkir = parseInt(data.getAttribute("data-price"));
                arrh.push(ongkir);
                let sellerid = data.getAttribute("data-seller");
                let panongkir = document.createElement("div");
                panongkir.innerHTML = "<input type='text' class='d-none' name='ongkir["+sellerid+"]' value='"+ongkir+"'>";
                document.querySelector(".ongkirlist").appendChild(panongkir);
                
            });

            let totong = parseInt(arrh.reduce(sump));
            document.querySelector(".sipokeh").value = totong;
            document.querySelector(".sipokeh").setAttribute("value",totong);
        }
        let getongkirnya = (el) =>{
            
            let berat = el.getAttribute("data-berat");
            let panel = el.getAttribute("data-panel");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('checkout.cekongkir')}}",
                type: 'POST',
                data: {
                    asal:el.value,tujuan:{{ $kota_id }},berat:berat,panel:panel
                },
                success: function (response) {
                    $(".pilongkir_"+panel).html(response);
                    jmlc++;
                    shownext(jmlc);
                    totalpengiriman();
                    
                }
            });
            
        };

        let lokasigudang = document.querySelectorAll('select[class~="lokasigudang"]');
        lokasigudang.forEach((gudang)=>{
            getongkirnya(gudang);
        });
        

    </script>
@endsection
