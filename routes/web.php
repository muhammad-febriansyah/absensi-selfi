<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JamKerjaController;
use App\Http\Controllers\LokasiPenempatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\RadiusKantorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/home/register',[HomeController::class,'register'])->name('home.register');
Route::post('/home/saveregister',[HomeController::class,'saveregister'])->name('home.saveregister');
Route::post('/home/checklogin',[HomeController::class,'checklogin'])->name('home.checklogin');
Route::get('/login',[AuthController::class,'index'])->name('login');
Route::post('/checklogin', [AuthController::class, 'checklogin'])->name('checklogin');

Route::group(['middleware' => ['auth.check']], function () {
    Route::get('/pegawai/home', [PegawaiController::class,'index'])->name('pegawai.home');
    Route::get('/pegawai/absen', [PegawaiController::class,'absen'])->name('pegawai.absen');
    Route::get('/pegawai/histori', [PegawaiController::class,'histori'])->name('pegawai.histori');
    Route::get('/pegawai/lokasi', [PegawaiController::class,'lokasi'])->name('pegawai.lokasi');
    Route::post('/pegawai/logout', [HomeController::class, 'logout'])->name('pegawai.logout');
    Route::post('/pegawai/saveabsen', [PegawaiController::class, 'saveabsen'])->name('pegawai.saveabsen');
    Route::post('/pegawai/absenout', [PegawaiController::class, 'absenout'])->name('pegawai.absenout');
    // Other routes
    
    Route::get('/pegawai/izin', [IzinController::class,'index'])->name('pegawai.izin');
    Route::get('/pegawai/createizin', [IzinController::class,'create'])->name('pegawai.createizin');
    Route::get('/pegawai/detailizin/{id}', [IzinController::class,'show'])->name('pegawai.detailizin');
    Route::post('/pegawai/storeizin', [IzinController::class,'store'])->name('pegawai.storeizin');
    
    Route::get('/pegawai/cuti', [PegawaiController::class,'cuti'])->name('pegawai.cuti');
    Route::get('/pegawai/createcuti', [PegawaiController::class,'create'])->name('pegawai.createcuti');
    Route::get('/pegawai/detailcuti/{id}', [PegawaiController::class,'show'])->name('pegawai.detailcuti');
    Route::post('/pegawai/storecuti', [PegawaiController::class,'store'])->name('pegawai.storecuti');
    
    Route::get('/pegawai/profile', [PegawaiController::class,'profile'])->name('pegawai.profile');
    Route::post('/pegawai/updateprofile', [PegawaiController::class,'updateprofile'])->name('pegawai.updateprofile');

});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/main/dashboard',[DashboardController::class,'index'])->name('main.dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get("main/jabatan",[JabatanController::class,'index'])->name('main.jabatan');
    Route::get("main/createjabatan",[JabatanController::class,'create'])->name('main.createjabatan');
    Route::post("main/storejabatan",[JabatanController::class,'store'])->name('main.storejabatan');
    Route::post("main/updatejabatan/{id}",[JabatanController::class,'update'])->name('main.updatejabatan');
    Route::get("main/editjabatan/{id}",[JabatanController::class,'edit'])->name('main.editjabatan');
    Route::delete("main/destroyjabatan",[JabatanController::class,'destroy'])->name('main.destroyjabatan');

    Route::get("main/lokasi",[LokasiPenempatanController::class,'index'])->name('main.lokasi');
    Route::get("main/createlokasi",[LokasiPenempatanController::class,'create'])->name('main.createlokasi');
    Route::post("main/storelokasi",[LokasiPenempatanController::class,'store'])->name('main.storelokasi');
    Route::post("main/updatelokasi/{id}",[LokasiPenempatanController::class,'update'])->name('main.updatelokasi');
    Route::get("main/editlokasi/{id}",[LokasiPenempatanController::class,'edit'])->name('main.editlokasi');
    Route::delete("main/destroylokasi",[LokasiPenempatanController::class,'destroy'])->name('main.destroylokasi');

    Route::get("main/jamkerja",[JamKerjaController::class,'index'])->name('main.jamkerja');
    Route::get("main/createjamkerja",[JamKerjaController::class,'create'])->name('main.createjamkerja');
    Route::post("main/storejamkerja",[JamKerjaController::class,'store'])->name('main.storejamkerja');
    Route::post("main/updatejamkerja/{id}",[JamKerjaController::class,'update'])->name('main.updatejamkerja');
    Route::get("main/editjamkerja/{id}",[JamKerjaController::class,'edit'])->name('main.editjamkerja');
    Route::delete("main/destroyjamkerja",[JamKerjaController::class,'destroy'])->name('main.destroyjamkerja');


    Route::get("main/radius",[RadiusKantorController::class,'index'])->name('main.radius');
    Route::get("main/createradius",[RadiusKantorController::class,'create'])->name('main.createradius');
    Route::post("main/storeradius",[RadiusKantorController::class,'store'])->name('main.storeradius');
    Route::post("main/updateradius/{id}",[RadiusKantorController::class,'update'])->name('main.updateradius');
    Route::get("main/editradius/{id}",[RadiusKantorController::class,'edit'])->name('main.editradius');
    Route::delete("main/destroyradius",[RadiusKantorController::class,'destroy'])->name('main.destroyradius');


    Route::get("main/izin",[DashboardController::class,'izin'])->name('main.izin');
    Route::post("main/approve",[DashboardController::class,'approve'])->name('main.approve');
    Route::post("main/reject",[DashboardController::class,'reject'])->name('main.reject');

    Route::get("main/cuti",[DashboardController::class,'cuti'])->name('main.cuti');
    Route::post("main/approvecuti",[DashboardController::class,'approvecuti'])->name('main.approvecuti');
    Route::post("main/rejectcuti",[DashboardController::class,'rejectcuti'])->name('main.rejectcuti');
    
    Route::get("main/pegawai",[DashboardController::class,'pegawai'])->name('main.pegawai');
    Route::get("main/detailpegawai/{id}",[DashboardController::class,'detailpegawai'])->name('main.detailpegawai');

    Route::get("main/absen",[DashboardController::class,'absen'])->name('main.absen');
    Route::get("main/detailAbsen/{id}",[DashboardController::class,'detailAbsen'])->name('main.detailAbsen');
    Route::get("main/detailAbsenPulang/{id}",[DashboardController::class,'detailAbsenPulang'])->name('main.detailAbsenPulang');
 

});