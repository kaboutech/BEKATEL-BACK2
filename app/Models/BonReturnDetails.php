<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonReturnDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'bon_return_id','order_id'
    ];

    public function bon_return()
    {
        return $this->belongsTo(BonReturn::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function receiver()
    {
        return $this->belongsTo(Receiver::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

}
