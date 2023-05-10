<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class DtoRequest
{
    /**
     * Getting one from variants.
     * 
     * @param Request $request
     * @param array $variants
     * @param mixed $default
     * 
     * @return mixed
     */
    protected function variant(Request $request, array $variants, mixed $default): mixed
    {
        $i = 0;
        $count = count($variants);
        $value = null;
        foreach ($variants as $variant) {
            if ($value) {
                break;
            } else {
                if(($i++) == $count) {
                    $value = $request->input($variant, $default);
                } else {
                    $value = $request->input($variant, null);
                }
            }
        }
        return $value;
    }
}
