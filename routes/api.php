<?php

use App\Http\Controllers\TodoListController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/list',[TodoListController::class, 'getlist']);
Route::post('/simpan',[TodoListController::class, 'simpan']);
Route::get('/listid/{id}',[TodoListController::class, 'view_edit']);
Route::post('/ubah',[TodoListController::class, 'ubah']);
Route::post('/update-status',[TodoListController::class, 'update_status']);
Route::get('/hapus/{id}',[TodoListController::class, 'hapus']);
Route::post('/cari-tugas',[TodoListController::class, 'cari_tugas']);
