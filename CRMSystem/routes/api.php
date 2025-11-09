<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\FollowUpController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\CommunicationController;

// مسار اختبار بسيط
Route::get('/test', function () {
    return response()->json(['message' => 'تم الاتصال']);
});

// -----------------------------
// Auth APIs
// -----------------------------
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    // معلومات المستخدم الحالي
    Route::get('/me', [AuthController::class, 'me']);

    // تسجيل الخروج
    Route::post('/logout', [AuthController::class, 'logout']);

    // -----------------------------
    // Client APIs
    // -----------------------------
    Route::apiResource('clients', ClientController::class);

    // -----------------------------
    // Communication APIs
    // -----------------------------
    Route::apiResource('communications', CommunicationController::class)
        ->only(['index','store']);

    // -----------------------------
    // Follow-up APIs
    // -----------------------------
    Route::apiResource('follow-ups', FollowUpController::class)
        ->only(['index','store','show']);

    // إنشاء Follow-up للعميل (خاص بالـ Manager و Sales Rep)
    Route::post('/clients/{client}/follow-up', [FollowUpController::class, 'store'])
        ->middleware('role:manager,sales_rep');

    // -----------------------------
    // Dashboard API
    // -----------------------------
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // -----------------------------
    // Admin-specific APIs
    // -----------------------------
    Route::middleware('role:admin')->group(function () {
        // مثال لمسار إضافي خاص بالـ Admin
        Route::get('/admin/clients', [ClientController::class, 'index']);
    });

    // -----------------------------
    // Debug (اختياري)
    // -----------------------------
    Route::get('/debug-me', function (\Illuminate\Http\Request $request) {
        \Log::info('✅ Inside Sanctum Route', ['user' => $request->user()]);
        return response()->json(['user' => $request->user()]);
    });
});
