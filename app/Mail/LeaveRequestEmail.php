<?php

namespace App\Mail;

use App\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveRequestEmail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Leave */
    protected $leave;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Leave $leave)
    {
        $this->leave = $leave;
        $this->from('noreply@justleave.work', 'Justleave Work');
        $this->subject("Leave request from {$leave->user->name}");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.new-leave-request', [
            'leave' => $this->leave
        ]);
    }
}
