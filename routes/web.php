<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('layout');
// });
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/check', [AuthController::class, 'check'])->name('auth.check');


Route::middleware(['agent'])->group(function () {
       
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});