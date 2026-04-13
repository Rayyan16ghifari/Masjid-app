<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Kajian App</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin:0;
            font-family:'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f5132, #198754);
        }

        .container-auth {
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .card-auth {
            background: rgba(255,255,255,0.95);
            padding:40px;
            border-radius:20px;
            width:420px;
            box-shadow:0 10px 30px rgba(0,0,0,0.2);
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from {opacity:0; transform:translateY(10px);}
            to {opacity:1; transform:translateY(0);}
        }

        .logo {
            text-align:center;
            margin-bottom:20px;
        }

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
            position:absolute;
            top:-6px;
            left:50%;
            transform:translateX(-50%);
            border-radius:50%;
        }

        .title {
            text-align:center;
            font-weight:600;
            margin-top:10px;
            margin-bottom:20px;
        }

        input {
            width:100%;
            padding:12px;
            margin-top:12px;
            border-radius:8px;
            border:1px solid #ddd;
        }

        button {
            width:100%;
            margin-top:15px;
            padding:12px;
            background:#198754;
            color:white;
            border:none;
            border-radius:10px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
        }

        button:hover {
            transform:scale(1.05);
        }

        .link {
            margin-top:12px;
            display:block;
            text-align:center;
            font-size:14px;
        }
    </style>
</head>

<body>

<div class="container-auth">

    <div class="card-auth">

        <!-- LOGO -->
        <div class="logo">
            <div class="dome"></div>
            <div class="title">🕌 Kajian App</div>
        </div>

        <!-- FORM -->
        {{ $slot }}

    </div>

</div>

</body>
</html>
