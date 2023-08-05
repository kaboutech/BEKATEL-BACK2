<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonPickupDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'bon_pickup_id','order_id'
    ];

    public function bon_pickup()
    {
        return $this->belongsTo(BonPickup::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public function receiver()
    {
        return $this->belongsTo(Receiver::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

  
}
