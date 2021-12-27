<?php

namespace App\Jobs;

use App\Mail\SendMail as MailSendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $detail = [
            'title' => 'Ini Judul',
            'body' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Perferendis, iure?'
        ];

        Mail::to('emailpenerima@gmail.com')->send(new MailSendMail(
            'Coba ' . now(),
            $detail,
            'mail.send-mail'
        ));
    }
}
