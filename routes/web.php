<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pegawai', [EmployeeController::class, 'index'])->name('pegawai');

// tampil tambah pegawai
Route::get('/tambahpegawai', [EmployeeController::class, 'tambahpegawai'])->name('tambahpegawai');
// proses tambah pegawai
Route::post('/insertdata', [EmployeeController::class, 'insertdata'])->name('insertdata');
// tampil edit pegawai
Route::get('/tampildata/{id}', [EmployeeController::class, 'tampildata'])->name('tampildata');
// proses edit pegawai
Route::post('/updatedata/{id}', [EmployeeController::class, 'updatedata'])->name('updatedata');
// hapus pegawai
Route::get('/delete/{id}', [EmployeeController::class, 'delete'])->name('delete');

// export pdf
Route::get('/exportpdf', [EmployeeController::class, 'exportpdf'])->name('exportpdf');

// export excel
Route::get('/exportexcel', [EmployeeController::class, 'exportexcel'])->name('exportexcel');
// import data 
Route::post('/importexcel', [EmployeeController::class, 'importexcel'])->name('importexcel');
