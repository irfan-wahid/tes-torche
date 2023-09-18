<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('user')->group(function (){
    Route::post('/register', [\App\Http\Controllers\UserController::class, 'register']);
    Route::get('/login', [\App\Http\Controllers\UserController::class, 'login']);
    Route::put('/changePassword', [\App\Http\Controllers\UserController::class, 'changePassword']);
    Route::delete('/delete', [\App\Http\Controllers\UserController::class, 'delete']);
});