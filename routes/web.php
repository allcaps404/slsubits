<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect(route('login'));
});

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
	Route::get('/settings/change-password', [App\Http\Controllers\Student\SettingsController::class, 'changePassword'])->name('student.settings.change-password');
	Route::post('/settings/change-password/update', [App\Http\Controllers\Student\SettingsController::class, 'changePasswordUpdate'])->name('student.settings.change-password.update');
	Route::get('/events', [App\Http\Controllers\Student\EventController::class, 'index'])->name('student.events.index');

	Route::post('/attend', [App\Http\Controllers\Student\AttendanceController::class, 'attend'])->name('student.attend');
    Route::post('/logout-attendance', [App\Http\Controllers\Student\AttendanceController::class, 'logout'])->name('student.logout-attendance');

    Route::get('/settings/face-registration', [App\Http\Controllers\Student\FaceAuthController::class, 'showFaceRegistration'])
        ->name('student.settings.face-registration');
    Route::post('/settings/store-face', [App\Http\Controllers\Student\FaceAuthController::class, 'storeFace'])
        ->name('student.settings.store-face');
});
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('events', [App\Http\Controllers\Admin\EventController::class, 'index'])->name('events.index');
    Route::get('events/create', [App\Http\Controllers\Admin\EventController::class, 'create'])->name('events.create');
    Route::post('events', [App\Http\Controllers\Admin\EventController::class, 'store'])->name('events.store');
    Route::get('events/{event}', [App\Http\Controllers\Admin\EventController::class, 'show'])->name('events.show');
    Route::get('events/{event}/edit', [App\Http\Controllers\Admin\EventController::class, 'edit'])->name('events.edit');
    Route::put('events/{event}', [App\Http\Controllers\Admin\EventController::class, 'update'])->name('events.update');
    Route::delete('events/{event}', [App\Http\Controllers\Admin\EventController::class, 'destroy'])->name('events.destroy');
});
Route::prefix('scanner')->middleware(['scanner'])->group(function () {
    Route::get('/', [App\Http\Controllers\Scanner\QRScannerController::class, 'showScanner'])->name('qr-scanner');
    Route::get('/get-student/{qr_code}', [App\Http\Controllers\Scanner\QRScannerController::class, 'getStudent']);
});

Route::prefix('alumni')->middleware(['alumni'])->group(function () {
    Route::get('/', [App\Http\Controllers\Alumni\HomeController::class, 'index'])->name('alumni.home');
    Route::get('/profile', [App\Http\Controllers\Alumni\ProfileController::class, 'edit'])->name('alumni.profile');
    Route::put('/profile', [App\Http\Controllers\Alumni\ProfileController::class, 'update'])->name('alumni.profile.update');
    // Route::get('/settings/change-password', [App\Http\Controllers\Alumni\SettingsController::class, 'changePassword'])->name('alumni.settings.change-password');
    // Route::post('/settings/change-password/update', [App\Http\Controllers\Alumni\SettingsController::class, 'changePasswordUpdate'])->name('alumni.settings.change-password.update');
    // Route::get('/events', [App\Http\Controllers\Alumni\EventController::class, 'index'])->name('alumni.events.index');
});

Auth::routes();
