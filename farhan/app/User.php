<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function detail(){
        return $this->hasOne('App\UserDetail','user_id');
    }
    public function location(){
        return $this->hasOne('App\UserLocation', 'user_id', 'id');
    }

    public function foodcategory(){
        return $this->hasMany('App\FoodCategory');

    }
     public function rider()
    {
        return $this->hasOne('App\Rider','rider_id','id');
    }
    public function bankaccount()
    {
        return $this->hasOne('App\BankAccount','vendor_id','id');
    }
    public function food()
    {
        return $this->hasMany('App\Food', 'vendor_id', 'id');
    }
    public function grocerycategory()
    {
        return $this->hasMany('App\GroceryCategory');
    }
    public function groceryProducts()
    {
        return $this->hasMany('App\GroceryProduct', 'vendor_id', 'id');
    }
    public function storecategory()
    {
        return $this->hasMany('App\StoreCategory');
    }
    public function storeProducts()
    {
        return $this->hasMany('App\StoreProduct', 'vendor_id', 'id');
    }
    public function hotel()
    {
        return $this->hasMany('App\Hotel');
    }
    public function showroom()
    {
        return $this->hasMany('App\ShowRoom');
    }
    public function car()
    {
        return $this->hasMany('App\Cars');
    }

    public function foodReviews(){
        return $this->hasMAny('App\FoodVendorReviews','vendor_id','id');
    }
    public function groceryReviews(){
        return $this->hasMAny('App\GroceryVendorReviews','vendor_id','id');
    }
    public function storeReviews(){
        return $this->hasMAny('App\StoreVendorReviews','vendor_id','id');
    }

   public function reservations()
    {
        return $this->hasMany('App\Reservation','vendor_id','id');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function bids()
    {
        return $this->hasMany('App\Bid');
    }
}
