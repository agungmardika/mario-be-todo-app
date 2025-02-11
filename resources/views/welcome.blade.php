<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('new-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('new-assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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
</head>

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
            <button id="toggleSidebar" class="btn btn-secondary m-3">
                <i class="bi bi-list"></i>
            </button>

            <div class="container mt-4">
                <h1 class="text-center">Dashboard</h1>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body text-center">
                                <h5 class="card-title">Jumlah TODO</h5>
                                <p class="card-text">{{ $todosCount ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body text-center">
                                <h5 class="card-title">Task Selesai</h5>
                                <p class="card-text">{{ $completedTasksCount ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-body text-center">
                                <h5 class="card-title">Task Dalam Proses</h5>
                                <p class="card-text">{{ $inProgressTasksCount ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('new-assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('new-assets/js/script.js') }}"></script>
</body>

</html>
