<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo('App\Category','category_id', 'id');
    }

    public function wishlist()
    {
        return $this->hasMany('App\Wishlist');
    }

    public function color()
    {
        return $this->hasOne('App\ProductColor');
    }

    public function images()
    {
        return $this->hasMany('App\ProductImage', 'product_id', 'id');
    }

    public function biding()
    {
        return $this->hasMany('App\ProductBid', 'product_id', 'id');
    }

    public function size()
    {
        return $this->hasOne('App\ProductSize');
    }

    public function sizess()
    {
        return $this->hasMany('App\ProductSize')->select(array('size'));
    }
    public function sizes()
    {
        if($this->size->first()){
            return $this->size->get(0)->pluck('id');
        }
        else{
            return null;
        }
    }

    public function orderSub()
    {
        return $this->hasMany('App\OrderSub');
    }

    public function vendor(){
        return $this->belongsTo('App\User','vendor_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','vendor_id','id');
    }

    public function getProductVendor($product_id,$full = null)
    {
        $product = Product::find($product_id);
        $vendor = User::find($product->vendor);
        if($product_id && $full){
            return $vendor;
        }else
        {

            if ($vendor)
            {
                return $vendor->first_name;
            }

            else{
                return 'No-Vendor';
            }
        }
    }
}
