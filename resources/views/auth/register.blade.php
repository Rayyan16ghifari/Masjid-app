<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    height:100vh;
    display:flex;
}

/* LEFT */
.left{
    flex:1;
    background: linear-gradient(135deg,#0f5132,#198754);
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    color:white;
    padding:40px;
}

.left h1{
    font-size:38px;
    margin-bottom:10px;
}

.left p{
    opacity:0.8;
    margin-bottom:20px;
}

.left a{
    border:1px solid white;
    padding:10px 20px;
    border-radius:10px;
    text-decoration:none;
    color:white;
    transition:0.3s;
}

.left a:hover{
    background:white;
    color:#0f5132;
}

/* RIGHT */
.right{
    flex:1;
    background:#f4f6f9;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* CARD */
.card{
    width:420px;
    background:white;
    padding:35px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    text-align:center;
}

/* KUBAH */
.dome{
    width:90px;
    height:55px;
    background:gold;
    border-radius:90px 90px 0 0;
    margin:auto;
    position:relative;
}

.dome::after{
    content:"";
    width:14px;
    height:14px;
    background:gold;
    border-radius:50%;
    position:absolute;
    top:-7px;
    left:50%;
    transform:translateX(-50%);
}

/* TITLE */
h2{
    margin-top:12px;
    margin-bottom:20px;
}

/* INPUT */
input{
    width:100%;
    padding:12px;
    margin-bottom:12px;
    border-radius:10px;
    border:1px solid #ddd;
    outline:none;
    transition:0.2s;
}

input:focus{
    border-color:#198754;
}

/* ERROR */
.error{
    text-align:left;
    font-size:12px;
    color:red;
    margin-bottom:8px;
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    background:gold;
    border:none;
    border-radius:10px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    transform:scale(1.05);
}

/* LOGIN */
.login{
    margin-top:12px;
    font-size:14px;
}

.login a{
    color:#198754;
    text-decoration:none;
    font-weight:500;
}

/* RESPONSIVE */
@media(max-width:900px){
    body{
        flex-direction:column;
    }

    .left{
        display:none;
    }

    .card{
        width:90%;
    }
}
</style>
</head>

<body>

<!-- LEFT -->
<div class="left">
    <h1>Selamat Datang 👋</h1>
    <p>Sudah punya akun?</p>
    <a href="{{ route('login') }}">Login</a>
</div>

<!-- RIGHT -->
<div class="right">

    <div class="card">

        <div class="dome"></div>
        <h2>Buat Akun</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- NAME -->
            <input type="text" name="name" placeholder="Nama" value="{{ old('name') }}">
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror

            <!-- EMAIL -->
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <!-- PASSWORD -->
            <input type="password" name="password" placeholder="Password">
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <!-- CONFIRM -->
            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password">

            <button type="submit">Daftar</button>
        </form>

        <div class="login">
            Sudah punya akun?
            <a href="{{ route('login') }}">Login</a>
        </div>

    </div>

</div>

</body>
</html>
