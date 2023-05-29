<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class TagDtoRequest
{
    /**
     * @var string
     */
    public $search;

    /**
     * @var integer
     */
    public $limit;
    
    public function __construct(Request $request)
    {
        $this->search = $request->input('search', '');
        $this->limit = $request->input('limit', 15);
    }
}
