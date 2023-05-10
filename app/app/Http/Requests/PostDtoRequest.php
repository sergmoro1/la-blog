<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class PostDtoRequest extends DtoRequest
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

        $this->offset = $this->variant($request, ['offset', 'start'], 0);
        $this->limit = $this->variant($request, ['limit', 'length'], 15);

        $this->order = $request->input('order', []);

        $request->merge(['page' => $this->offset / $this->limit + 1]);
    }
}
