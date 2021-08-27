<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    public function user(){
        return $this->belongsTo('App\User', 'user_id','id');
    }
    
    public function getImageAttribute($value){
        return $value ? asset('uploads/user_profile/'.$value) : null;
    }
    public function country(){
       return $this->hasOne('App\Country', 'country_name');
    }
}
