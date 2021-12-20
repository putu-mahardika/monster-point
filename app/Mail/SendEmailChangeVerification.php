<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailChangeVerification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datas, $user)
    {
        $this->user = $user;
        $this->details = $datas;
        $this->subject = 'Verify Email Address Change';
        $this->view = 'mail.send-change-email-verification';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->markdown($this->view)
                    ->with('details', $this->details)
                    ->with('user', $this->user);
    }
}
