<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::middleware(['guest:karyawan'])->group(function() {
    Route::get('/', function () {
        return view('auth.login');
    })->name('halamanLogin');
    
    Route::post('/proseslogin',[AuthController::class,'prosesLogin'])->name('prosesLogin');
});

Route::middleware(['auth:karyawan'])->group(function(){
    Route::get('/dashboard',[DashboardController::Class,'index'])->name('dashboard');
    Route::get('/proseslogout',[AuthController::class,'prosesLogout'])->name('logout');

    Route::get('/presensi/create',[PresensiController::class,'create'])->name('presensiCreate');
    Route::post('/presensi/store',[PresensiController::class,'store'])->name('presensiStore');

    Route::get('/editprofile',[PresensiController::class,'editProfile'])->name('editProfile');
    Route::post('/presensi/{nik}/updateprofile',[PresensiController::class,'updateProfile'])->name('updateProfile');

    //histori
    Route::get('/presensi/histori',[PresensiController::class,'histori'])->name('histori');
    Route::post('/getHistori',[PresensiController::class,'getHistori'])->name('getHistori');

    //izin
    Route::get('/presensi/izin',[PresensiController::class,'izin'])->name('izin');
    Route::get('/presensi/buatizin',[PresensiController::class,'buatizin'])->name('izin');
    Route::post('/presensi/storeIzin',[PresensiController::class,'storeizin'])->name('storeIzin');

});
