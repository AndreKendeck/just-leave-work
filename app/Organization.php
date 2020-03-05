<?php

namespace App;

use Laratrust\Models\LaratrustTeam;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;

class Organization extends LaratrustTeam implements BannableContract
{
    use Bannable;

    public const STORAGE_PATH = '/organizations/logos';

    protected $appends = [
        'logo_url',
        'has_logo',
        'is_owner'
    ];
    
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function leaves()
    {
        return $this->hasMany('App\Leave')->latest();
    }

    public function leader()
    {
        return $this->belongsTo('App\User', 'leader_id');
    }
    
    public function addUser(User $user)
    {
        $user->update([
              'organization_id' => $this->id,
         ]);
    }

    public function getLogoUrlAttribute()
    {
        return asset(self::STORAGE_PATH . '/' . $this->logo);
    }

    public function getHasLogoAttribute()
    {
        return !is_null($this->logo);
    }

    public function getIsOwnerAttribute()
    {
        if (auth()->check()) {
            return $this->leader_id == auth()->user()->id;
        }
        return false;
    }
}
