<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\TaskController;
use App\Http\Controllers\Web\SubjectController;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [TaskController::class, 'dashboard'])->name('dashboard');

    Route::resource('tasks', TaskController::class);
    Route::resource('subjects', SubjectController::class);
    Route::post('tasks/{task}/subtasks', [TaskController::class, 'storeSubtask'])->name('tasks.subtasks.store');
Route::patch('tasks/{task}/subtasks/{subtask}/toggle', [TaskController::class, 'toggleSubtask'])->name('tasks.subtasks.toggle');
Route::delete('tasks/{task}/subtasks/{subtask}', [TaskController::class, 'destroySubtask'])->name('tasks.subtasks.destroy');

});
