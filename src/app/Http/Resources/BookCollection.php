<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BookCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\Book';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        dd($request);
        return [
            'data' => $this->collection,

        ];
    }
}
