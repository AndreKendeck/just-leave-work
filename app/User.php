<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;

class User extends Authenticatable implements MustVerifyEmail , BannableContract
{
    use LaratrustUserTrait;
    use Notifiable;
    use Bannable; 

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
