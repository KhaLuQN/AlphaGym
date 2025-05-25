<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\MemberController;
use App\Http\Controllers\auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login.auth');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/member/index', [MemberController::class, 'index'])->name('members.index');
Route::post('/member/update', [MemberController::class, 'update'])->name('admin.members.update');
Route::post('/members/store', [MemberController::class, 'store'])->name('admin.members.store');
Route::get('/member/create', [MemberController::class, 'create'])->name('admin.members.create');
