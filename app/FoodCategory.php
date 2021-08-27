<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodCategory extends Model
{
    protected $table = 'food_category';

    public function user()
    {
        return $this->belongsTo('App\User','vendor_id','id');
    }
    public function products()
    {
        return $this->hasMany('App\Food', 'food_category_id', 'id');
    }    
}
