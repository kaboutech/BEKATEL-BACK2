<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'creation_date', 'orders', 'closed', 'paid', 'amount', 'customer_id', 'additional_fees', 'ref'
    ];

}
