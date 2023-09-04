<form class="form-default" role="form" action="{{ route('addresses.update', $address_data->id) }}" method="POST">
    @csrf
    <div class="p-3">
        <div class="row">
            <div class="col-md-3">
                <label>{{ translate('Address')}}</label>
            </div>
            <div class="col-md-9">
                <textarea class="form-control mb-3" placeholder="{{ translate('Your Address')}}" rows="2" name="address" required>{{ $address_data->address }}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label>Provinsi</label>
            </div>
            <div class="col-md-9">
                @php $idc = ""; @endphp
                <div class="mb-3">
                    <select class="form-control aiz-selectpicker" data-live-search="true" data-placeholder="{{ translate('Select your country')}}" name="country" id="edit_country" required>
                        @foreach (\App\Country::where('status', 1)->get() as $key => $country)
                        <option value="{{ $country->name }}" 
                            <?php if($address_data->country == $country->name){ $idc = $country->id; } ?> 
                            @if($address_data->country == $country->name) selected @endif>
                            {{ $country->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <label>Kota</label>
            </div>
            <div class="col-md-9">
                <select class="form-control mb-3 aiz-selectpicker" data-live-search="true" name="city" required>
                @php $idk=""; @endphp
                @foreach (\App\City::where('country_id', $idc)->get() as $key => $kota)
                    <option value="{{ $kota->name }}" <?php if($address_data->city == $kota->name){ echo "selected"; $idk = $kota->id; } ?>>
                            {{ $kota->name }}
                    </option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label>Kecamatan</label>
            </div>
            <div class="col-md-9">
                <select class="form-control mb-3 aiz-selectpicker" data-live-search="true" name="kecamatan" required>
                    @foreach (\App\Kecamatan::where('city_id', $idk)->get() as $key => $kecamatan)
                    <option value="{{ $kecamatan->name }}" @if($address_data->kecamatan == $kecamatan->name) selected @endif>
                            {{ $kecamatan->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div> 
        <div class="row">
            <div class="col-md-3">
                <label>Patokan</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control mb-3" placeholder="{{ translate('Masukkan Patokan Lokasi')}}" value="{{ $address_data->postal_code }}" name="postal_code" value="" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label>{{ translate('Nomor WA')}} </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control mb-3" placeholder="{{ translate('0857 8155 0337')}}" value="@isset($address_data->phone){{ $address_data->phone }} @endisset" name="phone" required>
            </div>
        </div>
        <div id="adddrpedit"></div>  
        <hr><br>         
        <div class="form-group text-right">
            <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
        </div>
    </div>
</form>