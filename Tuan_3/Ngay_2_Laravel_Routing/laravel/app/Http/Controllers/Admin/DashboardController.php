<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalPosts = Post::count();
        $recentPosts = Post::latest()->take(5)->get();
        
        return view('admin.dashboard', compact('totalPosts', 'recentPosts'));
    }
}
