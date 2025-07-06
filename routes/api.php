<?php

use App\Http\Controllers\Api\ChecklistApiController;
use App\Http\Controllers\Api\ChecklistItemApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/checklists', [ChecklistApiController::class, 'index']);
    Route::post('/checklists', [ChecklistApiController::class, 'store']);
    Route::delete('/checklists/{checklist}', [ChecklistApiController::class, 'destroy']);

    Route::post('/checklists/{checklist}/items', [ChecklistItemApiController::class, 'store']);
    Route::delete('/checklists/{checklist}/items/{item}', [ChecklistItemApiController::class, 'destroy']);
    Route::patch('/checklists/{checklist}/items/{item}', [ChecklistItemApiController::class, 'update']);
    Route::get('/checklists/{checklist}/items', [ChecklistItemApiController::class, 'listItems']);
});
