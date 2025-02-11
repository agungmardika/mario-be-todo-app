<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; // Tambahkan ini
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics.
     */
    public function index(): JsonResponse
    {
        $userId = Auth::id();

        $todosCount = Todo::where('user_id', $userId)->count();
        $completedTasksCount = Task::where('status', 'done')->whereHas('todo', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();
        $inProgressTasksCount = Task::where('status', 'in progress')->whereHas('todo', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();

        return response()->json([
            'todosCount' => $todosCount,
            'completedTasksCount' => $completedTasksCount,
            'inProgressTasksCount' => $inProgressTasksCount,
        ]);
    }
}
