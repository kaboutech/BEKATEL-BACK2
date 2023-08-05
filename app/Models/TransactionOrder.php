<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'order_id'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
