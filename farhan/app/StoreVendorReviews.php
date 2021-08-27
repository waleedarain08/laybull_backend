<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreVendorReviews extends Model
{
    protected $table = 'store_vendor_reviews';
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    
    public function getCreatedAtAttribute($value)
    {
        return date(config('app.date_format'), strtotime($value));
    }
    public function vendor()
    {
        return $this->belongsTo('App\User','vendor_id','id');
    }
}
