<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    //use HasFactory;
    public $guarded = [];
    public function product()
    {
        return $this->belongsTo('App\Product','product_id','id');
    }
}
