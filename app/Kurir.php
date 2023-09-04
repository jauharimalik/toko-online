<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    protected $table = 'kurir';
    public $timestamps = false;

    protected $fillable = ['ongkir_asal','ongkir_tujuan','ongkir_kurir','ongkir_jenis','ongkir_tarif','ongkir_est'];

    //
}
