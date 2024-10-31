<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\menuController as menu;
use App\Http\Controllers\mejaController as meja;
use App\Http\Controllers\TransksiController as transaksi;
use App\Http\Controllers\userController as user;
use App\Http\Controllers\Api\RegisterController as register;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/register',[register::class, 'register']);
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');
Route::put('/updateuser/{id}', [user::class,'updateUser']);
Route::delete('/deleteuser/{id}', [user::class,'deleteUser']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/indexmenu', [menu::class,'getMenu']);
Route::post('/tambahmenu', [menu::class,'addMenu']);
Route::put('/updatemenu/{id}', [menu::class,'updateMenu']);
Route::delete('/deletemenu/{id}', [menu::class,'deleteMenu']);

Route::get('/indexmeja', [meja::class,'getMeja']);
Route::post('/tambahmeja', [meja::class,'addMeja']);
Route::put('/updatemeja/{id}', [meja::class,'updateMeja']);
Route::delete('/deletemeja/{id}', [meja::class,'deleteMeja']);

Route::post('/transaksi', [transaksi::class, 'createTransaction']);
Route::get('/transaksibystatus', [TransaksiController::class, 'getbystatus']);
Route::get('/updatestatustransaksi/{id}', [TransaksiController::class, 'updateStatusTransaksi']);
