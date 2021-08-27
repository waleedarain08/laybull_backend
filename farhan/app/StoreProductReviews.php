<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreProductReviews extends Model
{
    protected $table = 'store_product_reviews';
    public function storeproduct()
    {
      return $this->belongsTo('App\StoreProduct','product_id','id');  
    }
}
