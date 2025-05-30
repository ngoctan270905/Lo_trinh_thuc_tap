<?php

use Illuminate\Support\Facades\Route;

// Route mặc định để Vue SPA hoạt động
Route::get('/{any}', function () {
    return view('app'); // trả về file resources/views/app.blade.php
})->where('any', '.*');
