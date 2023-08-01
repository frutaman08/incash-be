<?php

use App\Helper\ResponseDefault;
use App\Http\Controllers\API\AuthController;
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

Route::middleware('auth:sanctum')->group(function() {
    Route::prefix('/user')->group(function() {
        Route::get('/', [UserController::class, 'index'])->name('api.index.user');
        Route::post('/', [UserController::class, 'create'])->name('api.create.user');
        Route::get('/{id}', [UserController::class, 'show'])->name('api.show.user');
        Route::delete('/{id}', [UserController::class, 'delete'])->name('api.delete.user');
    });

    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
