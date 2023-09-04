<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgenPaket extends Model
{
    protected $guarded = [];
    public function komisi(){
        return $this->belongsTo(AgenKomisi::class);
    }           
}