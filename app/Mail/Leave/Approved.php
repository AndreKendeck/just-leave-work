<?php

namespace App\Mail\Leave;

use App\Approval;
use App\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Approved extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $approval;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Approval $approval)
    {
        $this->approval = $approval;
        $this->subject("{$approval->user->name} has approved your leave no. {$approval->leave->number}");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.leaves.approved', [
            'approval' => $this->approval
        ]);
    }
}
