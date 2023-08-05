<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReclamationTypeAccesses extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id', 'reclamations_type_id'
    ];

    public function ReclamationsType()
    {
        return $this->belongsTo(ReclamationsType::class);
    }

    public function Role()
    {
        return $this->belongsTo(Role::class);
    }
}
