<?php

namespace App\Observers;

use App\Comment;
use App\Mail\Comment\Created;
use App\Notifications\General;
use Illuminate\Support\Facades\Mail;

class CommentObserver
{
    /**
     * Handle the comment "created" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        $users = \App\User::wherePermissionIs('approve-and-deny-leave')
        ->where([
            'organization_id' => $comment->leave->organization_id, 
            'id' , '<>' , $comment->user_id
        ])
        ->get();
        $users->each(function ($user) use ($comment) {
            // notify the users via database
            $user->notify(new General(
                "{$comment->user->name} has commented on a leave request",
                route('leaves.showw', $comment->leave->id)
            ));
        });
        // send an email
        Mail::to($users)->queue(new Created($comment));
    }

    /**
     * Handle the comment "updated" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "deleted" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "restored" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function restored(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "force deleted" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function forceDeleted(Comment $comment)
    {
        //
    }
}
