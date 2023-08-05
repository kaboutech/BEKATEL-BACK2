<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name', 'phone', 'email', 'password', 'email_verified_at', 'company_name', 'company_logo', 'if', 'ice','users_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }

 
}