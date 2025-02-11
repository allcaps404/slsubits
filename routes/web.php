<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/usersmanagement', UserController::class);
    Route::get('/usersmanagement/{id}/edit', [UserController::class, 'edit'])->name('usersmanagement.edit');
    Route::put('/usersmanagement/{id}', [UserController::class, 'update'])->name('usersmanagement.update');
    Route::delete('admin/usersmanagement/{usersmanagement}', [UserController::class, 'destroy'])->name('usersmanagement.destroy');
    Route::get('/check-email', [UserController::class, 'checkEmail'])->name('check-email');
});

Route::prefix('student')->middleware(['student'])->group(function () {
    Route::get('/', [App\Http\Controllers\Student\HomeController::class,'index'])->name('student.home');
    Route::get('/profile', [App\Http\Controllers\Student\ProfileController::class, 'edit'])->name('student.profile');
	Route::put('/profile', [App\Http\Controllers\Student\ProfileController::class, 'update'])->name('student.profile.update');
});

Auth::routes();
