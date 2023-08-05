<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonPickup extends Model
{
    use HasFactory;

    protected $fillable = [
        'valid',"ref","customer_id","colis"
    ];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function bon_pickup()
    {
        return $this->belongsTo(BonDelivery::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
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
