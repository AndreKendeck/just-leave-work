<?php

namespace App;

use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Avatar;

class Team extends Model implements BannableContract
{
    use Bannable;

    protected $guarded = [];
    protected $appends = [
        'logo_url',
        'has_logo',
    ];
    public const STORAGE_PATH = '/teams/logos/';

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
            return (new Avatar([]))->create($this->name)->toBase64();
        }
        // only works fo the production enviorment
        if (env('APP_ENV') == 'production') {
            return Storage::disk('public')->url(self::STORAGE_PATH . $this->logo);
        }

        return asset(self::STORAGE_PATH . $this->logo);
    }
    public function getHasLogoAttribute()
    {
        return !is_null($this->logo);
    }
}
