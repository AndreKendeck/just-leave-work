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
        if ($comment->user_id != $comment->leave->user_id) {

            // reporter
            
            if ($comment->user_id != $comment->leave->reporter_id) {
                if ($comment->leave->has_reporter) {
                    Mail::to($comment->leave->reporter->email)->queue(new Created($comment));
                    $comment->leave->reporter->notify(new General("{$comment->user->name} has left a comment on a leave request", route('leaves.show', $comment->leave->id)));
                }
            }

            // another user
            Mail::to($comment->leave->user->email)->queue(new Created($comment));
            $comment->leave->user->notify(new General("{$comment->user->name} has left a comment on your leave request", route('leaves.show', $comment->leave->id)));
        }
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
