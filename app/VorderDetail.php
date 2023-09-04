<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VorderDetail extends Model
{
    public function vorder()
    {
        return $this->belongsTo(Vorder::class);
    }

    public function vplan()
    {
        return $this->belongsTo(Vplan::class);
    }
}
