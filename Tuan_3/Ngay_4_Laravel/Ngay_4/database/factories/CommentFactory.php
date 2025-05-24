<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = \App\Models\Comment::class;

    public function definition()
    {
        return [
            'content' => $this->faker->sentence(),
            'user_id' => null,  // set khi tạo dữ liệu
            'commentable_id' => null,  // set khi tạo dữ liệu
            'commentable_type' => null,  // set khi tạo dữ liệu
        ];
    }
}
