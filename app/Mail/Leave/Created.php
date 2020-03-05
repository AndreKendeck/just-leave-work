<?php

namespace App\Mail\Leave;

use App\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Created extends Mailable implements ShouldQueue
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
        $this->subject("{$leave->user->name} has requested for leave");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.leave.created', [
            'leave' => $this->leave
        ]);
    }
}
