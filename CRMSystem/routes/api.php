<?php
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\FollowUpController;


Route::get('/test', function () {
    return response()->json([
        'message' => 'تم الاتصال'
    ]);
});


// تسجيل الدخول
Route::post('/login', [AuthController::class, 'login']);

// مسارات محمية بالـ Sanctum
Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/debug-me', function (\Illuminate\Http\Request $request) {
        \Log::info('✅ Inside Sanctum Route', ['user' => $request->user()]);
        return response()->json(['user' => $request->user()]);
    });
    // معلومات المستخدم الحالي
    Route::get('/me', [AuthController::class, 'me']);

    // تسجيل الخروج
    Route::post('/logout', [AuthController::class, 'logout']);


    // مسارات Admin فقط
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/clients', [ClientController::class, 'index']);
        // يمكن إضافة أي مسار آخر خاص بالـ Admin هنا
    });

    // // // مسارات Manager و Sales Rep
    Route::middleware('role:manager,sales_rep')->group(function () {
        Route::post('/clients/{id}/follow-up', [FollowUpController::class, 'store']);
        // يمكن إضافة أي مسارات أخرى للمتابعة أو العملاء هنا
    });
});
