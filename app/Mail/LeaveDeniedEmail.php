<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveDeniedEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var \App\Leave  */
    protected $leave;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\Leave $leave)
    {
        $this->leave = $leave;
        $this->from('noreply@justleave.work', 'justleave.work');
        $this->subject("Your leave for {$leave->from->toFormattedDateString()} has been denied");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.leave-denied', [
            'leave' => $this->leave
        ]);
    }
}
