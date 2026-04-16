<!DOCTYPE html>
<html>
<head>
    <title>Masjid Al-Hasanah</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <style>
        body {
            margin:0;
            font-family:'Poppins', sans-serif;
            display:flex;
            background: linear-gradient(135deg, #0f5132, #198754);
            color:white;
        }

        /* SIDEBAR */
        .sidebar {
            width:230px;
            min-height:100vh;
            background:#062f22;
            padding:20px;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            overflow-y:auto;
        }

        .logo {
            font-weight:bold;
            margin-bottom:25px;
            color:#ffd700;
            font-size:18px;
        }

        .menu a {
            display:block;
            padding:10px;
            color:white;
            text-decoration:none;
            border-radius:8px;
            margin-bottom:10px;
            transition:0.3s;
        }

        .menu a:hover {
            background:#0f5132;
            transform:translateX(5px);
        }

        /* ACTIVE MENU */
        .active {
            background:#198754;
        }

        hr {
            border:0.5px solid rgba(255,255,255,0.2);
            margin:15px 0;
        }

        /* USER */
        .user {
            font-size:14px;
            opacity:0.8;
        }

        .logout button {
            background:red;
            border:none;
            padding:8px 12px;
            border-radius:6px;
            color:white;
            cursor:pointer;
            margin-top:10px;
        }

        /* CONTENT */
        .content {
            flex:1;
            padding:30px;
        }
    </style>
</head>

<body>

<div class="sidebar">

    <!-- TOP MENU -->
    <div>

        <div class="logo">🕌 Alhasanah App</div>

        <div class="menu">

            <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                🏠 Dashboard
            </a>

            <a href="/kajian" class="{{ request()->is('kajian*') ? 'active' : '' }}">
                📚 Kajian
            </a>

            <a href="/rekomendasi" class="{{ request()->is('rekomendasi') ? 'active' : '' }}">
                🎯 Rekomendasi
            </a>

            <a href="/pengumuman" class="{{ request()->is('pengumuman*') ? 'active' : '' }}">
                📢 Pengumuman
            </a>

            <a href="/dkm" class="{{ request()->is('dkm*') ? 'active' : '' }}">
                👥 Anggota DKM
            </a>

            <a href="/struktur-organisasi" class="{{ request()->is('struktur-organisasi') ? 'active' : '' }}">
                Struktur Organisasi
            </a>

            <a href="/jadwal-kajian" class="{{ request()->is('jadwal-kajian') ? 'active' : '' }}">
                Jadwal Kajian
            </a>

            <a href="/donasi" class="{{ request()->is('donasi*') ? 'active' : '' }}">
                🧾 Donasi
            </a>

            <a href="/kontak" class="{{ request()->is('kontak') ? 'active' : '' }}">
                Kontak
            </a>

            <a href="/faq" class="{{ request()->is('faq') ? 'active' : '' }}">
                FAQ
            </a>

            <a href="/tentang" class="{{ request()->is('tentang') ? 'active' : '' }}">
                ℹ️ Tentang Kami
            </a>

        </div>

    </div>

    <!-- BOTTOM USER -->
    <div>

        <hr>

        <div class="user">
            👤 {{ auth()->user()->name }}
        </div>

        <div class="logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button>Logout</button>
            </form>
        </div>

    </div>

</div>

<div class="content">
    @yield('content')
</div>

</body>
</html>
