<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Tag model class
 *
 * @param integer   $id
 * @param string    $name
 * @param timestamp $created_at
 *
 * @property Posts[]
 */
class Tag extends Model
{
    use HasFactory;
    
    const UPDATED_AT = null; 

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
   protected $fillable = [
        'name',
    ];

    /**
     * The attributes that are auto assignable.
     *
     * @var string[]
     */
    protected $hidden = [
        'created_at', 
    ];
    
    /**
     * Posts in which the tag was specified.
     *
     * @return mixed
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tags');
    }

    /**
     * Rewrite method to disable updated_at
     */
    public function setUpdatedAtAttribute($value)
    {
    }
}
