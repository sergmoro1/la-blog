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
        for ($i = 1; $i <= 3; $i++) {
            Post::factory()
                ->count(10)
                ->state(new Sequence(
                    ['status' => 'draft'],
                    ['status' => 'published'],
                ))
                ->hasAttached([
                    Tag::all()->random(),
                    Tag::all()->random(),
                ])
                ->create();
        }
    }
}
