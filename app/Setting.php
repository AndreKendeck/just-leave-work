<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    public function team()
    {
        return $this->belongsTo(\App\Team::class);
    }
}
