<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agen extends Model
{

    protected $fillable = ['user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }   

    public function upline(){
        return $this->belongsTo(User::class);
    }   

    public function paket(){
        return $this->belongsTo(AgenPaket::class);
    }      

    public function agenbonus(){
        return $this->belongsTo(AgenBonus::class);
    }     
    //
}
