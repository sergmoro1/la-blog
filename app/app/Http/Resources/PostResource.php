<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TagResource;

/**
 * @OA\Schema(
 *     schema="Post",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         enum={"draft", "published", "archived"},
 *         example="draft"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         example="Genius title"
 *     ),
 *     @OA\Property(
 *         property="excerpt",
 *         type="string",
 *         example="Excerpt of Content"
 *     ),
 *     @OA\Property(
 *         property="Content",
 *         type="string",
 *         example="Long Content"
 *     ),
 *     @OA\Property(
 *         property="Tags",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Tag")
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         example="2022-07-04T16:31:00+0300"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         example="2022-07-04T16:31:00+0300"
 *     )
 * )
 */

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'tags' => TagResource::collection($this->tags),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
