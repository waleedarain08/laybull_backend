<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    protected $table = 'user_locations';
    
    public function getLatitudeAttribute($value)
    {
        return number_format($value, 8);
    }
    
    public function getLongitudeAttribute($value)
    {
        return number_format($value, 8);
    }
}
