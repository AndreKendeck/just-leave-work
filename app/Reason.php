<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    protected $guarded = [];

    public function leaves()
    {
        return $this->hasMany('App\Leave');
    }
}
