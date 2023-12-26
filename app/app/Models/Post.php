<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\HasPageChecker;
use App\Traits\HasStorage;

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

    protected $addonsDefaults = [
        'caption' => '',
        'year' => '',
        'category' => 'home',
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
     * Prepare action buttons for datatables.js plugin.
     * 
     * @return string JSON array with buttons
     */
    public static function dtButtons(): string
    {
        return json_encode([
            '<a onclick="dtLine.get(\'post-show-modal\', ${id});">
                <button class="button small green" type="button">
                    <span class="material-icons">visibility</span>
                </button>
            </a>',
            '<a href="/post-edit/${id}">
                <button class="button small blue" type="button">
                    <span class="material-icons">edit</span>
                </button>
            </a>',
            '<button class="button small red --jb-modal"  
                data-target="modal-delete" type="button" 
                onclick="this.setAttribute(\'data-id\', ${id}); 
                  let modal = document.getElementById(\'modal-delete\'); 
                  modal.classList.add(\'active\');">
                  <span class="material-icons">delete</span>
            </button>',
        ]);
    }
  
    /**
     * Prepare options for uploading files.
     * 
     * @return string JSON array with uploading options
     */
    public function uploadOptions(): string
    {
        return json_encode([
            'data' => [
                'imageable_type' => get_class(), 
                'imageable_id' => $this->id,
            ],
            'image' => [
                'tools' => view('livewire.upload.tools')->render(),
                'line' => view('livewire.upload.line', ['defaults' => $this->addonsDefaults])->render(),
                'buttons' => view('livewire.upload.buttons')->render(),
            ],
            'fields' => array_keys($this->addonsDefaults),
        ]);
    }
    
    public function getAddonsDefaults()
    {
        return $this->addonsDefaults;
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
