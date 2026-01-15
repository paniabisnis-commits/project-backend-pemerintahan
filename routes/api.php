<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\InfografisController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ActivityController;

/*
|--------------------------------------------------------------------------
| AUTH (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::get('/user', [AuthController::class, 'user']);

    // Pengaduan user
    Route::post('/pengaduan', [ComplaintController::class, 'store']);
    Route::get('/pengaduan', [ComplaintController::class, 'index']);
    Route::get('/pengaduan/stats', [ComplaintController::class, 'stats']);
});

/*
|--------------------------------------------------------------------------
| PUBLIC CONTENT (READ ONLY)
|--------------------------------------------------------------------------
*/
Route::get('/berita', [BeritaController::class, 'index']);
Route::get('/berita/slug/{slug}', [BeritaController::class, 'show']);

Route::get('/events', [EventController::class, 'index']);
Route::get('/infografis', [InfografisController::class, 'index']);

Route::get('/layanan', [LayananController::class, 'index']);
Route::get('/layanan/{id}', [LayananController::class, 'show']);

/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    // ===== PROFILE ADMIN =====
    Route::post('/admin/profile/avatar', [ProfileController::class, 'updateAvatar']);

    // ===== BERITA =====
    Route::get('/admin/berita', [BeritaController::class, 'index']);
    Route::apiResource('/berita', BeritaController::class)->except(['index', 'show']);

    // ===== EVENTS =====
    Route::apiResource('/events', EventController::class)->except(['index', 'show']);

    // ===== INFOGRAFIS =====
    Route::apiResource('/infografis', InfografisController::class)->except(['index', 'show']);

    // ===== LAYANAN =====
    Route::post('/layanan', [LayananController::class, 'store']);
    Route::match(['put', 'patch'], '/layanan/{id}', [LayananController::class, 'update']);
    Route::delete('/layanan/{id}', [LayananController::class, 'destroy']);

    // ===== PENGADUAN (ADMIN) =====
    Route::get('/admin/pengaduan', [ComplaintController::class, 'adminIndex']);
    Route::put('/admin/pengaduan/{id}/status', [ComplaintController::class, 'updateStatus']);
    Route::delete('/admin/pengaduan/{id}', [ComplaintController::class, 'destroy']);

    // ===== ADMIN DATA =====
    Route::get('/admin/users', [AdminUserController::class, 'index']);
    Route::get('/admin/activities', [ActivityController::class, 'index']);
});
