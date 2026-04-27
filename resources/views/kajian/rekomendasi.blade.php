@extends('layouts.app')

@section('content')
@php
    $recommended = $recommended ?? collect();
    $preferredCategories = $preferredCategories ?? collect();
    $topCategory = $preferredCategories->keys()->first();
@endphp
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

* { box-sizing: border-box; }

.rk-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    min-height: 100vh;
    position: relative;
    overflow: hidden;
    background: #0a2e1f;
}

.rk-bg {
    position: absolute; inset: 0; z-index: 0;
    background:
        radial-gradient(ellipse 80% 60% at 10% 0%, rgba(29,158,117,0.18) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 90% 100%, rgba(8,80,65,0.30) 0%, transparent 55%),
        linear-gradient(160deg, #0d3322 0%, #0a2219 40%, #071a14 100%);
}

.rk-tex {
    position: absolute; inset: 0; z-index: 0;
    background-image:
        linear-gradient(rgba(29,158,117,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(29,158,117,0.04) 1px, transparent 1px);
    background-size: 48px 48px;
}

.orb { position: absolute; border-radius: 50%; filter: blur(80px); z-index: 0; pointer-events: none; }
.orb1 { width: 500px; height: 500px; background: rgba(29,158,117,0.12); top: -120px; left: -100px; }
.orb2 { width: 400px; height: 400px; background: rgba(8,80,65,0.20); bottom: -80px; right: -60px; }

.rk { position: relative; z-index: 1; padding: 36px 32px; }

.rk-hero {
    border-radius: 28px;
    padding: 32px;
    margin-bottom: 26px;
    background:
        radial-gradient(circle at 100% 0%, rgba(255,215,0,0.16), transparent 22%),
        linear-gradient(135deg, rgba(8,42,29,0.95) 0%, rgba(12,72,51,0.95) 48%, rgba(29,158,117,0.88) 100%);
    border: 1px solid rgba(29,158,117,0.24);
    box-shadow: 0 24px 60px rgba(0,0,0,0.22);
}

.rk-kicker {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 14px;
    border-radius: 999px;
    margin-bottom: 16px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #d6fff0;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.14);
}

.rk-kicker::before {
    content: '';
    width: 7px;
    height: 7px;
    border-radius: 999px;
    background: #ffd700;
}

.rk-title {
    margin: 0 0 12px;
    font-family: 'Playfair Display', serif;
    font-size: 36px;
    line-height: 1.18;
    color: #f6fff9;
}

.rk-copy {
    margin: 0;
    max-width: 700px;
    font-size: 14px;
    line-height: 1.85;
    color: rgba(255,255,255,0.78);
}

.rk-highlight {
    margin-top: 18px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    border-radius: 18px;
    background: rgba(255,215,0,0.1);
    border: 1px solid rgba(255,215,0,0.14);
    color: #fff3bf;
    font-size: 13px;
    font-weight: 600;
}

.rk-stat-row {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 26px;
}

.rk-stat-card {
    padding: 18px 20px;
    border-radius: 20px;
    background: rgba(13,51,34,0.72);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(29,158,117,0.2);
}

.rk-stat-card small {
    display: block;
    margin-bottom: 8px;
    font-size: 11px;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: rgba(159,225,203,0.56);
}

.rk-stat-card strong {
    display: block;
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    color: #ffd700;
    line-height: 1.1;
}

.rk-stat-card span {
    display: block;
    margin-top: 8px;
    font-size: 12px;
    line-height: 1.7;
    color: rgba(159,225,203,0.58);
}

.rk-category-strip {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 24px;
}

.rk-category-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 14px;
    border-radius: 999px;
    background: rgba(29,158,117,0.14);
    border: 1px solid rgba(29,158,117,0.2);
    color: #9fe1cb;
    font-size: 12px;
    font-weight: 700;
}

.rk-category-pill span {
    opacity: 0.76;
}

.sec-head { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; }
.sec-label { font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 700; color: #9FE1CB; white-space: nowrap; }
.sec-badge { font-size: 10px; font-weight: 600; padding: 3px 10px; background: rgba(29,158,117,0.2); color: #5DCAA5; border-radius: 20px; border: 1px solid rgba(29,158,117,0.25); }
.sec-line { flex: 1; height: 1px; background: rgba(29,158,117,0.2); }

.r-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 18px;
}

.r-card {
    background: rgba(13,51,34,0.7);
    backdrop-filter: blur(8px);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid rgba(29,158,117,0.2);
    transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
}

.r-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.3);
    border-color: rgba(255,215,0,0.3);
}

.r-img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    display: block;
}

.r-img-ph {
    width: 100%;
    height: 150px;
    background: rgba(8,80,65,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
    position: relative;
}

.r-top-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 5px 10px;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    background: rgba(255,215,0,0.12);
    border: 1px solid rgba(255,215,0,0.22);
    color: #ffd700;
}

.r-body { padding: 16px; }

.r-chip-row {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 12px;
}

.r-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 10px;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.8px;
    text-transform: uppercase;
}

.r-chip-source {
    background: rgba(255,215,0,0.1);
    color: #ffd700;
    border: 1px solid rgba(255,215,0,0.18);
}

.r-chip-category {
    background: rgba(29,158,117,0.15);
    color: #5dcaa5;
    border: 1px solid rgba(29,158,117,0.2);
}

.r-title {
    font-size: 16px;
    font-weight: 700;
    color: #9FE1CB;
    margin-bottom: 8px;
    line-height: 1.45;
}

.r-meta {
    font-size: 12px;
    color: rgba(159,225,203,0.56);
    margin-top: 5px;
}

.r-reason {
    margin-top: 14px;
    padding: 12px 14px;
    border-radius: 16px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(29,158,117,0.14);
    font-size: 12px;
    line-height: 1.8;
    color: rgba(236,255,247,0.74);
}

.r-score {
    margin-top: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    font-size: 12px;
    color: rgba(159,225,203,0.62);
}

.r-score strong {
    font-size: 13px;
    color: #ffd700;
}

.empty-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 60px 20px;
}

.empty-box {
    background: rgba(13,51,34,0.7);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(29,158,117,0.2);
    border-radius: 24px;
    padding: 48px 40px;
    text-align: center;
    max-width: 460px;
}

.empty-icon { font-size: 52px; margin-bottom: 18px; }
.empty-title {
    font-family: 'Playfair Display', serif;
    font-size: 22px;
    color: #9FE1CB;
    margin-bottom: 10px;
}
.empty-sub {
    font-size: 13px;
    color: rgba(159,225,203,0.5);
    line-height: 1.8;
    margin-bottom: 24px;
}
.empty-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 24px;
    background: #FFD700;
    color: #0a2e1f;
    font-size: 13px;
    font-weight: 700;
    border-radius: 20px;
    text-decoration: none;
}

@media (max-width: 900px) {
    .rk-stat-row {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 640px) {
    .rk { padding: 20px 16px; }
    .rk-hero { padding: 24px 20px; }
    .rk-title { font-size: 28px; }
    .rk-stat-row { grid-template-columns: 1fr; }
}
</style>

<div class="rk-wrap">
    <div class="rk-bg"></div>
    <div class="rk-tex"></div>
    <div class="orb orb1"></div>
    <div class="orb orb2"></div>

    <div class="rk">
        <section class="rk-hero">
            <div class="rk-kicker">Hybrid Recommendation Engine</div>
            <h1 class="rk-title">Rekomendasi Kajian Berbasis AI Hybrid</h1>
            <p class="rk-copy">
                Sistem kini menggabungkan collaborative filtering dari pola rating jamaah lain
                dan content-based recommendation dari kategori kajian yang paling sering Anda sukai.
            </p>

            @if($topCategory)
                <div class="rk-highlight">Karena kamu suka {{ strtolower($topCategory) }}, sistem memprioritaskan kajian dengan kategori yang paling dekat dengan preferensimu.</div>
            @elseif($recommendationMode === 'popular')
                <div class="rk-highlight">Belum ada cukup sinyal personal, jadi sistem menampilkan kajian populer sambil menunggu rating tambahan darimu.</div>
            @endif
        </section>

        <div class="rk-stat-row">
            <div class="rk-stat-card">
                <small>Mode Rekomendasi</small>
                <strong>{{ $recommendationMode === 'hybrid' ? 'Hybrid' : 'Popular' }}</strong>
                <span>Menggabungkan analisa kategori dan pola rating untuk hasil yang lebih cerdas.</span>
            </div>

            <div class="rk-stat-card">
                <small>Rekomendasi</small>
                <strong>{{ $recommended->count() }}</strong>
                <span>Jumlah kajian yang berhasil diprioritaskan untuk akun Anda saat ini.</span>
            </div>

            <div class="rk-stat-card">
                <small>Rating Kamu</small>
                <strong>{{ $userRatingsCount }}</strong>
                <span>Semakin banyak rating, semakin kuat profil preferensi yang bisa dianalisa sistem.</span>
            </div>

            <div class="rk-stat-card">
                <small>Jamaah Mirip</small>
                <strong>{{ $similarUsersCount }}</strong>
                <span>Jumlah user yang terdeteksi punya pola rating serupa dengan Anda.</span>
            </div>
        </div>

        @if($preferredCategories->isNotEmpty())
            <div class="rk-category-strip">
                @foreach($preferredCategories as $kategori => $weight)
                    <div class="rk-category-pill">{{ $kategori }} <span>Skor preferensi {{ $weight }}</span></div>
                @endforeach
            </div>
        @endif

        @if($recommended->isNotEmpty())
            <div class="sec-head">
                <div class="sec-label">Hasil Rekomendasi</div>
                <span class="sec-badge">{{ $recommended->count() }} kajian</span>
                <div class="sec-line"></div>
            </div>

            <div class="r-grid">
                @foreach($recommended as $k)
                    <div class="r-card">
                        @if($k->image)
                            <img src="{{ $k->image }}" class="r-img" alt="{{ $k->judul }}">
                        @else
                            <div class="r-img-ph">
                                📚
                                <div class="r-top-badge">{{ $k->hybrid_score }}%</div>
                            </div>
                        @endif

                        <div class="r-body">
                            <div class="r-chip-row">
                                <span class="r-chip r-chip-source">{{ $k->recommendation_source }}</span>
                                <span class="r-chip r-chip-category">{{ $k->kategori_label }}</span>
                            </div>

                            <div class="r-title">{{ $k->judul }}</div>
                            <div class="r-meta">Ustadz: {{ $k->ustadz->nama ?? '-' }}</div>
                            <div class="r-meta">Kitab: {{ $k->kitab->nama ?? '-' }}</div>
                            @if($k->hari)
                                <div class="r-meta">Hari: {{ $k->hari }} • Pekan {{ $k->pekan }}</div>
                            @endif
                            @if($k->waktu)
                                <div class="r-meta">Waktu: {{ \Carbon\Carbon::parse($k->waktu)->format('H:i') }} WIB</div>
                            @endif
                            @if($k->lokasi)
                                <div class="r-meta">Lokasi: {{ $k->lokasi }}</div>
                            @endif

                            <div class="r-reason">{{ $k->recommendation_reason }}</div>

                            <div class="r-score">
                                <span>Hybrid score</span>
                                <strong>{{ $k->hybrid_score }}%</strong>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-wrap">
                <div class="empty-box">
                    <div class="empty-icon">🤔</div>
                    <div class="empty-title">Belum Ada Rekomendasi</div>
                    <div class="empty-sub">
                        Berikan rating pada beberapa kajian yang sudah Anda ikuti agar sistem bisa
                        membaca kategori favorit dan mencari jamaah dengan pola rating yang mirip.
                    </div>
                    <a href="/kajian" class="empty-btn">Lihat Kajian</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
