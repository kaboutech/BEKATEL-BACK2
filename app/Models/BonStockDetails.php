<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonStockDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'bon_stock_id','order_id'
    ];
}
