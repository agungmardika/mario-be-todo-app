<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class TaskController extends Controller
{

    public function Allindex()
    {
        // Ambil semua tasks dari tabel tasks
        $tasks = Task::all();

        // Kembalikan response JSON
        return response()->json($tasks);
    }

    public function index(Todo $todo)
    {
        // Ambil semua task terkait dengan Todo
        $tasks = $todo->tasks;

        return response()->json(['tasks' => $tasks]);
    }

    public function show($id)
    {
        // Cari task berdasarkan ID
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        return response()->json(['task' => $task]);
    }

    public function store(Request $request, Todo $todo)
    {
        try {
            // Validasi input
            $request->validate([
                'title' => 'required|string|max:255',
                'progress' => 'required|integer|min:0|max:100',
                'parent_id' => 'nullable|exists:tasks,id',
            ]);

            // Buat task baru
            $task = new Task([
                'title' => $request->title,
                'progress' => $request->progress,
                'parent_id' => $request->parent_id,
                'todo_id' => $todo->id,
                'user_id' => Auth::id(),
                'status' => $request->progress == 100 ? 'done' : 'in progress',
            ]);

            $task->save();

            // Update progress Todo
            $this->updateTodoProgress($todo);

            return response()->json(['success' => 'Task berhasil ditambahkan!', 'task' => $task]);
        } catch (\Exception $e) {
            // Tampilkan detail error dalam respons JSON
            return response()->json([
                'error' => 'Terjadi kesalahan saat menambahkan task.',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }


    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'nullable|string|max:255', // Judul task
            'progress' => 'required|integer|min:0|max:100', // Progress wajib
            'todo_id' => 'nullable|exists:todos,id', // Validasi todo_id
            'parent_id' => 'nullable|exists:tasks,id' // Validasi parent task
        ]);

        // Update atribut task
        $task->title = $request->title ?? $task->title; // Update jika ada title baru
        $task->progress = $request->progress;
        $task->status = $request->progress == 100 ? 'done' : 'in progress';
        $task->todo_id = $request->todo_id ?? $task->todo_id; // Tetap gunakan todo_id lama jika tidak diberikan
        $task->parent_id = $request->parent_id ?? $task->parent_id;

        // Simpan perubahan
        $task->save();

        // Update progres Todo
        $this->updateTodoProgress($task->todo);

        return response()->json([
            'success' => 'Task berhasil diperbarui!',
            'task' => $task
        ]);
    }



    private function updateTodoProgress(Todo $todo)
    {
        // Ambil semua task dan subtask dari Todo
        $allTasks = $this->getAllTasksRecursive($todo->tasks);

        $totalTasks = count($allTasks);
        $totalProgress = array_sum(array_column($allTasks, 'progress'));

        // Update progres dan status Todo
        $todo->progress = $totalTasks > 0 ? round($totalProgress / $totalTasks, 2) : 0;
        $todo->status = $todo->progress == 100 ? 'done' : 'in progress';
        $todo->save();
    }

    private function getAllTasksRecursive($tasks)
    {
        $allTasks = [];

        foreach ($tasks as $task) {
            $allTasks[] = ['id' => $task->id, 'progress' => $task->progress];

            if ($task->children()->exists()) {
                $allTasks = array_merge($allTasks, $this->getAllTasksRecursive($task->children));
            }
        }

        return $allTasks;
    }

    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        // Hapus task
        $task->delete();

        // Update progres Todo setelah menghapus task
        $this->updateTodoProgress($task->todo);

        return response()->json(['success' => 'Task berhasil dihapus']);
    }
}
