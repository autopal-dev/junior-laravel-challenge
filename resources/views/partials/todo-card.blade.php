<div class="todo-card {{ $todo->completed ? 'completed' : 'pending' }}">
    <div class="todo-header">
        <h3 class="todo-title {{ $todo->completed ? 'completed' : '' }}">
            {{ $todo->title }}
        </h3>
        <div class="todo-actions">
            @if(!$todo->completed)
                <form action="{{ route('todos.complete', $todo) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success btn-action" title="Mark as completed">
                        <i class="bi bi-check-lg"></i>
                    </button>
                </form>
            @else
                <form action="{{ route('todos.uncomplete', $todo) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-warning btn-action" title="Mark as incomplete">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </button>
                </form>
            @endif

            <form action="{{ route('todos.destroy', $todo) }}" method="POST" class="d-inline"
                onsubmit="return confirm('Are you sure you want to delete this todo?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-action" title="Delete">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        </div>
    </div>

    @if($todo->description)
        <p class="todo-description">{{ $todo->description }}</p>
    @endif

    <div class="todo-meta">
        <span class="badge {{ $todo->completed ? 'status-completed' : 'status-pending' }}">
            <i class="bi bi-{{ $todo->completed ? 'check-circle' : 'clock' }} me-1"></i>
            {{ $todo->completed ? 'Completed' : 'Pending' }}
        </span>

        @if($todo->due_date)
            @php
                $today = now()->startOfDay();
                $dueDate = $todo->due_date->startOfDay();
                $daysDiff = $today->diffInDays($dueDate, false);

                $dueDateClass = '';
                if ($daysDiff < 0 && !$todo->completed) {
                    $dueDateClass = 'overdue';
                }
            @endphp
            <span class="badge due-date-badge {{ $dueDateClass }}">
                <i class="bi bi-calendar-event me-1"></i>
                Due: {{ $todo->due_date->format('M j, Y') }}
            </span>
        @endif
    </div>
</div>