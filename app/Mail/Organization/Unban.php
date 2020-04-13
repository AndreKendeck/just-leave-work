<?php

namespace App\Mail\Organization;

use App\Organization;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Unban extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $organization;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
        $this->subject("Your Organization's ban on JustLeave has been lifted");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.organization.unban', [
            'organization' => $this->organization
        ]);
    }
}
