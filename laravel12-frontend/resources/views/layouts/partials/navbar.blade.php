<nav class="navbar navbar-expand-lg fixed-top" style="background: var(--glass-bg); backdrop-filter: blur(10px); border-bottom: 1px solid var(--glass-border);">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <i class="fas fa-envelope-open-text me-2"></i>InquiryPro
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        {{ $lang('home') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        {{ $lang('about') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}">
                        {{ $lang('services') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('faq') ? 'active' : '' }}" href="{{ route('faq') }}">
                        {{ $lang('faq') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                        {{ $lang('contact') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('blog') ? 'active' : '' }}" href="{{ route('blog') }}">
                        {{ $lang('blog') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('testimonials') ? 'active' : '' }}" href="{{ route('testimonials') }}">
                        {{ $lang('testimonials') }}
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav align-items-center gap-2">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-globe me-1"></i>{{ strtoupper($locale ?? 'en') }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" onclick="switchLanguage('en')">English</a></li>
                        <li><a class="dropdown-item" href="#" onclick="switchLanguage('gu')">Gujarati</a></li>
                        <li><a class="dropdown-item" href="#" onclick="switchLanguage('hi')">Hindi</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <button class="btn btn-outline-light btn-sm rounded-circle" onclick="toggleDarkMode()" title="Toggle Dark Mode">
                        <i class="fas fa-moon" id="darkModeIcon"></i>
                    </button>
                </li>

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ $lang('login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ $lang('register') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('customer.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>{{ $lang('dashboard') }}
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>{{ $lang('logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar {
        min-height: 70px;
        transition: all 0.3s ease;
        background: var(--glass-bg) !important;
        border-bottom: 1px solid var(--glass-border);
    }
    .navbar-brand {
        font-size: 1.4rem;
        color: var(--text-primary) !important;
    }
    .nav-link {
        font-weight: 500;
        transition: all 0.3s ease;
        color: var(--text-primary) !important;
    }
    .nav-link:hover, .nav-link.active {
        color: var(--gradient-start) !important;
    }
    .navbar-toggler {
        border-color: var(--border-color);
    }
    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(33, 37, 41, 0.75)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
    .dark-mode .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.75)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
    .dropdown-menu {
        background: var(--bg-secondary);
        border-color: var(--border-color);
    }
    .dropdown-item {
        color: var(--text-primary);
    }
    .dropdown-item:hover {
        background: var(--bg-primary);
        color: var(--gradient-start);
    }
</style>
