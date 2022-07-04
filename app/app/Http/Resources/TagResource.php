<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Tag",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="php"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="date",
 *         example="2022-07-04 16:31:00"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="date",
 *         example="2022-07-04 16:31:00"
 *     )
 * )
 */

class TagResource extends JsonResource
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
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
