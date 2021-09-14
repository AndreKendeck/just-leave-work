<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPasswordEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var string */
    protected $password;

    /** @var User */
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $password, User $user)
    {
        $this->password = $password;
        $this->user = $user;
        $this->from('noreply@justleave.work' , 'justleave.work'); 
        $this->subject("Reset your justleave.work password"); 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.new-password', [
            'password' => $this->password,
            'user' => $this->user
        ]);
    }
}
