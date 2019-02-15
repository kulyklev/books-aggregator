<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public function dealer()
    {
        return $this->belongsTo('App\Models\Dealer');
    }

    public function prices()
    {
        return $this->hasMany('App\Models\Price');
    }

    public function book()
    {
        return $this->belongsTo('App\Models\Book');
    }
}
