<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Facades\ImageKeeper;
use App\Models\Image;

class ImageController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/images",
     *     operationId="createImage",
     *     tags={"Images"},
     *     summary="Save image",
     *     description="Save just uploaded image",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Image"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example="true"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Image saved."
     *             )
     *         )
     *     )
     * )
     * 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json(
            ImageKeeper::proceed($request), 
            200
        );
    }

    /**
     * @OA\Put(
     *     path="/api/images",
     *     operationId="updateImage",
     *     tags={"Images"},
     *     summary="Update image",
     *     description="Update ''existing image",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Image"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example="true"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Image updated."
     *             )
     *         )
     *     )
     * )
     * 
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $image = Image::find($id);
        if (!$image) {
            return $this->responseNotFound();
        }

        $post = $request->all();

        if (isset($post['swapping_image_id'])) {
            $swapping_image = Image::find($post['swapping_image_id']);
            if ($swapping_image) {
                $temp = $image->position;
                $image->position = $swapping_image->position;
                $swapping_image->position = $temp;
                $image->save();
                $swapping_image->save();
            } else {
                return $this->responseNotFound();
            }
        } else if (isset($post['addons'])) {
            $image->addons = $post['addons'];
            $image->save();
        } else {
            return response()->json([
                'success' => false,
                'message' => "Only the 'position' and 'addons' fields can be updated for images.",
            ], 403);
        }
        
        return response()->json([
            'success' => true,
            'message' => "Image ($id) updated.",
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/images/{id}",
     *     operationId="deleteImage",
     *     tags={"Images"},
     *     summary="Delete image",
     *     description="Delete image by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Image ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int32"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example="true"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Image deleted."
     *             )
     *         )
     *     )
     * )
     * 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Image::find($id);
        if (!$image) {
            return $this->responseNotFound();
        }
        // find model
        $modelClassName = $image->imageable_type;
        $model = $modelClassName::find($image->imageable_id);
        // delete all files from disk
        Storage::disk($model->getDisk())->delete($image->url);
        Storage::disk($model->getDisk())->delete($image->getThumbnailUrl(false));
        // delete image information
        $image->delete();
        
        return response()->json([
            'success' => true,
            'message' => (__("Entity #:id deleted succsessfully:" . $image->getThumbnailUrl(), ['id' => $id])),
        ], 200);
   }
}
