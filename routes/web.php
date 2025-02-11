<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Halaman Default (Root) Mengarah ke Login
Route::get('/', function () {
    return redirect()->route('login');
})->name('welcome');


Route::post('login', [AuthController::class, 'login']);

// Rute Login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Rute Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute untuk Reviewee A (Hanya Reviewee A yang bisa membuat Todo)
Route::middleware(['auth', 'role:revieweeA'])->group(function () {
    Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
});

// Rute untuk Reviewee A & B (Tambah Task/Subtask di Todo milik Reviewee A)
Route::middleware(['auth', 'role:revieweeA,revieweeB'])->group(function () {
    Route::post('/todos/{todo}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
});

// Rute untuk Semua Role yang Bisa Melihat Todos
Route::middleware(['auth'])->group(function () {
    Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Profil Pengguna (Umum untuk semua role)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/todos/search', [TodoController::class, 'search'])->name('todos.search');
Route::resource('todos', TodoController::class);
Route::get('/todos/search', [TodoController::class, 'search'])->name('todos.search');

// Sertakan Rute Default Laravel Breeze
require __DIR__ . '/auth.php';
