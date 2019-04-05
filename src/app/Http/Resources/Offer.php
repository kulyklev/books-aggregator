<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
        $latestPrice = $this->prices->sortByDesc('created_at')->first();

        return [
            'id' => $this->id,
            'dealer' => $this->dealer->site_name,
            'logo' => $this->dealer->logo,
            'link' => $this->link,
            'image' => Storage::url($this->image),
            'price' => $latestPrice->price,
            'currency' => $latestPrice->currency    ,
            'prices' => $this->when($this->isBooksShowRoute($request),
                                    new PriceCollection($this->prices))
        ];
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    private function isBooksShowRoute(Request $request): bool
    {
        return $request->route()->getName() == 'books.show';
    }
}
