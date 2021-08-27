<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroceryProductReviews extends Model
{
    protected $table = 'grocery_product_reviews';
    public function groceryproduct()
    {
        return $this->belongsTo('App\GroceryProduct','product_id','id');
    }
}
