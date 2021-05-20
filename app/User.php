<?php

namespace App;

use App\Mail\VerificationEmail;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// bannable contracts
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Sanctum\HasApiTokens;
use Laravolt\Avatar\Avatar;

class User extends Authenticatable implements MustVerifyEmail, BannableContract
{
    use Notifiable;
    use Bannable;
    use HasApiTokens;
    use LaratrustUserTrait;
    use SoftDeletes;

    public const STORAGE_PATH = '/users/avatars/';

    /**
     * @var array
     */
    protected $appends = [
        'avatar_url',
        'total_days_on_leave',
        'is_banned',
        'has_avatar',
        'is_on_leave',
        'leave_taken'
    ];

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email_code'
    ];

    protected $with = [
        'roles',
        'permissions',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'team_id' => 'integer',
    ];

    public function getHasAvatarAttribute()
    {
        return !is_null($this->avatar);
    }
    public function getTotalDaysOnLeaveAttribute()
    {
        return $this->leaves()->whereNotNull('approved_at')->get()->sum('number_of_days_off');
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

        // only works for production enviorment
        if (App::environment('production')) {
            return Storage::disk('public')->url(self::STORAGE_PATH . $this->avatar);
        }

        return asset(self::STORAGE_PATH . $this->avatar);
    }


    public function getIsBannedAttribute()
    {
        return $this->isBanned();
    }

    public function getIsOnLeaveAttribute()
    {
        if (($this->leaves()->whereNotNull('approved_at')->count() > 0)) {
            return today()->isBetween(
                $this->leaves()->whereNotNull('approved_at')->first()->from,
                $this->leaves()->whereNotNull('approved_at')->first()->until
            );
        }
        return false;
    }

    public function emailCode()
    {
        return $this->hasOne('App\EmailCode');
    }

    public function sendEmailVerificationNotification()
    {
        if ($this->hasVerifiedEmail()) {
            return false;
        }

        $code = strtoupper(Str::random(4));

        if (!$this->emailCode()->exists()) {
            EmailCode::create([
                'user_id' => $this->id,
                'code' => bcrypt($code),
                'expires_at' => now()->addMinutes(5),
            ]);
        }

        $this->emailCode->update([
            'code' => bcrypt($code),
            'expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($this->email)
            ->queue(new VerificationEmail($code));

        return $code;
    }

    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }

    public function getLeaveTakenAttribute()
    {
        return $this->leaves()->whereNotNull('approved_at')->count();
    }
}
