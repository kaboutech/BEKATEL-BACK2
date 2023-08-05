<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id', 'order_status_id'
    ];

    public function OrderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function Role()
    {
        return $this->belongsTo(Role::class);
    }

}
