<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Todo Lists</title>
    <link rel="stylesheet" href="{{ asset('new-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('new-assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
.d-flex {
            display: flex;
        }

        .sidebar {
            width: 250px;
            transition: width 0.3s ease;
        }

        .sidebar.hidden {
            width: 80px;
        }

        .sidebar.hidden .nav-link span {
            display: none;
        }

        .main-content {
            flex-grow: 1;
            transition: margin-left 0.3s ease;
            margin-left: 250px;
        }

        .sidebar.hidden ~ .main-content {
            margin-left: 80px;
        }
    </style>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header text-center py-3">
                <img src="path/to/logo.png" alt="Logo" class="sidebar-logo mb-2">
                <p class="sidebar-user-info mb-0">
                    <strong>Duck UI</strong><br>
                    Duckui@demo.com
                </p>
            </div>
            <div class="sidebar-search px-3 py-2">
                <form action="{{ route('todos.search') }}" method="GET" class="d-flex">
                    <input type="text" name="query" class="form-control me-2" placeholder="Search Todos or Tasks" value="{{ request()->input('query') }}">
                </form>
            </div>
            <ul class="nav flex-column sidebar-nav">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="bi bi-house-door"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('todos.index') }}" class="nav-link">
                        <i class="bi bi-calendar"></i>
                        <span>Todo-List</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-pie-chart"></i>
                        <span>Analytics</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer p-3">
                <button id="logoutButton" class="btn btn-danger w-100">Logout</button>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Sidebar Toggle Button -->
            <button id="toggleSidebar" class="btn btn-secondary mb-4">
                <i class="bi bi-list"></i>
            </button>

            <div class="container mt-4">
                <h1 class="main-header text-center">Your Todo Lists</h1>
                <hr>

                <!-- Add Todo Button -->
                @if(auth()->user()->role == 'revieweeA')
                <button id="showTodoForm" class="btn btn-primary mb-4 add-todo-btn">Add New Todo</button>

                <!-- Todo Form -->
                <form id="todoForm" action="{{ route('todos.store') }}" method="POST" class="mb-4 todo-form" style="display: none;">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-8">
                            <input type="text" name="name" class="form-control" placeholder="New Todo Name" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success w-100">Save Todo</button>
                        </div>
                    </div>
                    <button id="cancelTodoForm" type="button" class="btn btn-danger">Cancel</button>
                </form>
                @endif

                <!-- Feedback for Empty Results -->
                @if($todos->isEmpty())
                <div class="alert alert-warning text-center no-todos-alert">
                    No Todos found.
                </div>
                @endif

                <!-- Todo List -->
                <div class="row">
                    @foreach ($todos as $todo)
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card h-100 todo-card">
                            <div class="card-body" data-bs-toggle="collapse" data-bs-target="#tasks-{{ $todo->id }}" style="cursor: pointer;">
                                <h5 class="card-title">{{ $todo->name }}</h5>
                                <p class="card-text">Progress: {{ $todo->progress }}%</p>
                                <p class="card-text">Created by: <strong>{{ $todo->user->name }}</strong></p>
                                <form action="{{ route('todos.destroy', $todo) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Todo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">Delete Todo</button>
                                </form>
                            </div>

                            <!-- Task List -->
                            <div id="tasks-{{ $todo->id }}" class="collapse mt-3">
                                <ul class="list-group">
                                    @foreach ($todo->tasks->where('parent_id', null) as $task)
                                    <li class="list-group-item">
                                        {{ $task->title }} - {{ $task->progress }}%
                                        <button class="btn btn-sm btn-warning float-end" data-bs-toggle="collapse" data-bs-target="#edit-task-{{ $task->id }}">Edit</button>

                                        <!-- Edit Task Form -->
                                        <div id="edit-task-{{ $task->id }}" class="collapse mt-2">
                                            <form action="{{ route('tasks.update', $task) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="number" name="progress" class="form-control" value="{{ $task->progress }}" min="0" max="100" required>
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="submit" class="btn btn-success w-100">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Add Task Form -->
                            <div class="card-footer">
                                <form action="{{ route('tasks.store', ['todo' => $todo->id]) }}" method="POST" class="mt-3">
                                    @csrf
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <input type="text" name="title" class="form-control" placeholder="Task Name" required>
                                        </div>
                                        <div class="col-4">
                                            <input type="number" name="progress" class="form-control" placeholder="Progress (0-100)" min="0" max="100" required>
                                        </div>
                                        <div class="col-2">
                                            <button type="submit" class="btn btn-primary w-100">Add</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('new-assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        });

        document.addEventListener('DOMContentLoaded', function () {
            const showTodoFormButton = document.getElementById('showTodoForm');
            const todoForm = document.getElementById('todoForm');
            const cancelTodoFormButton = document.getElementById('cancelTodoForm');

            showTodoFormButton.addEventListener('click', function () {
                showTodoFormButton.style.display = 'none';
                todoForm.style.display = 'block';
            });

            cancelTodoFormButton.addEventListener('click', function () {
                todoForm.style.display = 'none';
                showTodoFormButton.style.display = 'block';
            });
        });
    </script>
</body>

</html>
