<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::name('dashboard.')->prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::middleware(['admin'])->group(function () {
            Route::resource('product', ProductController::class);
            Route::resource('category', ProductCategoryController::class);
            Route::resource('product.gallery', ProductGalleryController::class)->shallow()->only([
                'index',
                'create',
                'store',
                'destroy'
            ]);
            Route::resource('transaction', TransactionController::class)->only([
                'index',
                'show',
                'edit',
                'update'
            ]);
            Route::resource('user', UserController::class)->only([
                'index',
                'edit',
                'update',
                'destroy'
            ]);
        });
    });
});

// routes/web.php
Route::get('/test-image/{filename}', function ($filename) {
    $path = storage_path('app/public/gallery/' . $filename);
    if (file_exists($path)) {
        return response()->file($path);
    }
    return response()->json(['error' => 'File not found', 'path' => $path], 404);
});
