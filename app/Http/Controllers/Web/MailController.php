<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendMail as JobSendMail;

class MailController extends Controller
{
    public function index(){

        for ($i=0; $i < 10; $i++) {
            dispatch(new JobSendMail());
        }

        dd("Done | " . now());

    }
}
