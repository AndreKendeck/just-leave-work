<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveApprovedEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var  \App\Leave */
    protected $leave;

    /**
     * @param \App\Leave $leave
     */
    public function __construct(\App\Leave $leave)
    {
        $this->leave = $leave;
        $this->subject("Your leave for {$leave->from->toFormattedDateString()} has been approved");
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.leave-approved', [
            'leave' => $this->leave
        ]);
    }
}
