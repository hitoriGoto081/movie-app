<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\MovieController;

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

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/genres', [GenreController::class, 'index']);

Route::post('/genres', [GenreController::class, 'store']);

Route::get('/genres/{id}', [GenreController::class, 'show']);

Route::put('/genres/{id}', [GenreController::class, 'update']);

Route::delete('/genres/{id}', [GenreController::class, 'destroy']);

Route::get('/movies', [MovieController::class, 'index']);

Route::post('/movies', [MovieController::class, 'store']);

Route::get('/movies/{id}', [MovieController::class, 'show']);

Route::put('/movies/{id}', [MovieController::class, 'update']);

Route::delete('/movies/{id}', [MovieController::class, 'destroy']);
