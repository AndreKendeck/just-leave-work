<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orgizantion()
    {
        return $this->belongsTo('App\Organization');
    }

    public function leaves()
    {
        return $this->hasMany('App\Leave');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment')->latest();
    }
}
