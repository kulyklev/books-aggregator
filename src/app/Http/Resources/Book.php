<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
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
            'isbn' => $this->isbn,
            'name' => $this->name,
            'original_name' => $this->when($this->isBooksShowRoute($request), $this->original_name),
            'author' => $this->author,
            'language' => $this->when($this->isBooksShowRoute($request), $this->language),
            'original_language' => $this->when($this->isBooksShowRoute($request), $this->original_language),
            'publishing_year' => $this->publishing_year,
            'paperback' => $this->when($this->isBooksShowRoute($request), $this->paperback),
            'publisher' => $this->publisher->name,
            'category' => $this->category->name,
            'weight' => $this->when($this->isBooksShowRoute($request), $this->weight),

            'offers' => new OfferCollection($this->offers),
        ];
    }

    private function isBooksShowRoute(Request $request): bool
    {
        return $request->route()->getName() == 'books.show';
    }
}
