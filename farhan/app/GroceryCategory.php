<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroceryCategory extends Model
{
    protected $table = 'grocery_category'; 

    public function user()
    {
        return $this->belongsTo('App\User','vendor_id','id');
    }
    public function products()
    {
        return $this->hasMany('App\GroceryProduct','grocery_category_id','id');
    }
}
