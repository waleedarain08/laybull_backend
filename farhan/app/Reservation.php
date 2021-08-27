<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    protected $table = 'vendor_reservation';

    public function vendor()
    {
        return $this->belongsTo('App\User','vendor_id','id');
    }
   
    public function getTimeAttribute($value)
    {
      return Carbon::parse($value)->format('h:i A');
    }
}
