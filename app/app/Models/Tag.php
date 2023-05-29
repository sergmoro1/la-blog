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
     * The attributes that are auto assignable.
     *
     * @var string[]
     */
    protected $hidden = [
        'created_at', 
        'updated_at',
    ];
    
    /**
     * Posts in which the tag was specified.
     *
     * @return mixed
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag');
    }
}
