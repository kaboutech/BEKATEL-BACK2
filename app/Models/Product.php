<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',"price","warehouse_id","image","product_categorie_id","product_type_id","quantity","customer_id","package_id","is_package","weight",
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product_categorie()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function product_type()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

}
