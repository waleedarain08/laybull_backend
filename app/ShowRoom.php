<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShowRoom extends Model
{
    protected $table = 'showroom';
    public function getimageAttribute($value){
        return asset('uploads/showroomImages/'.$value);
    }
    public function user()
    {
        return $this->belongsTo('App\User','vendor_id','id');
    }
}
