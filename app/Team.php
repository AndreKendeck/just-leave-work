<?php

namespace App;

use Cog\Laravel\Ban\Traits\Bannable;
use Illuminate\Database\Eloquent\Model;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Laravolt\Avatar\Avatar;

class Team extends Model implements BannableContract
{
    use Bannable;

    protected $guarded = [];
    protected $appends = [
        'logo_url'
    ];
    public const STORAGE_PATH = 'teams/logos/';

    public function users()
    {
        return $this->hasMany('App\User')->latest();
    }

    public function leaves()
    {
        return $this->hasMany('App\Leave')->latest();
    }

    public function getLogoUrlAttribute()
    {
        if (is_null($this->logo)) {
            return ( new Avatar([]) )->create($this->name)->toBase64();
        }
        return asset(self::STORAGE_PATH .  $this->logo);
    }
}
