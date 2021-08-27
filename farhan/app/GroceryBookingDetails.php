<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroceryBookingDetails extends Model
{
    protected $table = 'grocery_booking_details';

    public function vendor()
    {
        return $this->belongsTo('App\User','vendor_id','id');
    }
    public function grocerybooking()
    {
        return $this->belongsTo('App\GroceryBooking');
    }
    public function grocery()
    {
        return $this->belongsTo('App\GroceryProduct');
    }

}
