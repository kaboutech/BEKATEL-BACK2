<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonReturnsDelivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'valid',"ref","driver_id","colis"
    ];



    public function driver(){
        return $this->belongsTo(Driver::class);
    }

}
