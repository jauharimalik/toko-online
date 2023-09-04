@extends('frontend.layouts.app')

@section('content')
<style>
.overhide{overflow: hidden;}
.mh200{min-height:220px;line-height: 1.7;}
.dropship{
    transform: rotate(40deg);
    position: absolute;
    right: -40px;
    top: 10px;
    padding: 10px 25%;
    width: 60%;
}
</style>
<section class="pt-5 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="row aiz-steps arrow-divider">
                    <div class="col done">
                        <div class="text-center text-success">
                            <i class="la-3x mb-2 las la-shopping-cart"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block ">{{ translate('1. My Cart')}}</h3>
                        </div>
                    </div>
                    <div class="col active">
                        <div class="text-center text-primary">
                            <i class="la-3x mb-2 las la-map"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block ">{{ translate('2. Shipping info')}}</h3>
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-center">
                            <i class="la-3x mb-2 opacity-50 las la-truck"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50 ">{{ translate('3. Delivery info')}}</h3>
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-center">
                            <i class="la-3x mb-2 opacity-50 las la-credit-card"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50 ">{{ translate('4. Payment')}}</h3>
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-center">
                            <i class="la-3x mb-2 opacity-50 las la-check-circle"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50 ">{{ translate('5. Confirmation')}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mb-4 gry-bg">
    <div class="container">
        <div class="row cols-xs-space cols-sm-space cols-md-space">
            <div class="col-xxl-8 col-xl-10 mx-auto">
                <form class="form-default" data-toggle="validator" action="{{ route('checkout.store_shipping_infostore') }}" role="form" method="POST">
                    @csrf
                        @if(Auth::check())
                        <div class="shadow-sm bg-white p-4 rounded mb-4">
                            <div class="row gutters-5">
                                @php
                                $i = 0;
                                foreach (Auth::user()->addresses as $key => $address){
                                    $i++;
                                    if($i == 1){ $ci = "checked";}
                                    else { $ci = "";}
                                    if($address->dropship >= 1){ $classinc = "<div class='btn-primary dropship'> Dropshipp</div>";}
                                    else{$classinc = "";}
                                    
                                @endphp
                                    <div class="col-md-6 mb-3">
                                        <label class="aiz-megabox  d-block bg-white mb-0 overhide">
                                            <input type="radio" name="address_id" value="{{ $address->id }}" @if ($address->set_default)
                                                
                                             @else  {{ $ci }} @endif required>
                                             @php echo $classinc; @endphp
                                            <span class="d-flex mh200 p-3 aiz-megabox-elem">
                                                <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                <span class="flex-grow-1 pl-3 text-left">
                                                    <div>
                                                        <span class="opacity-60">Alamat :</span>
                                                        <span class="fw-600 ml-2">{{ $address->address }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="opacity-60">Patokan:</span>
                                                        <span class="fw-600 ml-2">{{ $address->postal_code }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="opacity-60">Provinsi:</span>
                                                        <span class="fw-600 ml-2">{{ $address->country }}</span>
                                                    </div>                                                    
                                                    <div>
                                                        <span class="opacity-60">Kota:</span>
                                                        <span class="fw-600 ml-2">{{ $address->city }}</span>
                                                    </div>
                                                    @if ($address->penerima != null)
                                                    <div>
                                                        <span class="opacity-60">Penerima :</span>
                                                        <span class="fw-600 ml-2">{{ $address->penerima }}</span>
                                                    </div>                          
                                                    @endif                         
                                                    <div>
                                                        <span class="opacity-60">Nomor Whatsapp:</span>
                                                        <span class="fw-600 ml-2">{{ $address->phone }}</span>
                                                    </div>
                                                </span>
                                            </span>
                                        </label>
                                        <div class="dropdown position-absolute right-0 top-0">
                                            <button class="btn bg-gray px-2" type="button" data-toggle="dropdown">
                                                <i class="la la-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" onclick="edit_address('{{$address->id}}')">
                                                    {{ translate('Edit') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @php }  @endphp
                                
                                <input type="hidden" name="checkout_type" value="logged">
                                <div class="col-md-6 mx-auto mb-3" >
                                    <div class="border p-3 rounded mb-3 c-pointer text-center bg-white h-100 d-flex flex-column justify-content-center" onclick="add_new_address()">
                                        <i class="las la-plus la-2x mb-3"></i>
                                        <div class="alpha-7">Tambahkan Alamat Utama</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                            <div class="shadow-sm bg-white p-4 rounded mb-4">
                                <div class="form-group">
                                    <label class="control-label">{{ translate('Name')}}</label>
                                    <input type="text" class="form-control" name="name" placeholder="{{ translate('Name')}}" required>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">{{ translate('Email')}}</label>
                                    <input type="text" class="form-control" name="email" placeholder="{{ translate('Email')}}" required>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">{{ translate('Address')}}</label>
                                    <input type="text" class="form-control" name="address" placeholder="{{ translate('Address')}}" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">{{ translate('Select your country')}}</label>
                                            <select class="form-control aiz-selectpicker" data-live-search="true" name="country">
                                                @foreach (\App\Country::where('status', 1)->get() as $key => $country)
                                                    <option value="{{ $country->name }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            
                                            <label class="control-label">{{ translate('City')}}</label>
                                            <select class="form-control aiz-selectpicker" data-live-search="true" name="city" required>
                                                @foreach (\App\City::get() as $key => $city)
                                                    <option value="{{ $city->name }}">{{ $city->getTranslation('name') }}</option>
                                                @endforeach
                                            </select>
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">{{ translate('Postal code')}}</label>
                                            <input type="text" class="form-control" placeholder="{{ translate('Postal code')}}" name="postal_code" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">{{ translate('Phone')}}</label>
                                            <input type="number" lang="en" min="0" class="form-control" placeholder="{{ translate('Phone')}}" name="phone" required>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="checkout_type" value="guest">
                            </div>
                        @endif
                    <div class="row align-items-center">
                        <div class="col-md-6 text-center text-md-left order-1 order-md-0">
                            <a href="{{ route('home') }}" class="btn btn-link">
                                <i class="las la-arrow-left"></i>
                                {{ translate('Return to shop')}}
                            </a>
                        </div>
                        <div class="col-md-6 text-center text-md-right">
                            <button type="submit" class="btn btn-primary fw-600">{{ translate('Continue to Delivery Info')}}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('modal')


<div class="modal fade" id="new-address-modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-zoom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">{{ translate('New Address')}}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-default" role="form" action="{{ route('addresses.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Alamat</label>
                            </div>
                            <div class="col-md-8">
                                <textarea class="form-control textarea-autogrow mb-3" placeholder="Alamat Lengkap" rows="1" name="address" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Provinsi</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control mb-3 aiz-selectpicker" data-live-search="true" name="country" required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach (\App\Country::where('status', 1)->get() as $key => $country)
                                        <option value="{{ $country->name }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label>Kota</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control mb-3 aiz-selectpicker" data-live-search="true" name="city" required>

                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <label>Patokan</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control mb-3" placeholder="Patokan Lokasi" name="postal_code" value="" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Nomor Whatsapp</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control mb-3" placeholder="{{ translate('+6285781550337')}}" name="phone" value="" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Dropship</label>
                            </div>
                            <div class="col-md-8">
                                <select id="dropshipcek" class="form-control mb-3 aiz-selectpicker"name="dropship" required>
                                    <option value="0">Tidak, Jadikan alamat pribadi</option>
                                    <option value="1">Iya, Kirim sebagai Dropshipper</option>
                                </select>
                            </div>
                        </div>
                        <div id="adddrp"></div>               
                    </div>
                </div>
                   
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{  translate('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ translate('New Address') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body" id="edit_modal_body">

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    function edit_address(address) {
        var url = '{{ route("addresses.edit", ":id") }}';
        url = url.replace(':id', address);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'GET',
            success: function (response) {
                $('#edit_modal_body').html(response);
                $('#edit-address-modal').modal('show');
                AIZ.plugins.bootstrapSelect('refresh');
                var country = $("#edit_country").val();
                get_city(country);
            }
        });
    }

    $(document).on('change', '[name=country]', function() {
        var country = $(this).val();
        get_city(country);
    });
    
    function get_city(country) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get-city')}}",
            type: 'POST',
            data: {
                country_name: country
            },
            success: function (response) {
                var obj = JSON.parse(response);
                if(obj != '') {
                    $('[name="city"]').html(obj);
                    var city = $("[name='city']").val();
                    get_kecamatan(city);
                    AIZ.plugins.bootstrapSelect('refresh');
                }
            }
        });
    }
    
    $(document).on('change', '[name=city]', function() {
        var city = $(this).val();
        get_kecamatan(city);
    });

    function get_kecamatan(city) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get-kecamatan')}}",
            type: 'POST',
            data: {
                city_name: city
            },
            success: function (response) {
                var obj = JSON.parse(response);
                if(obj != '') {
                    $('[name="kecamatan"]').html(obj);
                    AIZ.plugins.bootstrapSelect('refresh');
                }
            }
        });
    }

    function add_new_address(){
        $('#new-address-modal').modal('show');
    }
    
    let drpc = document.querySelector("#dropshipcek");
    drpc.onchange = () =>{
        if(drpc.value == 1){
            document.querySelector("#adddrp").innerHTML ="<div class='row'><div class='col-md-4'><label>Penerima</label></div><div class='col-md-8'><input type='text' class='form-control mb-3' placeholder='Nama Penerima' name='penerima'></div></div>"
        }
    };

    
</script>
@endsection
