<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use App\Models\Post;
use App\Models\Tag;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = Post::factory()->count(5)
            ->has(Tag::factory()
                ->count(2)
                ->state(new Sequence(
                    ['name' => 'news'],
                    ['name' => 'art'],
                    ['name' => 'animals'],
                    ['name' => 'food'],
                    ['name' => 'war'],
                    ['name' => 'weather'],
                    ['name' => 'adventure'],
                    ['name' => 'sport'],
                    ['name' => 'law'],
                    ['name' => 'politics'],
                ))
            )->create();
    }
}
