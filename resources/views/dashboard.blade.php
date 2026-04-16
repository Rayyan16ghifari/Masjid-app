@extends('layouts.main')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap');

* { box-sizing: border-box; }

/* ══ BACKGROUND ══ */
.db-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    min-height: 100vh;
    position: relative;
    overflow: hidden;
    background: #0a2e1f;
}
.db-bg {
    position: absolute; inset: 0; z-index: 0;
    background:
        radial-gradient(ellipse 80% 60% at 10% 0%,   rgba(29,158,117,0.18) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 90% 100%, rgba(8,80,65,0.30)    0%, transparent 55%),
        radial-gradient(ellipse 50% 40% at 50% 50%,  rgba(15,110,86,0.08)  0%, transparent 70%),
        linear-gradient(160deg, #0d3322 0%, #0a2219 40%, #071a14 100%);
}
.db-grid-tex {
    position: absolute; inset: 0; z-index: 0;
    background-image:
        linear-gradient(rgba(29,158,117,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(29,158,117,0.04) 1px, transparent 1px);
    background-size: 48px 48px;
}
.orb { position: absolute; border-radius: 50%; filter: blur(80px); z-index: 0; pointer-events: none; }
.orb1 { width:500px; height:500px; background:rgba(29,158,117,0.12); top:-120px; left:-100px; }
.orb2 { width:400px; height:400px; background:rgba(8,80,65,0.20);    bottom:-80px; right:-60px; }
.orb3 { width:300px; height:300px; background:rgba(255,215,0,0.05);  top:40%; left:50%; }
.db { position: relative; z-index: 1; padding: 36px 32px; }

/* ══ HERO ══ */
.hero {
    border-radius: 24px;
    overflow: hidden;
    position: relative;
    /* Tinggi diperbesar agar foto masjid tidak terpotong */
    height: 400px;
    margin-bottom: 40px;
    border: 1px solid rgba(29,158,117,0.3);
}
.hero-photo {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    /* Geser ke bawah sedikit agar bangunan masjid terlihat penuh */
    object-position: center 55%;
    display: block;
}
/* Overlay kiri gelap → kanan transparan */
.hero-overlay-dark {
    position: absolute; inset: 0;
    background: linear-gradient(
        100deg,
        rgba(3,14,8,  0.95) 0%,
        rgba(5,38,22, 0.88) 32%,
        rgba(8,65,42, 0.68) 55%,
        rgba(10,80,52,0.28) 75%,
        rgba(10,80,52,0.05) 100%
    );
}
/* Gradasi bawah supaya foto melebur ke konten */
.hero-overlay-bottom {
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 90px;
    background: linear-gradient(transparent, rgba(3,14,8,0.5));
}
.hero-shimmer {
    position: absolute; inset: 0;
    background-image:
        radial-gradient(circle at 12% 88%, rgba(255,215,0,0.06) 0%, transparent 35%),
        radial-gradient(circle at 88% 12%, rgba(255,255,255,0.03) 0%, transparent 40%);
}
.hero::after {
    content: ''; position: absolute; inset: 0; z-index: 2;
    border-radius: 24px;
    border: 1px solid rgba(29,158,117,0.18);
    pointer-events: none;
}
.hero-overlay {
    position: absolute; inset: 0; z-index: 1;
    display: flex; align-items: center; gap: 36px;
    padding: 48px 52px;
}
.hero-mosque-wrap {
    flex-shrink: 0;
    display: flex; flex-direction: column; align-items: center; gap: 10px;
}
.hero-mosque {
    width: 88px; height: 88px; border-radius: 50%;
    border: 2px solid rgba(255,215,0,0.35);
    background: rgba(0,0,0,0.4);
    backdrop-filter: blur(8px);
    display: flex; align-items: center; justify-content: center;
    font-size: 38px;
}
.hero-est {
    font-size: 15px; font-weight: 600; letter-spacing: 2px;
    color: rgba(255,215,0,0.65); text-align: center;
    font-family: 'Playfair Display', serif;
}
.hero-text { color: white; flex: 1; }
.hero-eyebrow {
    font-size: 11px; font-weight: 600; letter-spacing: 2.5px;
    text-transform: uppercase; color: #9FE1CB; margin-bottom: 10px;
    display: flex; align-items: center; gap: 8px;
}
.hero-eyebrow::before {
    content: ''; display: inline-block;
    width: 6px; height: 6px; border-radius: 50%;
    background: #1D9E75; flex-shrink: 0;
}
.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: 28px; font-weight: 700; line-height: 1.28;
    margin-bottom: 10px; text-shadow: 0 2px 20px rgba(0,0,0,0.5);
}
.hero-sub {
    font-size: 13px; color: rgba(255,255,255,0.68);
    line-height: 1.78; margin-bottom: 20px; max-width: 460px;
}
.hero-divider {
    width: 40px; height: 2px;
    background: linear-gradient(90deg, #FFD700, transparent);
    border-radius: 2px; margin-bottom: 18px;
}
.hero-stats { display: flex; gap: 28px; margin-bottom: 22px; }
.hstat-num {
    font-size: 22px; font-weight: 700; color: #FFD700;
    font-family: 'Playfair Display', serif; line-height: 1;
}
.hstat-lbl { font-size: 11px; color: rgba(255,255,255,0.5); margin-top: 4px; }
.hero-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 24px; background: #FFD700; color: #071a14;
    font-size: 13px; font-weight: 700; border-radius: 20px;
    text-decoration: none; letter-spacing: 0.3px;
    transition: opacity 0.2s, transform 0.2s;
}
.hero-btn:hover { opacity: 0.88; transform: translateY(-1px); text-decoration: none; color: #071a14; }

/* ══ ADMIN STATS ══ */
.admin-stat-wrap { margin-bottom: 44px; }
.admin-stat-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; }
.admin-stat-card {
    padding: 20px;
    border-radius: 20px;
    background: rgba(13,51,34,0.72);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(29,158,117,0.2);
    box-shadow: 0 18px 40px rgba(0,0,0,0.16);
}
.admin-stat-card small {
    display: block;
    margin-bottom: 10px;
    font-size: 11px;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: rgba(159,225,203,0.56);
}
.admin-stat-card strong {
    display: block;
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    line-height: 1.1;
    color: #FFD700;
}
.admin-stat-card span {
    display: block;
    margin-top: 8px;
    font-size: 12px;
    line-height: 1.7;
    color: rgba(159,225,203,0.58);
}

/* ══ SECTION HEADER ══ */
.sec-head { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; }
.sec-label { font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 700; color: #9FE1CB; white-space: nowrap; }
.sec-badge { font-size: 10px; font-weight: 600; padding: 3px 10px; background: rgba(29,158,117,0.18); color: #5DCAA5; border-radius: 20px; border: 1px solid rgba(29,158,117,0.25); white-space: nowrap; }
.sec-line { flex: 1; height: 1px; background: rgba(29,158,117,0.18); }

/* ══ GALLERY ══ */
.gallery-wrap { position: relative; margin-bottom: 44px; }
.gallery-track { display: flex; gap: 16px; overflow-x: auto; scroll-behavior: smooth; padding-bottom: 6px; scrollbar-width: none; }
.gallery-track::-webkit-scrollbar { display: none; }
.gallery-slide { flex: 0 0 270px; height: 175px; border-radius: 16px; overflow: hidden; position: relative; cursor: pointer; background: rgba(15,110,86,0.3); border: 1px solid rgba(29,158,117,0.2); transition: border-color 0.25s, transform 0.25s; }
.gallery-slide:hover { border-color: rgba(29,158,117,0.55); transform: translateY(-3px); }
.gallery-slide img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.35s; }
.gallery-slide:hover img { transform: scale(1.06); }
.gallery-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 44px; }
.gallery-cap { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(4,20,12,0.92)); color: rgba(255,255,255,0.92); padding: 30px 14px 12px; font-size: 12px; font-weight: 500; }
.gal-arrow { position: absolute; top: 50%; transform: translateY(-50%); width: 36px; height: 36px; border-radius: 50%; background: rgba(10,46,31,0.92); border: 1px solid rgba(29,158,117,0.35); display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 2; font-size: 18px; color: #9FE1CB; transition: background 0.2s; line-height: 1; }
.gal-arrow:hover { background: rgba(29,158,117,0.28); }
.gal-prev { left: -14px; }
.gal-next { right: -14px; }

/* ══ DKM GRID ══ */
.dkm-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 16px; margin-bottom: 44px; }
.dkm-card { background: rgba(13,51,34,0.7); backdrop-filter: blur(8px); border-radius: 18px; overflow: hidden; text-decoration: none; color: inherit; border: 1px solid rgba(29,158,117,0.2); transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s; }
.dkm-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(0,0,0,0.35); border-color: rgba(29,158,117,0.48); text-decoration: none; }
.dkm-card-top { background: linear-gradient(135deg, #064030 0%, #0F6E56 50%, #1D9E75 100%); height: 58px; position: relative; }
.dkm-avatar { position: absolute; bottom: -26px; left: 50%; transform: translateX(-50%); width: 52px; height: 52px; border-radius: 50%; border: 3px solid #0a2e1f; object-fit: cover; }
.dkm-avatar-init { position: absolute; bottom: -26px; left: 50%; transform: translateX(-50%); width: 52px; height: 52px; border-radius: 50%; border: 3px solid #0a2e1f; background: #0F6E56; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 700; color: white; font-family: 'Playfair Display', serif; }
.dkm-body { padding: 34px 12px 18px; text-align: center; }
.dkm-nama { font-size: 13px; font-weight: 600; color: #9FE1CB; margin-bottom: 3px; line-height: 1.4; }
.dkm-jab { font-size: 11px; color: rgba(159,225,203,0.5); margin-bottom: 10px; }
.dkm-chip { font-size: 10px; font-weight: 600; padding: 3px 12px; background: rgba(29,158,117,0.15); color: #5DCAA5; border-radius: 20px; border: 1px solid rgba(29,158,117,0.2); }
.dkm-card-more { display: flex; align-items: center; justify-content: center; min-height: 144px; border-style: dashed !important; color: #5DCAA5; font-size: 13px; font-weight: 600; }

/* ══ JADWAL SHOLAT — UPGRADE UI ══ */
.jadwal-wrap { margin-bottom: 44px; }
.jadwal-card {
    background: rgba(13,51,34,0.75);
    backdrop-filter: blur(12px);
    border-radius: 20px;
    border: 1px solid rgba(29,158,117,0.25);
    overflow: hidden;
    position: relative;
}
/* Strip atas bercahaya */
.jadwal-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, #1D9E75 30%, #FFD700 50%, #1D9E75 70%, transparent);
}
/* Header */
.jadwal-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 18px 24px 14px;
    border-bottom: 1px solid rgba(29,158,117,0.15);
    flex-wrap: wrap; gap: 10px;
}
.jadwal-header-left { display: flex; align-items: center; gap: 12px; }
.jadwal-icon-wrap {
    width: 40px; height: 40px; border-radius: 10px;
    background: rgba(29,158,117,0.18); border: 1px solid rgba(29,158,117,0.25);
    display: flex; align-items: center; justify-content: center; font-size: 20px;
}
.jadwal-title { font-family: 'Playfair Display', serif; font-size: 16px; font-weight: 700; color: #9FE1CB; }
.jadwal-subtitle { font-size: 11px; color: rgba(159,225,203,0.45); margin-top: 2px; }
.jadwal-date-pill {
    display: flex; align-items: center; gap: 7px;
    font-size: 11px; font-weight: 600; color: #5DCAA5;
    background: rgba(29,158,117,0.15); border: 1px solid rgba(29,158,117,0.22);
    padding: 6px 14px; border-radius: 20px;
}
.jadwal-dot {
    width: 6px; height: 6px; border-radius: 50%; background: #1D9E75;
    animation: pdot 2s infinite;
}
@keyframes pdot { 0%,100%{opacity:1} 50%{opacity:0.25} }

/* Grid 5 waktu */
.jadwal-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    padding: 8px 10px 10px;
    gap: 6px;
}
.jadwal-item {
    display: flex; flex-direction: column; align-items: center; gap: 7px;
    padding: 18px 8px; border-radius: 14px; position: relative;
    transition: background 0.2s, border-color 0.2s;
    border: 1px solid transparent;
    cursor: default;
}
.jadwal-item:hover { background: rgba(29,158,117,0.08); }
/* Garis pemisah vertikal */
.jadwal-item + .jadwal-item::after {
    content: ''; position: absolute; left: -3px; top: 18%; bottom: 18%;
    width: 1px; background: rgba(29,158,117,0.12);
}
/* Waktu aktif */
.jadwal-item.aktif {
    background: rgba(29,158,117,0.13);
    border-color: rgba(29,158,117,0.28);
}
.jadwal-item.aktif + .jadwal-item::after { display: none; }

.jadwal-waktu-icon { font-size: 22px; line-height: 1; }
.jadwal-waktu-nama {
    font-size: 10px; font-weight: 600; letter-spacing: 1px;
    color: rgba(159,225,203,0.5); text-transform: uppercase;
}
.jadwal-waktu-jam {
    font-size: 21px; font-weight: 700; color: #9FE1CB;
    font-family: 'Playfair Display', serif; letter-spacing: 0.5px;
}
.jadwal-item.aktif .jadwal-waktu-jam { color: #FFD700; }

.jadwal-aktif-badge {
    display: none; font-size: 9px; font-weight: 700;
    padding: 2px 8px; background: rgba(255,215,0,0.12);
    color: #FFD700; border-radius: 20px;
    border: 1px solid rgba(255,215,0,0.22); letter-spacing: 0.5px;
}
.jadwal-item.aktif .jadwal-aktif-badge { display: block; }

/* Countdown ke sholat berikutnya */
.jadwal-countdown-bar {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    padding: 10px 24px;
    border-top: 1px solid rgba(29,158,117,0.12);
    font-size: 12px; color: rgba(159,225,203,0.5);
}
.jadwal-countdown-val {
    font-size: 13px; font-weight: 700; color: #5DCAA5;
    font-family: 'Playfair Display', serif;
}
.jadwal-unavail { padding: 28px; text-align: center; font-size: 13px; color: rgba(159,225,203,0.4); }

/* ══ KAJIAN GRID ══ */
.kjn-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(210px, 1fr)); gap: 16px; margin-bottom: 44px; }
.kjn-card { background: rgba(13,51,34,0.7); backdrop-filter: blur(8px); border-radius: 16px; overflow: hidden; border: 1px solid rgba(29,158,117,0.18); transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s; }
.kjn-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.3); border-color: rgba(29,158,117,0.42); }
.kjn-img { width: 100%; height: 135px; object-fit: cover; display: block; }
.kjn-img-ph { width: 100%; height: 135px; background: rgba(8,80,65,0.45); display: flex; align-items: center; justify-content: center; font-size: 34px; }
.kjn-body { padding: 13px; }
.hot-badge { display: inline-block; font-size: 10px; font-weight: 700; padding: 2px 9px; background: rgba(226,75,74,0.14); color: #F09595; border-radius: 20px; border: 1px solid rgba(226,75,74,0.2); margin-bottom: 6px; }
.new-badge { display: inline-block; font-size: 10px; font-weight: 700; padding: 2px 9px; background: rgba(29,158,117,0.14); color: #5DCAA5; border-radius: 20px; border: 1px solid rgba(29,158,117,0.2); margin-bottom: 6px; }
.kjn-title { font-size: 13px; font-weight: 600; color: #9FE1CB; margin-bottom: 5px; line-height: 1.4; }
.kjn-meta { font-size: 11px; color: rgba(159,225,203,0.5); margin-top: 3px; }

/* ══ VIDEO GRID ══ */
.vid-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(210px, 1fr)); gap: 16px; margin-bottom: 32px; }
.vid-card { background: rgba(13,51,34,0.7); backdrop-filter: blur(8px); border-radius: 16px; overflow: hidden; border: 1px solid rgba(29,158,117,0.18); cursor: pointer; transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s; }
.vid-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.3); border-color: rgba(29,158,117,0.42); }
.vid-thumb { position: relative; height: 125px; background: rgba(8,80,65,0.55); overflow: hidden; }
.vid-thumb img { width: 100%; height: 100%; object-fit: cover; opacity: 0.75; transition: opacity 0.2s; }
.vid-card:hover .vid-thumb img { opacity: 0.9; }
.vid-play { position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); width: 42px; height: 42px; border-radius: 50%; background: rgba(255,215,0,0.92); display: flex; align-items: center; justify-content: center; font-size: 14px; color: #071a14; transition: transform 0.2s; }
.vid-card:hover .vid-play { transform: translate(-50%,-50%) scale(1.1); }
.vid-body { padding: 12px 14px; }
.vid-title { font-size: 13px; font-weight: 600; color: #9FE1CB; margin-bottom: 4px; line-height: 1.4; }
.vid-meta { font-size: 11px; color: rgba(159,225,203,0.5); }

/* ══ RESPONSIVE ══ */
@media (max-width: 768px) {
    .db { padding: 20px 16px; }
    .hero { height: auto; min-height: 300px; }
    .hero-overlay { flex-direction: column; gap: 16px; padding: 28px 24px; align-items: flex-start; }
    .hero-mosque { width: 64px; height: 64px; font-size: 28px; }
    .hero-title { font-size: 22px; }
    .hero-stats { gap: 18px; }
    .admin-stat-grid { grid-template-columns: 1fr; }
    .jadwal-grid { grid-template-columns: repeat(3,1fr); }
}
@media (max-width: 480px) {
    .jadwal-grid { grid-template-columns: repeat(3,1fr); }
}
</style>

<div class="db-wrap">
    <div class="db-bg"></div>
    <div class="db-grid-tex"></div>
    <div class="orb orb1"></div>
    <div class="orb orb2"></div>
    <div class="orb orb3"></div>

    <div class="db">

        {{-- ══ HERO ══ --}}
        <div class="hero">

            {{-- ===== SLOT FOTO MASJID =====
                 Letak file : public/images/masjid/Masjid1.jpg
                 Ganti nama file sesuai kebutuhan
            ===== --}}
            <img
                src="{{ asset('images/masjid/Masjid1.jpg') }}"
                class="hero-photo"
                alt="Masjid Al-Hasanah"
                onerror="this.style.display='none'"
            >
            <div class="hero-overlay-dark"></div>
            <div class="hero-overlay-bottom"></div>
            <div class="hero-shimmer"></div>

            <div class="hero-overlay">
                <div class="hero-mosque-wrap">
                    <div class="hero-mosque">🕌</div>
                    <div class="hero-est">الحسنة</div>
                </div>
                <div class="hero-text">
                    <div class="hero-eyebrow">Masjid Al-Hasanah</div>
                    <div class="hero-title">
                        Website Resmi<br>
                        Dewan Kemakmuran Masjid Al-Hasanah
                    </div>
                    <div class="hero-divider"></div>
                    <div class="hero-sub">
                        Komplek Pushubad Cijantung Jl. Radar VII Kel. Kalisari<br>
                        Kec. Pasar Rebo, Jakarta Timur 13790<br>
                        Selamat datang, {{ auth()->user()->name }}
                    </div>
                    <div class="hero-stats">
                        <div class="hstat">
                            <div class="hstat-num">{{ $totalDkm }}</div>
                            <div class="hstat-lbl">Anggota DKM</div>
                        </div>
                        <div class="hstat">
                            <div class="hstat-num">{{ $totalKajian }}</div>
                            <div class="hstat-lbl">Kajian Aktif</div>
                        </div>
                        <div class="hstat">
                            <div class="hstat-num">{{ $videos->count() }}</div>
                            <div class="hstat-lbl">Video</div>
                        </div>
                    </div>
                    <a href="/rekomendasi" class="hero-btn">Lihat Rekomendasi →</a>
                </div>
            </div>
        </div>

        <div class="admin-stat-wrap">
            <div class="sec-head">
                <div class="sec-label">Dashboard Statistik</div>
                <span class="sec-badge">Admin Insight</span>
                <div class="sec-line"></div>
            </div>

            <div class="admin-stat-grid">
                <div class="admin-stat-card">
                    <small>Total Jamaah</small>
                    <strong>{{ $totalJamaah }}</strong>
                    <span>Total pengguna yang sudah terdaftar dan dapat mengakses platform masjid.</span>
                </div>

                <div class="admin-stat-card">
                    <small>Total Kajian</small>
                    <strong>{{ $totalKajian }}</strong>
                    <span>Seluruh kajian aktif yang tercatat dan siap dijelajahi jamaah.</span>
                </div>

                <div class="admin-stat-card">
                    <small>Total Rating</small>
                    <strong>{{ $totalRating }}</strong>
                    <span>Dataset penilaian yang menjadi fondasi sistem rekomendasi hybrid.</span>
                </div>

                <div class="admin-stat-card">
                    <small>Total Donasi</small>
                    <strong>Rp {{ number_format($totalDonasi, 0, ',', '.') }}</strong>
                    <span>{{ $totalTransaksiDonasi }} transaksi donasi tercatat dalam sistem.</span>
                </div>
            </div>
        </div>


        {{-- ══ GALERI ══ --}}
        <div class="sec-head">
            <div class="sec-label">Galeri Masjid</div>
            <span class="sec-badge">Dokumentasi</span>
            <div class="sec-line"></div>
        </div>
        <div class="gallery-wrap">
            <button class="gal-arrow gal-prev" onclick="galleryScroll(-1)">‹</button>
            <div class="gallery-track" id="galleryTrack">

                <div class="gallery-slide">
                    <img src="{{ asset('images/masjid/Masjid2.jpg') }}" alt="Halaman Luar Masjid"
                         onerror="this.parentElement.querySelector('.gallery-placeholder').style.display='flex';this.style.display='none';">
                    <div class="gallery-placeholder" style="display:none;">🕌</div>
                    <div class="gallery-cap">Halaman Luar Masjid</div>
                </div>

                <div class="gallery-slide">
                    <img src="{{ asset('images/masjid/Masjid5.jpg') }}" alt="Halaman Dalam Masjid"
                         onerror="this.parentElement.querySelector('.gallery-placeholder').style.display='flex';this.style.display='none';">
                    <div class="gallery-placeholder" style="display:none;">🕌</div>
                    <div class="gallery-cap">Halaman Dalam Masjid</div>
                </div>

                <div class="gallery-slide">
                    <img src="{{ asset('images/masjid/Masjid3.jpg') }}" alt="Kegiatan TPA"
                         onerror="this.parentElement.querySelector('.gallery-placeholder').style.display='flex';this.style.display='none';">
                    <div class="gallery-placeholder" style="display:none;">📖</div>
                    <div class="gallery-cap">Kegiatan TPA</div>
                </div>

                <div class="gallery-slide">
                    <img src="{{ asset('images/masjid/photo1.jpg') }}" alt="Kajian Rutin"
                         onerror="this.parentElement.querySelector('.gallery-placeholder').style.display='flex';this.style.display='none';">
                    <div class="gallery-placeholder" style="display:none;">📚</div>
                    <div class="gallery-cap">Kajian Rutin</div>
                </div>

                <div class="gallery-slide">
                    <img src="{{ asset('images/masjid/Masjid4.jpg') }}" alt="Menu Sahur"
                         onerror="this.parentElement.querySelector('.gallery-placeholder').style.display='flex';this.style.display='none';">
                    <div class="gallery-placeholder" style="display:none;">🌙</div>
                    <div class="gallery-cap">Menu Sahur</div>
                </div>

                {{--
                    Tambah slide baru:
                    <div class="gallery-slide">
                        <img src="{{ asset('images/masjid/NamaFile.jpg') }}" alt="Keterangan"
                             onerror="this.parentElement.querySelector('.gallery-placeholder').style.display='flex';this.style.display='none';">
                        <div class="gallery-placeholder" style="display:none;">🕌</div>
                        <div class="gallery-cap">Keterangan Foto</div>
                    </div>
                --}}

            </div>
            <button class="gal-arrow gal-next" onclick="galleryScroll(1)">›</button>
        </div>


        {{-- ══ DKM ══ --}}
        <div class="sec-head">
            <div class="sec-label">Anggota DKM</div>
            <span class="sec-badge">Pengurus Aktif</span>
            <div class="sec-line"></div>
        </div>
        <div class="dkm-grid">
            @foreach($dkm as $d)
            @php
                $words    = explode(' ', $d->nama);
                $initials = strtoupper(
                    (isset($words[0]) ? $words[0][0] : '') .
                    (isset($words[1]) ? $words[1][0] : '')
                );
            @endphp
            <a href="/dkm/{{ $d->id }}" class="dkm-card">
                <div class="dkm-card-top">
                    @if($d->foto)
                        <img src="{{ $d->foto }}" class="dkm-avatar" alt="{{ $d->nama }}">
                    @else
                        <div class="dkm-avatar-init">{{ $initials }}</div>
                    @endif
                </div>
                <div class="dkm-body">
                    <div class="dkm-nama">{{ $d->nama }}</div>
                    <div class="dkm-jab">{{ $d->jabatan }}</div>
                    <span class="dkm-chip">{{ $d->jabatan ?? 'Anggota' }}</span>
                </div>
            </a>
            @endforeach
            <a href="/dkm" class="dkm-card dkm-card-more">Lihat Semua →</a>
        </div>


        {{-- ══ JADWAL SHOLAT ══ --}}
        <div class="sec-head">
            <div class="sec-label">Jadwal Sholat</div>
            <span class="sec-badge">Hari Ini</span>
            <div class="sec-line"></div>
        </div>

        <div class="jadwal-wrap">
            <div class="jadwal-card">

                <div class="jadwal-header">
                    <div class="jadwal-header-left">
                        <div class="jadwal-icon-wrap">🕌</div>
                        <div>
                            <div class="jadwal-title">Jadwal Sholat Hari Ini</div>
                            <div class="jadwal-subtitle">Jakarta Timur · Pasar Rebo</div>
                        </div>
                    </div>
                    <div class="jadwal-date-pill">
                        <div class="jadwal-dot"></div>
                        <span id="jadwal-tanggal">—</span>
                    </div>
                </div>

                @if($jadwal)
                <div class="jadwal-grid" id="jadwal-grid">

                    <div class="jadwal-item" data-waktu="{{ $jadwal['Fajr'] }}">
                        <div class="jadwal-waktu-icon">🌙</div>
                        <div class="jadwal-waktu-nama">Subuh</div>
                        <div class="jadwal-waktu-jam">{{ $jadwal['Fajr'] }}</div>
                        <div class="jadwal-aktif-badge">Waktu Ini</div>
                    </div>

                    <div class="jadwal-item" data-waktu="{{ $jadwal['Dhuhr'] }}">
                        <div class="jadwal-waktu-icon">☀️</div>
                        <div class="jadwal-waktu-nama">Dzuhur</div>
                        <div class="jadwal-waktu-jam">{{ $jadwal['Dhuhr'] }}</div>
                        <div class="jadwal-aktif-badge">Waktu Ini</div>
                    </div>

                    <div class="jadwal-item" data-waktu="{{ $jadwal['Asr'] }}">
                        <div class="jadwal-waktu-icon">🌤️</div>
                        <div class="jadwal-waktu-nama">Ashar</div>
                        <div class="jadwal-waktu-jam">{{ $jadwal['Asr'] }}</div>
                        <div class="jadwal-aktif-badge">Waktu Ini</div>
                    </div>

                    <div class="jadwal-item" data-waktu="{{ $jadwal['Maghrib'] }}">
                        <div class="jadwal-waktu-icon">🌅</div>
                        <div class="jadwal-waktu-nama">Maghrib</div>
                        <div class="jadwal-waktu-jam">{{ $jadwal['Maghrib'] }}</div>
                        <div class="jadwal-aktif-badge">Waktu Ini</div>
                    </div>

                    <div class="jadwal-item" data-waktu="{{ $jadwal['Isha'] }}">
                        <div class="jadwal-waktu-icon">🌃</div>
                        <div class="jadwal-waktu-nama">Isya</div>
                        <div class="jadwal-waktu-jam">{{ $jadwal['Isha'] }}</div>
                        <div class="jadwal-aktif-badge">Waktu Ini</div>
                    </div>

                </div>

                <div class="jadwal-countdown-bar">
                    <span>Sholat berikutnya dalam</span>
                    <span class="jadwal-countdown-val" id="jadwal-countdown">—</span>
                </div>

                @else
                <div class="jadwal-unavail">Jadwal sholat tidak tersedia saat ini.</div>
                @endif

            </div>
        </div>


        <!-- PENGUMUMAN -->
        <div class="section-title">📢 Pengumuman Masjid</div>

        <div class="grid">
        @foreach($pengumuman as $p)
            <div class="card">

                <!-- IMAGE -->
                <img src="{{ $p->gambar ?? 'https://via.placeholder.com/400x200' }}">

                <div class="card-body">
                    <h4 style="color:#198754;">{{ $p->judul }}</h4>

                    <p style="font-size:13px; color:#666;">
                        {{ \Illuminate\Support\Str::limit($p->isi, 100) }}
                    </p>

                    <small style="color:#999;">
                        📅 {{ $p->tanggal }}
                    </small>
                </div>

            </div>
        @endforeach
        </div>

        {{-- ══ TRENDING KAJIAN ══ --}}
        <div class="sec-head">
            <div class="sec-label">Trending Kajian</div>
            <span class="sec-badge">Paling Diminati</span>
            <div class="sec-line"></div>
        </div>
        <div class="kjn-grid">
            @foreach($kajianTrending as $k)
            <div class="kjn-card">
                @if($k->image)
                    <img src="{{ $k->image }}" class="kjn-img" alt="{{ $k->judul }}">
                @else
                    <div class="kjn-img-ph">📖</div>
                @endif
                <div class="kjn-body">
                    <span class="hot-badge">HOT</span>
                    <div class="kjn-title">{{ $k->judul }}</div>
                    <div class="kjn-meta">👤 {{ $k->ustadz->nama ?? '-' }}</div>
                    <div class="kjn-meta">⭐ {{ number_format($k->ratings_avg_rating ?? 0, 1) }}</div>
                </div>
            </div>
            @endforeach
        </div>


        {{-- ══ KAJIAN TERBARU ══ --}}
        <div class="sec-head">
            <div class="sec-label">Kajian Terbaru</div>
            <span class="sec-badge">Baru Ditambahkan</span>
            <div class="sec-line"></div>
        </div>
        <div class="kjn-grid">
            @foreach($kajianTerbaru as $k)
            <div class="kjn-card">
                @if($k->image)
                    <img src="{{ $k->image }}" class="kjn-img" alt="{{ $k->judul }}">
                @else
                    <div class="kjn-img-ph">📚</div>
                @endif
                <div class="kjn-body">
                    <span class="new-badge">BARU</span>
                    <div class="kjn-title">{{ $k->judul }}</div>
                    <div class="kjn-meta">👤 {{ $k->ustadz->nama ?? '-' }}</div>
                    <div class="kjn-meta">⭐ {{ number_format($k->ratings_avg_rating ?? 0, 1) }}</div>
                </div>
            </div>
            @endforeach
        </div>


        {{-- ══ VIDEO KAJIAN ══ --}}
        <div class="sec-head">
            <div class="sec-label">Video Kajian</div>
            <span class="sec-badge">Youtube</span>
            <div class="sec-line"></div>
        </div>
        <div class="vid-grid">
            @foreach($videos as $v)
            @php
                preg_match('/(youtu\.be\/|v=)([^&]+)/', $v->youtube_url, $matches);
                $vid = $matches[2] ?? null;
            @endphp
            <div class="vid-card" onclick="playVideo(this, '{{ $vid }}')">
                <div class="vid-thumb">
                    @if($vid)
                        <img src="https://img.youtube.com/vi/{{ $vid }}/hqdefault.jpg" alt="{{ $v->judul }}">
                    @endif
                    <div class="vid-play">▶</div>
                </div>
                <div class="vid-body">
                    <div class="vid-title">{{ $v->judul }}</div>
                    <div class="vid-meta">{{ $v->ustadz }}</div>
                </div>
            </div>
            @endforeach
        </div>

    </div>{{-- end .db --}}
</div>{{-- end .db-wrap --}}

<script>
/* ── Gallery scroll ── */
function galleryScroll(dir) {
    document.getElementById('galleryTrack').scrollLeft += dir * 300;
}

/* ── Video embed ── */
function playVideo(el, id) {
    if (!id) return;
    el.querySelector('.vid-thumb').innerHTML =
        `<iframe width="100%" height="125"
            src="https://www.youtube.com/embed/${id}?autoplay=1"
            frameborder="0" allow="autoplay;encrypted-media" allowfullscreen></iframe>`;
}

/* ── Jadwal sholat: tanggal, highlight aktif, countdown ── */
(function () {
    /* Tanggal hari ini */
    const now  = new Date();
    const opts = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
    const elTgl = document.getElementById('jadwal-tanggal');
    if (elTgl) elTgl.textContent = now.toLocaleDateString('id-ID', opts);

    /* Parse "HH:MM" dari string jadwal */
    function parseMin(str) {
        if (!str) return null;
        const m = str.match(/(\d{1,2}):(\d{2})/);
        return m ? +m[1] * 60 + +m[2] : null;
    }

    const items  = document.querySelectorAll('#jadwal-grid .jadwal-item');
    if (!items.length) return;

    const nowMin = now.getHours() * 60 + now.getMinutes();

    /* Tentukan sholat aktif (waktu terakhir yang sudah lewat) */
    let aktifIdx  = 0;
    let nextIdx   = -1;
    let nextMin   = null;

    items.forEach(function(item, i) {
        const wkt = parseMin(item.dataset.waktu);
        if (wkt !== null && nowMin >= wkt) aktifIdx = i;
    });

    items[aktifIdx].classList.add('aktif');

    /* Tentukan sholat berikutnya */
    for (let i = aktifIdx + 1; i < items.length; i++) {
        const wkt = parseMin(items[i].dataset.waktu);
        if (wkt !== null && wkt > nowMin) { nextIdx = i; nextMin = wkt; break; }
    }

    /* Countdown ke sholat berikutnya */
    const elCd = document.getElementById('jadwal-countdown');
    if (elCd && nextMin !== null) {
        function updateCd() {
            const n  = new Date();
            const nm = n.getHours() * 60 + n.getMinutes();
            const diff = nextMin - nm;
            if (diff <= 0) { elCd.textContent = 'Sekarang'; return; }
            const h = Math.floor(diff / 60);
            const m = diff % 60;
            elCd.textContent = (h > 0 ? h + ' jam ' : '') + m + ' menit lagi';
        }
        updateCd();
        setInterval(updateCd, 30000);
    } else if (elCd) {
        elCd.textContent = 'Isya adalah sholat terakhir hari ini';
    }
})();
</script>

@endsection
