<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExcludedDay extends Model
{
    protected $guarded = [];

    public function setting()
    {
        return $this->belongsTo(\App\Setting::class);
    }
}
