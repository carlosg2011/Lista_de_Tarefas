<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

use App\Http\Controllers\TodoController;

// Route::middleware(['auth'])->group(function () {

Route::get('/todos', [TodoController::class, 'index'])->name('tasklist.index');
Route::post('/todos', [TodoController::class, 'store'])->name('tasklist.store');
Route::patch('/todos/{todo}/toggle', [TodoController::class, 'toggle'])->name('tasklist.toggle');
Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('tasklist.destroy');
    
// });