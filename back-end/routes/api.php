<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/profile', 'profile')->middleware('auth:sanctum');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

Route::prefix('admin')->middleware('auth:sanctum')->group(function() {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/roles', 'roles');
        Route::post('/create_role', 'addRole');
        Route::put('/update_role/{id}', 'updateRole');
        Route::delete('/delete_role/{id}', 'deleteRole');

        Route::get('/permissions', 'permissions');
        Route::post('/create_permission', 'addPermission');
        Route::put('/update_permission/{id}', 'updatePermission');
        Route::delete('/delete_permission/{id}', 'deletePermission');
    });
});