<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TaskController;

// Rute login
Route::post('login', [AuthController::class, 'login']);

// Rute yang memerlukan autentikasi
Route::middleware('auth:api')->group(function () {
    // Rute untuk Todo
    Route::get('/todos', [TodoController::class, 'index']);       // Get all todos
    Route::post('/todos', [TodoController::class, 'store']);      // Create new todo
    Route::get('/todos/{id}', [TodoController::class, 'show']);   // Get specific todo by ID
    Route::put('/todos/{todo}', [TodoController::class, 'update']); // Update todo
    Route::delete('/todos/{id}', [TodoController::class, 'destroy']); // Delete todo

    // Rute untuk Task
    Route::get('/tasks', [TaskController::class, 'Allindex']);  // Menampilkan semua tasks
    Route::post('/tasks/{todo}', [TaskController::class, 'store']); // Menambahkan task baru ke Todo tertentu
    Route::get('/tasks/{id}', [TaskController::class, 'show']);     // Menampilkan task berdasarkan ID
    Route::put('/tasks/{task}', [TaskController::class, 'update']); // Perbarui task berdasarkan ID
    Route::delete('/tasks/{tasks}', [TaskController::class, 'destroy']); // Menghapus task berdasarkan ID

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});
