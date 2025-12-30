<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\InfografisController;
use App\Http\Controllers\LayananController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ✅ BARU PAKAI auth:sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('pengaduan', [ComplaintController::class, 'store']);
    Route::get('pengaduan', [ComplaintController::class, 'index']);
    Route::get('pengaduan/stats', [ComplaintController::class, 'stats']);
});

Route::middleware(['auth:sanctum','role:admin'])->group(function() {
    Route::get('admin/pengaduan',[ComplaintController::class,'adminIndex']);
    Route::put('admin/pengaduan/{complaint}/status',[ComplaintController::class,'updateStatus']);
});

// Public
Route::get('/berita', [BeritaController::class, 'index']);
Route::get('/events', [EventController::class, 'index']);
Route::get('/infografis', [InfografisController::class, 'index']);
Route::get('/layanan', [LayananController::class, 'index']);
Route::get('/layanan/{id}', [LayananController::class, 'show']);


// Protected (admin)
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    Route::apiResource('/berita', BeritaController::class)->except(['index']);
    Route::apiResource('/events', EventController::class)->except(['index']);
    Route::apiResource('/infografis', InfografisController::class)->except(['index']);
    Route::get('/admin/pengaduan', [ComplaintController::class, 'adminIndex']);
    Route::post('/layanan', [LayananController::class, 'store']);
    Route::match(['put', 'patch'], '/layanan/{id}', [LayananController::class, 'update']);


    Route::delete('/layanan/{id}', [LayananController::class, 'destroy']);
    Route::delete('/berita/{id}', [BeritaController::class, 'destroy']);
    Route::delete('/pengaduan/{id}', [ComplaintController::class, 'destroy']);

});
