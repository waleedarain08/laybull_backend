<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
   // use HasFactory;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Product','product_id','id');
    }
}
