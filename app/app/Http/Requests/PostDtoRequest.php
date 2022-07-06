<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class PostDtoRequest
{
    /**
     * @var array
     */
    public $tags;

    /**
     * @var integer
     */
    public $limit;
    
    public function __construct(Request $request)
    {
        $this->tags = $request->input('tags') ?? null;
        $this->limit = $request->input('limit') ?? 15;
    }
}
