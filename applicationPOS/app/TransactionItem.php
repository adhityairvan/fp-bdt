<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    //
    protected $fillable = [
        'amount',
        'total_price',
        'item_id',
    ];

    public function item(){
        return $this->belongsTo('App\Item', 'item_id');
    }

    public function transaction(){
        return $this->belongsTo('App\Transaction','transaction_id');
    }
}
