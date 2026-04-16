@extends('layouts.main')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

* { box-sizing: border-box; }

.dkm-root {
    font-family: 'Plus Jakarta Sans', sans-serif;
    padding: 40px 32px 56px;
    background:
        radial-gradient(circle at top left, rgba(29,158,117,0.08), transparent 24%),
        linear-gradient(180deg, #f6f9f7 0%, #eef4f1 100%);
    min-height: 100vh;
}

.dkm-shell {
    max-width: 1160px;
    margin: 0 auto;
}

.dkm-header-card {
    position: relative;
    overflow: hidden;
    border-radius: 30px;
    padding: 34px 34px 28px;
    margin-bottom: 26px;
    background:
        radial-gradient(circle at 100% 0%, rgba(255,215,0,0.16), transparent 22%),
        linear-gradient(135deg, #0b4c3d 0%, #0f6e56 48%, #1d9e75 100%);
    box-shadow: 0 26px 60px rgba(8, 80, 65, 0.16);
    color: white;
}

.dkm-header-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background:
        linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
    background-size: 42px 42px;
    opacity: 0.35;
    pointer-events: none;
}

.dkm-header-content {
    position: relative;
    z-index: 1;
}

.dkm-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #d7fff1;
    margin-bottom: 16px;
    background: rgba(255,255,255,0.12);
    padding: 7px 14px;
    border-radius: 999px;
    border: 1px solid rgba(255,255,255,0.16);
}

.dkm-dot {
    width: 7px;
    height: 7px;
    border-radius: 999px;
    background: #ffd700;
}

.dkm-head-layout {
    display: grid;
    grid-template-columns: minmax(0, 1.2fr) minmax(300px, 0.8fr);
    gap: 22px;
    align-items: end;
}

.dkm-title {
    font-family: 'Playfair Display', serif;
    font-size: 40px;
    font-weight: 700;
    line-height: 1.15;
    margin: 0 0 12px;
}

.dkm-subtitle {
    font-size: 14px;
    line-height: 1.85;
    max-width: 560px;
    margin: 0;
    color: rgba(255,255,255,0.82);
}

.dkm-header-note {
    padding: 18px 20px;
    border-radius: 22px;
    background: rgba(3,31,24,0.22);
    border: 1px solid rgba(255,255,255,0.14);
    backdrop-filter: blur(10px);
}

.dkm-header-note strong {
    display: block;
    margin-bottom: 7px;
    font-size: 13px;
    color: #fff6cd;
}

.dkm-header-note p {
    margin: 0;
    font-size: 12px;
    line-height: 1.75;
    color: rgba(255,255,255,0.74);
}

.dkm-stat-grid {
    position: relative;
    z-index: 1;
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
    margin-top: 26px;
}

.dkm-stat-card {
    padding: 18px 20px;
    border-radius: 22px;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.14);
    backdrop-filter: blur(10px);
}

.dkm-stat-label {
    display: block;
    margin-bottom: 10px;
    font-size: 11px;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.72);
}

.dkm-stat-value {
    display: block;
    font-family: 'Playfair Display', serif;
    font-size: 30px;
    line-height: 1.1;
    color: #ffffff;
}

.dkm-stat-sub {
    display: block;
    margin-top: 8px;
    font-size: 12px;
    line-height: 1.6;
    color: rgba(255,255,255,0.76);
}

.dkm-count-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    padding: 16px 20px;
    margin-bottom: 28px;
    border-radius: 20px;
    background: white;
    border: 1px solid #e0ebe6;
    box-shadow: 0 12px 30px rgba(11, 76, 61, 0.05);
}

.dkm-count-copy {
    font-size: 13px;
    line-height: 1.8;
    color: #61756d;
}

.dkm-count-copy strong {
    color: #085041;
}

.dkm-count-pills {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.dkm-count-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    color: #0f6e56;
    background: #e1f5ee;
    border: 1px solid #cceade;
}

.dkm-section {
    margin-bottom: 26px;
    padding: 24px;
    border-radius: 28px;
    background: rgba(255,255,255,0.8);
    border: 1px solid #deebe5;
    box-shadow: 0 20px 45px rgba(11, 76, 61, 0.05);
}

.dkm-section-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 18px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.dkm-section-kicker {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 12px;
}

.dkm-section-title {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    color: #085041;
    margin: 0 0 8px;
}

.dkm-section-copy {
    font-size: 13px;
    line-height: 1.8;
    color: #63756e;
    margin: 0;
    max-width: 640px;
}

.dkm-section-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 14px;
    border-radius: 16px;
    font-size: 12px;
    font-weight: 700;
    min-width: 120px;
}

.dkm-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(238px, 1fr));
    gap: 18px;
}

.dkm-grid-featured {
    grid-template-columns: repeat(auto-fit, minmax(260px, 320px));
    justify-content: center;
}

.dkm-card {
    background: white;
    border-radius: 22px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    border: 1px solid #e2e8e5;
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    position: relative;
}

.dkm-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 48px rgba(15, 110, 86, 0.13);
    text-decoration: none;
    color: inherit;
}

.dkm-card-top {
    height: 92px;
    position: relative;
}

.dkm-badge-ribbon,
.dkm-tier-badge {
    position: absolute;
    top: 12px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 5px 10px;
    border-radius: 999px;
}

.dkm-badge-ribbon {
    right: 12px;
    color: white;
    background: rgba(255,255,255,0.16);
    border: 1px solid rgba(255,255,255,0.22);
}

.dkm-tier-badge {
    left: 12px;
    color: #fff6cd;
    background: rgba(3,31,24,0.2);
    border: 1px solid rgba(255,255,255,0.14);
}

.dkm-avatar-wrap {
    position: absolute;
    bottom: -36px;
    left: 50%;
    transform: translateX(-50%);
}

.dkm-avatar,
.dkm-avatar-initials {
    width: 74px;
    height: 74px;
    border-radius: 50%;
    border: 4px solid white;
}

.dkm-avatar {
    object-fit: cover;
    background: #e1f5ee;
}

.dkm-avatar-initials {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #0f6e56;
    font-size: 22px;
    font-weight: 700;
    color: white;
    font-family: 'Playfair Display', serif;
}

.dkm-card-body {
    padding: 50px 20px 22px;
    text-align: center;
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.dkm-rank-line {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.dkm-nama {
    font-size: 16px;
    font-weight: 700;
    color: #085041;
    margin-bottom: 5px;
    line-height: 1.5;
}

.dkm-jabatan-text {
    font-size: 12px;
    color: #778983;
    margin-bottom: 14px;
    line-height: 1.7;
    min-height: 40px;
}

.dkm-chip-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
}

.dkm-chip {
    display: inline-block;
    padding: 5px 14px;
    font-size: 11px;
    font-weight: 700;
    border-radius: 999px;
    letter-spacing: 0.5px;
}

.dkm-chip-soft {
    background: #f3f7f5;
    color: #6d7f79;
    border: 1px solid #e2ebe6;
}

.dkm-card-footer {
    border-top: 1px solid #f0f0ee;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-size: 12px;
    color: #1d9e75;
    font-weight: 600;
}

.dkm-arrow {
    display: inline-block;
    transition: transform 0.2s;
}

.dkm-card:hover .dkm-arrow {
    transform: translateX(4px);
}

.dkm-accent-gold .dkm-section-kicker,
.dkm-accent-gold .dkm-section-count,
.dkm-accent-gold .dkm-chip {
    background: #fff4d0;
    color: #8a6800;
    border: 1px solid #f2df9b;
}

.dkm-accent-gold .dkm-card-top {
    background: linear-gradient(135deg, #7c5b00 0%, #b68900 50%, #d9ac1d 100%);
}

.dkm-accent-gold .dkm-rank-line {
    color: #8a6800;
}

.dkm-accent-emerald .dkm-section-kicker,
.dkm-accent-emerald .dkm-section-count,
.dkm-accent-emerald .dkm-chip {
    background: #e1f5ee;
    color: #0f6e56;
    border: 1px solid #cceade;
}

.dkm-accent-emerald .dkm-card-top {
    background: linear-gradient(135deg, #085041 0%, #0f6e56 48%, #1d9e75 100%);
}

.dkm-accent-emerald .dkm-rank-line {
    color: #0f6e56;
}

.dkm-accent-teal .dkm-section-kicker,
.dkm-accent-teal .dkm-section-count,
.dkm-accent-teal .dkm-chip {
    background: #e1f1f5;
    color: #0d6772;
    border: 1px solid #cee5ea;
}

.dkm-accent-teal .dkm-card-top {
    background: linear-gradient(135deg, #0b5360 0%, #127786 48%, #2ca4af 100%);
}

.dkm-accent-teal .dkm-rank-line {
    color: #0d6772;
}

.dkm-accent-mint .dkm-section-kicker,
.dkm-accent-mint .dkm-section-count,
.dkm-accent-mint .dkm-chip {
    background: #e8f8f2;
    color: #2d8064;
    border: 1px solid #d6efe5;
}

.dkm-accent-mint .dkm-card-top {
    background: linear-gradient(135deg, #1f6a54 0%, #2d8064 48%, #47aa84 100%);
}

.dkm-accent-mint .dkm-rank-line {
    color: #2d8064;
}

.dkm-accent-slate .dkm-section-kicker,
.dkm-accent-slate .dkm-section-count,
.dkm-accent-slate .dkm-chip {
    background: #edf1f3;
    color: #5d7178;
    border: 1px solid #dce4e8;
}

.dkm-accent-slate .dkm-card-top {
    background: linear-gradient(135deg, #4f646b 0%, #627980 48%, #7f959b 100%);
}

.dkm-accent-slate .dkm-rank-line {
    color: #5d7178;
}

@media (max-width: 900px) {
    .dkm-head-layout,
    .dkm-stat-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 640px) {
    .dkm-root {
        padding: 20px 16px 40px;
    }

    .dkm-header-card,
    .dkm-section {
        padding: 22px 18px;
        border-radius: 24px;
    }

    .dkm-title {
        font-size: 30px;
    }

    .dkm-grid,
    .dkm-grid-featured {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="dkm-root">
    <div class="dkm-shell">
        <div class="dkm-header-card">
            <div class="dkm-header-content">
                <div class="dkm-eyebrow">
                    <div class="dkm-dot"></div>
                    {{ $pageEyebrow ?? 'Dewan Kemakmuran Masjid' }}
                </div>

                <div class="dkm-head-layout">
                    <div>
                        <h1 class="dkm-title">{{ $pageTitle ?? 'Struktur Pengurus & Anggota DKM' }}</h1>
                        <p class="dkm-subtitle">
                            {{ $pageSubtitle ?? 'Susunan pengurus kini ditampilkan berdasarkan tingkatan jabatan, sehingga posisi inti seperti Ketua, pengurus harian, layanan ibadah, hingga seksi pendukung lebih mudah dipahami dalam satu alur visual.' }}
                        </p>
                    </div>

                    <div class="dkm-header-note">
                        <strong>{{ $pageNoteTitle ?? 'Hierarki organisasi lebih jelas' }}</strong>
                        <p>
                            {{ $pageNoteCopy ?? 'Setiap bagian disusun dari jabatan tertinggi ke lapisan pendukung agar struktur kerja DKM terasa lebih profesional dan mudah dibaca jamaah.' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="dkm-stat-grid">
                <div class="dkm-stat-card">
                    <span class="dkm-stat-label">Total Anggota Aktif</span>
                    <strong class="dkm-stat-value">{{ $dkm->count() }}</strong>
                    <span class="dkm-stat-sub">Seluruh pengurus dan anggota yang sudah tercatat pada sistem.</span>
                </div>

                <div class="dkm-stat-card">
                    <span class="dkm-stat-label">Lapisan Struktur</span>
                    <strong class="dkm-stat-value">{{ $dkmSections->count() }}</strong>
                    <span class="dkm-stat-sub">Dibagi ke beberapa tingkatan agar jalur organisasi terlihat lebih tertata.</span>
                </div>

                <div class="dkm-stat-card">
                    <span class="dkm-stat-label">Pimpinan Tertinggi</span>
                    <strong class="dkm-stat-value">{{ $ketuaDkm->nama ?? 'Belum Diatur' }}</strong>
                    <span class="dkm-stat-sub">{{ $ketuaDkm->jabatan ?? 'Data Ketua belum tersedia di daftar jabatan.' }}</span>
                </div>
            </div>
        </div>

        <div class="dkm-count-bar">
            <div class="dkm-count-copy">
                Struktur ditampilkan <strong>berdasarkan hierarki jabatan</strong>,
                dimulai dari pimpinan utama hingga anggota pendukung.
            </div>

            <div class="dkm-count-pills">
                <span class="dkm-count-pill">{{ $dkm->count() }} Anggota</span>
                <span class="dkm-count-pill">{{ $dkmSections->count() }} Tingkatan</span>
            </div>
        </div>

        @foreach($dkmSections as $section)
            @php
                $sectionMeta = $section['meta'];
                $sectionMembers = $section['members'];
                $sectionKey = $section['key'];
            @endphp
            <section class="dkm-section dkm-accent-{{ $sectionMeta['accent'] }}">
                <div class="dkm-section-head">
                    <div>
                        <div class="dkm-section-kicker">{{ $sectionMeta['level'] }}</div>
                        <h2 class="dkm-section-title">{{ $sectionMeta['title'] }}</h2>
                        <p class="dkm-section-copy">{{ $sectionMeta['description'] }}</p>
                    </div>

                    <div class="dkm-section-count">{{ $sectionMembers->count() }} Anggota</div>
                </div>

                <div class="dkm-grid {{ $sectionKey === 'pimpinan' ? 'dkm-grid-featured' : '' }}">
                    @foreach($sectionMembers as $d)
                        @php
                            $words = explode(' ', $d->nama);
                            $initials = strtoupper(
                                (isset($words[0]) ? $words[0][0] : '') .
                                (isset($words[1]) ? $words[1][0] : '')
                            );
                        @endphp

                        <a href="/dkm/{{ $d->id }}" class="dkm-card">
                            <div class="dkm-card-top">
                                <div class="dkm-tier-badge">{{ $sectionMeta['level'] }}</div>
                                <div class="dkm-badge-ribbon">{{ $sectionMeta['ribbon'] }}</div>

                                <div class="dkm-avatar-wrap">
                                    @if($d->foto)
                                        <img src="{{ $d->foto }}" alt="{{ $d->nama }}" class="dkm-avatar">
                                    @else
                                        <div class="dkm-avatar-initials">{{ $initials }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="dkm-card-body">
                                <div class="dkm-rank-line">{{ $sectionMeta['title'] }}</div>
                                <div class="dkm-nama">{{ $d->nama }}</div>
                                <div class="dkm-jabatan-text">{{ $d->jabatan ?? 'Anggota DKM' }}</div>

                                <div class="dkm-chip-row">
                                    <span class="dkm-chip">{{ $d->jabatan ?? 'Anggota' }}</span>
                                    <span class="dkm-chip dkm-chip-soft">{{ $sectionMeta['level'] }}</span>
                                </div>
                            </div>

                            <div class="dkm-card-footer">
                                Lihat Profil
                                <span class="dkm-arrow">→</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>
</div>
@endsection
