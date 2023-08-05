<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemsPickup extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',"quantity","product_categorie_id","product_type_id","order_id"
    ];


    public function product_categorie()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function product_type()
    {
        return $this->belongsTo(ProductType::class);
    }

}
