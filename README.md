# Junior Laravel Developer Challenge 🚀

Welcome! This coding challenge tests your **programming and problem-solving skills**. Don't worry if you're new to Laravel or PHP - the existing code serves as a good example to learn from!

## 📋 Your Task

The app already has a working Todo list. **Your job is to add a new "Summary" page** that shows:

### Requirements for `/summary` page:
1. **Total number of todos**
2. **Number of completed vs. pending todos**
3. **Completion percentage** (as a progress bar or text)
4. **List of todos due in the next 30 days**
5. **A button/link** to access this page from the main todo list (for example in header or near "Create New Todo" button)

---

## 🛠️ Setup Instructions

### Prerequisites

You'll need PHP and Composer installed. Choose one option:

**Option A: Laravel Herd** (Easiest - Windows/Mac)
- Download from [herd.laravel.com](https://herd.laravel.com)
- Includes PHP, Composer, and automatic site management

**Option B: Manual Setup**
- Install [PHP 8.1+](https://www.php.net/downloads)
- Install [Composer](https://getcomposer.org/download/)

### 1. Clone This Repository

**In GitHub:**
1. Click the "Fork" button (top right) to create your own copy
2. On your forked repository, click the green "Code" button
3. Copy the URL

**In your terminal:**
```bash
git clone <your-forked-repo-url>
cd junior-laravel-challenge
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate app key (required for Laravel)
php artisan key:generate
```

The project uses **SQLite** (database file already included). No additional database setup needed!

### 4. Run Migrations & Seed Data
```bash
php artisan migrate:fresh --seed
```

This creates the todos table and adds sample data (some with due dates in the next 30 days).

### 5. Start the Development Server

**If using Laravel Herd:**
- In Herd, click "Park" and select your projects directory
- Access at: `http://junior-laravel-challenge.test`

**If using PHP directly:**
```bash
php artisan serve
```
- Access at: `http://localhost:8000`

### 6. Verify Everything Works
Visit the URL - you should see a working todo list with sample tasks. ✅

---

## 📁 Project Structure

Here's what you need to know:

```
app/
├── Http/Controllers/
│   └── TodoController.php     # Controller logic - add your summary() method here
└── Models/
    └── Todo.php                # Database model for todos

routes/
└── web.php                     # URL routes - add your /summary route here

resources/views/
├── layouts/
│   └── app.blade.php          # Main page layout (header, footer, etc.)
├── partials/
│   └── header.blade.php       # Reusable header component
└── todos/
    ├── index.blade.php        # Existing todo list page (use as example!)
    └── summary.blade.php      # YOU CREATE THIS for the summary page

public/css/
└── app.css                    # Styles (Bootstrap 5.3 + custom CSS)
```

### Quick Concept Guide:

**Routes** (`routes/web.php`): Define URLs and what controller method handles them
```php
Route::get('/summary', [TodoController::class, 'summary'])->name('todos.summary');
```

**Controllers** (`app/Http/Controllers/TodoController.php`): Handle requests and return views
```php
public function summary() {
    // Get data from database
    // Return a view with that data
}
```

**Models** (`app/Models/Todo.php`): Interact with database tables
- The `Todo` model represents the `todos` table
- Use it to query data (examples in TodoController)

**Views** (`resources/views/`): HTML templates that display data
- Create your view by extending the main layout:
```blade
@extends('layouts.app')

@section('title', 'Summary')

@section('content')
    <!-- Your HTML here -->
@endsection
```

---

## 💡 What You'll Need to Figure Out

### Database Queries
You'll need to count todos, filter by status, and find todos due in the next 30 days. 

**What is Eloquent?**  
Laravel's Eloquent ORM (Object-Relational Mapping) lets you work with database tables using PHP objects instead of writing SQL. Look at how `TodoController.php` already uses the `Todo` model for examples.

**Helpful docs:**
- [Eloquent Basics](https://laravel.com/docs/10.x/eloquent)
- [Query Builder](https://laravel.com/docs/10.x/queries)
- [Date Comparisons](https://laravel.com/docs/10.x/queries#where-clauses)

### Percentage Calculation
How do you calculate what percentage of todos are completed? Sounds like a simple math, doesn't it?

### Displaying a Progress Bar
Bootstrap (already included) has built-in [progress bar components](https://getbootstrap.com/docs/5.3/components/progress/).

---

## 📚 Resources

- [Laravel 10 Documentation](https://laravel.com/docs/10.x) - Your main reference
- [Blade Templates](https://laravel.com/docs/10.x/blade) - For creating views
- [Eloquent ORM](https://laravel.com/docs/10.x/eloquent) - For database queries
- [Bootstrap 5.3](https://getbootstrap.com/docs/5.3/) - For styling
- [Bootstrap Icons](https://icons.getbootstrap.com/) - For icons

**Pro tip:** Look at the existing `TodoController.php` and `index.blade.php` files - they show you how everything works!

---

## 📤 Submission

When you're done:

1. **Commit your changes** with clear commit messages:
```bash
git add .
git commit -m "Add summary page with statistics and upcoming todos"
```

2. **Push to your GitHub repository:**
```bash
git push origin main
```

3. **Send us the link** to your GitHub repository

---

## ❓ Need Help?

**Stuck on something?** That's totally normal! Feel free to:
- Contact us directly - we're here to help juniors learn
- Check the existing code for examples
- Read the Laravel docs
- Google specific errors

We're interested in seeing your problem-solving approach, not perfection!

---

Good luck! We're excited to see your solution. 🎉
