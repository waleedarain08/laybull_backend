<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodProductReviews extends Model
{
    protected $table = 'food_product_reviews';
    public function foodProduct()
    {
        return $this->belongsTo('App\Food','product_id','id');
    }
}
