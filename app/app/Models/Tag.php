<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Tag model class
 *
 * @param integer $id
 * @param string  $name
 * @param integer $created_at
 * @param integer $updated_at
 *
 * @property Posts
 */
class Tag extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
   protected $fillable= [
        'name',
    ];

    /**
     * Статьи, в которых был указан тег.
     *
     * @return mixed
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag');
    }
}
