<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
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
        $users = User::select('id')->limit(10)->get()->toArray();
        $statuses = [Post::STATUS_DRAFT, Post::STATUS_PUBLISHED, Post::STATUS_ARCHIVED];
        $date = $this->faker->dateTimeBetween($startDate = '-6 month', $endDate = '-1 month');
        return [
            'user_id' => $users[rand(0, count($users) - 1)]['id'],
            'status' => $statuses[rand(0, 2)],
            'title' => $this->faker->sentence(),
            'excerpt' => $this->faker->paragraph(),
            'content' => $this->faker->realText(),
            'created_at' => $date,
        ];
    }
}
