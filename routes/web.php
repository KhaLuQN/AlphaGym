<?php

use App\Http\Controllers\admin\CheckinController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\EquipmentController;
use App\Http\Controllers\admin\MemberController;
use App\Http\Controllers\admin\MembershipplanController;
use App\Http\Controllers\admin\MemberSubscriptionController;
use App\Http\Controllers\admin\RFIDController;
use App\Http\Controllers\auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index']);

Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login.auth');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/member/index', [MemberController::class, 'index'])->name('members.index');
Route::post('/member/update', [MemberController::class, 'update'])->name('admin.members.update');
Route::post('/members/store', [MemberController::class, 'store'])->name('admin.members.store');
Route::get('/member/create', [MemberController::class, 'create'])->name('admin.members.create');
Route::get('/member/{id}', [MemberController::class, 'show'])->name('admin.members.show');

Route::get('/package/index', [MembershipplanController::class, 'index'])->name('admin.package.index');
Route::post('/package/update', [MembershipPlanController::class, 'update'])->name('admin.package.update');
Route::get('/package/create', [MembershipPlanController::class, 'create'])->name('admin.package.create');
Route::delete('/package/{id}', [MembershipplanController::class, 'destroy'])->name('admin.package.destroy');

Route::post('/package/store', [MembershipplanController::class, 'store'])->name('admin.package.store');

Route::get('/admin/subscriptions/create', [MemberSubscriptionController::class, 'create'])->name('admin.subscriptions.create');
Route::post('/admin/subscriptions/store', [MemberSubscriptionController::class, 'store'])->name('admin.subscriptions.store');

Route::prefix('admin/rfid')->name('admin.rfid.')->group(function () {
    Route::get('/', [RFIDController::class, 'index'])->name('index');

    Route::put('/{id}', [RFIDController::class, 'update'])->name('update');

    Route::delete('/{id}', [RfidController::class, 'destroy'])->name('destroy');

});
Route::prefix('admin/equipment')->name('admin.equipment.')->group(function () {
    Route::get('/', [EquipmentController::class, 'index'])->name('index');
    Route::get('/create', [EquipmentController::class, 'create'])->name('create');
    Route::post('/', [EquipmentController::class, 'store'])->name('store');
    Route::put('/update', [EquipmentController::class, 'update'])->name('update');

    Route::delete('/{equipment}', [EquipmentController::class, 'destroy'])->name('destroy');
});
// Add these routes to your web.php file in the admin route group
Route::prefix('admin')->name('admin.checkin.')->group(function () {

    Route::post('/checkins/{checkin}/force-checkout', [CheckinController::class, 'forceCheckout'])->name('forceCheckout');

    Route::post('/checkins/force-checkout-all', [CheckinController::class, 'forceCheckoutAll'])->name('forceCheckoutAll');
    Route::get('/checkins/page', [CheckinController::class, 'checkinPage'])->name('checkinPage');
    Route::get('/checkins', [CheckinController::class, 'index'])->name('index');
    Route::post('/checkin/machine', [CheckinController::class, 'machineCheckin'])->name('machine');

});
Route::get('/members/{id}', [MemberController::class, 'show'])->name('admin.members.show');
