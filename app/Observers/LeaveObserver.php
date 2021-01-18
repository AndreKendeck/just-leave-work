<?php

namespace App\Observers;

use App\Leave;
use App\Notifications\LeaveApproved;

class LeaveObserver
{
    /**
     * Handle the leave "created" event.
     *
     * @param  \App\Leave  $leave
     * @return void
     */
    public function created(Leave $leave)
    {
        $teamSettings = $leave->team->settings;

        if ($leave->user->leave_balance > 0 && $teamSettings->automatic_leave_approval) {
            $leave->approve();
            $user = $leave->user;
            $user->decrement('leave_balance');
        }
    }


    /**
     * @param Leave $leave
     * @return void
     */
    public function approved(Leave $leave)
    {
        $leave->user->notify(new LeaveApproved("", $leave));
    }

    /**
     * @param Leave $leave
     * @return void
     */
    public function denied(Leave $leave)
    {
    }
}
