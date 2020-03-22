<?php

namespace App;

use App\Mail\User\Banned;
use App\Mail\User\Unbanned;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;
use Illuminate\Support\Facades\Mail;
use Laravolt\Avatar\Avatar;
use Spatie\Permission\Traits\HasRoles;

// bannable contarcts
use Cog\Contracts\Ban\Ban as BanContract;
use Cog\Contracts\Ban\BanService as BanServiceContract;

class User extends Authenticatable implements MustVerifyEmail, BannableContract
{
    use Notifiable;
    use Bannable;
    use HasRoles;

    public const STORAGE_PATH = 'users/avatars';

    protected $appends = [
        'avatar_url',
        'url',
        'total_days_on_leave'
    ];
    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getTotalDaysOnLeaveAttribute()
    {
        return $this->leaves->whereNotNull('approved_at')->sum('number_of_days_off');
    }

    public function approvals()
    {
        return $this->hasMany('App\Leave')->latest();
    }

    public function denials()
    {
        return $this->hasMany('App\Denial')->latest();
    }

    public function comments()
    {
        return $this->hasMany('App\Comment')->latest();
    }

    public function leaves()
    {
        return $this->hasMany('App\Leave')->latest();
    }

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function getAvatarUrlAttribute()
    {
        if (is_null($this->avatar)) {
            return (new Avatar([]))->create($this->name)->toBase64();
        }
        return asset(self::STORAGE_PATH . $this->avatar);
    }

    public function getUrlAttribute()
    {
        return route('users.show', $this->id);
    }


    /**
     * Ban model.
     *
     * @param null|array $attributes
     * @return \Cog\Contracts\Ban\Ban
     */
    public function ban(array $attributes = []): BanContract
    {
        // send an email when banned
        Mail::to($this->email)->queue(new Banned($this));
        return app(BanServiceContract::class)->ban($this, $attributes);
    }


    /**
     * Remove ban from model.
     *
     * @return void
     */
    public function unban(): void
    {
        Mail::to($this->email)->queue(new Unbanned($this));
        app(BanServiceContract::class)->unban($this);
    }
}
