<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreBookingDetails extends Model
{
    public $table = 'store_booking_details'; 
    
    public function vendor()
    {
        return $this->belongsTo('App\User','vendor_id','id');
    }
    public function storebooking()
    {
        return $this->belongsTo('App\StoreBooking');
    }
    public function store()
    {
        return $this->belongsTo('App\StoreProduct');
    }

}
