# PHP_Laravel12_Frontend_And_Backend_With_Different_Projects

## Introduction

This project demonstrates a complete Frontend and Backend Inquiry Management System using Laravel 12.

The application allows users to submit inquiries through a frontend form while administrators can manage inquiries through a dedicated dashboard.

---

## Step 1: Create Laravel 12 Project

```bash
composer create-project laravel/laravel:^12.0 laravel12-frontend
cd laravel12-frontend
php artisan key:generate
```

## Step 2: Database Configuration

Update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_frontend
DB_USERNAME=root
DB_PASSWORD=
```

Run:

```bash
php artisan migrate
```

## Step 3: Create Inquiry Model & Migration

```bash
php artisan make:model Inquiry -m
```

### app/Models/Inquiry.php

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'is_read'
    ];
}
```

## Migration

### database/migrations/2026_06_01_085412_create_inquiries_table.php

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
```

---

## Step 4: Controller

### app/Http/Controllers

### HomeController

```php
<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.home');
    }
}
```

### FrontendController

```php
<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function storeInquiry(Request $request)
    {
        $request->validate([
            'name'    => 'required|max:100',
            'email'   => 'required|email',
            'phone'   => 'nullable|max:20',
            'message' => 'required|max:1000',
        ]);

        Inquiry::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'message' => $request->message,
        ]);

        return redirect('/')
            ->with('success', 'Inquiry submitted successfully.');
    }
}
```

### AdminController

```php
<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $inquiries = Inquiry::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query) use ($status) {
                if ($status === 'read') {
                    $query->where('is_read', true);
                } elseif ($status === 'unread') {
                    $query->where('is_read', false);
                }
            })
            ->orderByDesc('id')
            ->paginate(4);

        $total = Inquiry::count();
        $read = Inquiry::where('is_read', true)->count();
        $unread = Inquiry::where('is_read', false)->count();
        $today = Inquiry::whereDate('created_at', Carbon::today())->count();

        return view('backend.dashboard', compact(
            'inquiries',
            'total',
            'read',
            'unread',
            'today'
        ));
    }

    public function markRead($id)
    {
        $inquiry = Inquiry::findOrFail($id);

        $inquiry->update([
            'is_read' => true
        ]);

        return redirect()->back()->with(
            'success',
            'Inquiry marked as read successfully.'
        );
    }

    public function markAllRead()
    {
        Inquiry::where('is_read', false)->update([
            'is_read' => true
        ]);

        return redirect()->back()->with(
            'success',
            'All inquiries marked as read successfully.'
        );
    }

    public function delete($id)
    {
        $inquiry = Inquiry::findOrFail($id);

        $inquiry->delete();

        return redirect()->back()->with(
            'success',
            'Inquiry deleted successfully.'
        );
    }
}
```

---

## Step 5: Blade Files

### resources/views/backend/dashboard.blade.php

```blade
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .header-card {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            border-radius: 20px;
            padding: 25px;
        }

        .stat-card {
            border: none;
            border-radius: 15px;
            transition: .3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .shadow-custom {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .table-container {
            background: white;
            border-radius: 20px;
            padding: 20px;
        }

        .badge-status {
            padding: 8px 12px;
            font-size: 13px;
        }

        .pagination .page-link {
            border-radius: 8px;
            margin: 0 3px;
        }

        .pagination .page-item.active .page-link {
            background: #4f46e5;
            border-color: #4f46e5;
        }

        .search-box {
            max-width: 500px;
        }

        .table td {
            vertical-align: middle;
        }
    </style>
</head>

<body>

    <div class="container py-4">

        {{-- Header --}}
        <div class="header-card shadow-custom mb-4">
            <h2>
                <i class="fas fa-chart-line"></i>
                Inquiry Management Dashboard
            </h2>
            <p class="mb-0">
                Monitor and manage customer inquiries.
            </p>
        </div>

        {{-- Statistics --}}
        <div class="row mb-4">

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card bg-primary text-white">
                    <div class="card-body">
                        <h6>Total</h6>
                        <h2>{{ $total }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card bg-success text-white">
                    <div class="card-body">
                        <h6>Read</h6>
                        <h2>{{ $read }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card bg-warning">
                    <div class="card-body">
                        <h6>Unread</h6>
                        <h2>{{ $unread }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card bg-info text-white">
                    <div class="card-body">
                        <h6>Today</h6>
                        <h2>{{ $today }}</h2>
                    </div>
                </div>
            </div>

        </div>

        {{-- Main Table --}}
        <div class="table-container shadow-custom">

            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">

                <h4>
                    <i class="fas fa-envelope"></i>
                    Customer Inquiries
                </h4>

                <div class="d-flex gap-2 flex-wrap">

                    {{-- Mark All Read --}}
                    <a href="{{ route('inquiry.readAll') }}" class="btn btn-success btn-sm"
                        onclick="return confirm('Mark all inquiries as read?')">
                        <i class="fas fa-check-double"></i>
                        Mark All Read
                    </a>

                    {{-- Search + Filter --}}
                    <form method="GET" class="d-flex search-box gap-2">

                        <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                            placeholder="Search name/email">

                        <select name="status" class="form-control">
                            <option value="">All</option>

                            <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>
                                Read
                            </option>

                            <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>
                                Unread
                            </option>
                        </select>

                        <button class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>

                    </form>

                </div>

            </div>

            <div class="table-responsive">

                <table class="table table-hover table-bordered">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th width="180">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($inquiries as $key => $inquiry)

                            <tr>

                                <td>
                                    {{ $inquiries->firstItem() + $key }}
                                </td>

                                <td>{{ $inquiry->name }}</td>

                                <td>{{ $inquiry->email }}</td>

                                <td>{{ $inquiry->phone }}</td>

                                <td>
                                    {{ \Illuminate\Support\Str::limit($inquiry->message, 80) }}
                                </td>

                                <td>
                                    @if($inquiry->is_read)
                                        <span class="badge bg-success">
                                            Read
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            Unread
                                        </span>
                                    @endif
                                </td>

                                <td>

                                    @if(!$inquiry->is_read)

                                        <a href="{{ route('inquiry.read', $inquiry->id) }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i>
                                        </a>

                                    @endif

                                    <a href="{{ route('inquiry.delete', $inquiry->id) }}" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this inquiry?')">

                                        <i class="fas fa-trash"></i>

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-center">
                                    No inquiries found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Pagination Numbers Only --}}
            @if($inquiries->lastPage() > 1)

                <div class="d-flex justify-content-center mt-4">

                    <nav>

                        <ul class="pagination">

                            @for($i = 1; $i <= $inquiries->lastPage(); $i++)

                                <li class="page-item {{ $i == $inquiries->currentPage() ? 'active' : '' }}">

                                    <a class="page-link" href="{{ $inquiries->appends(request()->query())->url($i) }}">

                                        {{ $i }}

                                    </a>

                                </li>

                            @endfor

                        </ul>

                    </nav>

                </div>

            @endif

        </div>

    </div>

    {{-- jQuery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    {{-- Toastr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            newestOnTop: true,
            preventDuplicates: true,
            positionClass: "toast-top-right",
            timeOut: "3000",
            extendedTimeOut: "1000"
        };
    </script>

    @if(session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif

    @if(session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
    @endif

</body>

</html>
```

### resources/views/frontend/home.blade.php

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Inquiry Portal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #4f46e5, #7c3aed, #9333ea);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .main-card {
            width: 100%;
            max-width: 900px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .15);
        }

        .left-panel {
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, .15),
                rgba(255, 255, 255, .05)
            );
            color: white;
            padding: 50px;
        }

        .right-panel {
            background: white;
            padding: 40px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px;
        }

        .btn-submit {
            background: #4f46e5;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 12px;
            width: 100%;
            font-weight: 600;
        }

        .btn-submit:hover {
            background: #4338ca;
            color: white;
        }

        .dashboard-btn {
            text-decoration: none;
        }

        .icon-box {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, .2);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="main-card">

    <div class="row g-0">

        <div class="col-lg-5">
            <div class="left-panel h-100">

                <div class="icon-box">
                    <i class="fas fa-envelope-open-text fa-2x"></i>
                </div>

                <h2 class="fw-bold">
                    Customer Inquiry Portal
                </h2>

                <p class="mt-3">
                    Submit your inquiry quickly and our team will get back to you as soon as possible.
                </p>

                <hr>

                <p>
                    <i class="fas fa-check-circle"></i>
                    Fast Response
                </p>

                <p>
                    <i class="fas fa-check-circle"></i>
                    Secure Data Storage
                </p>

                <p>
                    <i class="fas fa-check-circle"></i>
                    Real-Time Dashboard Tracking
                </p>

                <a href="{{ route('dashboard') }}" class="btn btn-light mt-4 dashboard-btn">
                    <i class="fas fa-chart-line"></i>
                    Open Admin Dashboard
                </a>

            </div>
        </div>

        <div class="col-lg-7">

            <div class="right-panel">

                <h3 class="mb-4">
                    Send Your Inquiry
                </h3>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('inquiry.store') }}" method="POST">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>

                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter your name"
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>

                        <input
                            type="email"
                            class="form-control"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Enter your email"
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>

                        <input
                            type="text"
                            class="form-control"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="Enter phone number"
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message</label>

                        <textarea
                            class="form-control"
                            rows="5"
                            name="message"
                            placeholder="Write your inquiry here..."
                        >{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i>
                        Submit Inquiry
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>
```

---

## Step 6: Routes

### routes/web.php

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index']);

Route::post('/inquiry/store', [FrontendController::class, 'storeInquiry'])
    ->name('inquiry.store');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->name('dashboard');

Route::get('/inquiry/read/{id}', [AdminController::class, 'markRead'])
    ->name('inquiry.read');

Route::get('/inquiry/read-all', [AdminController::class, 'markAllRead'])
    ->name('inquiry.readAll');
    
Route::get('/inquiry/delete/{id}', [AdminController::class, 'delete'])
    ->name('inquiry.delete');
```

---

## Run Project

```bash
php artisan serve
```

Frontend:

```bash
http://127.0.0.1:8000
```

Dashboard:

```bash
http://127.0.0.1:8000/admin/dashboard
```

---

## Screenshots

<img width="1918" height="1028" alt="Screenshot 2026-06-15 182130" src="https://github.com/user-attachments/assets/8229275f-c5d7-44ce-9617-37b29b435d85" />

<img width="1918" height="1031" alt="Screenshot 2026-06-15 182142" src="https://github.com/user-attachments/assets/6a34e57c-e471-4774-8816-925224ad3dbd" />

<img width="1918" height="1027" alt="Screenshot 2026-06-15 182152" src="https://github.com/user-attachments/assets/26c1a2d6-9816-469e-8828-dfcb9962c092" />

---

## Folder Structure

```text
PHP_Laravel12_Frontend_And_Backend_With_Different_Projects
│
└── laravel12-frontend
    │
    ├── app
    │   ├── Http
    │   │   └── Controllers
    │   │       ├── HomeController.php
    │   │       ├── FrontendController.php
    │   │       └── AdminController.php
    │   │
    │   └── Models
    │       └── Inquiry.php
    │
    ├── bootstrap
    ├── config
    │
    ├── database
    │   ├── factories
    │   ├── migrations
    │   │   ├── 0001_01_01_000000_create_users_table.php
    │   │   ├── 0001_01_01_000001_create_cache_table.php
    │   │   ├── 0001_01_01_000002_create_jobs_table.php
    │   │   └── 2026_06_01_085412_create_inquiries_table.php
    │   │
    │   └── seeders
    │
    ├── public
    │
    ├── resources
    │   ├── css
    │   ├── js
    │   └── views
    │       ├── frontend
    │       │   └── home.blade.php
    │       │
    │       ├── backend
    │       │   └── dashboard.blade.php
    │       │
    │       └── welcome.blade.php
    │
    ├── routes
    │   ├── web.php
    │   └── console.php
    │
    ├── storage
    ├── tests
    │
    ├── .env
    ├── artisan
    ├── composer.json
    ├── composer.lock
    ├── package.json
    ├── vite.config.js
    └── README.md
```

---

Now PHP_Laravel12_Frontend_And_Backend_With_Different_Projects Project is ready!

