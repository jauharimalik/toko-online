<?php
namespace App;

class Rajaongkir{
    
    public function awal($tipe,$field){
        $curl = curl_init();
        $key = "fa989f8576723ca4522fc0080d0a23e8";
        $key2 = "3993431dbd390ea00bca6a6db518c77f";
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.rajaongkir.com/starter/".$tipe,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $field,
          CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: fa989f8576723ca4522fc0080d0a23e8"
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }       
    }

    public function int3($s){return(int)preg_replace('/[^\-\d]*(\-?\d*).*/','$1',$s);}

    public function konversihari($a){
        $a = strtolower($a);
        if (strpos($a, 'hari') !== false) { $a = str_replace("hari","",$a);}
        if($this->int3($a) > 0){
            return $a." hari";
        } else { return "1 - 14 hari";}
        
    }

    public function convertkg($a){
        $a = $this->int3($a);
        $b = intval($a / 1000);
        if(($a %1000) != 0){ $b = $b+1;}
        return $b;
    }

    public function cekongkir($tujuan,$berat,$lokasi = null,$kurir=null){
        $row = [];
        $hasil2 = [];
        $no = 0;
        $berat = ($berat == 0) ? 1000 : $berat;
        $lokasi = $lokasi ?? 154;
        $target_tujuan = $tujuan[0];
        $tipe_tujuan = $tujuan[1];
        $kurx = ["jne","tiki","pos"];
        if($kurir){
            $isian = "origin=$lokasi&originType=city&destination=$target_tujuan&destinationType=$tipe_tujuan&weight=$berat&courier=$kurir";
            $res = $this->awal("cost",$isian);
            $hasil = json_decode($res);
            $hasilx = $hasil->rajaongkir->results;
            array_push($hasil2,$hasilx);
        }else{
            foreach($kurx as $kk => $kv){
                $isian = "origin=$lokasi&originType=city&destination=$target_tujuan&destinationType=$tipe_tujuan&weight=$berat&courier=$kv";
                $res = $this->awal("cost",$isian);
                $hasil = json_decode($res);
                $hasilx = ($hasil->rajaongkir->results);
                foreach( $hasilx as $key=>$value){
                    $no++;
        
                    $kurir = strtoupper($value->code);
                    foreach($value->costs as $key2=>$value2){
                        foreach($value2->cost as $key3=>$value3){
                            if($value3->value > 0){
                                $newarr = array_push($row,array(
                                    "kurir"=>$kurir,
                                    "jenis"=>$value2->service,
                                    "tarif"=>$value3->value,
                                    "in_rp"=>"Rp ".$this->int3($value3->value),
                                    "est"=>$this->konversihari($value3->etd)
                                ));
                            }
                            
                        }
                    }
                    
                }            
            } 
        }


        
        //return $res;
        return json_encode($row);
    }


}
