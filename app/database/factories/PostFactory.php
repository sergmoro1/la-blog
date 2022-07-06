<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => Post::STATUS_DRAFT,
            'title' => $this->faker->sentence(),
            'excerpt' => $this->faker->paragraph(),
            'content' => $this->faker->realText(),
        ];
    }
}
