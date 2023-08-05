<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id', 'amount'
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function driverPaymentDetails()
    {
        return $this->hasMany(DriverPaymentDetail::class);
    }
}
