<h6 class="fs-15 fw-600">Pilih Kurir</h6>
<div class="scrollsamping ">
@php 
    $i = 0;
    foreach($cek_ongkir as $key_ongkir => $val_ongkir){
        $i++;
        if($i==1){ $ci = "checked";}
        else{$ci ="";}
@endphp
    <div class="col-6">
        <label class="aiz-megabox d-block bg-white mb-0">
            <input
                class="infoship"
                onclick="totalpengiriman()"
                type="radio"
                data-seller="{{ $pengirim_id }}"
                data-price="{{ $berat * $val_ongkir->ongkir_tarif }}"
                name="shipping_kurir[{{ $panel }}]"
                value="@php echo $val_ongkir->ongkir_kurir."-".$val_ongkir->ongkir_jenis; @endphp"
                 {{ $ci }}
            >
            <span class="d-flex p-3 aiz-megabox-elem">
                <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                <span class="flex-grow-1 pl-3 fw-600"> 
                @php echo $val_ongkir->ongkir_kurir." ".$val_ongkir->ongkir_jenis; @endphp <br>
                <span class="text-primary fs16">{{ single_price($berat * $val_ongkir->ongkir_tarif) }}</span> <br>
                <small>{{ $val_ongkir->ongkir_est }}</small> <br>
                </span>
            </span>
        </label>
    </div>                                    
@php
        
    }
@endphp
</div>                                              