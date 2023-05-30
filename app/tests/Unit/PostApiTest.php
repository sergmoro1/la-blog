<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\BlogTestCase;
use App\Models\Post;
use App\Models\Tag;

class PostApiTest extends BlogTestCase
{
    /**
     * Api post store test.
     *
     * @return void
     */
    public function test_api_post_store()
    {
        $this->clearTables();

        // Create Basic Api key
        BasicAuth::setKey('sergmoro1@ya.ru', 'password');

        // Make a post
        $post = Post::factory()->make(['id' => 1]);
        
        $this->withHeaders(["Authorization" => BasicAuth::getKey()])
            ->postJson('api/posts', $post->toArray())
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

        $this->withHeaders(["Authorization" => BasicAuth::getKey()])
            ->putJson('api/posts/2', $post->toArray())
            ->assertStatus(200);
        
        // Set empty excerpt
        $post->excerpt = '';
        
        $this->withHeaders(["Authorization" => BasicAuth::getKey()])
            ->putJson('api/posts/2', $post->toArray())
            ->assertStatus(422)
            ->assertJsonStructure([
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
        $this->withHeaders(["Authorization" => BasicAuth::getKey()])
            ->deleteJson('api/posts/' . $post_id)
            ->assertStatus(200);
    }
    
    /**
     * Api post index test.
     *
     * @return int
     */
    public function test_api_post_index()
    {
        // Create a 7 posts with one from tags
        $post = Post::factory()
            ->has(Tag::factory()
                ->state(new Sequence(
                    ['name' => 'news'],
                    ['name' => 'art'],
                    ['name' => 'sport'],
                    ['name' => 'economic'],
                    ['name' => 'politics'],
                    ['name' => 'finance'],
                    ['name' => 'helth'],
                    ['name' => 'humor'],
                    ['name' => 'cooking'],
                    ['name' => 'cinema'],
                ))
            )
            ->count(7)
            ->create();

        $response = $this->withHeaders(["Authorization" => BasicAuth::getKey()])
            ->getJson('api/posts?limit=5&offset=5')
                ->assertStatus(200)
                ->assertJsonFragment(["current_page" => 2])
                ->assertJsonFragment(["total" => 8])
                ->assertJsonFragment(["per_page" => "5"])
                ->assertJsonStructure([
                    'success',
                    'links' => [
                        "first",
                        "last",
                        "prev",
                        "next",
                    ],
                    'meta' => [
                        "current_page",
                        "from",
                        "last_page",
                        "per_page",
                        "to",
                        "total",
                    ],
                    'data' => [
                        '*' => [
                            'id',
                            'status',
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

       $response = $this->getJson('api/posts?limit=5&search=news')
            ->assertStatus(200)
            ->assertJsonFragment(["total" => 1]);

        return $response['data'][0]['id'];
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
        $this->withHeaders(["Authorization" => BasicAuth::getKey()])
            ->getJson('api/posts/' . $post_id)
            ->assertStatus(200);
        
        $this->withHeaders(["Authorization" => BasicAuth::getKey()])
            ->getJson('api/posts/' . ($post_id + 10))
            ->assertStatus(404);

        $this->clearTables();
    }
}
