@extends('layouts.main')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

* { box-sizing: border-box; }

.jk-page {
    font-family: 'Plus Jakarta Sans', sans-serif;
    position: relative;
    overflow: hidden;
    border-radius: 28px;
    background:
        radial-gradient(circle at top left, rgba(29,158,117,0.12), transparent 24%),
        linear-gradient(180deg, #f6f9f7 0%, #eef4f1 100%);
    min-height: 100vh;
    padding: 34px 30px 48px;
}

.jk-shell {
    max-width: 1160px;
    margin: 0 auto;
}

.jk-hero {
    border-radius: 28px;
    padding: 32px;
    margin-bottom: 24px;
    background:
        radial-gradient(circle at 100% 0%, rgba(255,215,0,0.16), transparent 22%),
        linear-gradient(135deg, #0b4c3d 0%, #0f6e56 48%, #1d9e75 100%);
    color: white;
    box-shadow: 0 24px 58px rgba(8, 80, 65, 0.14);
}

.jk-kicker {
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
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.16);
}

.jk-kicker::before {
    content: '';
    width: 7px;
    height: 7px;
    border-radius: 999px;
    background: #ffd700;
}

.jk-title {
    margin: 0 0 12px;
    font-family: 'Playfair Display', serif;
    font-size: 38px;
    line-height: 1.15;
}

.jk-copy {
    margin: 0;
    max-width: 620px;
    font-size: 14px;
    line-height: 1.85;
    color: rgba(255,255,255,0.82);
}

.jk-stat-row {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 24px;
}

.jk-stat {
    padding: 18px 20px;
    border-radius: 20px;
    background: white;
    border: 1px solid #deebe5;
    box-shadow: 0 18px 40px rgba(11, 76, 61, 0.05);
}

.jk-stat small {
    display: block;
    margin-bottom: 8px;
    font-size: 11px;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #6a7f77;
}

.jk-stat strong {
    display: block;
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    line-height: 1.1;
    color: #085041;
}

.jk-stat span {
    display: block;
    margin-top: 8px;
    font-size: 12px;
    line-height: 1.7;
    color: #687b74;
}

.jk-day-section {
    margin-bottom: 24px;
    padding: 24px;
    border-radius: 26px;
    background: rgba(255,255,255,0.84);
    border: 1px solid #deebe5;
    box-shadow: 0 18px 40px rgba(11, 76, 61, 0.05);
}

.jk-day-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 18px;
}

.jk-day-title {
    margin: 0;
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    color: #085041;
}

.jk-day-pill {
    padding: 8px 12px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    color: #0f6e56;
    background: #e1f5ee;
    border: 1px solid #cceade;
}

.jk-list {
    display: grid;
    gap: 14px;
}

.jk-item {
    display: grid;
    grid-template-columns: 110px minmax(0, 1fr);
    gap: 16px;
    padding: 16px 18px;
    border-radius: 20px;
    background: #f6faf8;
    border: 1px solid #e2ebe6;
}

.jk-time {
    padding: 14px 16px;
    border-radius: 18px;
    background: linear-gradient(135deg, #0b4c3d 0%, #1d9e75 100%);
    color: white;
    text-align: center;
}

.jk-time strong {
    display: block;
    font-family: 'Playfair Display', serif;
    font-size: 24px;
}

.jk-time span {
    display: block;
    margin-top: 6px;
    font-size: 11px;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.74);
}

.jk-topic {
    margin: 0 0 8px;
    font-size: 18px;
    color: #12453b;
}

.jk-meta {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 10px;
}

.jk-meta span {
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 600;
    color: #5f736c;
    background: white;
    border: 1px solid #e2ebe6;
}

.jk-desc {
    margin: 0;
    font-size: 13px;
    line-height: 1.8;
    color: #6a7d76;
}

.jk-empty {
    padding: 44px 24px;
    text-align: center;
    border-radius: 24px;
    background: white;
    border: 1px solid #deebe5;
}

.jk-empty h2 {
    margin: 0 0 10px;
    font-family: 'Playfair Display', serif;
    color: #085041;
}

.jk-empty p {
    margin: 0;
    font-size: 13px;
    line-height: 1.8;
    color: #6d8079;
}

@media (max-width: 900px) {
    .jk-stat-row {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 720px) {
    .jk-item {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 640px) {
    .jk-page {
        padding: 20px 16px 36px;
    }

    .jk-hero,
    .jk-day-section {
        padding: 22px 18px;
    }

    .jk-title {
        font-size: 30px;
    }
}
</style>

<div class="jk-page">
    <div class="jk-shell">
        <section class="jk-hero">
            <div class="jk-kicker">Jadwal Kajian</div>
            <h1 class="jk-title">Agenda Kajian Rutin Masjid</h1>
            <p class="jk-copy">
                Daftar kajian ditampilkan berdasarkan hari dan waktu agar jamaah lebih mudah melihat tema,
                ustadz, dan lokasi pelaksanaannya dalam satu tampilan yang tertata.
            </p>
        </section>

        <div class="jk-stat-row">
            <div class="jk-stat">
                <small>Total Kajian</small>
                <strong>{{ $jadwalKajian->count() }}</strong>
                <span>Seluruh sesi kajian yang saat ini tersedia dalam sistem.</span>
            </div>

            <div class="jk-stat">
                <small>Hari Aktif</small>
                <strong>{{ $jadwalByHari->count() }}</strong>
                <span>Jumlah hari yang sudah memiliki agenda kajian aktif.</span>
            </div>

            <div class="jk-stat">
                <small>Kategori</small>
                <strong>{{ $kategoriTersedia->count() }}</strong>
                <span>Kategori kajian yang saat ini terdistribusi di dalam jadwal.</span>
            </div>
        </div>

        @if($jadwalKajian->isEmpty())
            <div class="jk-empty">
                <h2>Jadwal kajian belum tersedia</h2>
                <p>Silakan tambahkan data kajian terlebih dahulu agar daftar hari, ustadz, dan tema dapat ditampilkan di halaman ini.</p>
            </div>
        @else
            @foreach($jadwalByHari as $hari => $items)
                <section class="jk-day-section">
                    <div class="jk-day-head">
                        <h2 class="jk-day-title">{{ $hari }}</h2>
                        <div class="jk-day-pill">{{ $items->count() }} Kajian</div>
                    </div>

                    <div class="jk-list">
                        @foreach($items as $kajian)
                            <article class="jk-item">
                                <div class="jk-time">
                                    <strong>{{ $kajian->waktu ? \Carbon\Carbon::parse($kajian->waktu)->format('H:i') : '--:--' }}</strong>
                                    <span>WIB</span>
                                </div>

                                <div>
                                    <h3 class="jk-topic">{{ $kajian->judul }}</h3>

                                    <div class="jk-meta">
                                        <span>Ustadz: {{ $kajian->ustadz->nama ?? '-' }}</span>
                                        <span>Kategori: {{ $kajian->kategori }}</span>
                                        <span>Kitab: {{ $kajian->kitab->nama ?? '-' }}</span>
                                        <span>Lokasi: {{ $kajian->lokasi }}</span>
                                    </div>

                                    <p class="jk-desc">
                                        {{ $kajian->deskripsi ?: 'Kajian rutin untuk memperkuat pemahaman jamaah terhadap materi yang dibahas pada sesi ini.' }}
                                    </p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endforeach
        @endif
    </div>
</div>
@endsection
