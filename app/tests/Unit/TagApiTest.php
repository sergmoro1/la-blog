<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Tag;
use App\Http\Resources\PostResource;

class TagApiTest extends TestCase
{
    use BasicAuth;
    
    /**
     * Api tag store test.
     *
     * @return void
     */
    public function test_api_tag_store()
    {
        // Create Basic Api key
        BasicAuth::setKey('sergmoro1@ya.ru', 'password');

        // Make a tag
        $tag = Tag::factory()->make(['id' => 1]);
        
        $this->withHeaders(["Authorization" => BasicAuth::getKey()])
            ->postJson('api/tags', $tag->toArray())
            ->assertStatus(200);
    }

    /**
     * Api tag update test.
     * 
     * @return void
     */
    public function test_api_tag_update()
    {
        // Create a tag
        $tag = Tag::factory()->create(['id' => 2]);
        // Change tag name
        $tag->name = 'news';

        $this->withHeaders(["Authorization" => BasicAuth::getKey()])
            ->putJson('api/tags/2', $tag->toArray())
            ->assertStatus(200);
        
        // Set empty name
        $tag->name = '';
        
        $this->withHeaders(["Authorization" => BasicAuth::getKey()])
            ->putJson('api/tags/2', $tag->toArray())
            ->assertStatus(422)
            ->assertJsonStructure([
                'success',
                'errors',
            ]);
        
        return 2;
    }

    /**
     * Api tag delete test.
     * 
     * @depends test_api_tag_update
     * @param int $tag_id
     * @return void
     */
    public function test_api_tag_delete(int $tag_id)
    {
        $this->withHeaders(["Authorization" => BasicAuth::getKey()])
            ->deleteJson('api/tags/' . $tag_id)
            ->assertStatus(200);
    }
    
    /**
     * Api tag index test.
     *
     * @return int
     */
    public function test_api_tag_index()
    {
        // Create tags with post
        $tag = Tag::factory()
            ->has(Post::factory())
            ->count(7)
            ->create();

        $response = $this->withHeaders(["Authorization" => BasicAuth::getKey()])
            ->getJson('api/tags?limit=5&page=2')
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
                        "path",
                        "per_page",
                        "to",
                        "total",
                    ],
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'posts' => [
                                '*' => [
                                    'id',
                                    'status',
                                    'title', 
                                    'excerpt', 
                                    'content', 
                                    'created_at',
                                    'updated_at',
                                ],
                            ],
                            'created_at',
                            'updated_at',
                        ],
                    ],
                ]);

        return $response['data'][0]['id'];
    }

   /**
     * Api tag show test.
     * 
     * @depends test_api_tag_index
     * @param int $tag_id
     * @return void
     */
    public function test_api_tag_show(int $tag_id)
    {
        $this->withHeaders(["Authorization" => BasicAuth::getKey()])
            ->getJson('api/tags/' . $tag_id)
            ->assertStatus(200);

        DB::table('post_tag')->delete();
        DB::table('tags')->delete();
        DB::table('posts')->delete();
        BasicAuth::clear();
    }
}
