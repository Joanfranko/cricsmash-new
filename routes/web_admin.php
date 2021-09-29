<?php

use Illuminate\Support\Facades\Route;

Route::get('/admin/dashboard', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('dashboard')->middleware('role:Super Admin|Admin');

?>