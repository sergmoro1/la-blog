<?php

namespace Tests\Unit;

use Tests\BlogTestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Factories\Sequence;
use App\Models\User;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Image;

class ImageApiTest extends BlogTestCase
{
    /**
     * Api image store test.
     *
     * @return void
     */
    public function test_api_image_store()
    {
        $this->clearTables();

        // Create Basic Api key
        BasicAuth::setKey('sergmoro1@ya.ru', 'password');

        // Create users
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

        $file = UploadedFile::fake()->image('avatar.jpg');
        
        $this->withHeaders(["Authorization" => BasicAuth::getKey()])
            ->postJson('api/images', [
                'imageable_type' => 'App\Models\Post',
                'imageable_id' => $post->id,
                'file_input' => $file,
            ])->assertJsonFragment(['success' => 1]);
        
        Storage::disk($post->getDisk())->assertExists($post->getFullPath() . '/' . $file->hashName());

        $image = Image::where(['original' => 'avatar.jpg'])->first();

        return $image->id;
    }

    /**
     * Api image update test.
     * 
     * @depends test_api_image_store
     * @param int $image_id
     * @return void
     */
    public function test_api_image_update(int $image_id)
    {
        // Find an image
        $image = Image::find($image_id);

        // update addons
        $image->addons = '{"caption": "Jhon Tatarin", "age": "30"}';
        $this->withHeaders(["Authorization" => BasicAuth::getKey()])
            ->putJson('api/images/' . $image_id, $image->toArray())
            ->assertStatus(200);

        // add second image
        $file = UploadedFile::fake()->image('photo.jpg');
        $this->withHeaders(["Authorization" => BasicAuth::getKey()])
            ->postJson('api/images', [
                'imageable_type' => 'App\Models\Post',
                'imageable_id' => 1,
                'file_input' => $file,
            ])->assertJsonFragment(['success' => 1]);

        // swap two images
        $swapping_image = Image::where(['original' => 'photo.jpg'])->first();
        $swapping_image->save();

        $this->assertLessThan($swapping_image->position, $image->position);

        $this->withHeaders(["Authorization" => BasicAuth::getKey()])
            ->putJson('api/images/' . $image_id, ['oldIndex' => 0, 'newIndex' => 1])
            ->assertStatus(200);
        
        $image = Image::where(['original' => 'avatar.jpg'])->first();
        $swapping_image = Image::where(['original' => 'photo.jpg'])->first();

        $this->assertLessThan($image->position, $swapping_image->position);
        
        return $image_id;
    }

    /**
     * Api image delete test.
     * 
     * @depends test_api_image_store
     * @param int $image_id
     * @return void
     */
    public function test_api_image_delete(int $image_id)
    {
        $this->withHeaders(["Authorization" => BasicAuth::getKey()])
            ->deleteJson('api/images/' . $image_id)
            ->assertStatus(200);

        $this->withHeaders(["Authorization" => BasicAuth::getKey()])
            ->deleteJson('api/images/' . ($image_id + 1))
            ->assertStatus(200);
    }
}
