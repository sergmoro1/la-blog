<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasPageChecker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Post model class
 * @author   Sergey Morozov <sergmoro1@ya.ru>
 * @license  https://mit-license.org/ MIT
 *
 * @param integer  $id
 * @param enum     $status
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
    use HasFactory, HasPageChecker;
    
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_ARCHIVED = 'archived';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable= [
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
     * @var [position => string]
     */
    protected static $sortable = [
        0 => 'id', 
        1 => 'status',
        2 => 'title',
        5 => 'created_at',
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
     * Get all authors of the post.
     *
     * @return mixed
     */
    public function authors()
    {
        return $this->belongsToMany(User::class, 'post_user');
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
}
