<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    public function offer()
    {
        return $this->belongsTo('App\Models\Offer');
    }
}
