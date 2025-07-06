<?php

use App\Http\Controllers\Api\ChecklistApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/checklists', [ChecklistApiController::class, 'index']);
    Route::post('/checklists', [ChecklistApiController::class, 'store']);
    Route::delete('/checklists/{checklist}', [ChecklistApiController::class, 'destroy']);
});
