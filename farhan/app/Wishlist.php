<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
//    use HasFactory;
    protected $fillable = [
        'user_id',
        'prod_id',
    ];
    public function product()
    {
        return $this->belongsTo('App\Product','prod_id','id');
    }
}
