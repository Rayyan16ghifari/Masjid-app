<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body {
            height:100vh;
            display:flex;
            background:#f4f6f9;
        }

        /* LEFT SIDE */
        .left {
            flex:1;
            background: linear-gradient(135deg, #0f5132, #198754);
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            color:white;
            padding:40px;
            text-align:center;
        }

        .left h1 {
            font-size:42px;
            margin-bottom:10px;
        }

        .left p {
            opacity:0.8;
            margin-bottom:25px;
        }

        .left a {
            border:2px solid white;
            padding:10px 25px;
            border-radius:10px;
            text-decoration:none;
            color:white;
            transition:0.3s;
        }

        .left a:hover {
            background:white;
            color:#0f5132;
        }

        /* RIGHT SIDE */
        .right {
            flex:1;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .card {
            width:380px;
            background:white;
            padding:35px;
            border-radius:20px;
            box-shadow:0 10px 30px rgba(0,0,0,0.1);
            text-align:center;
            animation:fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from {opacity:0; transform:translateY(10px);}
            to {opacity:1; transform:translateY(0);}
        }

        /* KUBAH */
        .dome {
            width:80px;
            height:50px;
            background:#ffd700;
            border-radius:80px 80px 0 0;
            margin:auto;
            position:relative;
        }

        .dome::after {
            content:"";
            width:12px;
            height:12px;
            background:#ffd700;
            border-radius:50%;
            position:absolute;
            top:-6px;
            left:50%;
            transform:translateX(-50%);
        }

        h2 {
            margin-top:15px;
            margin-bottom:20px;
            color:#0f5132;
        }

        input {
            width:100%;
            padding:12px;
            margin-bottom:12px;
            border-radius:8px;
            border:1px solid #ddd;
            transition:0.3s;
        }

        input:focus {
            outline:none;
            border-color:#198754;
            box-shadow:0 0 5px rgba(25,135,84,0.3);
        }

        button {
            width:100%;
            padding:12px;
            background:#ffd700;
            border:none;
            border-radius:10px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
        }

        button:hover {
            transform:scale(1.05);
        }

        .register {
            margin-top:15px;
            font-size:14px;
        }

        .register a {
            color:#198754;
            text-decoration:none;
            font-weight:500;
        }

        .error {
            background:#ffe5e5;
            color:#c00;
            padding:10px;
            border-radius:8px;
            margin-bottom:12px;
            font-size:13px;
        }

        /* MOBILE */
        @media(max-width:900px){
            body {
                flex-direction:column;
            }
            .left {
                display:none;
            }
        }
    </style>
</head>

<body>

<!-- LEFT -->
<div class="left">
    <h1>Selamat Datang 👋</h1>
    <p>Masuk untuk melanjutkan ke Kajian App</p>
    <a href="{{ route('register') }}">Buat Akun</a>
</div>

<!-- RIGHT -->
<div class="right">

    <div class="card">

        <div class="dome"></div>
        <h2>Login Kajian</h2>

        <!-- ERROR -->
        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Masuk</button>
        </form>

        <div class="register">
            Belum punya akun?
            <a href="{{ route('register') }}">Daftar</a>
        </div>

    </div>

</div>

</body>
</html>
