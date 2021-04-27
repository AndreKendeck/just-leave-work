<?php

namespace App\Observers;

use App\Setting;
use App\Team;

class TeamObserver
{
    /**
     * Handle the team "created" event.
     *
     * @param  \App\Team  $team
     * @return void
     */
    public function created(Team $team)
    {
        Setting::create(['team_id' => $team->id]);
    }
}
