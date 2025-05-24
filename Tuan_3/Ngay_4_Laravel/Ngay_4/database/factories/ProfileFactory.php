<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition()
    {
        return [
            'bio' => $this->faker->paragraph,
            'birthday' => $this->faker->date(),
            'avatar_url' => $this->faker->imageUrl(),
            // user_id sẽ được gán khi tạo user
        ];
    }
}
