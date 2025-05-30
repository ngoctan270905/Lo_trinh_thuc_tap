<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Các URI không cần kiểm tra CSRF
     *
     * @var array<int, string>
     */
    protected $except = [
        // Nếu bạn muốn ngoại lệ các route API hoặc route sanctum, ví dụ:
        'api/*',
        'sanctum/csrf-cookie',
    ];
}
