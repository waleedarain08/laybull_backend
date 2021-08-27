<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
 public function product(){
        return $this->belongsTo('App\Product','product_id');
    }
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
      public function userdetail(){
        return $this->belongsTo('App\Usedetailr', 'user_id','id');
    }
   
}
