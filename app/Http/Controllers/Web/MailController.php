<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function index(){

        $details = [
        'title' => 'foo',
        'body' => 'bar'
        ];

        \Mail::to('emailpenerima@gmail.com')->send(new SendMail($details));

        dd("Email sudah terkirim.");

    }
}
