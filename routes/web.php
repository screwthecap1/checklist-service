<?php

use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChecklistController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('checklists', ChecklistController::class);

    // Добавляем маршруты для пунктов чек-листов:
    Route::post('checklists/{checklist}/items', [\App\Http\Controllers\ChecklistItemController::class, 'store'])->name('checklists.items.store');
    Route::put('checklists/{checklist}/items/{item}', [\App\Http\Controllers\ChecklistItemController::class, 'update'])->name('checklists.items.update');
    Route::delete('checklists/{checklist}/items/{item}', [\App\Http\Controllers\ChecklistItemController::class, 'destroy'])->name('checklists.items.destroy');

    Route::middleware(['can.isAdmin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('users', [UserManagementController::class, 'index'])->name('users.index');
        Route::patch('users/{user}/role', [UserManagementController::class, 'updateRole'])->name('users.updateRole');
        Route::patch('users/{user}/toggle-block', [UserManagementController::class, 'toggleBlock'])->name('users.toggleBlock');
    });
});

