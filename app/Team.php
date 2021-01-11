<?php

namespace App;

use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Avatar;
use Illuminate\Support\Facades\App;

class Team extends Model implements BannableContract
{
    use Bannable;

    protected $guarded = [];

    protected $with = ['settings'];

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

    public function settings()
    {
        return $this->hasOne('App\Setting');
    }

    public function getLogoUrlAttribute()
    {
        if (is_null($this->logo)) {
            return (new Avatar([]))->create($this->name)->toBase64();
        }
        // only works fo the production enviorment
        if (App::environment('production')) {
            return Storage::disk('public')->url(self::STORAGE_PATH . $this->logo);
        }

        return asset(self::STORAGE_PATH . $this->logo);
    }
    public function getHasLogoAttribute()
    {
        return !is_null($this->logo);
    }
}
