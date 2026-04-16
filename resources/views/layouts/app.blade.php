<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Al-Hasanah App') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f4f6f9;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: #0b3d2e;
            color: white;
            padding: 25px 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow-y: auto;
        }

        .sidebar h2 {
            font-size: 20px;
            margin-bottom: 25px;
            padding-left: 10px;
        }

        /* MENU */
        .menu-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin-bottom: 6px;
            border-radius: 10px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .menu-link:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
            transform: translateX(5px);
        }

        .menu-link span {
            margin-right: 10px;
        }

        /* ACTIVE MENU */
        .menu-link.active {
            background: #198754;
            color: #fff;
        }

        /* USER */
        .user-section {
            padding: 15px;
            background: rgba(0,0,0,0.25);
            border-radius: 12px;
        }

        .user-name {
            display: block;
            font-weight: 600;
            margin-bottom: 10px;
            color: #ffd700;
        }

        .btn-logout {
            width: 100%;
            background: #e74c3c;
            border: none;
            padding: 8px;
            border-radius: 8px;
            color: white;
            cursor: pointer;
        }

        .btn-logout:hover {
            background: #c0392b;
        }

        /* MAIN */
        .main {
            flex: 1;
            padding: 30px;
        }
    </style>
</head>

<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div>
            <h2 style="color:#ffd700;">🕌 Al-Hasanah</h2>

            <nav>
                <a href="/dashboard" class="menu-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <span>📊</span> Dashboard
                </a>

                <a href="/kajian" class="menu-link {{ request()->is('kajian*') ? 'active' : '' }}">
                    <span>📚</span> Kajian
                </a>

                <a href="/rekomendasi" class="menu-link {{ request()->is('rekomendasi') ? 'active' : '' }}">
                    <span>🎯</span> Rekomendasi
                </a>

                <a href="/pengumuman" class="menu-link {{ request()->is('pengumuman*') ? 'active' : '' }}">
                    <span>📢</span> Pengumuman
                </a>

                <a href="/donasi" class="menu-link {{ request()->is('donasi*') ? 'active' : '' }}">
                    <span>🧾</span> Donasi
                </a>

                <a href="/dkm" class="menu-link {{ request()->is('dkm*') ? 'active' : '' }}">
                    <span>👥</span> Anggota DKM
                </a>

                <a href="/struktur-organisasi" class="menu-link {{ request()->is('struktur-organisasi') ? 'active' : '' }}">
                    <span>🏛️</span> Struktur
                </a>

                <a href="/jadwal-kajian" class="menu-link {{ request()->is('jadwal-kajian') ? 'active' : '' }}">
                    <span>🗓️</span> Jadwal Kajian
                </a>

                <a href="/kontak" class="menu-link {{ request()->is('kontak') ? 'active' : '' }}">
                    <span>📞</span> Kontak
                </a>

                <a href="/faq" class="menu-link {{ request()->is('faq') ? 'active' : '' }}">
                    <span>❓</span> FAQ
                </a>

                <a href="/tentang" class="menu-link {{ request()->is('tentang') ? 'active' : '' }}">
                    <span>ℹ️</span> Tentang Kami
                </a>
            </nav>
        </div>

        <!-- USER -->
        <div class="user-section">
            <span class="user-name">👤 {{ auth()->user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    Logout
                </button>
            </form>
        </div>

    </div>

    <!-- MAIN CONTENT -->
    <main class="main">
        @yield('content')
    </main>

</div>

</body>
</html>
