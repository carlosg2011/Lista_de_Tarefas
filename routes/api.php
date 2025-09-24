<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ToDoController;
use App\Http\Controllers\TaskController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {


    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Rotas da lista de tarefas
    Route::get('/todos', [ToDoController::class, 'index']);
    Route::post('/todos',         [ToDoController::class, 'store']);
    Route::get('/todos/{todo}',   [ToDoController::class, 'show']);
    Route::put('/todos/{todo}',   [ToDoController::class, 'update']);
    Route::delete('/todos/{todo}', [ToDoController::class, 'destroy']);

    Route::get('/todos/{todo}/tasks', [TaskController::class, 'index']);
    Route::post('/todos/{todo}/tasks', [TaskController::class, 'store']);
    Route::put('/todos/{todo}/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('/todos/{todo}/tasks/{task}', [TaskController::class, 'destroy']);
});