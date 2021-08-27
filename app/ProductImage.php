<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    public $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Product','product_id','id');
    }
}
