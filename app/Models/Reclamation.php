<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reclamations_type_id',"customer_id","content","title","reclamation_status_id","ref"
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function reclamation_status()
    {
        return $this->belongsTo(ReclamationStatus::class);
    }


}
