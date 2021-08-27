<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroceryProduct extends Model
{
    protected $table = 'grocery_product';

    public function getImageAttribute($value){
        return asset('uploads/groceryproduct/'.$value);
    }
    public function category(){
        return $this->belongsTo('App\GroceryCategory','grocery_category_id','id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','vendor_id','id');
    }
}
