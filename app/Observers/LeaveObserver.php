<?php

namespace App\Observers;

use App\Leave;
use App\Mail\LeaveApprovedEmail;
use App\Mail\LeaveDeniedEmail;
use Illuminate\Support\Facades\Mail;

class LeaveObserver
{
    /**
     * @param Leave $leave
     * @return void
     */
    public function approved(Leave $leave)
    {
        Mail::to($leave->user->email)->queue(new LeaveApprovedEmail($leave));
    }

    /**
     * @param Leave $leave
     * @return void
     */
    public function denied(Leave $leave)
    {
        Mail::to($leave->user->email)->queue(new LeaveDeniedEmail($leave));
    }
}
