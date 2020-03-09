<?php

namespace App\Mail\Organization;

use App\Organization;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Ban extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $organization;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
        $this->subject("Your organization has been banned");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.organization.ban', [
            'organization' => $this->organization
        ]);
    }
}
