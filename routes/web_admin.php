<?php

use Illuminate\Support\Facades\Route;

Route::get('/admin/dashboard', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('dashboard')->middleware('role:Super Admin|Admin');

// Routes for category
Route::group(['middleware' => ['permission:View Category Permission']], function () {
    Route::get('/admin/category', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('category');
    Route::get('/admin/category/list', [App\Http\Controllers\Admin\CategoryController::class, 'list'])->name('category.list');
    Route::group(['middleware' => ['permission:Create Category']], function () {
        Route::post('/admin/category/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('category.create'); 
    });
    Route::group(['middleware' => ['permission:Edit Category']], function () {
        Route::get('/admin/category/edit/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/admin/category/update/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('category.update');
    });
    Route::group(['middleware' => ['permission:Edit Category']], function () {
        Route::delete('/admin/category/delete/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'delete'])->name('category.delete');
    });
});
?>