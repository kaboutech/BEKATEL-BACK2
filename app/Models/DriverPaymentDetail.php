<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverPaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_payment_id', 'order_id'
    ];

    public function driverPayment()
    {
        return $this->belongsTo(DriverPayment::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
}
