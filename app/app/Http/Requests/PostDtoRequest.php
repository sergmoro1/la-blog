<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class PostDtoRequest
{
    /**
     * @var integer
     */
    public $draw;

    /**
     * @var string
     */
    public $search;

    /**
     * @var integer
     */
    public $offset;

    /**
     * @var integer
     */
    public $limit;
    
    /**
     * @var array
     */
    public $order;

    public function __construct(Request $request)
    {
        $this->draw = $request->input('draw', 0);
        $search = $request->input('search', ['value' => '']);
        $this->search = $search['value'];

        $this->offset = $request->input('start', 0);

        $limit = $request->input('limit', null);
        if(!$limit) {
            $limit = $request->input('length', 15);
        }
        $this->limit = $limit;

        $this->order = $request->order;

        $request->merge(['page' => $this->offset / $this->limit + 1]);
    }
}
