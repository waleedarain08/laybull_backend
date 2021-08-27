<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodBooking extends Model
{
    protected $table = 'food_booking';

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    public function details()
    {
        return $this->hasMany('App\FoodBookingDetail','food_booking_id','id');
    }
    public function getCreatedAtAttribute($value)
    {
        return date(config('app.date_format2'), strtotime($value));
    }
    
    public function getLatitudeAttribute($value)
    {
        return number_format($value, 8);
    }
    
    public function getLongitudeAttribute($value)
    {
        return number_format($value, 8);
    }
}
