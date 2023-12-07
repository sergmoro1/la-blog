<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Image model class
 *
 * @param integer   $id
 * @param integer   $imageable_id
 * @param string    $parent_type
 * @param string    $disk
 * @param string    $url
 * @param string    $original
 * @param integer   $size
 * @param string    $mime_type
 * @param json      $addons
 * @param timestamp $created_at
 * @param timestamp $updated_at
 *
 * @property Model $imageable
 */
class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable= [
        'imageable_type',
        'imageable_id',
        'disk',
        'url',
        'size',
        'mime_type',
        'original',
        'addons',
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
     * Get parent model for image.
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
