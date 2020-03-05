<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;

class User extends Authenticatable implements MustVerifyEmail, BannableContract 
{
    use LaratrustUserTrait;
    use Notifiable;
    use Bannable;

    public const STORAGE_PATH = '/users/avatars';

    protected $appends = [
        'is_leader',
        'avatar_url',
        'has_avatar'
    ];
    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function organization()
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

    public function getIsLeaderAttribute()
    {
        return $this->organization->leader_id == $this->id;
    }

    public function areTeammates(User $user)
    {
        return $this->organization_id == $user->organization_id;
    }

    public function getAvatarUrlAttribute()
    {
        return asset(self::STORAGE_PATH . '/' . $this->avatar);
    }

    public function getHasAvatarAttribute()
    {
        return !is_null($this->avatar);
    }
   
}
