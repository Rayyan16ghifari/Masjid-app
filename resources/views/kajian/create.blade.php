<!DOCTYPE html>
<html>
<head>
    <title>Tambah Kajian</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f4f6f9;
        }

        /* NAVBAR */
        .navbar {
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:15px 40px;
            background:white;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        }

        .nav-left {
            font-weight:600;
            color:#198754;
        }

        .nav-center {
            flex:1;
            display:flex;
            justify-content:center;
            gap:30px;
        }

        .nav-center a {
            text-decoration:none;
            color:#333;
            font-size:14px;
            font-weight:500;
            position:relative;
        }

        .nav-center a::after {
            content:'';
            position:absolute;
            width:0%;
            height:2px;
            bottom:-5px;
            left:0;
            background:#198754;
            transition:0.3s;
        }

        .nav-center a:hover::after {
            width:100%;
        }

        .nav-right button {
            background:#198754;
            color:white;
            border:none;
            padding:8px 14px;
            border-radius:20px;
            cursor:pointer;
        }

        /* CONTAINER */
        .wrapper {
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:90vh;
        }

        .card {
            background:white;
            width:450px;
            padding:30px;
            border-radius:15px;
            box-shadow:0 10px 30px rgba(0,0,0,0.08);
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from {opacity:0; transform:translateY(10px);}
            to {opacity:1; transform:translateY(0);}
        }

        h2 {
            text-align:center;
            margin-bottom:20px;
            color:#198754;
        }

        label {
            font-size:13px;
            font-weight:500;
            display:block;
            margin-top:10px;
        }

        input, select {
            width:100%;
            padding:10px;
            margin-top:5px;
            border-radius:8px;
            border:1px solid #ddd;
            outline:none;
            transition:0.3s;
        }

        input:focus, select:focus {
            border-color:#198754;
            box-shadow:0 0 0 2px rgba(25,135,84,0.2);
        }

        .btn {
            width:100%;
            margin-top:20px;
            padding:12px;
            background:#198754;
            color:white;
            border:none;
            border-radius:10px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
        }

        .btn:hover {
            transform:translateY(-2px);
            box-shadow:0 10px 20px rgba(0,0,0,0.1);
        }

        .back {
            text-align:center;
            margin-top:15px;
        }

        .back a {
            font-size:13px;
            color:#666;
            text-decoration:none;
        }

    </style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">

    <!-- LEFT -->
    <div class="nav-left">🕌 Kajian App</div>

    <!-- CENTER -->
    <div class="nav-center">
        <a href="/dashboard">Dashboard</a>
        <a href="/kajian">Kajian</a>
        <a href="/rekomendasi">Rekomendasi</a>
    </div>

    <!-- RIGHT -->
    <div class="nav-right">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button>Logout</button>
        </form>
    </div>

</div>

<!-- FORM -->
<div class="wrapper">

    <div class="card">

        <h2>➕ Tambah Kajian</h2>

        <form action="/kajian" method="POST">
            @csrf

            <label>Judul</label>
            <input type="text" name="judul" placeholder="Masukkan judul kajian" required>

            <label>Kategori</label>
            <select name="kategori" required>
                @foreach($kategoriOptions as $kategori)
                    <option value="{{ $kategori }}" {{ old('kategori') === $kategori ? 'selected' : '' }}>
                        {{ $kategori }}
                    </option>
                @endforeach
            </select>

            <label>Ustadz</label>
            <select name="ustadz_id">
                @foreach($ustadz as $u)
                    <option value="{{ $u->id }}">{{ $u->nama }}</option>
                @endforeach
            </select>

            <label>Kitab</label>
            <select name="kitab_id">
                @foreach($kitab as $k)
                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                @endforeach
            </select>

            <label>Hari</label>
            <select name="hari">
                <option>Jumat</option>
                <option>Minggu</option>
            </select>

            <label>Pekan</label>
            <input type="number" name="pekan" min="1" max="4">

            <label>Waktu</label>
            <input type="time" name="waktu">

            <label>Lokasi</label>
            <input type="text" name="lokasi">

            <label>Link Gambar</label>
            <input type="text" name="image" placeholder="https://...">

            <label>Deskripsi Singkat</label>
            <input type="text" name="deskripsi" placeholder="Ringkasan tema kajian">

            <button type="submit" class="btn">Simpan Kajian</button>

        </form>

        <div class="back">
            <a href="/kajian">← Kembali</a>
        </div>

    </div>

</div>

</body>
</html>
