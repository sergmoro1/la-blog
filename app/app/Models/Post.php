<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasPageChecker;
use App\Traits\HasStorage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Post model class
 *
 * @param integer   $id
 * @param integer   $user_id
 * @param enum      $status
 * @param string    $title
 * @param text      $excerpt
 * @param longText  $content
 * @param timestamp $created_at
 * @param timestamp $updated_at
 *
 * @property User $user
 * @property Tag[] $tags
 * @property Like[] $likes
 * @property Image[] $images
 */
class Post extends Model
{
    use HasFactory, HasPageChecker, HasStorage;
    
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_ARCHIVED = 'archived';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable= [
        'user_id',
        'status',
        'title',
        'excerpt',
        'content',
    ];
    
    /**
     * The attributes that are auto assignable.
     *
     * @var string[]
     */
    protected $hidden = [
        'created_at', 
        'updated_at',
    ];

    /**
     * The attributes, by it's positions in a table (datatables js),  that can be sorted.
     *
     * @var array [position => string]
     */
    protected static $sortable = [
        0 => 'id', 
        1 => 'status',
        2 => 'title',
        5 => 'created_at',
    ];

    /**
     * Storage params. Seperately = false - all pictures saved in $path subdirectory, 
     * = true - pictures for the model saved in a seperate {$path}/{$id} subdirectory.
     * 
     * @var array
     */    
    protected $storage = [
        'disk' => 'public',
        'path' => 'post',
        'seperatly' => true,
    ];
    
    /**
     * Get the owner of this post.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all tags of the post.
     *
     * @return mixed
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    /**
     * The attribute name that can be sorted.
     *
     * @param integer $position
     * 
     * @return string
     */
    public static function getAttributeNameByPosition(int $position)
    {
        return self::$sortable[$position];
    }

    /**
     * Get the likes of this post.
     *
     * @return mixed
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Get the images of this post.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Convert markdown to html
     *
     * @return string
     */
    public function markdownToHtml()
    {
        return Str::markdown($this->content);
    }
}
