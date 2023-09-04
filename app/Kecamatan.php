<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class Kecamatan extends Model
{
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    
}
