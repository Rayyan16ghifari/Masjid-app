<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('description', 'Al-Hasanah App - Aplikasi Manajemen Masjid Al-Hasanah. Sistem informasi lengkap untuk jadwal kajian, donasi, dan kegiatan masjid.')">
    <meta name="keywords" content="masjid, al-hasanah, kajian, donasi, islam, aplikasi masjid">
    <meta name="author" content="Masjid Al-Hasanah">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('title', config('app.name', 'Al-Hasanah App')) - Al-Hasanah App">
    <meta property="og:description" content="@yield('description', 'Al-Hasanah App - Aplikasi Manajemen Masjid Al-Hasanah. Sistem informasi lengkap untuk jadwal kajian, donasi, dan kegiatan masjid.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Al-Hasanah App">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <title>@yield('title', config('app.name', 'Al-Hasanah App')) - Al-Hasanah App</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Page Transitions CSS -->
    <link href="{{ asset('css/page-transitions.css') }}" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')

    <style>
        :root {
            --green-deep: #04291f;
            --green-dark: #063827;
            --green-main: #0f5132;
            --green-soft: #198754;
            --gold: #f4c430;
            --white-soft: rgba(255,255,255,0.86);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: white;
            background: var(--green-deep);
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            z-index: -3;
            background-image: linear-gradient(180deg, rgba(4,41,31,0.38), rgba(4,41,31,0.9));
            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
        }

        body::after {
            content: "";
            position: fixed;
            inset: 0;
            z-index: -2;
            background: radial-gradient(circle at top center, rgba(255,255,255,0.16), transparent 36%), linear-gradient(180deg, rgba(255,255,255,0.12) 0%, rgba(4,41,31,0.04) 26%, rgba(4,41,31,0.92) 82%);
            pointer-events: none;
        }

        a {
            color: inherit;
        }

        .topbar-wrap {
            position: fixed;
            top: 18px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 100;
            width: min(1400px, calc(100% - 40px));
            margin: 18px auto 0;
        }

        .topbar {
            min-height: 68px;
            display: grid;
            grid-template-columns: minmax(230px, 255px) minmax(0, 1fr) minmax(205px, auto);
            align-items: center;
            gap: 12px;
            padding: 11px 24px 11px 24px;
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 999px;
            background: rgba(5,54,38,0.76);
            backdrop-filter: blur(18px);
            box-shadow: 0 18px 55px rgba(0,0,0,0.28);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: max-content;
            text-decoration: none;
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: var(--green-deep);
            background: radial-gradient(circle at 30% 20%, #fff3ad, #f4c430 58%, #c99513);
            box-shadow: 0 10px 24px rgba(244,196,48,0.22);
        }

        .brand-mark svg {
            width: 26px;
            height: 26px;
            display: block;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .brand-title {
            color: var(--gold);
            font-size: 15px;
            font-weight: 800;
            letter-spacing: 0.2px;
            white-space: nowrap;
        }

        .brand-subtitle {
            margin-top: 3px;
            color: rgba(255,255,255,0.62);
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.6px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .menu {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 3  px;
            min-width: 0;
            overflow: visible;
        }

        .menu-link,
        .dropdown-toggle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: max-content;
            padding: 10px 11px;
            color: rgba(255,255,255,0.88);
            text-decoration: none;
            border: none;
            border-radius: 999px;
            background: transparent;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.25s ease;
        }

        .menu-link:hover,
        .dropdown:hover .dropdown-toggle,
        .dropdown:focus-within .dropdown-toggle {
            color: white;
            background: rgba(255,255,255,0.12);
            transform: translateY(-1px);
        }

        .menu-link.active,
        .dropdown.active .dropdown-toggle {
            color: var(--green-deep);
            background: linear-gradient(135deg, #ffe680, #f4c430);
            box-shadow: 0 8px 22px rgba(244,196,48,0.24);
        }

        .dropdown {
            position: relative;
            display: inline-flex;
        }

        .dropdown-toggle::after {
            content: "";
            width: 7px;
            height: 7px;
            margin-left: 8px;
            border-right: 2px solid currentColor;
            border-bottom: 2px solid currentColor;
            transform: rotate(45deg) translateY(-2px);
            transition: 0.25s ease;
        }

        .dropdown:hover .dropdown-toggle::after,
        .dropdown:focus-within .dropdown-toggle::after,
        .dropdown.open .dropdown-toggle::after {
            transform: rotate(225deg) translate(-1px, -1px);
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 14px);
            left: 50%;
            width: 245px;
            padding: 10px;
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 22px;
            background: rgba(4,41,31,0.96);
            backdrop-filter: blur(18px);
            box-shadow: 0 24px 60px rgba(0,0,0,0.34);
            opacity: 0;
            visibility: hidden;
            transform: translate(-50%, 10px);
            transition: 0.22s ease;
            z-index: 200;
        }

        .dropdown-menu::before {
            content: "";
            position: absolute;
            top: -8px;
            left: 50%;
            width: 14px;
            height: 14px;
            background: rgba(4,41,31,0.96);
            border-left: 1px solid rgba(255,255,255,0.14);
            border-top: 1px solid rgba(255,255,255,0.14);
            transform: translateX(-50%) rotate(45deg);
        }

        .dropdown:hover .dropdown-menu,
        .dropdown:focus-within .dropdown-menu,
        .dropdown.open .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translate(-50%, 0);
        }

        .dropdown-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 11px 12px;
            border-radius: 14px;
            color: rgba(255,255,255,0.82);
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            transition: 0.2s ease;
        }

        .dropdown-link:hover,
        .dropdown-link.active {
            color: var(--green-deep);
            background: linear-gradient(135deg, #ffe680, #f4c430);
        }

        .nav-user {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            min-width: max-content;
            flex-wrap: wrap;
        }

        .admin-section {
            display: flex;
            align-items: center;
            margin-right: 8px;
            order: -1;
        }

        .user-section {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-admin {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 20px;
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
            white-space: nowrap;
        }

        .btn-admin:hover {
            background: linear-gradient(135deg, #c82333, #a02622);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
        }

        .btn-admin i {
            font-size: 11px;
        }

        .user-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            max-width: 185px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            padding: 8px 12px 8px 8px;
            border-radius: 999px;
            color: var(--white-soft);
            background: rgba(255,255,255,0.1);
            font-size: 13px;
            font-weight: 700;
        }

        .user-avatar {
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            border-radius: 50%;
            color: var(--green-deep);
            background: linear-gradient(135deg, #ffffff, #f4c430);
            font-size: 12px;
            font-weight: 800;
        }

        .user-name-text {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .logout-form {
            margin: 0;
        }

        .btn-logout,
        .btn-auth {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            padding: 10px 15px;
            border-radius: 999px;
            color: white;
            cursor: pointer;
            font-family: inherit;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
            transition: 0.25s ease;
        }

        .btn-logout {
            background: rgba(220,53,69,0.9);
        }

        .btn-logout:hover {
            background: #dc3545;
            transform: translateY(-1px);
        }

        .btn-auth {
            color: var(--green-deep);
            background: linear-gradient(135deg, #ffe680, #f4c430);
            box-shadow: 0 8px 22px rgba(244,196,48,0.24);
        }

        .btn-auth:hover {
            transform: translateY(-1px);
        }

        .btn-admin {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
            padding: 10px 15px;
            border-radius: 999px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            cursor: pointer;
            font-family: inherit;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
            transition: 0.25s ease;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .btn-admin:hover {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        .page-hero {
            width: 100%;
            margin: -86px 0 0;
            min-height: clamp(560px, 72vh, 760px);
            display: flex;
            align-items: center;
            padding: 132px clamp(20px, 4vw, 60px) 86px;
            border-radius: 0;
            overflow: hidden;
            border: none;
            background:
                linear-gradient(135deg, rgba(5,54,38,0.96), rgba(3,32,24,0.98)),
                linear-gradient(180deg, rgba(4,41,31,0.18) 0%, rgba(4,41,31,0.96) 100%);
            background-size: cover;
            background-position: center;
            box-shadow: none;
        }

        .hero-content {
            max-width: 780px;
            padding: 0;
        }

        .hero-kicker {
            margin: 0 0 10px;
            color: var(--gold);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        .hero-title {
            margin: 0;
            font-size: clamp(40px, 6vw, 76px);
            line-height: 1.05;
            font-weight: 800;
            letter-spacing: -1.6px;
        }

        .hero-desc {
            margin: 14px 0 0;
            max-width: 640px;
            color: rgba(255,255,255,0.78);
            line-height: 1.75;
            font-size: clamp(15px, 1.2vw, 18px);
            font-weight: 500;
        }

        .main-content {
            width: 100%;
            min-height: 45vh;
            margin: 0;
            padding: 44px 0 76px;
            border: none;
            border-radius: 0;
            background: linear-gradient(180deg, rgba(4,41,31,0.96), rgba(3,32,24,0.98));
            backdrop-filter: blur(14px);
            box-shadow: none;
        }

        @media (max-width: 1180px) {
            .topbar {
                grid-template-columns: 1fr;
                border-radius: 28px;
                padding: 16px;
            }

            .brand,
            .nav-user {
                justify-content: center;
            }

            .menu {
                justify-content: center;
                flex-wrap: wrap;
                width: 100%;
            }

            .dropdown-menu {
                left: 50%;
            }
        }

        @media (max-width: 720px) {
            .topbar-wrap {
                width: calc(100% - 20px);
                top: 10px;
                margin-top: 10px;
                left: 50%;
                transform: translateX(-50%);
            }

            .topbar {
                grid-template-columns: 1fr;
                border-radius: 28px;
                padding: 16px;
            }

            .brand,
            .menu,
            .nav-user {
                width: 100%;
                justify-content: center;
                overflow-x: auto;
                flex-wrap: nowrap;
                padding: 2px 2px 8px;
                scrollbar-width: none;
            }

            .menu-link,
            .dropdown-toggle {
                padding: 9px 11px;
                font-size: 13px;
            }

            .dropdown {
                position: static;
            }

            .dropdown-menu {
                position: fixed;
                top: 112px;
                left: 10px;
                right: 10px;
                width: auto;
                max-height: calc(100vh - 132px);
                overflow-y: auto;
                z-index: 200;
                transform: translateY(10px);
            }

            .dropdown-menu::before {
                display: none;
            }

            .dropdown:hover .dropdown-menu,
            .dropdown:focus-within .dropdown-menu,
            .dropdown.open .dropdown-menu {
                transform: translateY(0);
            }

            .nav-user {
                flex-wrap: wrap;
                justify-content: center;
                gap: 8px;
            }

            .admin-section {
                order: 1;
                margin-right: 0;
                margin-bottom: 8px;
                width: 100%;
                justify-content: center;
            }

            .user-section {
                order: 2;
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
            }

            .btn-admin {
                width: 100%;
                justify-content: center;
                max-width: 200px;
            }

            .user-pill {
                flex: 1;
                justify-content: center;
                max-width: none;
            }

            .logout-form {
                width: 100%;
                justify-content: center;
            }

            .btn-logout {
                width: 100%;
                justify-content: center;
                max-width: 120px;
            }

            .page-hero {
                width: 100%;
                margin-top: -78px;
                min-height: 500px;
                padding: 124px 22px 58px;
                border-radius: 0;
            }

            .hero-content {
                padding: 0;
            }

            .main-content {
                width: 100%;
                padding: 28px 16px 54px;
                border-radius: 0;
            }
        }
    </style>
</head>
<body class="@yield('body_class')">
    @unless(View::hasSection('hide_topbar'))
    <header class="topbar-wrap">
        <div class="topbar">
            <a href="/dashboard" class="brand">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M32 8C25.2 13.4 21.8 18.8 21.8 24.3C21.8 29.9 26.4 34.5 32 34.5C37.6 34.5 42.2 29.9 42.2 24.3C42.2 18.8 38.8 13.4 32 8Z" fill="#063827"/>
                        <path d="M14 31.5C14 29 16 27 18.5 27H45.5C48 27 50 29 50 31.5V50H14V31.5Z" fill="#063827"/>
                        <path d="M20 50V37.5C20 35.6 21.6 34 23.5 34C25.4 34 27 35.6 27 37.5V50H20Z" fill="#F4C430"/>
                        <path d="M37 50V37.5C37 35.6 38.6 34 40.5 34C42.4 34 44 35.6 44 37.5V50H37Z" fill="#F4C430"/>
                        <path d="M29 50V39C29 37.3 30.3 36 32 36C33.7 36 35 37.3 35 39V50H29Z" fill="#F4C430"/>
                        <path d="M10 50H54" stroke="#063827" stroke-width="4" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="brand-text">
                    <span class="brand-title">Alhasanah App</span>
                    <span class="brand-subtitle">Masjid Al-Hasanah</span>
                </span>
            </a>

            <nav class="menu" aria-label="Navigasi utama">
                <a href="/dashboard" class="menu-link {{ request()->is('dashboard') ? 'active' : '' }}">Beranda</a>
                <a href="/rekomendasi" class="menu-link {{ request()->is('rekomendasi') ? 'active' : '' }}">Rekomendasi Kajian</a>
                <a href="/galeri" class="menu-link {{ request()->is('galeri*') ? 'active' : '' }}">Galeri</a>
                <a href="/kitab" class="menu-link {{ request()->is('kitab*') ? 'active' : '' }}">Kitab Kajian</a>
                <a href="/donasi" class="menu-link {{ request()->is('donasi*') ? 'active' : '' }}">Donasi</a>
                <a href="/kontak" class="menu-link {{ request()->is('kontak') ? 'active' : '' }}">Kontak</a>

                <div class="dropdown {{ request()->is('tentang') || request()->is('visi-misi') || request()->is('dkm*') || request()->is('struktur-organisasi') ? 'active' : '' }}" data-dropdown>
                    <button type="button" class="dropdown-toggle" data-dropdown-toggle aria-expanded="false">Tentang Kami</button>
                    <div class="dropdown-menu">
                        <a href="/tentang" class="dropdown-link {{ request()->is('tentang') ? 'active' : '' }}">Profil Masjid</a>
                        <a href="/visi-misi" class="dropdown-link {{ request()->is('visi-misi') ? 'active' : '' }}">Visi & Misi</a>
                        <a href="/dkm" class="dropdown-link {{ request()->is('dkm*') || request()->is('struktur-organisasi') ? 'active' : '' }}">Struktur DKM</a>
                    </div>
                </div>

                <div class="dropdown {{ request()->is('kajian*') || request()->is('pengumuman*') || request()->is('kas') || request()->is('jadwal-kajian') || request()->is('faq') ? 'active' : '' }}" data-dropdown>
                    <button type="button" class="dropdown-toggle" data-dropdown-toggle aria-expanded="false">Informasi</button>
                    <div class="dropdown-menu">
                        <a href="/kajian" class="dropdown-link {{ request()->is('kajian*') ? 'active' : '' }}">Kajian</a>
                        <a href="/pengumuman" class="dropdown-link {{ request()->is('pengumuman*') ? 'active' : '' }}">Pengumuman</a>
                        <a href="/kas" class="dropdown-link {{ request()->is('kas') || request()->is('kas*') ? 'active' : '' }}">Kas Masjid</a>
                        <a href="/jadwal-kajian" class="dropdown-link {{ request()->is('jadwal-kajian') ? 'active' : '' }}">Jadwal Kajian</a>
                        <a href="/faq" class="dropdown-link {{ request()->is('faq') ? 'active' : '' }}">FAQ</a>
                    </div>
                </div>
            </nav>

            <div class="nav-user">
                @auth
                    @if(auth()->user()->role == 'admin')
                        <div class="admin-section">
                            <a href="{{ route('admin.dashboard') }}" class="btn-admin">
                                <i class="fas fa-cog"></i>
                                <span>Admin</span>
                            </a>
                        </div>
                    @endif
                    <div class="user-section">
                        <div class="user-pill" title="{{ auth()->user()->name }}">
                            <span class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            <span class="user-name-text">{{ auth()->user()->name }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="logout-form">
                            @csrf
                            <button type="submit" class="btn-logout">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-auth">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Login</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>
    @endunless

    <main class="main-content @yield('main_class')">
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif
    </main>

    @unless(View::hasSection('hide_footer'))
        @include('components.footer')
    @endunless

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdowns = Array.from(document.querySelectorAll('[data-dropdown]'));
            if (!dropdowns.length) return;

            function closeDropdown(dropdown) {
                dropdown.classList.remove('open');
                const toggle = dropdown.querySelector('[data-dropdown-toggle]');
                if (toggle) toggle.setAttribute('aria-expanded', 'false');
            }

            function closeAll(except) {
                dropdowns.forEach((d) => {
                    if (except && d === except) return;
                    closeDropdown(d);
                });
            }

            dropdowns.forEach((dropdown) => {
                const toggle = dropdown.querySelector('[data-dropdown-toggle]');
                if (!toggle) return;

                toggle.addEventListener('click', function (event) {
                    event.preventDefault();
                    event.stopPropagation();

                    const willOpen = !dropdown.classList.contains('open');
                    closeAll();
                    if (willOpen) {
                        dropdown.classList.add('open');
                        toggle.setAttribute('aria-expanded', 'true');
                    } else {
                        closeDropdown(dropdown);
                    }
                });

                // Supaya konsisten saat "dilepas" (mouse keluar)
                dropdown.addEventListener('mouseleave', function () {
                    closeDropdown(dropdown);
                });
            });

            document.addEventListener('click', function (event) {
                const clickedInsideAny = dropdowns.some((d) => d.contains(event.target));
                if (!clickedInsideAny) closeAll();
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') closeAll();
            });
        });
    </script>
    
    <!-- Page Transitions JavaScript -->
    <script src="{{ asset('js/page-transitions.js') }}"></script>

    @stack('scripts')
</body>
</html>
