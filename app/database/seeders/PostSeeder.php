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
        for ($i = 1; $i <= 10; $i++) {
            Post::factory()
                ->count(3)
                ->hasAttached([
                    Tag::all()->random(),
                    Tag::all()->random(),
                ])
                ->create();
        }
    }
}
