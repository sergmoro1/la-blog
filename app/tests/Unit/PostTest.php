<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\Tag;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * Post creation test.
     *
     * @return void
     */
    public function test_post_creation()
    {
        // Create a post with two tags
        $post = Post::factory()
            ->has(Tag::factory()
                ->count(2)
                ->state(new Sequence(
                    ['name' => 'news'],
                    ['name' => 'art'],
                ))
            )
            ->create();

        // Database
        // Check if a post exists.
        $this->assertModelExists($post);
        // Check if there are two tags in the table.
        $this->assertDatabaseCount('tags', 2);
        // Check the number of links between the post and the tags.
        $this->assertDatabaseCount('post_tag', 2);

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
        DB::table('post_tag')->delete();
        DB::table('tags')->delete();
        DB::table('posts')->delete();
    }
}