<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonDeliveryDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'bon_delivery_id','order_id'
    ];


    public function bon_delivery()
    {
        return $this->belongsTo(BonDelivery::class);
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

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    
}
