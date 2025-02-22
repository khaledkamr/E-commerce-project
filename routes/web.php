<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::prefix('shop')->as('shop.')->controller(ShopController::class)->group(function() {
    Route::get("/", 'index')->name('index');
    Route::get("/{product_slug}", 'product_details')->name('product.details');
});

Route::prefix('cart')->as('cart.')->controller(CartController::class)->group(function() {
    Route::get('/', 'index')->name('index');
    Route::post('/add', 'add_to_cart')->name('add');
    Route::put('/increase-quantity/{rowId}', 'increase_cart_quantity')->name('qty.increase');
    Route::put('/decrease-quantity/{rowId}', 'decrease_cart_quantity')->name('qty.decrease');
    Route::delete('/remove/{rowId}', 'remove_item')->name('remove');
    Route::delete('/clear', 'empty_cart')->name('clear');
});

Route::prefix('wishlist')->as('wishlist.')->controller(WishlistController::class)->group(function() {
    Route::get('/', 'index')->name('index');
    Route::post('/add', 'add_to_wishlist')->name('add');
    Route::delete('/item/remove/{rowId}', 'remove_item')->name('item.remove');
    Route::delete('/clear', 'empty_wishlist')->name('items.clear');
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