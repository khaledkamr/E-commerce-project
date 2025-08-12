<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'image',
        'description',
        'price',
        'stock',
        'featured',
        'category_id',
        'brand_id',
        'user_id',
    ];
}
