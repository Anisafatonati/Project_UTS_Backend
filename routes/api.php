<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group( function () {

//Route untuk menampilkan data employees
Route::get('/employees', [PegawaiController::class, 'index']);

//Route untuk menampilkan detail employees
Route::get('/employees/{id}', [PegawaiController::class, 'show']);

//Route untuk menambahkan data employees
Route::post('/employees', [PegawaiController::class, 'store']);

//Route untuk mengupdate data employees
Route::put('/employees/{id}', [PegawaiController::class, 'update']);

//Route untuk menghapus data employees
Route::delete('/employees/{id}', [PegawaiController::class, 'destroy']);

// Rute untuk pencarian berdasarkan nama
Route::get('/employees/search/{name}', [PegawaiController::class, 'search']);

// Rute untuk mendapatkan employees dengan status aktif
Route::get('/employees/status/active', [PegawaiController::class, 'getActive']);

// Rute untuk mendapatkan employees dengan status tidak aktif
Route::get('/employees/status/inactive', [PegawaiController::class, 'getInactive']);

// Rute untuk mendapatkan employees dengan status terminated
Route::get('/employees/status/terminated', [PegawaiController::class, 'getTerminated']);


});

//Route Login dan Register
Route::post("register", [AuthController::class,"register"]);
Route::post("login", [AuthController::class,"login"]);