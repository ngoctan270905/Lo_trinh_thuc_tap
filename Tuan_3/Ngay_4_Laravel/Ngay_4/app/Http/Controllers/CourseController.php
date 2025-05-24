<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index()
    {
        // Lấy các khóa học có từ 5 bài học trở lên
        $courses = DB::table('courses')
            ->join('lessons', 'courses.id', '=', 'lessons.course_id')
            ->groupBy('courses.id')
            ->havingRaw('COUNT(lessons.id) >= 5')
            ->select('courses.*')
            ->get();

        return response()->json($courses);
    }
}
