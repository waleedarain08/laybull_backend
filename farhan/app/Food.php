<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Food extends Model
{
    protected $table = 'food';

    public function getImageAttribute($value){
        return asset('uploads/images/'.$value);
    }
    public function foodcategory(){
        return $this->belongsTo('App\FoodCategory','food_category_id','id');
    }
    public function foodbookingdetails(){
        return $this->hasOne('App\FoodBookingDetails');
    }
    public function user()
    {
        return $this->belongsTo('App\User','vendor_id','id');
    }
}
