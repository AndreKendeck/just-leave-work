<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laratrust\Models\LaratrustTeam;

class Organization extends LaratrustTeam
{
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
