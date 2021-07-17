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
        $setting = Setting::create(['team_id' => $team->id, 'last_leave_balance_added_at' => now()]);

        // we will assume most people have a 5 day working week.
        // so we will create a another setting that will add the weekend to the

        collect(['Saturday', 'Sunday'])->each(function (string $day) use ($setting) {
            \App\ExcludedDay::create(['day' => $day, 'setting_id' => $setting->id]);
        });
    }
}
