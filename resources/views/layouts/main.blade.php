<!DOCTYPE html>
<html>
<head>
    <title>Kajian App</title>

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
        }

        .logo {
            font-weight:bold;
            margin-bottom:30px;
            color:#ffd700;
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

        .logout {
            margin-top:20px;
        }

        .logout button {
            background:red;
            border:none;
            padding:8px 12px;
            border-radius:6px;
            color:white;
            cursor:pointer;
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
    <div class="logo">🕌 Kajian App</div>

    <div class="menu">
        <a href="/dashboard">🏠 Dashboard</a>
        <a href="/kajian">📚 Kajian</a>
        <a href="/rekomendasi">🎯 Rekomendasi</a>
    </div>

    <hr>

    <div>
        👤 {{ auth()->user()->name }}
    </div>

    <div class="logout">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button>Logout</button>
        </form>
    </div>
</div>

<div class="content">
    @yield('content')
</div>

</body>
</html>
