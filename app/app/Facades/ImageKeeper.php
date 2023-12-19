<?php

namespace App\Facades;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Image;

class ImageKeeper
{
    /**
     * Unsuccessful uploading. 
     * 
     * @param string $message
     * @param array $params
     * @return array with error status and message
     */
    private static function err(string $message, array $params = []): array
    {
        return [
            'success' => 0,
            'message' => __($message, $params),
        ];
    }
    
    /**
     * Transfer the uploaded image to the desired directory and
     * save a record of the file characteristics in the Images table.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static function proceed(Request $request, string $file_input = 'file_input'): array
    {
        $post = $request->all();

        if (isset($post['imageable_type']) && isset($post['imageable_id'])) {
            $imageable_type = $post['imageable_type'];
            $imageable_id = $post['imageable_id'];
        } else {
            return self::err('images.undefined_imageable_type_or_id');
        }

        // a model that has images, such as Post
        $model = $imageable_type::find($imageable_id);
    
        $file = $post[$file_input];

        // upload error
        if ($file->getError() !== UPLOAD_ERR_OK) {
            return self::err($file->getErrorMessage());
        }

        // is not image
        if (strtolower(substr($file->getClientMimeType(), 0, 5)) !== 'image') {
            return self::err('images.is_not_image');
        }

        // too many files
        if (isset($post['limit']) && $post['limit'] > count($model->images)) {
            return self::err('images.too_many_files', ['max' => $post['limit']]);
        }

        // check file size
        if ($file->getSize() > $file->getMaxFilesize()) {
            return self::err('size_does_not_fit', [
                'max'  => $file->getMaxFilesize(),
            ]);
        }

        $url = Storage::disk($model->getDisk())->putFile($model->getFullPath(), $file);
        
        // save information about just uploaded image
        if ($image = Image::create([
            'imageable_type' => $imageable_type,
            'imageable_id'   => $imageable_id,
            'disk'           => $model->getDisk(),
            'url'            => $url,
            'original'       => $file->getClientOriginalName(),
            'mime_type'      => $file->getClientMimeType(),
            'size'           => $file->getSize(),
            'addons'         => json_encode($model->getAddonsDefaults()),
        ])) {
            return [
                'success' => 1, 
                'file' => [ 
                    'id'    => $image->id,
                    'thumb' => $image->makeThumbnail(),
                    'url'   => $image->getUrl(),
                ]
            ];
        } else {
            return self::err(__('image.image_cant_be_saved', ['name' => $image->original]));
        }
    }
}