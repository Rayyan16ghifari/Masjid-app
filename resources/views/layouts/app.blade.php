<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            /* Menggunakan Plus Jakarta Sans sebagai font utama */
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f4f6f9;
            color: #333;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px; /* Sedikit diperlebar agar font bernafas */
            background: #0b3d2e;
            color: white;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 4px 0px 10px rgba(0,0,0,0.1);
        }

        .sidebar h2 {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 30px;
            padding-left: 10px;
        }

        /* MENU LINK STYLING */
        .menu-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin-bottom: 8px;
            border-radius: 10px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-weight: 500; /* Medium weight untuk kesan elegan */
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .menu-link:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            transform: translateX(5px); /* Efek geser sedikit saat hover */
        }

        /* Memberikan warna berbeda untuk icon emoji agar tetap kontras */
        .menu-link span {
            margin-right: 12px;
        }

        /* USER SECTION */
        .user-section {
            padding: 20px;
            background: rgba(0,0,0,0.2);
            border-radius: 12px;
            font-size: 0.9rem;
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
            color: white;
            border: none;
            padding: 8px;
            border-radius: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-logout:hover {
            background: #c0392b;
        }

        .main {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }
    </style>
</head>

<body>

<div class="wrapper">

    <div class="sidebar">

        <div>
            <h2 style="color:#ffd700;">🕌 Al-Hasanah App</h2>

            <nav>
                <a href="/dashboard" class="menu-link"><span>📊</span> Dashboard</a>
                <a href="/kajian" class="menu-link"><span>📚</span> Kajian</a>
                <a href="/rekomendasi" class="menu-link"><span>🎯</span> Rekomendasi</a>
                <a href="/dkm" class="menu-link"><span>👥</span> Anggota DKM</a>
            </nav>
        </div>

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

    <main class="main">
        {{ $slot }}
    </main>

</div>

</body>
</html>
