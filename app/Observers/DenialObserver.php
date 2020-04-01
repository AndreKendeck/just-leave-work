<?php

namespace App\Observers;

use App\Denial;
use App\Mail\Leave\Denied;
use App\Notifications\General;
use Illuminate\Support\Facades\Mail;

class DenialObserver
{
    /**
     * Handle the denial "created" event.
     *
     * @param  \App\Denial  $denial
     * @return void
     */
    public function created(Denial $denial)
    {
        if ($denial->user_id != $denial->leave->user_id) {
            Mail::to($denial->leave->user->email)->queue(new Denied($denial->leave));
            $denial->leave->user->notify(new General("{$denial->user->name} has denied your leave request", route('leaves.show', $denial->leave->id)));
        }
    }

    /**
     * Handle the denial "updated" event.
     *
     * @param  \App\Denial  $denial
     * @return void
     */
    public function updated(Denial $denial)
    {
        //
    }

    /**
     * Handle the denial "deleted" event.
     *
     * @param  \App\Denial  $denial
     * @return void
     */
    public function deleted(Denial $denial)
    {
        //
    }

    /**
     * Handle the denial "restored" event.
     *
     * @param  \App\Denial  $denial
     * @return void
     */
    public function restored(Denial $denial)
    {
        //
    }

    /**
     * Handle the denial "force deleted" event.
     *
     * @param  \App\Denial  $denial
     * @return void
     */
    public function forceDeleted(Denial $denial)
    {
        //
    }
}
