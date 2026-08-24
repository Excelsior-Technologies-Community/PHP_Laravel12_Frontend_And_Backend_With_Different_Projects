<!DOCTYPE html>
<html lang="{{ $locale ?? 'en' }}" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'InquiryPro')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-primary: #f8f9fa;
            --bg-secondary: #ffffff;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --border-color: #dee2e6;
            --card-bg: rgba(255, 255, 255, 0.85);
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.3);
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 12px 40px rgba(0, 0, 0, 0.12);
            --gradient-start: #4f46e5;
            --gradient-end: #7c3aed;
        }

        .dark-mode {
            --bg-primary: #0f0f1a;
            --bg-secondary: #1a1a2e;
            --text-primary: #e4e6eb;
            --text-secondary: #b0b3b8;
            --border-color: #2d2d44;
            --card-bg: rgba(26, 26, 46, 0.85);
            --glass-bg: rgba(26, 26, 46, 0.7);
            --glass-border: rgba(255, 255, 255, 0.08);
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            --shadow-hover: 0 12px 40px rgba(0, 0, 0, 0.4);
        }

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            box-shadow: var(--shadow-hover);
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            border: none;
            color: white;
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.35);
            color: white;
        }

        .section-title {
            font-weight: 700;
            position: relative;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            border-radius: 2px;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #9333ea 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-gradient::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            animation: float 20s linear infinite;
        }

        @keyframes float {
            0% { transform: translate(0, 0); }
            100% { transform: translate(30px, 30px); }
        }

        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--gradient-start);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.15);
        }

        .toastr-custom {
            font-family: 'Poppins', sans-serif;
        }

        @media (max-width: 768px) {
            .hero-gradient {
                padding: 60px 0 !important;
            }
        }
    </style>

    @yield('styles')
</head>
<body>
    @include('layouts.partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('layouts.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @php($lang = fn($key) => $lang($key) ?? $key)

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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
            const body = document.body;
            const isDark = html.getAttribute('data-bs-theme') === 'dark';
            html.setAttribute('data-bs-theme', isDark ? 'light' : 'dark');
            body.classList.toggle('dark-mode', !isDark);
            localStorage.setItem('darkMode', isDark ? 'light' : 'dark');
        };

        const loadDarkMode = () => {
            const saved = localStorage.getItem('darkMode');
            if (saved === 'dark') {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                document.body.classList.add('dark-mode');
            }
        };

        const switchLanguage = (locale) => {
            fetch(`/language/${locale}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            }).then(() => {
                location.reload();
            });
        };

        document.addEventListener('DOMContentLoaded', () => {
            loadDarkMode();
        });
    </script>

    @yield('scripts')
</body>
</html>
