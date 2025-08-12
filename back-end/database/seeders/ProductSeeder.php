<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\User;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 10 products for each brand
        Brand::all()->each(function ($brand) {
            Product::factory()->count(10)->create([
                'brand_id' => $brand->id,
                'category_id' => Category::inRandomOrder()->first()->id,
                'user_id' => 1,
            ]);
        });

        // 10 products for each category
        Category::all()->each(function ($category) {
            Product::factory()->count(10)->create([
                'category_id' => $category->id,
                'brand_id' => Brand::inRandomOrder()->first()->id,
                'user_id' => 1,
            ]);
        });
    }
}