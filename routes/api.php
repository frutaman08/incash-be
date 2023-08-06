<?php

use App\Helper\ResponseDefault;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::middleware('auth:api')->group(function() {
    Route::prefix('/category')->group(function() {
        Route::get('/', [CategoryController::class, 'index'])->name('api.index.category');
        Route::get('/{id}',);
        Route::post('/', [CategoryController::class, 'store'])->name('api.store.category');
        Route::put('/{id}',);
        Route::delete('/{id}',);
    });

    Route::get('/current-user', [AuthController::class, 'me'])->name('api.current.user');
    Route::get('/logout', [AuthController::class, 'logout'])->name('api-logout');
});

// Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);