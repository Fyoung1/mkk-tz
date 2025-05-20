<?php

use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::post('/tasks/{taskId}/subtasks', [SubtaskController::class, 'store']);
Route::put('/tasks/{task}', [TaskController::class, 'updateStatus']);
Route::put('/subtasks/{subtask}', [SubtaskController::class, 'update']);
