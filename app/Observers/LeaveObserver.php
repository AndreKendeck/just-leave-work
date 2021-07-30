<?php

namespace App\Observers;

use App\Leave;
use App\Mail\LeaveApprovedEmail;
use App\Mail\LeaveDeniedEmail;
use App\Transaction;
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
        $description = $leave->is_for_one_day ? "Approved leave {$leave->from->toFormattedDateString()}" : "Approved leave {$leave->from->toFormattedDateString()} - {$leave->until->toFormattedDateString()}";
        Transaction::create([
            'user_id' => $leave->user->id,
            'description' => $description,
            'amount' => -$leave->number_of_days_off,
        ]);
    }

    /**
     * @param Leave $leave
     * @return void
     */
    public function denied(Leave $leave)
    {
        Mail::to($leave->user->email)->queue(new LeaveDeniedEmail($leave));
        Transaction::create([
            'user_id' => $leave->user->id,
            'description' => $leave->is_for_one_day ? "Denied leave {$leave->from->toFormattedDateString()}" : "Denied leave {$leave->from->toFormattedDateString()} - {$leave->until->toFormattedDateString()}",
            'amount' => 0,
        ]);
    }
}
