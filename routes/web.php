<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get("/shop", [ShopController::class, 'index'])->name('shop.index');

Route::middleware((["auth"]))->group(function() {
    Route::get("/account-dashboard", [UserController::class, "index"])->name("user.index");
});

Route::middleware((["auth", AuthAdmin::class]))->group(function() {
    Route::get("/admin", [AdminController::class, "index"])->name("admin.index");

    Route::get("/admin/brands", [AdminController::class, "brands"])->name("admin.brands");
    Route::get("/admin/brand/add", [AdminController::class, "addBrand"])->name("admin.brand.add");
    Route::post("/admin/brand/store", [AdminController::class, 'brand_store'])->name('admin.brand.store');
    Route::delete("/admin/brand/{id}", [AdminController::class, 'delete_brand'])->name("admin.brand.delete");
    Route::get("/admin/brand/edit/{id}", [AdminController::class, "edit_brand"])->name("admin.brand.edit");
    Route::put("/admin/brand/update/{id}", [AdminController::class, "update_brand"])->name("admin.brand.update");

    Route::get("/admin/categories", [AdminController::class, "categories"])->name("admin.categories");
    Route::get("/admin/categories/add", [AdminController::class, "add_category"])->name("admin.categories.add");
    Route::post("/admin/categories/store", [AdminController::class, "store_category"])->name("admin.categories.store");
    Route::delete("/admin/categories/{id}", [AdminController::class, "delete_category"])->name("admin.categories.delete");
    Route::get("/admin/categories/edit/{id}", [AdminController::class, "edit_category"])->name("admin.categories.edit");
    Route::put("/admin/categories/update/{id}", [AdminController::class, "update_category"])->name("admin.categories.update");

    Route::get("/admin/products", [AdminController::class, "products"])->name("admin.products");
    Route::get("/admin/product/add", [AdminController::class, "add_product"])->name("admin.product.add");
    Route::post("/admin/product/store", [AdminController::class, "store_product"])->name("admin.product.store");
    Route::delete("/admin/product/{id}", [AdminController::class, "delete_product"])->name("admin.product.delete");
    Route::get("/admin/product/edit/{id}", [AdminController::class, "edit_product"])->name("admin.product.edit");
    Route::put("/admin/product/update/{id}", [AdminController::class, "update_product"])->name("admin.product.update");
});