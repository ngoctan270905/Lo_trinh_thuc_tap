<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\CourseController;

Route::get('/courses', [CourseController::class, 'index']);
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Tag;
use App\Models\Comment;
// use Illuminate\Support\Facades\Route;

Route::get('/test-elearning', function () {
    $instructor = User::where('role', 'instructor')->first();
    if (!$instructor) {
        $instructor = User::factory()->create(['role' => 'instructor']);
    }
    $course = $instructor->courses()->create([
        'title' => 'Khóa học Laravel cơ bản',
        'description' => 'Giới thiệu Laravel',
    ]);
    $lessons = [];
    for ($i = 1; $i <= 3; $i++) {
        $lessons[] = $course->lessons()->create([
            'title' => "Bài học số $i",
            'content' => "Nội dung bài học $i",
        ]);
    }

    $lesson1 = $lessons[0];
    $tagLaravel = Tag::firstOrCreate(['name' => 'Laravel']);
    $tagEloquent = Tag::firstOrCreate(['name' => 'Eloquent']);
    $lesson1->tags()->attach([$tagLaravel->id, $tagEloquent->id]);

    Comment::factory()->count(2)->create([
        'commentable_id' => $course->id,
        'commentable_type' => Course::class,
        'user_id' => $instructor->id,
        'content' => 'Comment cho khóa học',
    ]);
    $commentsCourse = $course->comments()->get();
    $courses = Course::withCount('lessons')
        ->withCount(['comments as comments_count' => function ($q) {
            $q->where('commentable_type', Course::class);
        }])->get();

    $lessonsPerformance = Lesson::whereHas('tags', function ($q) {
        $q->where('name', 'Performance');
    })->withCount('comments')
      ->having('comments_count', '>', 3)
      ->get();

    return response()->json([
        'created_course' => $course,
        'lessons_created' => $lessons,
        'comments_on_course_count' => $commentsCourse->count(),
        'courses_with_counts' => $courses->map(function ($c) {
            return [
                'id' => $c->id,
                'title' => $c->title,
                'lessons_count' => $c->lessons_count,
                'comments_count' => $c->comments_count,
            ];
        }),
        'performance_lessons' => $lessonsPerformance->map(function ($l) {
            return [
                'id' => $l->id,
                'title' => $l->title,
                'comments_count' => $l->comments_count,
            ];
        }),
    ]);
});

