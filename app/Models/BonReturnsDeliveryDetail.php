<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonReturnsDeliveryDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'bon_returns_delivery_id','order_id'
    ];


    public function bon_returns_delivery()
    {
        return $this->belongsTo(BonDelivery::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }





}
