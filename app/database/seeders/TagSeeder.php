<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::factory()
            ->count(10)
            ->state(new Sequence(
                ['id' => 1, 'name' => 'news'],
                ['id' => 2, 'name' => 'art'],
                ['id' => 3, 'name' => 'animals'],
                ['id' => 4, 'name' => 'food'],
                ['id' => 5, 'name' => 'war'],
                ['id' => 6, 'name' => 'weather'],
                ['id' => 7, 'name' => 'adventure'],
                ['id' => 8, 'name' => 'sport'],
                ['id' => 9, 'name' => 'law'],
                ['id' => 10, 'name' => 'politics'],
            ))
        ->create();
    }
}
