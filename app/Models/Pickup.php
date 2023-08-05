<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    use HasFactory;


    protected $fillable = [
        'customer_id',
        'pickup_status_id',
        'adresse',
        'product_name',
        'city_id',
        'quantity',
        'product_type_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function pickupStatus()
    {
        return $this->belongsTo(PickupStatus::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }



}
