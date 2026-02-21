<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SubjectController as ApiSubjectController;
use App\Http\Controllers\Api\TaskController as ApiTaskController;
use App\Http\Controllers\Api\SubtaskController as ApiSubtaskController;
use App\Http\Controllers\Api\TagController as ApiTagController;
use App\Http\Controllers\Api\AttachmentController as ApiAttachmentController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('subjects', ApiSubjectController::class);
    Route::apiResource('tasks', ApiTaskController::class);

    Route::patch('tasks/{task}/status', [ApiTaskController::class, 'patchStatus']);

    Route::post('tasks/{task}/subtasks', [ApiSubtaskController::class, 'store']);
    Route::patch('subtasks/{subtask}', [ApiSubtaskController::class, 'update']);
    Route::delete('subtasks/{subtask}', [ApiSubtaskController::class, 'destroy']);

    Route::apiResource('tags', ApiTagController::class)->only(['index','store','destroy']);

    Route::post('tasks/{task}/attachments', [ApiAttachmentController::class, 'store']);
    Route::delete('attachments/{attachment}', [ApiAttachmentController::class, 'destroy']);
});