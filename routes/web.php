<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::controller(ShopController::class)->group(function() {
    Route::get("/shop", 'index')->name('shop.index');
    Route::get("/shop/{product_slug}", 'product_details')->name('shop.product.details');
});

Route::controller(CartController::class)->group(function() {
    Route::get('/cart', 'index')->name('cart.index');
    Route::post('/cart/add', 'add_to_cart')->name('cart.add');
    Route::put('/cart/increase-quantity/{rowId}', 'increase_cart_quantity')->name('cart.qty.increase');
    Route::put('/cart/decrease-quantity/{rowId}', 'decrease_cart_quantity')->name('cart.qty.decrease');
    Route::delete('/cart/remove/{rowId}', 'remove_item')->name('cart.remove');
    Route::delete('/cart/clear', 'empty_cart')->name('cart.clear');
});

Route::middleware((["auth"]))->group(function() {
    Route::get("/account-dashboard", [UserController::class, "index"])->name("user.index");
});

Route::middleware((["auth", AuthAdmin::class]))->prefix("admin")->as("admin.")->controller(AdminController::class)->group(function() {
    Route::get("/", "index")->name("index");

    // Brands Routes
    Route::get("/brands", "brands")->name("brands");
    Route::get("/brand/add", "addBrand")->name("brand.add");
    Route::post("/brand/store", 'brand_store')->name('brand.store');
    Route::delete("/brand/{id}", 'delete_brand')->name("brand.delete");
    Route::get("/brand/edit/{id}", "edit_brand")->name("brand.edit");
    Route::put("/brand/update/{id}", "update_brand")->name("brand.update");

    // Categories Routes
    Route::get("/categories", "categories")->name("categories");
    Route::get("/categories/add", "add_category")->name("categories.add");
    Route::post("/categories/store", "store_category")->name("categories.store");
    Route::delete("/categories/{id}", "delete_category")->name("categories.delete");
    Route::get("/categories/edit/{id}", "edit_category")->name("categories.edit");
    Route::put("/categories/update/{id}", "update_category")->name("categories.update");

    // Products Routes
    Route::get("/products", "products")->name("products");
    Route::get("/product/add", "add_product")->name("product.add");
    Route::post("/product/store", "store_product")->name("product.store");
    Route::delete("/product/{id}", "delete_product")->name("product.delete");
    Route::get("/product/edit/{id}", "edit_product")->name("product.edit");
    Route::put("/product/update/{id}", "update_product")->name("product.update");
});