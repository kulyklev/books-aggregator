<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Price extends JsonResource
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
            'price' => $this->price,
            'currency' => $this->currency,
            'date' => $this->updated_at
        ];
    }
}
