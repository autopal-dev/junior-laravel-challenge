@extends('layouts.app')

@section('title', 'Todo List - All Tasks')

@section('content')
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">My Todos</h1>
            <p class="page-subtitle">Manage your tasks and stay organized</p>
        </div>

        <!-- Actions -->
        <div class="actions-container">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTodoModal">
                <i class="bi bi-plus-circle me-2"></i>Create New Todo
            </button>
        </div>

        <!-- Todos List -->
        @if($todos->count() > 0)
            <div class="todos-list">
                @foreach($todos as $todo)
                    @include('partials.todo-card', ['todo' => $todo])
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-clipboard-check"></i>
                </div>
                <h2 class="empty-state-title">No todos yet</h2>
                <p class="empty-state-text">Start by creating your first todo to stay organized!</p>
                <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#createTodoModal">
                    <i class="bi bi-plus-circle me-2"></i>Create Your First Todo
                </button>
            </div>
        @endif
    </div>

    <!-- Create Todo Modal -->
    <div class="modal fade" id="createTodoModal" tabindex="-1" aria-labelledby="createTodoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('todos.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createTodoModalLabel">
                            <i class="bi bi-plus-circle me-2"></i>Create New Todo
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title') }}" required maxlength="255"
                                placeholder="Enter todo title">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="3"
                                placeholder="Add more details about this todo (optional)">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Optional: Add more context to your todo</div>
                        </div>

                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date"
                                name="due_date" value="{{ old('due_date') }}" min="{{ date('Y-m-d') }}">
                            @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Optional: Set a deadline for this todo</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>Create Todo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($errors->any())
        @push('scripts')
            <script>
                // Reopen modal if there are validation errors
                document.addEventListener('DOMContentLoaded', function () {
                    var modal = new bootstrap.Modal(document.getElementById('createTodoModal'));
                    modal.show();
                });
            </script>
        @endpush
    @endif
@endsection