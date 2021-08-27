<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreCategory extends Model
{
    protected $table = 'store_category';
    public function user()
    {
        return $this->belongsTo('App\User','vendor_id','id');
    }
    public function products()
    {
        return $this->hasMany('App\StoreProduct','store_category_id','id');
    }
}
