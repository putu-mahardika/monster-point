<?php

namespace App\Notifications;

use App\Models\EmailChangeVerification as ModelsEmailChangeVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailChangeVerification extends Notification
{
    use Queueable;

    private $emailChangeVerification;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ModelsEmailChangeVerification $emailChangeVerification)
    {
        $this->emailChangeVerification = $emailChangeVerification;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->subject('Verify Email Address Change')
                    ->greeting("Hallo, $notifiable->name")
                    ->line('Click the button below to verify your new email address.')
                    ->action('Verify Email Address Change', route('verify-email-change', [
                        'token' => $this->emailChangeVerification->token
                    ]));
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
            //
        ];
    }
}
