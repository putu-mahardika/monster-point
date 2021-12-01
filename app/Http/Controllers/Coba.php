<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\CobaEmail;
use Illuminate\Support\Facades\Mail;

class Coba extends Controller
{


    public function index()
    {
        try {
            Mail::to("ekkys99@gmail.com")->send(new CobaEmail());
            return "Email telah dikirim";
        } catch (\Throwable $th) {
            //throw $th;
            return "error";
        }



    }
}
