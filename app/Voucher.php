<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function vplan()
    {
        return $this->hasMany(Vplan::class);
    }
}