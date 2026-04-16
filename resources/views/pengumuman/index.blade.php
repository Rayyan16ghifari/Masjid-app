@extends('layouts.app')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap');

* { box-sizing: border-box; }

/* ══ BACKGROUND ══ */
.pg-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    min-height: 100vh;
    position: relative;
    overflow: hidden;
    background: #0a2e1f;
}
.pg-bg {
    position: absolute; inset: 0; z-index: 0;
    background:
        radial-gradient(ellipse 80% 60% at 10% 0%,   rgba(29,158,117,0.18) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 90% 100%, rgba(8,80,65,0.30)    0%, transparent 55%),
        linear-gradient(160deg, #0d3322 0%, #0a2219 40%, #071a14 100%);
}
.pg-tex {
    position: absolute; inset: 0; z-index: 0;
    background-image:
        linear-gradient(rgba(29,158,117,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(29,158,117,0.04) 1px, transparent 1px);
    background-size: 48px 48px;
}
.orb { position: absolute; border-radius: 50%; filter: blur(80px); z-index: 0; pointer-events: none; }
.orb1 { width: 500px; height: 500px; background: rgba(29,158,117,0.12); top: -120px; left: -100px; }
.orb2 { width: 400px; height: 400px; background: rgba(8,80,65,0.20); bottom: -80px; right: -60px; }
.pg { position: relative; z-index: 1; padding: 36px 32px; }

/* ══ PAGE HEADER ══ */
.pg-head { margin-bottom: 36px; }
.pg-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: 11px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase;
    color: #5DCAA5; background: rgba(29,158,117,0.15);
    border: 1px solid rgba(29,158,117,0.25);
    padding: 5px 14px; border-radius: 20px; margin-bottom: 14px;
}
.pg-dot { width: 6px; height: 6px; border-radius: 50%; background: #1D9E75; }
.pg-title {
    font-family: 'Playfair Display', serif;
    font-size: 32px; font-weight: 700; color: #9FE1CB;
    margin-bottom: 10px; line-height: 1.2;
}
.pg-sub {
    font-size: 13px; color: rgba(159,225,203,0.5);
    line-height: 1.7; max-width: 480px;
}
.pg-divider {
    width: 40px; height: 2px;
    background: linear-gradient(90deg, #FFD700, transparent);
    border-radius: 2px; margin-top: 16px;
}

/* ══ FILTER TABS ══ */
.pg-tabs { display: flex; gap: 8px; margin-bottom: 28px; flex-wrap: wrap; }
.pg-tab {
    padding: 7px 18px; font-size: 12px; font-weight: 600;
    border-radius: 20px; border: 1px solid rgba(29,158,117,0.25);
    background: rgba(13,51,34,0.6); color: rgba(159,225,203,0.6);
    cursor: pointer; transition: all 0.2s; letter-spacing: 0.3px;
    text-decoration: none;
}
.pg-tab:hover, .pg-tab.active {
    background: rgba(29,158,117,0.2);
    color: #9FE1CB;
    border-color: rgba(29,158,117,0.45);
    text-decoration: none;
}

/* ══ FEATURED CARD (pengumuman terbaru / teratas) ══ */
.pg-featured {
    background: rgba(13,51,34,0.8);
    backdrop-filter: blur(12px);
    border-radius: 20px; overflow: hidden;
    border: 1px solid rgba(29,158,117,0.25);
    margin-bottom: 24px;
    display: grid; grid-template-columns: 2fr 3fr;
    position: relative;
    transition: border-color 0.25s;
}
.pg-featured:hover { border-color: rgba(29,158,117,0.5); text-decoration: none; }
/* Strip bercahaya */
.pg-featured::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, #1D9E75 30%, #FFD700 50%, #1D9E75 70%, transparent);
}
.pf-img {
    min-height: 260px; overflow: hidden; position: relative;
    background: rgba(8,80,65,0.5);
}
.pf-img img { width: 100%; height: 100%; object-fit: cover; opacity: 0.85; display: block; }
.pf-img-ph {
    width: 100%; height: 100%; min-height: 260px;
    display: flex; align-items: center; justify-content: center; font-size: 64px;
}
.pf-badge {
    position: absolute; top: 14px; left: 14px;
    font-size: 10px; font-weight: 700; padding: 4px 12px;
    background: rgba(255,215,0,0.15); color: #FFD700;
    border: 1px solid rgba(255,215,0,0.28);
    border-radius: 20px; letter-spacing: 0.8px; text-transform: uppercase;
}
.pf-body {
    padding: 32px 36px;
    display: flex; flex-direction: column; justify-content: center;
}
.pf-kategori {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 10px; font-weight: 700; letter-spacing: 1.5px;
    text-transform: uppercase; color: #5DCAA5; margin-bottom: 14px;
}
.pf-kategori-dot { width: 5px; height: 5px; border-radius: 50%; background: #1D9E75; }
.pf-title {
    font-family: 'Playfair Display', serif;
    font-size: 22px; font-weight: 700; color: #9FE1CB;
    margin-bottom: 12px; line-height: 1.35;
}
.pf-isi {
    font-size: 13px; color: rgba(159,225,203,0.6);
    line-height: 1.78; margin-bottom: 20px;
    display: -webkit-box; -webkit-line-clamp: 3;
    -webkit-box-orient: vertical; overflow: hidden;
}
.pf-meta { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
.pf-tanggal { font-size: 11px; color: rgba(159,225,203,0.45); }
.pf-read-btn {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 12px; font-weight: 700; padding: 8px 20px;
    background: #FFD700; color: #071a14; border-radius: 20px;
    text-decoration: none; margin-left: auto; transition: opacity 0.2s;
}
.pf-read-btn:hover { opacity: 0.85; text-decoration: none; color: #071a14; }

/* ══ GRID CARDS ══ */
.pg-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 18px;
}
.pg-card {
    background: rgba(13,51,34,0.7);
    backdrop-filter: blur(8px);
    border-radius: 18px; overflow: hidden;
    border: 1px solid rgba(29,158,117,0.18);
    transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
    display: flex; flex-direction: column;
    text-decoration: none; color: inherit;
}
.pg-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 36px rgba(0,0,0,0.3);
    border-color: rgba(29,158,117,0.42);
    text-decoration: none;
}
.pc-img {
    height: 160px; overflow: hidden;
    position: relative; background: rgba(8,80,65,0.45);
    flex-shrink: 0;
}
.pc-img img { width: 100%; height: 100%; object-fit: cover; opacity: 0.85; transition: transform 0.3s; display: block; }
.pg-card:hover .pc-img img { transform: scale(1.04); }
.pc-img-ph {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center; font-size: 40px;
}
.pc-cat-badge {
    position: absolute; bottom: 10px; left: 12px;
    font-size: 9px; font-weight: 700; padding: 3px 10px;
    border-radius: 20px; letter-spacing: 0.8px; text-transform: uppercase;
}
.pc-cat-umum    { background: rgba(29,158,117,0.2);  color: #5DCAA5; border: 1px solid rgba(29,158,117,0.3); }
.pc-cat-ibadah  { background: rgba(255,215,0,0.12);  color: #FFD700; border: 1px solid rgba(255,215,0,0.25); }
.pc-cat-kegiatan{ background: rgba(93,202,165,0.12); color: #9FE1CB; border: 1px solid rgba(93,202,165,0.25); }
.pc-cat-lainnya { background: rgba(159,225,203,0.1); color: rgba(159,225,203,0.7); border: 1px solid rgba(159,225,203,0.2); }

.pc-body { padding: 16px 18px; flex: 1; display: flex; flex-direction: column; }
.pc-title {
    font-family: 'Playfair Display', serif;
    font-size: 15px; font-weight: 700; color: #9FE1CB;
    margin-bottom: 8px; line-height: 1.4;
}
.pc-isi {
    font-size: 12px; color: rgba(159,225,203,0.55);
    line-height: 1.72; margin-bottom: 14px; flex: 1;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}
.pc-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding-top: 12px; border-top: 1px solid rgba(29,158,117,0.1);
}
.pc-tanggal { font-size: 11px; color: rgba(159,225,203,0.38); }
.pc-arrow {
    display: flex; align-items: center; justify-content: center;
    width: 28px; height: 28px; border-radius: 50%;
    background: rgba(29,158,117,0.15);
    border: 1px solid rgba(29,158,117,0.22);
    color: #5DCAA5; font-size: 13px; transition: background 0.2s;
    flex-shrink: 0;
}
.pg-card:hover .pc-arrow { background: rgba(29,158,117,0.3); }

/* ══ EMPTY STATE ══ */
.pg-empty {
    text-align: center; padding: 80px 20px;
}
.pg-empty-box {
    background: rgba(13,51,34,0.7); backdrop-filter: blur(8px);
    border: 1px solid rgba(29,158,117,0.2); border-radius: 24px;
    padding: 52px 40px; max-width: 400px; margin: 0 auto;
}
.pg-empty-icon { font-size: 52px; margin-bottom: 16px; }
.pg-empty-title {
    font-family: 'Playfair Display', serif;
    font-size: 20px; color: #9FE1CB; margin-bottom: 8px;
}
.pg-empty-sub { font-size: 13px; color: rgba(159,225,203,0.45); line-height: 1.7; }

/* ══ RESPONSIVE ══ */
@media (max-width: 768px) {
    .pg { padding: 20px 16px; }
    .pg-featured { grid-template-columns: 1fr; }
    .pf-img { min-height: 200px; }
    .pf-body { padding: 20px 20px 24px; }
    .pf-title { font-size: 18px; }
    .pg-grid { grid-template-columns: 1fr; }
    .pg-title { font-size: 26px; }
}
</style>

<div class="pg-wrap">
    <div class="pg-bg"></div>
    <div class="pg-tex"></div>
    <div class="orb orb1"></div>
    <div class="orb orb2"></div>

    <div class="pg">

        {{-- ══ PAGE HEADER ══ --}}
        <div class="pg-head">
            <div class="pg-eyebrow">
                <div class="pg-dot"></div>
                Masjid Al-Hasanah
            </div>
            <h1 class="pg-title">Pengumuman Masjid</h1>
            <p class="pg-sub">
                Informasi terkini mengenai kegiatan, jadwal, dan pengumuman penting
                dari Masjid Al-Hasanah.
            </p>
            <div class="pg-divider"></div>
        </div>

        {{-- ══ FILTER TABS ══ --}}
        <div class="pg-tabs">
            <a href="?kategori=" class="pg-tab {{ !request('kategori') ? 'active' : '' }}">Semua</a>
            <a href="?kategori=umum" class="pg-tab {{ request('kategori') == 'umum' ? 'active' : '' }}">Umum</a>
            <a href="?kategori=ibadah" class="pg-tab {{ request('kategori') == 'ibadah' ? 'active' : '' }}">Ibadah</a>
            <a href="?kategori=kegiatan" class="pg-tab {{ request('kategori') == 'kegiatan' ? 'active' : '' }}">Kegiatan</a>
        </div>

        @if($pengumuman->isEmpty())

            {{-- ══ EMPTY STATE ══ --}}
            <div class="pg-empty">
                <div class="pg-empty-box">
                    <div class="pg-empty-icon">📢</div>
                    <div class="pg-empty-title">Belum Ada Pengumuman</div>
                    <p class="pg-empty-sub">
                        Pengumuman dari Masjid Al-Hasanah akan muncul di sini.
                        Pantau terus halaman ini untuk informasi terbaru.
                    </p>
                </div>
            </div>

        @else

            {{-- ══ FEATURED — pengumuman pertama/terbaru ══ --}}
            @php $featured = $pengumuman->first(); @endphp

            <a href="/pengumuman/{{ $featured->id }}" class="pg-featured" style="text-decoration:none;">
                <div class="pf-img">
                    @if($featured->gambar)
                        <img src="{{ $featured->gambar }}" alt="{{ $featured->judul }}"
                             onerror="this.parentElement.querySelector('.pf-img-ph').style.display='flex';this.style.display='none';">
                        <div class="pf-img-ph" style="display:none;">📢</div>
                    @else
                        <div class="pf-img-ph">📢</div>
                    @endif
                    <div class="pf-badge">Terbaru</div>
                </div>
                <div class="pf-body">
                    <div class="pf-kategori">
                        <div class="pf-kategori-dot"></div>
                        {{ $featured->kategori ?? 'Pengumuman' }}
                    </div>
                    <div class="pf-title">{{ $featured->judul }}</div>
                    <div class="pf-isi">{{ $featured->isi }}</div>
                    <div class="pf-meta">
                        <span class="pf-tanggal">
                            📅 {{ \Carbon\Carbon::parse($featured->tanggal)->translatedFormat('d F Y') }}
                        </span>
                        <span class="pf-read-btn">Baca Selengkapnya →</span>
                    </div>
                </div>
            </a>

            {{-- ══ GRID — pengumuman sisanya ══ --}}
            @if($pengumuman->count() > 1)
            <div class="pg-grid">
                @foreach($pengumuman->skip(1) as $p)
                @php
                    $catClass = match(strtolower($p->kategori ?? '')) {
                        'ibadah'   => 'pc-cat-ibadah',
                        'kegiatan' => 'pc-cat-kegiatan',
                        'umum'     => 'pc-cat-umum',
                        default    => 'pc-cat-lainnya',
                    };
                    $catLabel = $p->kategori ?? 'Umum';
                @endphp
                <a href="/pengumuman/{{ $p->id }}" class="pg-card">
                    <div class="pc-img">
                        @if($p->gambar)
                            <img src="{{ $p->gambar }}" alt="{{ $p->judul }}"
                                 onerror="this.parentElement.querySelector('.pc-img-ph').style.display='flex';this.style.display='none';">
                            <div class="pc-img-ph" style="display:none;">📢</div>
                        @else
                            <div class="pc-img-ph">📢</div>
                        @endif
                        <div class="pc-cat-badge {{ $catClass }}">{{ $catLabel }}</div>
                    </div>
                    <div class="pc-body">
                        <div class="pc-title">{{ $p->judul }}</div>
                        <div class="pc-isi">{{ $p->isi }}</div>
                        <div class="pc-footer">
                            <span class="pc-tanggal">
                                📅 {{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d F Y') }}
                            </span>
                            <div class="pc-arrow">→</div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif

        @endif

    </div>
</div>

@endsection
