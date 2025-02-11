<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    // Fungsi untuk menampilkan semua Todos berdasarkan peran pengguna
    public function index()
    {
        // Ambil pengguna yang sedang terautentikasi
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Lanjutkan dengan pengecekan role
        if ($user->role === 'reviewerA' || $user->role === 'reviewerB') {
            // Reviewer melihat semua Todos
            $todos = Todo::with('tasks')->get();
        } elseif ($user->role === 'revieweeB') {
            // Reviewee B hanya melihat Todos milik Reviewee A
            $todos = Todo::whereHas('user', function ($query) {
                $query->where('role', 'revieweeA');
            })->with('tasks')->get();
        } else {
            // Reviewee A melihat Todos miliknya
            $todos = Todo::where('user_id', $user->id)->with('tasks')->get();
        }

        return response()->json($todos);
    }

    public function show($id)
    {
        $user = Auth::user();

        // Cari Todo berdasarkan ID
        $todo = Todo::with('tasks')->find($id);

        if (!$todo) {
            return response()->json(['error' => 'Todo not found'], 404);
        }

        // Pastikan pengguna hanya bisa melihat Todo yang sesuai dengan role mereka
        if ($user->role === 'reviewerA' || $user->role === 'reviewerB') {
            // Reviewer bisa melihat semua Todos
            return response()->json($todo);
        } elseif ($user->role === 'revieweeB') {
            // Reviewee B hanya bisa melihat Todos milik Reviewee A
            if ($todo->user->role !== 'revieweeA') {
                return response()->json(['error' => 'Unauthorized to view this Todo'], 403);
            }
            return response()->json($todo);
        } else {
            // Reviewee A hanya bisa melihat Todos miliknya
            if ($todo->user_id !== $user->id) {
                return response()->json(['error' => 'Unauthorized to view this Todo'], 403);
            }
            return response()->json($todo);
        }
    }


    // Fungsi untuk membuat Todo baru
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'revieweeA') {
            return response()->json(['error' => 'Unauthorized action. Only Reviewee A can create Todos.'], 403);
        }

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'progress' => 'required|integer|min:0|max:100', // Tambahkan validasi progress
            'status' => 'required|string|in:in progress,done', // Sesuaikan dengan pilihan di frontend
        ]);

        // Simpan Todo baru berdasarkan data input
        $todo = Todo::create([
            'name' => $request->name,
            'user_id' => $user->id,
            'progress' => $request->progress, // Simpan progress dari request
            'status' => $request->status,     // Simpan status dari request
        ]);

        return response()->json(['success' => 'Todo berhasil ditambahkan!', 'todo' => $todo]);
    }


    // Fungsi untuk mencari Todos berdasarkan nama atau kriteria lainnya
    public function search(Request $request)
    {
        $user = Auth::user();
        $query = $request->input('query');

        // Logika pencarian berdasarkan peran pengguna
        if ($user->role === 'reviewerA' || $user->role === 'reviewerB') {
            // Reviewer mencari semua Todos
            $todos = Todo::where('name', 'LIKE', "%{$query}%")->with('tasks')->get();
        } elseif ($user->role === 'revieweeB') {
            // Reviewee B mencari Todos milik Reviewee A
            $todos = Todo::where('name', 'LIKE', "%{$query}%")
                ->whereHas('user', function ($q) {
                    $q->where('role', 'revieweeA');
                })
                ->with('tasks')
                ->get();
        } else {
            // Reviewee A mencari Todos miliknya
            $todos = Todo::where('name', 'LIKE', "%{$query}%")
                ->where('user_id', $user->id)
                ->with('tasks')
                ->get();
        }

        return response()->json(['todos' => $todos, 'query' => $query]);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $todo = Todo::findOrFail($id);

            // Check if the todo belongs to the logged-in user
            if ($todo->user_id != $user->id) {
                return response()->json(['error' => 'Unauthorized action. You can only update your own Todos.'], 403);
            }

            // Validate the request data
            $request->validate([
                'name' => 'required|string|max:255',
                'progress' => 'required|integer|min:0|max:100',
                'status' => 'required|string|in:in progress,completed',
            ]);

            // Update the Todo
            $todo->update([
                'name' => $request->name,
                'progress' => $request->progress,
                'status' => $request->status,
            ]);

            return response()->json($todo);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat memperbarui Todo.',
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ], 500);
        }
    }


    public function destroy($id)
    {
        $user = Auth::user();
        $todo = Todo::findOrFail($id);

        // Pastikan hanya Reviewee A yang bisa menghapus todos miliknya
        if ($todo->user_id != $user->id) {
            return response()->json(['error' => 'Unauthorized action. You can only delete your own Todos.'], 403);
        }

        // Hapus todo
        $todo->delete();

        return response()->json(['success' => 'Todo berhasil dihapus']);
    }
}
