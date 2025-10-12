<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\AuthController;

//Group Controller
Route::get('/medicine/group', [GroupController::class, 'new'])->name('pharmacy.group')->middleware('auth');
Route::post("/group/create", [GroupController::class, 'create'])->name('pharmacy.group_create');

//medicine controller
Route::middleware('auth')->controller(MedicineController::class)->group(function (){
    Route::get("/", 'index')->name('pharmacy.index');
    Route::get("/medicine/create", 'create')->name('pharmacy.create');
    Route::get('/medicine/pharmstore', 'pharmstore')->name('pharmacy.pharmstore');
    Route::get('/medicine/{medicine}', 'show')->name('pharmacy.show');
    Route::delete('/medicine/{medicine}', 'destroy')->name('pharmacy.destroy');
    Route::get('/medicine/pharminstock/{medicine}', 'pharminstock')->name('pharmacy.pharminstock');
    Route::post('/home', 'store')->name('pharmacy.store');
    Route::put('/pharmacy/update/{medicine}', 'update')->name('pharmacy.update');
    Route::post('/reduce-stock', 'reduceStock');
    Route::get('/restock-alert', 'restockAlert')->name('pharmacy.restock');
});


//Sales Controller
Route::middleware('auth')->controller(SalesController::class)->group(function (){
    Route::get('/sales', 'index')->name('pharmacy.sales'); 
    Route::get('/sales/{id}', 'show')->name('pharmacy.showsales');
    Route::delete('/sales/{sales}', 'destroy')->name('pharmacy.destroysale');
    Route::post('/save-cart', 'cartStore');
});



//Auth Controller
Route::middleware('guest')->controller(AuthController::class)->group(function (){
    Route::get('/login',  'showLogin')->name('show.login');
    Route::get('/register', 'showRegister')->name('show.register');
    Route::post('/login', 'login')->name('login');
    Route::post('/register','register')->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');




