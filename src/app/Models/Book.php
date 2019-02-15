<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function publisher()
    {
        return $this->belongsTo('App\Models\Publisher');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }
}
