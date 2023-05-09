<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collecton into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $start = $request->input('start', null);
        $length = $request->input('length', null);
        return [
            'success' => true,
            'draw' => (isset($_REQUEST["draw"]) ? $_REQUEST["draw"] : 0),
            'data' => $this->collection,
            'links' => [
                'first' => $this->url(1),
                'last' => $this->url($this->lastPage()),
                'prev' => $this->previousPageUrl(),
                'next' => $this->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => (is_null($start) ? $this->currentPage() : ($start / $length + 1)),
                'from' => $this->firstItem(),
                'last_page' => $this->lastPage(),
                'path' => $this->getOptions()['path'] . (is_null($start) ? '' : '?page=' . ($start / $length + 1)),
                'per_page' => (is_null($length) ? $this->perPage() : $length),
                'to' => $this->lastItem(),
                'total' => $this->total(),
            ],
            'recordsTotal' => $this->total(),
            'recordsFiltered' => $this->total(),
        ];
    }
}
