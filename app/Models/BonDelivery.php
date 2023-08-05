<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonDelivery extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'valid','driver_id','ref',"colis"
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

 

}
