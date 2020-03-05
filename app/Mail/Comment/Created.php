<?php

namespace App\Mail\Comment;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Created extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $comment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
        $this->subject("{$comment->user->name} has comment on your leave request");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.comment.created', [
            'comment' => $this->comment
        ]);
    }
}
