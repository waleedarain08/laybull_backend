<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $table = 'hotel';
    public function getimageAttribute($value){
        return asset('uploads/hotelImages/'.$value);
    }
    public function user()
    {
        return $this->belongsTo('App\User','vendor_id','id');
    }

}
