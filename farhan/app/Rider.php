<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    protected $table = 'rider';

    public function user()
    {
        return $this->belongsTo('App\User','rider_id','id');
    }
}
