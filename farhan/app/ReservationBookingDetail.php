<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationBookingDetail extends Model
{
    protected $table = 'reservation_booking_detail';

    public function vendors()
    {
        return $this->belongsTo('App\User','vendor_id','id');
    }
    public function reservationbooking()
    {
        return $this->belongsTo('App\ReservationBooking');
    }
    public function reservation()
    {
        return $this->belongsTo('App\Reservation','reservation_id','id');
    } 
}
