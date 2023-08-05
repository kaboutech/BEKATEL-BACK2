<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryMessagesNotes extends Model
{
    use HasFactory;

    protected $fillable = [
        'content', 'conversation_id', 'driver_id'
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }


}
