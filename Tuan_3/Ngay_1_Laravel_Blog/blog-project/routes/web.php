<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GreetingController;
use App\Services\Mail\WelcomeMailer;
use App\Services\LoggerService;

Route::get('/demo-log', function (LoggerService $logger) {
    $logger->log("User accessed greeting page");
    return 'Logged!';
});

Route::get('/send-welcome-email', function (WelcomeMailer $mailer) {
    $mailer->send('user@example.com');
    return 'Sent!';
});

Route::get('/greeting', [GreetingController::class, 'greet']);

