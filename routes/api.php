<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatroomController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->prefix('chatrooms')->group(function () {
    Route::post('/', [ChatroomController::class, 'create']); 
    Route::get('/', [ChatroomController::class, 'list']); 
    Route::post('/{id}/enter', [ChatroomController::class, 'enter']); 
    Route::post('/{id}/leave', [ChatroomController::class, 'leave']); 

    Route::post('/{id}/messages', [MessageController::class, 'send']); 
    Route::get('/{id}/messages', [MessageController::class, 'list']); 
});
