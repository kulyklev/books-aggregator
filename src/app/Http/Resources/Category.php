<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
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
            'links' => $this->when($this->isCategoriesShowRoute($request), new CategoryLinkCollection($this->categoryLinks))
        ];
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    private function isCategoriesShowRoute(Request $request): bool
    {
        return $request->route()->getName() == 'categories.show';
    }
}
