<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $table = 'bankaccount';

    public function vendor()
    {
        return $this->belongsTo('App\User','vendor_id','id');
    }
}
