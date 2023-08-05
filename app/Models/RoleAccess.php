<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id', 'module'
    ];

    public function Role()
    {
        return $this->belongsTo(Role::class);
    }

    	
}
