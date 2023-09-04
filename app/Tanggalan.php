<?php

namespace App;


class Tanggalan
{
    
    public static function expired($a){
        $tanggal_besok = date('D, Y-m-d', strtotime($a.' +1 day'));
        $tanggal0 = explode(" ",$tanggal_besok);
        $hari = Self::hari(str_replace(",","",$tanggal0[0]));
        $tanggal = Self::tgl_indo($tanggal0[1]);
        $exp = $hari.", ".$tanggal;
        return $exp;
    }


    public static function rupiah($angka){
        $rupiah="";
        $rp=strlen($angka);
        while ($rp>3)
        {
            $rupiah = ".". substr($angka,-3). $rupiah;
            $s=strlen($angka) - 3;
            $angka=substr($angka,0,$s);
            $rp=strlen($angka);
        }
        $rupiah = $angka . $rupiah . ",-";
        return $rupiah;
    }
    
    public static function tanggalIndonesia($data){
        $tahunSelesai = substr($data,0,4);
        $bulanSelesai = substr($data,5,2);
        $tanggalSelesai = substr($data,8,2);
        $dataIndonesia = $tanggalSelesai . "/" . $bulanSelesai . "/" . $tahunSelesai;
        return $dataIndonesia;
    }
    
    public static function tgl_indo($tanggal){
        $bulan = array (
            1 =>  'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        );
        $pecahkan = explode('-', $tanggal);
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }
    
    public static function tanggalIndonesiaString($data){
        $tahunSelesai = substr($data,0,4);
        $bulanSelesai = substr($data,5,2);
        $tanggalSelesai = substr($data,8,2);
        if($bulanSelesai==1){
            $nama_bulan = "Januari";
        }elseif($bulanSelesai==2){
            $nama_bulan = "Februari";
        }elseif($bulanSelesai==3){
            $nama_bulan = "Maret";
        }elseif($bulanSelesai==4){
            $nama_bulan = "April";
        }elseif($bulanSelesai==5){
            $nama_bulan = "Mei";
        }elseif($bulanSelesai==6){
            $nama_bulan = "Juni";
        }elseif($bulanSelesai==7){
            $nama_bulan = "Juli";
        }elseif($bulanSelesai==8){
            $nama_bulan = "Agustus";
        }elseif($bulanSelesai==9){
            $nama_bulan = "September";
        }elseif($bulanSelesai==10){
            $nama_bulan = "Oktober";
        }elseif($bulanSelesai==11){
            $nama_bulan = "November";
        }elseif($bulanSelesai==12){
            $nama_bulan = "Desember";
        }
        
        
        
        $dataIndonesia = $tanggalSelesai . " " . $nama_bulan . " " . $tahunSelesai;
        return $dataIndonesia;
    }
    
    public static function bulanIndonesia($bulan){
    
        if($bulan==1) $bulanId = 'Januari';
        elseif ($bulan==2)  $bulanId = 'Februari';
        elseif ($bulan==3)  $bulanId = 'Maret';
        elseif ($bulan==4)  $bulanId = 'April';
        elseif($bulan==5)  $bulanId = 'Mei';
        elseif ($bulan==6)  $bulanId = 'Juni';
        elseif ($bulan==7)  $bulanId = 'Juli';
        elseif ($bulan==8)  $bulanId = 'Agustus';
        elseif ($bulan==9)  $bulanId = 'September';
        elseif ($bulan==10)  $bulanId = 'Oktober';
        elseif ($bulan==11)  $bulanId = 'November';
        elseif ($bulan==12)  $bulanId = 'Desember';
    
        return $bulanId;
    }
    
    public static function hari($hari){
        switch($hari){
            case 'Sun':
                $hari_ini = "Minggu";
            break;
            
            case 'Mon':			
                $hari_ini = "Senin";
            break;
     
            case 'Tue':
                $hari_ini = "Selasa";
            break;
     
            case 'Wed':
                $hari_ini = "Rabu";
            break;
     
            case 'Thu':
                $hari_ini = "Kamis";
            break;
     
            case 'Fri':
                $hari_ini = "Jumat";
            break;
     
            case 'Sat':
                $hari_ini = "Sabtu";
            break;
            
            default:
                $hari_ini = "Tidak di ketahui";		
            break;
        }
     
        return $hari_ini;
    }    
}
