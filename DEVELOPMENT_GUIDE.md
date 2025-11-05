# Todo Application - Development Guide

This is a Laravel-based Todo application built as a coding challenge for junior developers. The project demonstrates best practices for building a simple CRUD application with a modern, responsive UI.

## Project Structure

### Views Architecture

The application uses a blade templating system with reusable components:

```
resources/views/
├── layouts/
│   └── app.blade.php          # Main layout template
├── partials/
│   └── header.blade.php       # Reusable header component
└── todos/
    └── index.blade.php        # Todo list page
```

#### Layout System

**`layouts/app.blade.php`** - Main layout template that includes:
- Bootstrap 5.3 CSS framework
- Bootstrap Icons
- Custom CSS file
- CSRF token meta tag
- Flash message display
- Script stack for page-specific JavaScript

**`partials/header.blade.php`** - Reusable header component with:
- Logo with checkmark icon
- Navigation bar
- Responsive mobile menu

#### How to Use Layouts

To extend the main layout in a new view:

```blade
@extends('layouts.app')

@section('title', 'Your Page Title')

@section('content')
    <!-- Your content here -->
@endsection
```

### Styling Architecture

**`public/css/app.css`** - Custom styles organized by component:
- CSS variables for consistent theming
- Component-specific styles (header, cards, forms, etc.)
- Responsive design breakpoints
- Animation keyframes
- Utility classes

### Controller Structure

**`app/Http/Controllers/TodoController.php`**

The controller follows RESTful conventions:

| Method      | Route                        | Purpose                    |
|-------------|------------------------------|----------------------------|
| `index()`   | GET `/`                      | Display all todos          |
| `store()`   | POST `/todos`                | Create a new todo          |
| `complete()`| PATCH `/todos/{todo}/complete`| Mark todo as completed    |
| `destroy()` | DELETE `/todos/{todo}`       | Delete a todo              |

#### Request Validation

The `store()` method validates input:
```php
$validated = $request->validate([
    'title' => 'required|string|max:255',
    'description' => 'nullable|string',
    'due_date' => 'nullable|date|after_or_equal:today',
]);
```

### Routes

**`routes/web.php`**

Routes are named for easy reference in views:
```php
Route::get('/', [TodoController::class, 'index'])->name('todos.index');
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
Route::patch('/todos/{todo}/complete', [TodoController::class, 'complete'])->name('todos.complete');
Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');
```

### Database Schema

**`database/migrations/2025_11_05_112708_create_todos_table.php`**

The todos table contains:
- `id` - Primary key
- `title` - Todo title (required, max 255 chars)
- `description` - Optional detailed description
- `completed` - Boolean flag (default: false)
- `due_date` - Optional date field
- `created_at` / `updated_at` - Timestamps

### Model

**`app/Models/Todo.php`**

The Todo model includes:
- Mass assignment protection via `$fillable`
- Date casting for `due_date`
- Boolean casting for `completed`

## Features

### 1. View Todos
- List all todos with sorting (newest first)
- Display statistics (total, completed, pending)
- Show todo details: title, description, status, due date, creation date
- Visual distinction between completed and pending todos
- Due date indicators (overdue, due soon, days remaining)

### 2. Create Todo
- Modal-based form (Bootstrap modal)
- Required title field
- Optional description
- Optional due date (must be today or future)
- Form validation with error display
- Success/error flash messages

### 3. Mark as Completed
- One-click button to mark todo as done
- Visual feedback (green background, strikethrough)
- Button disappears after completion

### 4. Delete Todo
- Delete button with confirmation dialog
- Permanent deletion from database
- Success flash message

## UI Components

### Color Scheme
```css
--primary-color: #4f46e5    /* Indigo */
--success-color: #10b981    /* Green */
--warning-color: #f59e0b    /* Amber */
--danger-color: #ef4444     /* Red */
```

### Reusable CSS Classes

**Status Badges:**
- `.badge.status-completed` - Green badge for completed todos
- `.badge.status-pending` - Amber badge for pending todos

**Due Date Badges:**
- `.due-date-badge` - Default blue badge
- `.due-date-badge.overdue` - Red badge with pulse animation
- `.due-date-badge.due-soon` - Amber badge

**Todo Cards:**
- `.todo-card` - Base card style
- `.todo-card.completed` - Completed todo styling
- `.todo-card.pending` - Pending todo styling

**Buttons:**
- `.btn-action` - Compact action buttons (mark done, delete)

## Best Practices Demonstrated

1. **Separation of Concerns**
   - Logic in controllers
   - Presentation in views
   - Styling in CSS files

2. **Reusability**
   - Layout templates
   - Partial components
   - Named routes
   - CSS utility classes

3. **User Experience**
   - Modal forms (no page reload)
   - Flash messages for feedback
   - Confirmation dialogs for destructive actions
   - Responsive design
   - Loading states and animations

4. **Code Quality**
   - Consistent naming conventions
   - PHPDoc comments
   - Form validation
   - CSRF protection
   - Route model binding

5. **Accessibility**
   - Semantic HTML
   - ARIA labels
   - Bootstrap's built-in accessibility features

## Adding New Features

### Example: Adding an Edit Feature

1. **Add Route** (`routes/web.php`):
```php
Route::patch('/todos/{todo}', [TodoController::class, 'update'])->name('todos.update');
```

2. **Add Controller Method** (`app/Http/Controllers/TodoController.php`):
```php
public function update(Request $request, Todo $todo)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'due_date' => 'nullable|date|after_or_equal:today',
    ]);

    $todo->update($validated);

    return redirect()->route('todos.index')
        ->with('success', 'Todo updated successfully!');
}
```

3. **Add Modal to View** (`resources/views/todos/index.blade.php`):
- Copy the create modal structure
- Change the form action to update route
- Pre-fill form fields with current todo data

4. **Add Edit Button** in the todo card actions:
```blade
<button type="button" class="btn btn-primary btn-action" 
        data-bs-toggle="modal" 
        data-bs-target="#editTodoModal{{ $todo->id }}">
    <i class="bi bi-pencil"></i>
</button>
```

## Testing the Application

1. **View Todos**: Navigate to `/`
2. **Create Todo**: Click "Create New Todo" button
3. **Mark Complete**: Click green checkmark on pending todo
4. **Delete**: Click red trash icon (confirm deletion)
5. **Check Responsiveness**: Resize browser window

## Common Customizations

### Change Color Scheme
Edit CSS variables in `public/css/app.css`:
```css
:root {
    --primary-color: #your-color;
}
```

### Add New Status Badge
1. Add CSS class in `app.css`:
```css
.badge.status-in-progress {
    background-color: #3b82f6;
}
```

2. Use in view:
```blade
<span class="badge status-in-progress">In Progress</span>
```

### Modify Layout
Edit `resources/views/layouts/app.blade.php` to:
- Add footer
- Include additional CSS/JS
- Add meta tags
- Modify structure

## Bootstrap Components Used

- **Grid System**: Responsive layouts
- **Cards**: Todo items container
- **Badges**: Status indicators
- **Buttons**: Action buttons
- **Forms**: Input fields and validation
- **Modal**: Create todo popup
- **Alert**: Flash messages
- **Navbar**: Header navigation

## Tips for Junior Developers

1. **Always validate user input** - Use Laravel's validation rules
2. **Use named routes** - Easier to maintain and refactor
3. **Follow MVC pattern** - Keep logic out of views
4. **Comment your code** - Explain why, not what
5. **Test your features** - Create, read, update, delete
6. **Keep CSS organized** - Group related styles together
7. **Use version control** - Commit often with clear messages
8. **Check responsiveness** - Test on different screen sizes

## Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Bootstrap Documentation](https://getbootstrap.com/docs/5.3)
- [Bootstrap Icons](https://icons.getbootstrap.com)
- [Laravel Blade Templates](https://laravel.com/docs/blade)

