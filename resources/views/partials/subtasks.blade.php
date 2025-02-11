@foreach ($tasks as $task)
<ul class="list-group mt-2 ms-4">
    <li class="list-group-item">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong>{{ $task->title }}</strong> - {{ $task->progress }}% 
                <span class="text-muted">Created by: {{ $task->user->name }}</span>
            </div>

            <!-- Update Progress -->
            @if(auth()->user()->role == 'revieweeA' || auth()->user()->role == 'revieweeB')
            <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <input type="number" name="progress" value="{{ $task->progress }}" class="form-control d-inline w-auto" min="0" max="100" required>
                <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
            </form>
            @endif
        </div>

        <!-- Add Sub-Task -->
        @if(auth()->user()->role == 'revieweeA' || auth()->user()->role == 'revieweeB')
        <form action="{{ route('tasks.store', $task->todo) }}" method="POST" class="mt-2">
            @csrf
            <div class="row g-2">
                <div class="col-md-7">
                    <input type="text" name="title" class="form-control" placeholder="New Sub-Task Name" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="progress" class="form-control" placeholder="Progress (0-100)" required>
                </div>
                <div class="col-md-2">
                    <input type="hidden" name="parent_id" value="{{ $task->id }}">
                    <button type="submit" class="btn btn-primary w-100">Add Sub-Task</button>
                </div>
            </div>
        </form>
        @endif

        <!-- Recursive Subtasks -->
        @if ($task->children->isNotEmpty())
            @include('partials.subtasks', ['tasks' => $task->children])
        @endif
    </li>
</ul>
@endforeach
