<?php

namespace App;

use Laratrust\Models\LaratrustTeam;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;

class Organization extends LaratrustTeam implements BannableContract
{
    use Bannable;
    
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function leaves()
    {
        return $this->hasMany('App\Leave')->latest();
    }
    
    public function addUser(User $user)
    {
        $user->update([
              'organization_id' => $this->id,
         ]);
    }
}
