<?php

namespace App\Mail\Leave;

use App\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Approved extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $leave;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Leave $leave)
    {
        $this->leave = $leave;
        $this->subject("Your Leave #{$leave->number} has been approved");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.leaves.approved', [
            'leave' => $this->leave
        ]);
    }
}
