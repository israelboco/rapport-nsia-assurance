<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProduitController;
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
       
    Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('dashboard');
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

    Route::controller(ProduitController::class)->group(function () {
        Route::get('produit/index/{serviceId?}', 'index')->name('produit.index');  
        Route::post('produit/create', 'store')->name('produit.store');
        Route::put('produit/update/{produit}', 'update')->name('produit.update');
        Route::get('produit/delete/{produit}', 'destroy')->name('produit.delete');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('user/index', 'index')->name('user.index'); 
        Route::post('user/create', 'store')->name('user.store');
        Route::put('user/update/{user}', 'update')->name('user.update');
        Route::get('user/delete/{user}', 'destroy')->name('user.delete');
        Route::get('user/calcule/ca', 'calculeCa');
        Route::get('user/blocked/{user}', 'blocked')->name('user.blocked');
        Route::get('user/role/show', 'showRoles')->name('role.select');
        Route::get('user/search', 'index')->name('user.search');
        Route::get('user/{user?}/profile', 'profile')->name('user.profile')->middleware('access');
        Route::get('user/{user?}/deal', 'userDeal')->name('user.deal')->middleware('access');
        Route::put('user/update/password/{user}', 'updatePassword')->name('user.update_password');
        Route::put('user/update/image/profile/{user}', 'updateProfile')->name('user.image_profile');
        Route::get('users/export', 'export')->name('user.export');
        Route::post('user/agent/import', 'importAgent')->name('agent_info.import');
        Route::post('user/agent_sup/import', 'importAgentSup')->name('agent_sup.import');

    });

    Route::controller(DealController::class)->group(function () {
        Route::get('deal/index', 'index')->name('deal.index'); 
        Route::post('deal/create', 'store')->name('deal.store');
        Route::put('deal/update/{deal}', 'update')->name('deal.update');
        Route::get('deal/delete/{deal}', 'destroy')->name('deal.delete'); //->middleware('access');
        Route::get('deals/export', 'export')->name('deal.export');
        Route::get('deal/object/export', 'exportObj')->name('deal_object.export');
        Route::get('deal/object/export/all', 'exportAll')->name('deal_object_all.export');
    });

    Route::controller(ContratController::class)->group(function () {
        Route::get('contrat/index', 'index')->name('contrat.index'); 
        Route::get('contrat/detail/{contrat}', 'detail')->name('contrat.detail');
        Route::post('contrat/import', 'import')->name('contrat.import');
        Route::get('contrat/export', 'export')->name('contrat.export');
    });
});