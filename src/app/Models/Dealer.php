<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function categoryLinks()
    {
        return $this->hasMany('App\Models\Offer\CategoryLink');
    }
}
