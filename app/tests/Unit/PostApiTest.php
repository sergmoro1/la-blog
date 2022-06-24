<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Tag;
use App\Http\Resources\PostResource;

class PostApiTest extends TestCase
{
    /**
     * Api post store test.
     *
     * @return void
     */
    public function test_api_post_store()
    {
        // Make a post
        $post = Post::factory()->make(['id' => 1]);
        
        $this->postJson('api/posts', $post->toArray())
            ->assertStatus(200);
    }

    /**
     * Api post update test.
     * 
     * @return void
     */
    public function test_api_post_update()
    {
        // Create a post
        $post = Post::factory()->create(['id' => 2]);
        // Change title
        $post->title = 'New title';

        $this->putJson('api/posts/2', $post->toArray())
            ->assertStatus(200);
        
        // Set empty excerpt
        $post->excerpt = '';
        
        $this->putJson('api/posts/2', $post->toArray())
            ->assertStatus(422)
            ->assertJsonStructure([
                'success',
                'errors',
            ]);
        
        return 2;
    }
    
    /**
     * Api post delete test.
     * 
     * @depends test_api_post_update
     * @param int $post_id
     * @return void
     */
    public function test_api_post_delete(int $post_id)
    {
        $this->deleteJson('api/posts/' . $post_id)
            ->assertStatus(200);
    }
    
    /**
     * Api post index test.
     *
     * @return int
     */
    public function test_api_post_index()
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
            ->create(['id' => 3]);

       $this->getJson('api/posts')
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id', 
                        'title', 
                        'excerpt', 
                        'content', 
                        'tags' => [
                            '*' => [
                                'id',
                                'name',
                                'created_at',
                                'updated_at',
                            ],
                        ],
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);

        return 3;
    }

    /**
     * Api post show test.
     * 
     * @depends test_api_post_index
     * @param int $post_id
     * @return void
     */
    public function test_api_post_show(int $post_id)
    {
        $this->getJson('api/posts/' . $post_id)
            ->assertStatus(200);

        DB::table('post_tag')->delete();
        DB::table('tags')->delete();
        DB::table('posts')->delete();
    }
}
