<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    protected $table = 'cars';
    public function getimageAttribute($value){
        return asset('uploads/carsImage/'.$value);
    }
    public function category(){
        return $this->belongsTo('App\ShowRoom','showroom_id','id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','vendor_id','id');
    }
}

