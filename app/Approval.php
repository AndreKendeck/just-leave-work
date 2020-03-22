<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $appends = [];

    public function leave()
    {
        return $this->belongsTo('App\Leave');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }
}
