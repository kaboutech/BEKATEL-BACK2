<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function PickupRequest()
    {
        return $this->hasMany(PickupRequest::class);
    }

}
