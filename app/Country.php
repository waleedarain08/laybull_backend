<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
      public function detail(){
        return $this->belongsTo('App\UserDetail','country');
    }
}
