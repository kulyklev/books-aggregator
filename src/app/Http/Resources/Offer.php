<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Offer extends JsonResource
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
            'dealer' => $this->dealer->site_name,
            'link' => $this->link,
            'image' => $this->image,
            'prices' => $this->prices->sortByDesc('created_at')->first()->price
        ];
    }
}
