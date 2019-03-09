<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryLink extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function dealer()
    {
        return $this->belongsTo('App\Models\Dealer');
    }
}
