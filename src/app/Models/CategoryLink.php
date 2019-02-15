<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryLink extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Models\CategoryLink');
    }
}
