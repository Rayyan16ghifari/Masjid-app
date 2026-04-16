@extends('layouts.main')

@section('content')

<style>
.main {
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:90vh;
    background:#f4f6f9;
    padding:20px;
    font-family:'Segoe UI', sans-serif;
}

/* CARD */
.card-about {
    max-width:800px;
    width:100%;
    background:white;
    border-radius:25px;
    box-shadow:0 20px 50px rgba(0,0,0,0.1);
    padding:40px;
    position:relative;
    overflow:hidden;
    animation:fadeIn 0.6s ease;
}

/* TOP BORDER */
.card-about::before {
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:6px;
    background:linear-gradient(90deg,#20c997,#198754);
}

/* ANIMATION */
@keyframes fadeIn {
    from {opacity:0; transform:translateY(15px);}
    to {opacity:1; transform:translateY(0);}
}

/* LOGO */
.logo {
    width:90px;
    height:90px;
    border-radius:50%;
    object-fit:cover;
    margin:auto;
    display:block;
    margin-bottom:15px;
}

/* TITLE */
.title {
    text-align:center;
}

.title h1 {
    font-size:24px;
    font-weight:700;
    color:#198754;
}

.subtitle {
    font-size:12px;
    letter-spacing:2px;
    color:#20c997;
    font-weight:600;
    margin-top:5px;
}

/* CONTENT */
.content {
    margin-top:25px;
    font-size:15px;
    line-height:1.8;
    color:#444;
    text-align:justify;
}

/* BOX HIGHLIGHT */
.highlight {
    background:#e9f7ef;
    padding:20px;
    border-left:5px solid #198754;
    border-radius:10px;
    margin:20px 0;
}

/* FOOTER */
.footer {
    text-align:center;
    margin-top:25px;
    padding-top:20px;
    border-top:1px solid #eee;
    font-size:13px;
    font-weight:600;
    color:#888;
}
</style>

<div class="main">

    <div class="card-about">

        <!-- LOGO -->
        <img src="{{ asset('images/masjid/Masjid1.jpg') }}" class="logo">

        <!-- TITLE -->
        <div class="title">
            <h1>Masjid Al-Hasanah</h1>
            <div class="subtitle">KOMPLEK PUSKOMLEKAD</div>
        </div>

        <!-- CONTENT -->
        <div class="content">

            <p>
                <strong>Masjid Al-Hasanah</strong> bermula dari sebuah tempat ibadah sederhana yang berdiri di lingkungan komplek Pushubad (Pusat Perhubungan Angkatan Darat), Kalisari, Pasar Rebo. Meski berawal dari skala yang kecil, masjid ini tumbuh dengan semangat besar dan dukungan warga sekitar untuk menjadi sarana pembinaan umat yang berlandaskan Al-Qur'an dan Sunnah. Seiring waktu, Masjid Al-Hasanah tidak hanya berfungsi sebagai tempat shalat, tetapi juga berkembang menjadi ruang edukasi dan pemberdayaan masyarakat.
                        Dengan berlandaskan nilai-nilai Al-Qur’an dan Sunnah, Masjid Al-Hasanah secara konsisten menghadirkan berbagai kegiatan keislaman, mulai dari kajian ilmiah, pembinaan generasi muda, hingga program sosial kemasyarakatan. Komitmen ini menjadikan masjid sebagai pusat peradaban kecil yang berperan aktif dalam meningkatkan kualitas spiritual dan kesejahteraan masyarakat sekitar.
                        Melalui langkah yang berkesinambungan, Masjid Al-Hasanah terus berupaya menjadi simbol dakwah yang inklusif, inspiratif, dan berdampak nyata bagi umat
                        </p>

            <div class="highlight">
                <b>Visi:</b><br>
                Menjadi pusat dakwah Islam yang unggul dalam pembinaan umat berbasis ilmu dan teknologi.
            </div>

            <p>
                Kami secara aktif menyelenggarakan kajian rutin yang menghadirkan para ustadz
                terpercaya serta materi yang sesuai dengan Al-Qur’an dan Sunnah.
            </p>

            <div class="highlight">
                <b>Misi:</b><br>
                • Menyediakan kajian berkualitas <br>
                • Meningkatkan literasi Islam <br>
                • Memanfaatkan teknologi untuk dakwah <br>
                • Membangun komunitas islami yang kuat
            </div>

            <p>
                Sistem ini juga dilengkapi dengan teknologi rekomendasi berbasis AI untuk membantu
                jamaah menemukan kajian yang sesuai dengan minat dan kebutuhannya secara lebih efektif.
            </p>

            <p>
                Dengan adanya platform ini, diharapkan masjid dapat menjadi pusat pembelajaran digital
                yang modern dan mudah diakses oleh seluruh kalangan masyarakat.
            </p>

        </div>

        <!-- FOOTER -->
        <div class="footer">
            🕌 <i>Copyright © Masjid Al-Hasanah 2026</i>
        </div>

    </div>

</div>

@endsection
