<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuditLogController;

// Handle preflight OPTIONS requests
Route::options('/{any}', function() {
    return response()->json('OK', 200);
})->where('any', '.*');

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::patch('/products/{id}/toggle', [ProductController::class, 'toggleActive']);
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::patch('/users/{id}/toggle', [UserController::class, 'toggleActive']);
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::post('/transactions/{id}/post-void', [TransactionController::class, 'postVoid']);
    Route::post('/transactions/cancel', [TransactionController::class, 'cancelSale']);
    Route::post('/transactions/void-item', [TransactionController::class, 'voidItem']);
    Route::get('/audit-logs', [AuditLogController::class, 'index']);
});
