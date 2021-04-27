<?php

namespace App;

use Cog\Laravel\Ban\Traits\Bannable;
use Laratrust\Models\LaratrustTeam;

class Team extends LaratrustTeam
{
    use Bannable;

    public $guarded = [];

    public function users()
    {
        return $this->hasMany(\App\User::class)->latest();
    }

    public function leaves()
    {
        return $this->hasMany(\App\Leave::class)->latest();
    }

    public function settings()
    {
        return $this->hasOne(\App\Setting::class);
    }
}
