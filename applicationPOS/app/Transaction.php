<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
        'total_price',
        'payment_type',
        'person_in_charge',
        'unique_id',
    ];

    public function personInCharge(){
        return $this->belongsTo('App\User', 'person_in_charge');
    }
    public function items(){
        return $this->hasMany('App\TransactionItem', 'transaction_id');
    }
}
