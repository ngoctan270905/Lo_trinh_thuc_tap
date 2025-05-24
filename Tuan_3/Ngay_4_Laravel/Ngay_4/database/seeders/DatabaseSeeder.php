<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Tag;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Tạo 10 user (giảng viên + học viên)
        User::factory(10)->create()->each(function ($user) {
            // Tạo profile cho mỗi user
            Profile::factory()->create([
                'user_id' => $user->id,
            ]);

            if ($user->role === 'instructor') {
                // Giảng viên thì tạo khóa học
                Course::factory(rand(1, 3))->create([
                    'user_id' => $user->id,
                ])->each(function ($course) {
                    // Mỗi khóa học tạo 3-5 bài học
                    Lesson::factory(rand(3, 5))->create([
                        'course_id' => $course->id,
                    ]);
                });
            }
        });

        // Tạo 10 tag
        $tags = Tag::factory(10)->create();

        // Gắn tag cho một số bài học ngẫu nhiên
        $lessons = Lesson::all();
        foreach ($lessons as $lesson) {
            $randomTags = $tags->random(rand(1, 3))->pluck('id');
            $lesson->tags()->attach($randomTags);
        }

        // Tạo comment cho khóa học và bài học
        $users = User::all();
        $courses = Course::all();

        foreach ($courses as $course) {
            Comment::factory(rand(1, 3))->create([
                'commentable_id' => $course->id,
                'commentable_type' => Course::class,
                'user_id' => $users->random()->id,
            ]);
        }

        foreach ($lessons as $lesson) {
            Comment::factory(rand(1, 3))->create([
                'commentable_id' => $lesson->id,
                'commentable_type' => Lesson::class,
                'user_id' => $users->random()->id,
            ]);
        }
    }
}
