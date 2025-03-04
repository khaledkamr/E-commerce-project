<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description' ,
        'regular_price',
        'sale_price' ,
        'SKU',
        'stock_status',
        'featured',
        'quantity' ,
        'image' ,
        'images',
        'category_id',
        'brand_id'
    ];

    protected $casts = [
        "images" => "array" // Cast images to an array for proper JSON storage
    ];

    public function category() {
        return $this->belongsTo(Category::class, "category_id");
    }

    public function brand() {
        return $this->belongsTo(Brand::class, "brand_id");
    }
}
