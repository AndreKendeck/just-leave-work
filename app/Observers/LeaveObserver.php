<?php

namespace App\Observers;

use App\Leave;
use App\Mail\Leave\Created;
use App\Notifications\General;
use Illuminate\Support\Facades\Mail;

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
        Mail::to($leave->reporter->email)->queue(new Created($leave));
        $leave->reporter->notify(new General("{$leave->user->name} has requested for leave", route('leaves.show', $leave->id)));
    }

    /**
     * Handle the leave "updated" event.
     *
     * @param  \App\Leave  $leave
     * @return void
     */
    public function updated(Leave $leave)
    {
        //
    }

    /**
     * Handle the leave "deleted" event.
     *
     * @param  \App\Leave  $leave
     * @return void
     */
    public function deleted(Leave $leave)
    {
        //
    }

    /**
     * Handle the leave "restored" event.
     *
     * @param  \App\Leave  $leave
     * @return void
     */
    public function restored(Leave $leave)
    {
        //
    }

    /**
     * Handle the leave "force deleted" event.
     *
     * @param  \App\Leave  $leave
     * @return void
     */
    public function forceDeleted(Leave $leave)
    {
        //
    }
}
