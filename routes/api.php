<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ToDoController;
use App\Http\Controllers\TaskController;


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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:api'])->group(function () {

Route::apiResource('todolists', ToDoController::class);

Route::get('/todolists/{id}/tasks',    [TaskController::class, 'index']);
Route::post('/todolists/{id}/tasks',   [TaskController::class, 'store']);
Route::patch('/tasks/{id}',            [TaskController::class, 'update']);
Route::delete('/tasks/{id}',           [TaskController::class, 'destroy']);

});