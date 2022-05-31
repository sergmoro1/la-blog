<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Post model class
 * @author   Sergey Morozov <sergmoro1@ya.ru>
 * @license  https://mit-license.org/ MIT
 *
 * @param integer  $id
 * @param string   $title
 * @param text     $excerpt
 * @param longText $content
 * @param integer  $created_at
 * @param integer  $updated_at
 *
 * @property Tags
 */
class Post extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
   protected $fillable= [
        'title',
        'excerpt',
        'content',
    ];

    /**
     * Get all tags of the post.
     *
     * @return mixed
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    /**
     * Add a post.
     *
     * @param  Request $request данные формы
     * @return boolean
     */
    public function create(Request $request)
    {
        $this->title = $request->input('title');
        $this->excerpt = $request->input('except');
        $this->content = $request->input('content');
        return $this->save();
    }
}
