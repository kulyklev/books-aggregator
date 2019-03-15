<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Book extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'isbn' => $this->isbn,
            'publishing_year' => $this->publishing_year,
            'author' => $this->author,
            'publisher' => $this->publisher->name,
            'offers' => new OfferCollection($this->offers)
        ];
    }
}
