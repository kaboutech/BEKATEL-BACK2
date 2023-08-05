<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receiver extends Model
{
    use HasFactory;

    protected $fillable = [
        'adresse',"name","phone","email","city_id"
    ];
   
    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
