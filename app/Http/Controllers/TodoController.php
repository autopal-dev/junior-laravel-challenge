<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of all todos.
     */
    public function index()
    {
        $todos = Todo::orderBy('created_at', 'desc')->get();

        return view('todos.index', compact('todos'));
    }

    /**
     * Store a newly created todo in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date|after_or_equal:today',
        ]);

        Todo::create($validated);

        return redirect()->route('todos.index')
            ->with('success', 'Todo created successfully!');
    }

    /**
     * Mark a todo as completed.
     */
    public function complete(Todo $todo)
    {
        $todo->update(['completed' => true]);

        return redirect()->route('todos.index')
            ->with('success', 'Todo marked as completed!');
    }

    /**
     * Mark a todo as incomplete (undo completion).
     */
    public function uncomplete(Todo $todo)
    {
        $todo->update(['completed' => false]);

        return redirect()->route('todos.index')
            ->with('success', 'Todo marked as incomplete!');
    }

    /**
     * Remove the specified todo from the database.
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return redirect()->route('todos.index')
            ->with('success', 'Todo deleted successfully!');
    }
}
