<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('layout');
// });
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/check', [AuthController::class, 'check'])->name('auth.check');


Route::middleware(['agent'])->group(function () {
       
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    
    Route::controller(ServiceController::class)->group(function () {
        Route::get('service/index', 'index')->name('service.index');
        Route::post('service/create', 'store')->name('service.store');
        Route::put('service/{service}/update', 'update')->name('service.update');
        Route::get('service/delete/{service}', 'destroy')->name('service.delete');
    });

    Route::controller(RoleController::class)->group(function () {
        Route::get('role/index/{serviceId?}', 'index')->name('role.index');  
        Route::post('role/create', 'store')->name('role.store');
        Route::put('role/update/{role}', 'update')->name('role.update');
        Route::get('role/delete/{role}', 'destroy')->name('role.delete');
        Route::get('role/service/show', 'showServices')->name('service.select');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('user/index', 'index')->name('user.index'); 
        Route::post('user/create', 'store')->name('user.store');
        Route::put('user/update/{user}', 'update')->name('user.update');
        Route::get('user/delete/{user}', 'destroy')->name('user.delete');
        Route::get('user/blocked/{user}', 'blocked')->name('user.blocked');
        Route::get('user/role/show', 'showRoles')->name('role.select');
        Route::get('user/{user?}/chiffre_affaire', 'chiffre_affaire')->name('user.chiffre_affaire');
        Route::get('user/{user}/contrat', 'userContrat')->name('user.contrat');
    });

    Route::controller(ContratController::class)->group(function () {
        Route::get('contrat/index', 'index')->name('contrat.index'); 
        Route::post('contrat/create', 'store')->name('contrat.store');
        Route::put('contrat/update/{contrat}', 'update')->name('contrat.update');
        Route::get('contrat/delete/{contrat}', 'destroy')->name('contrat.delete');
    });
});