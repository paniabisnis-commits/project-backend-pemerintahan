<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\InfografisController;

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('profile',[AuthController::class,'profile']);
    Route::put('profile',[AuthController::class,'updateProfile']);
    Route::post('logout',[AuthController::class,'logout']);
});

Route::post('pengaduan',[PengaduanController::class,'store']);
Route::get('pengaduan/stats',[PengaduanController::class,'stats']);

Route::middleware(['auth:sanctum','role:admin'])->group(function() {
    Route::get('admin/pengaduan',[PengaduanController::class,'adminIndex']);
    Route::put('admin/pengaduan/{complaint}/status',[PengaduanController::class,'updateStatus']);
});


// Public
Route::get('/berita', [BeritaController::class, 'index']);
Route::get('/events', [EventController::class, 'index']);
Route::get('/infografis', [InfografisController::class, 'index']);

// Protected (admin)
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    Route::apiResource('/berita', BeritaController::class)->except(['index']);
    Route::apiResource('/events', EventController::class)->except(['index']);
    Route::apiResource('/infografis', InfografisController::class)->except(['index']);

});
