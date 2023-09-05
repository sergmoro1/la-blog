<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Like model class
 * to save which users like the post.
 *
 * @param integer   $id
 * @param integer   $user_id
 * @param integer   $post_id
 * @param timestamp $created_at
 */
class Like extends Model
{
    use HasFactory;

    const UPDATED_AT = null; 

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
   protected $fillable= [
        'user_id',
        'post_id',
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
     * Rewrite method to disable updated_at
     */
    public function setUpdatedAtAttribute($value)
    {
    }
}
