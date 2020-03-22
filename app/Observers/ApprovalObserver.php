<?php

namespace App\Observers;

use App\Approval;
use App\Mail\Leave\Approved;
use App\Notifications\General;
use Illuminate\Support\Facades\Mail;

class ApprovalObserver
{
    /**
     * Handle the approval "created" event.
     *
     * @param  \App\Approval  $approval
     * @return void
     */
    public function created(Approval $approval)
    {
        if ($approval->user_id != $approval->leave->user_id) {
            Mail::to($approval->leave->user->email)->queue(new Approved($approval));
            $approval->leave()->user->notify(new General("{$approval->user->name} has approved your leave #{$approval->leave->number}", route('leaves.show', $approval->leave->id)));
        }
    }

    /**
     * Handle the approval "updated" event.
     *
     * @param  \App\Approval  $approval
     * @return void
     */
    public function updated(Approval $approval)
    {
        //
    }

    /**
     * Handle the approval "deleted" event.
     *
     * @param  \App\Approval  $approval
     * @return void
     */
    public function deleted(Approval $approval)
    {
        //
    }

    /**
     * Handle the approval "restored" event.
     *
     * @param  \App\Approval  $approval
     * @return void
     */
    public function restored(Approval $approval)
    {
        //
    }

    /**
     * Handle the approval "force deleted" event.
     *
     * @param  \App\Approval  $approval
     * @return void
     */
    public function forceDeleted(Approval $approval)
    {
        //
    }
}
