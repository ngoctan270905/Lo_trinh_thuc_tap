<?php

namespace App\Services\Mail;

namespace App\Services\Mail;

use Illuminate\Support\Facades\Mail;

class WelcomeMailer
{
    public function send($email)
    {
        Mail::raw("Welcome to our platform!", function ($message) use ($email) {
            $message->to($email)->subject("Welcome!");
        });
    }
}
