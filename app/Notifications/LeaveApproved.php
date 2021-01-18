<?php

namespace App\Notifications;

use App\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeaveApproved extends Notification
{
    use Queueable;

    public $message;

    public $leave;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $message, Leave $leave)
    {
        $this->message = $message;
        $this->leave = $leave;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => "Your leave request for 
            {$this->leave->from->toFormattedDateString()} until 
            {$this->leave->until->toFormattedDateString()} has been approved",
        ];
    }
}
