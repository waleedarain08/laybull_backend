<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodBookingDetail extends Model
{
    protected $table = 'food_booking_detail';

    public function vendor(){
        return $this->belongsTo('App\User','vendor_id','id');
    }
    public function foodbooking(){
        return $this->belongsTo('App\FoodBooking');
    }
    public function food(){
        return $this->belongsTo('App\Food');
    }
}
