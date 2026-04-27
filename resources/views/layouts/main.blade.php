<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masjid Al-Hasanah</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            color: white;
            background: var(--green-deep);
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            z-index: -3;
            background-image:
                linear-gradient(180deg, rgba(4,41,31,0.42), rgba(4,41,31,0.86)),
                url('/images/masjid/Masjid1.jpg');
            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
        }

        body::after {
            content: "";
            position: fixed;
            inset: 0;
            z-index: -2;
            background:
                radial-gradient(circle at top center, rgba(255,255,255,0.16), transparent 38%),
                linear-gradient(180deg, rgba(255,255,255,0.14) 0%, rgba(4,41,31,0.06) 24%, rgba(4,41,31,0.9) 78%);
            pointer-events: none;
        }

        .topbar-wrap {
            position: sticky;
            top: 18px;
            z-index: 20;
            width: min(1180px, calc(100% - 32px));
            margin: 18px auto 0;
        }

        .topbar {
            min-height: 66px;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 18px;
            padding: 12px 16px 12px 22px;
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 999px;
            background: rgba(5,54,38,0.78);
            backdrop-filter: blur(18px);
            box-shadow: 0 18px 55px rgba(0,0,0,0.28);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: max-content;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.2px;
            color: var(--gold);
            text-decoration: none;
        }

        .logo-mark {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: var(--green-deep);
            background: linear-gradient(135deg, #ffe680, #f4c430);
            font-size: 16px;
        }

        .menu {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 4px;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .menu::-webkit-scrollbar {
            display: none;
        }

        .menu a {
            display: inline-flex;
            align-items: center;
            min-width: max-content;
            padding: 10px 13px;
            color: rgba(255,255,255,0.88);
            text-decoration: none;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            transition: 0.25s ease;
        }

        .menu a:hover {
            color: white;
            background: rgba(255,255,255,0.12);
            transform: translateY(-1px);
        }

        .menu a.active {
            color: var(--green-deep);
            background: linear-gradient(135deg, #ffe680, #f4c430);
            box-shadow: 0 8px 22px rgba(244,196,48,0.24);
        }

        .nav-user {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: max-content;
        }

        .user-name {
            max-width: 140px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 13px;
            color: var(--white-soft);
        }

        .logout form {
            margin: 0;
        }

        .logout button {
            border: none;
            padding: 10px 15px;
            border-radius: 999px;
            color: white;
            background: rgba(220,53,69,0.9);
            cursor: pointer;
            font-family: inherit;
            font-weight: 600;
            transition: 0.25s ease;
        }

        .logout button:hover {
            background: #dc3545;
            transform: translateY(-1px);
        }

        .page-hero {
            width: min(1180px, calc(100% - 32px));
            margin: 34px auto 0;
            min-height: 260px;
            display: flex;
            align-items: center;
            border-radius: 28px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.1);
            background:
                linear-gradient(90deg, rgba(3,32,24,0.92), rgba(4,41,31,0.56), rgba(4,41,31,0.26));
            background-size: cover;
            background-position: center;
            box-shadow: 0 24px 70px rgba(0,0,0,0.26);
        }

        .hero-content {
            max-width: 620px;
            padding: 48px;
        }

        .hero-kicker {
            margin: 0 0 10px;
            color: var(--gold);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        .hero-title {
            margin: 0;
            font-size: clamp(30px, 4vw, 48px);
            line-height: 1.05;
            font-weight: 700;
        }

        .hero-desc {
            margin: 14px 0 0;
            max-width: 540px;
            color: rgba(255,255,255,0.78);
            line-height: 1.7;
            font-size: 15px;
        }

        .content {
            width: min(1180px, calc(100% - 32px));
            margin: 24px auto 56px;
            padding: 28px;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            background: rgba(4,41,31,0.74);
            backdrop-filter: blur(14px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.18);
        }

        @media (max-width: 1100px) {
            .topbar {
                grid-template-columns: 1fr;
                border-radius: 28px;
                padding: 16px;
            }

            .logo,
            .nav-user {
                justify-content: center;
            }

            .menu {
                justify-content: flex-start;
                width: 100%;
                padding-bottom: 2px;
            }
        }

        @media (max-width: 640px) {
            .topbar-wrap,
            .page-hero,
            .content {
                width: min(100% - 20px, 1180px);
            }

            .topbar-wrap {
                top: 10px;
                margin-top: 10px;
            }

            .topbar {
                border-radius: 22px;
            }

            .menu a {
                padding: 9px 11px;
                font-size: 12px;
            }

            .nav-user {
                flex-wrap: wrap;
            }

            .page-hero {
                margin-top: 22px;
                min-height: 230px;
                border-radius: 22px;
            }

            .hero-content {
                padding: 30px 24px;
            }

            .content {
                padding: 18px;
                border-radius: 18px;
            }
        }
    </style>
</head>
<body>

<header class="topbar-wrap">
    <div class="topbar">

        <a href="/dashboard" class="logo">
            <span class="logo-mark">M</span>
            <span>Alhasanah App</span>
        </a>

        <nav class="menu" aria-label="Navigasi utama">
            <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <a href="/kajian" class="{{ request()->is('kajian*') ? 'active' : '' }}">
                Kajian
            </a>

            <a href="/rekomendasi" class="{{ request()->is('rekomendasi') ? 'active' : '' }}">
                Rekomendasi
            </a>

            <a href="/pengumuman" class="{{ request()->is('pengumuman*') ? 'active' : '' }}">
                Pengumuman
            </a>

            <a href="/dkm" class="{{ request()->is('dkm*') ? 'active' : '' }}">
                Anggota DKM
            </a>

            <a href="/struktur-organisasi" class="{{ request()->is('struktur-organisasi') ? 'active' : '' }}">
                Struktur Organisasi
            </a>

            <a href="/jadwal-kajian" class="{{ request()->is('jadwal-kajian') ? 'active' : '' }}">
                Jadwal Kajian
            </a>

            <a href="/donasi" class="{{ request()->is('donasi*') ? 'active' : '' }}">
                Donasi
            </a>

            <a href="/kontak" class="{{ request()->is('kontak') ? 'active' : '' }}">
                Kontak
            </a>

            <a href="/faq" class="{{ request()->is('faq') ? 'active' : '' }}">
                FAQ
            </a>

            <a href="/tentang" class="{{ request()->is('tentang') ? 'active' : '' }}">
                Tentang Kami
            </a>
        </nav>

        <div class="nav-user">
            <div class="user-name">
                {{ auth()->user()->name }}
            </div>

            <div class="logout">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>

    </div>
</header>

<section class="page-hero">
    <div class="hero-content">
        <p class="hero-kicker">Masjid Al-Hasanah</p>
        <h1 class="hero-title">
            Website Resmi Dewan Kemakmuran Masjid Al-Hasanah
        </h1>
        <p class="hero-desc">
            Kelola kajian, pengumuman, donasi, dan informasi masjid dalam tampilan dashboard yang lebih rapi dan modern.
        </p>
    </div>
</section>

<main class="content">
    @yield('content')
</main>

</body>
</html>
