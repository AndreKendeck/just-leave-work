<?php

namespace App\Observers;

use App\Leave;
use App\Notifications\LeaveApproved;

class LeaveObserver
{
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
