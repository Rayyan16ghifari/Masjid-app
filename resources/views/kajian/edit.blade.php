@extends('layouts.app')

@section('content')

<style>
body {
    background: linear-gradient(135deg, #0f5132, #198754);
    font-family: 'Poppins', sans-serif;
}

/* CONTAINER */
.container-form {
    min-height: 100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* CARD */
.card-form {
    background: rgba(0,0,0,0.4);
    backdrop-filter: blur(12px);
    padding:30px;
    border-radius:20px;
    width:500px;
    color:white;
    animation: fadeIn 0.7s ease;
}

@keyframes fadeIn {
    from {opacity:0; transform:translateY(10px);}
    to {opacity:1; transform:translateY(0);}
}

/* TITLE */
.card-form h2 {
    text-align:center;
    margin-bottom:20px;
}

/* INPUT */
.input-group {
    margin-bottom:15px;
}

.input-group label {
    font-size:13px;
    opacity:0.8;
}

.input-group input,
.input-group select {
    width:100%;
    padding:10px;
    margin-top:5px;
    border-radius:8px;
    border:none;
}

/* GRID */
.row {
    display:flex;
    gap:10px;
}

.row .input-group {
    flex:1;
}

/* BUTTON */
.btn {
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background: linear-gradient(145deg,#ffd700,#ffcc00);
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.btn:hover {
    transform: scale(1.05);
}

/* BACK */
.back {
    text-align:center;
    margin-top:10px;
}

.back a {
    color:#ddd;
    text-decoration:none;
    font-size:13px;
}
</style>

<div class="container-form">

    <div class="card-form">

        <h2>✏️ Edit Kajian</h2>

        <form action="/kajian/{{ $kajian->id }}" method="POST">
            @csrf
            @method('PUT')

            <div class="input-group">
                <label>Judul Kajian</label>
                <input type="text" name="judul" value="{{ $kajian->judul }}">
            </div>

            <div class="input-group">
                <label>Kategori</label>
                <select name="kategori">
                    @foreach($kategoriOptions as $kategori)
                    <option value="{{ $kategori }}" {{ $kajian->kategori == $kategori ? 'selected' : '' }}>
                        {{ $kategori }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="input-group">
                <label>Ustadz</label>
                <select name="ustadz_id">
                    @foreach($ustadz as $u)
                    <option value="{{ $u->id }}" {{ $kajian->ustadz_id == $u->id ? 'selected' : '' }}>
                        {{ $u->nama }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="input-group">
                <label>Kitab</label>
                <select name="kitab_id">
                    @foreach($kitab as $k)
                    <option value="{{ $k->id }}" {{ $kajian->kitab_id == $k->id ? 'selected' : '' }}>
                        {{ $k->nama }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="input-group">
                    <label>Hari</label>
                    <select name="hari">
                        <option value="Jumat" {{ $kajian->hari == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                        <option value="Minggu" {{ $kajian->hari == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>Pekan</label>
                    <input type="number" name="pekan" value="{{ $kajian->pekan }}">
                </div>
            </div>

            <div class="row">
                <div class="input-group">
                    <label>Waktu</label>
                    <input type="time" name="waktu" value="{{ $kajian->waktu }}">
                </div>

                <div class="input-group">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" value="{{ $kajian->lokasi }}">
                </div>
            </div>

            <!-- OPTIONAL IMAGE -->
            <div class="input-group">
                <label>Link Gambar (Opsional)</label>
                <input type="text" name="image" value="{{ $kajian->image }}">
            </div>

            <div class="input-group">
                <label>Deskripsi Singkat</label>
                <input type="text" name="deskripsi" value="{{ $kajian->deskripsi }}">
            </div>

            <button type="submit" class="btn">💾 Update Kajian</button>

        </form>

        <div class="back">
            <a href="/kajian">⬅ Kembali ke Kajian</a>
        </div>

    </div>

</div>

@endsection
