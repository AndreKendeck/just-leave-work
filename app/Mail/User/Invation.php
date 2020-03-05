<?php

namespace App\Mail\User;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Invation extends Mailable
{
    use Queueable, SerializesModels;

    private $user; 
    private $password; 
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user , $password )
    {
        $this->user = $user; 
        $this->password = $password; 
        $this->subject("{$user->orgizantion->name} has invited you to join their JustLeave platform");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.users.invatation' , [
            'user' => $this->user, 
            'password' => $this->password
        ]);
    }
}
