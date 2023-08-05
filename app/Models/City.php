<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price',"cities_codes_id","price","delay"];

    public function CitiesCode()
    {
        return $this->belongsTo(CitiesCode::class);
    }

}
