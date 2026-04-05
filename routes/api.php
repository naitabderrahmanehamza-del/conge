<?php

use App\Http\Controllers\AdminLeaveController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeaveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:api')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    });
});
Route::middleware('auth:api')->group(function () {

    Route::get('/leave', [LeaveController::class, 'conge']);
    Route::post('/leave/request', [LeaveController::class, 'requestLeave']);

});
Route::prefix('admin')->middleware(['auth:api', 'check.role'])->group(function () {

    Route::post('/leave/{user}/credit', [AdminLeaveController::class, 'credit']);
    Route::post('/leave/{user}/debit', [AdminLeaveController::class, 'debit']);

});