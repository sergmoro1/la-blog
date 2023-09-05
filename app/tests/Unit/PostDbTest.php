<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Post;
use App\Models\Tag;
use Tests\TestCase;

class PostDbTest extends TestCase
{
    /**
     * Post creation test.
     *
     * @return void
     */
    public function test_post_creation()
    {
        $user = User::factory(10)->create();
        // Create a post with two tags
        $post = Post::factory()
            ->has(Tag::factory()
                ->count(2)
                ->state(new Sequence(
                    ['name' => 'news'],
                    ['name' => 'art'],
                ))
            )
            ->create(['id' => 1]);

        // Database
        // Check if a post exists.
        $this->assertModelExists($post);
        // Check if there are two tags in the table.
        $this->assertDatabaseCount('tags', 2);
        // Check the number of links between the post and the tags.
        $this->assertDatabaseCount('post_tags', 2);

        // Relations
        // Check a count of tags.
        $tags = $post->tags()->get();
        $this->assertEquals(2, count($tags));
        // Check a count of posts for the tag.
        $tag = Tag::where('name','art')->first();
        $posts = $tag->posts()->get();
        $this->assertEquals(1, count($posts));
    }

    protected function tearDown(): void
    {
        DB::table('post_tags')->delete();
        DB::table('tags')->delete();
        DB::table('posts')->delete();
        DB::table('users')->delete();
    }
}
