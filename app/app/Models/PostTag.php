<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Post_tags model class
 *
 * @param integer   $id
 * @param integer   $post_id
 * @param integer   $tag_id
 */
class PostTag extends Model
{
    /**
     * Update tags for the post.
     * 
     * @param int $post_id
     * @param Request $request with new list of tags
     */
    protected static function update_tags(int $post_id, Request $request) {
        // get old tags
        $old_tags_collection = self::select('tag_id')->where(['post_id' => $post_id])->get();

        $old_tags = $old_tags_collection->map(function($item) {
            return $item->tag_id;
        })->toArray();

        // insert added tags
        $diff = array_diff($request->tags, $old_tags);
        if ($diff) {
            $added_links = array_map(function($tag_id) use ($post_id) {
                return ['post_id' => $post_id, 'tag_id' => $tag_id];
            }, $diff);
            self::insert($added_links);
        }

        // delete tags that are no longer used
        $diff = array_diff($old_tags, $request->tags);
        if ($diff) {
            foreach($diff as $tag_id) {
                self::where([
                    'post_id' => $post_id,
                    'tag_id' => $tag_id
                ])->delete();
            }
        }
    }
}
    