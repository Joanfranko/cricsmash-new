<?php

use Illuminate\Support\Facades\Route;

Route::get('/admin/dashboard', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('dashboard')->middleware('role:SuperAdmin|Admin');

Route::group(['middleware' => ['role:SuperAdmin']], function () {
    // Routes for Roles
    Route::get('/admin/role', [App\Http\Controllers\Admin\RolesController::class, 'index'])->name('roles');
    Route::get('/admin/role/list', [App\Http\Controllers\Admin\RolesController::class, 'list'])->name('roles.list');
    Route::post('/admin/role/create', [App\Http\Controllers\Admin\RolesController::class, 'create'])->name('roles.create');
    Route::get('/admin/role/edit/{id}', [App\Http\Controllers\Admin\RolesController::class, 'edit'])->name('roles.edit');
    Route::put('/admin/role/update/{id}', [App\Http\Controllers\Admin\RolesController::class, 'update'])->name('roles.update');
    Route::delete('/admin/role/delete/{id}', [App\Http\Controllers\Admin\RolesController::class, 'delete'])->name('roles.delete');

    // Routes for Permissions
    Route::get('/admin/permission', [App\Http\Controllers\Admin\PermissionsController::class, 'index'])->name('permissions');
    Route::get('/admin/permission/list', [App\Http\Controllers\Admin\PermissionsController::class, 'list'])->name('permissions.list');
    Route::post('/admin/permission/create', [App\Http\Controllers\Admin\PermissionsController::class, 'create'])->name('permissions.create');
    Route::get('/admin/permission/edit/{id}', [App\Http\Controllers\Admin\PermissionsController::class, 'edit'])->name('permissions.edit');
    Route::put('/admin/permission/update/{id}', [App\Http\Controllers\Admin\PermissionsController::class, 'update'])->name('permissions.update');
    Route::delete('/admin/permission/delete/{id}', [App\Http\Controllers\Admin\PermissionsController::class, 'delete'])->name('permissions.delete');
});

// Routes for category
Route::group(['middleware' => ['permission:ViewCategory']], function () {
    Route::get('/admin/category', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('category');
    Route::get('/admin/category/list', [App\Http\Controllers\Admin\CategoryController::class, 'list'])->name('category.list');
    Route::group(['middleware' => ['permission:CreateCategory']], function () {
        Route::post('/admin/category/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('category.create'); 
    });
    Route::group(['middleware' => ['permission:EditCategory']], function () {
        Route::get('/admin/category/edit/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/admin/category/update/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('category.update');
    });
    Route::group(['middleware' => ['permission:DeleteCategory']], function () {
        Route::delete('/admin/category/delete/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'delete'])->name('category.delete');
    });
});

?>