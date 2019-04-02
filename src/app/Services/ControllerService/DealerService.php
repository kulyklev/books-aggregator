<?php


namespace App\Services\ControllerService;


use App\Http\Resources\DealerCollection;
use App\Models\Dealer;

class DealerService
{
    /**
     * @return mixed
     */
    public function getAll()
    {
        return new DealerCollection(Dealer::all());
    }
}