<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationBooking extends Model
{
    protected $table = 'reservation_booking';

    public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    public function details()
    {
        return $this->hasMany('App\ReservationBookingDetail','reservation_booking_id','id');
    }
    public function getCreatedAtAttribute($value)
    {
        return date(config('app.date_format2'), strtotime($value));
    }
}
