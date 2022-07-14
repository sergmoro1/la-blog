<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class TagDtoRequest
{
    /**
     * @var integer
     */
    public $limit;
    
    public function __construct(Request $request)
    {
        $this->limit = $request->input('limit') ?? 15;
    }
}
