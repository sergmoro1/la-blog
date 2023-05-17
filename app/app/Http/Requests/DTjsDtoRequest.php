<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

/**
 * Class for processing DataTables js plugin request.
 * 
 */
class DTjsDtoRequest
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
