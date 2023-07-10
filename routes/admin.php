<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\EnsureUserType;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth','auth.type:admin,super-admin'])->prefix('/admin')->group(function(){

 Route::get('/products/trashed',[ProductController::class , 'trashed'])->name('products.trashed');
 Route::put('/products/{product}/restore',[ProductController::class , 'restore'])->name('products.restore');

 Route::delete('/products/{product}/force' , [ProductController::class , 'forceDelete'])->name('products.force-delete');

 Route::resource('/products', ProductController::class);
 Route::resource('/categories', CategoryController::class);
 Route::resource('/orders', OrdersController::class);

 });
 Route::middleware(['auth', 'auth.type:admin,super-admin'])->prefix('/admin')->group(function () {

    Route::resource('/categories', CategoriesController::class);

    Route::get('/categories/trashed', [CategoriesController::class, 'trashed'])
        ->name('categories.trashed');

    Route::put('/categories/{category}/restore', [CategoriesController::class, 'restore'])
        ->name('categories.restore');

    Route::delete('/categories/{category}/force', [CategoriesController::class, 'forceDelete'])
        ->name('categories.force-delete');
 });
