<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected User $user;

    protected ?string $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, string $password = null)
    {
        $this->user = $user;
        $this->password = $password;
        $this->from('noreply@justleave.work', 'Justleave Work');
        $this->subject("Welcome to Justleave Work");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user.welcome', [
            'user' => $this->user,
            'password' => $this->password
        ]);
    }
}
