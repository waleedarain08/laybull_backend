<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreProduct extends Model
{
    protected $table = 'store_product';

    public function getImageAttribute($value){
        return asset('uploads/storeproductimage/'.$value);
    }

    public function category(){
        return $this->belongsTo('App\StoreCategory','store_category_id','id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','vendor_id','id');
    }
}
