<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vorder extends Model
{
    public function vorderDetails()
    {
        return $this->hasMany(VorderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pic()
    {
        return $this->belongsTo(Pic::class);
    }    
}
