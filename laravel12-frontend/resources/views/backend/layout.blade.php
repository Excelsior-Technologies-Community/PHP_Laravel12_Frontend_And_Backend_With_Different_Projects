<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - InquiryPro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f4f6f9;
            min-height: 100vh;
        }

        .dark-mode {
            --bg-primary: #0f0f1a;
            --bg-secondary: #1a1a2e;
            --text-primary: #e4e6eb;
            --text-secondary: #b0b3b8;
            --border-color: #2d2d44;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            position: fixed;
            width: 260px;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 12px 20px;
            margin: 4px 0;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .sidebar .nav-link i {
            width: 24px;
            text-align: center;
            margin-right: 10px;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .top-header {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-area {
            padding: 30px;
        }

        .dark-mode .top-header {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
        }

        .dark-mode .glass-card {
            background: var(--card-bg);
            border-color: var(--glass-border);
        }

        .glass-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none;
            color: white;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
            color: white;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>

    @yield('styles')
</head>
<body>
    <div class="d-flex">
        <aside class="sidebar">
            <div class="p-4">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none">
                    <h4 class="fw-bold"><i class="fas fa-envelope-open-text me-2"></i>InquiryPro</h4>
                </a>
            </div>

            <nav class="nav flex-column px-3">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('admin.categories') ? 'active' : '' }}" href="{{ route('admin.categories') }}">
                    <i class="fas fa-tags"></i> Categories
                </a>
                <a class="nav-link {{ request()->routeIs('admin.blogs') ? 'active' : '' }}" href="{{ route('admin.blogs') }}">
                    <i class="fas fa-blog"></i> Blogs
                </a>
                <a class="nav-link {{ request()->routeIs('admin.testimonials') ? 'active' : '' }}" href="{{ route('admin.testimonials') }}">
                    <i class="fas fa-quote-right"></i> Testimonials
                </a>
                <a class="nav-link {{ request()->routeIs('admin.faqs') ? 'active' : '' }}" href="{{ route('admin.faqs') }}">
                    <i class="fas fa-question-circle"></i> FAQs
                </a>
            </nav>
        </aside>

        <div class="main-content flex-grow-1">
            <header class="top-header">
                <div class="d-flex align-items-center gap-3">
                    <h5 class="mb-0 fw-bold">@yield('page_title', 'Dashboard')</h5>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-outline-secondary btn-sm rounded-circle" onclick="toggleDarkMode()" title="Toggle Dark Mode">
                        <i class="fas fa-moon" id="adminDarkModeIcon"></i>
                    </button>
                    <div class="dropdown">
                        <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-weight: 600;">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="fw-semibold">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                                <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <main class="content-area">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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

        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        const toggleDarkMode = () => {
            const html = document.documentElement;
            const isDark = html.getAttribute('data-bs-theme') === 'dark';
            html.setAttribute('data-bs-theme', isDark ? 'light' : 'dark');
            document.body.classList.toggle('dark-mode', !isDark);
            localStorage.setItem('adminDarkMode', isDark ? 'light' : 'dark');
        };

        const loadDarkMode = () => {
            const saved = localStorage.getItem('adminDarkMode');
            if (saved === 'dark') {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                document.body.classList.add('dark-mode');
            }
        };

        document.addEventListener('DOMContentLoaded', loadDarkMode);
    </script>

    @yield('scripts')
</body>
</html>
