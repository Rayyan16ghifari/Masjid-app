<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap');

* { box-sizing: border-box; }

/* ══════════════════════════════════
   LAYERED DARK GREEN BACKGROUND
══════════════════════════════════ */
.db-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    min-height: 100vh;
    position: relative;
    overflow: hidden;
    background: #0a2e1f;
}

/* Gradient mesh layer */
.db-bg {
    position: absolute;
    inset: 0;
    z-index: 0;
    background:
        radial-gradient(ellipse 80% 60% at 10% 0%,   rgba(29,158,117,0.18) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 90% 100%, rgba(8,80,65,0.30)    0%, transparent 55%),
        radial-gradient(ellipse 50% 40% at 50% 50%,  rgba(15,110,86,0.08)  0%, transparent 70%),
        linear-gradient(160deg, #0d3322 0%, #0a2219 40%, #071a14 100%);
}

/* Subtle grid texture */
.db-grid-tex {
    position: absolute;
    inset: 0;
    z-index: 0;
    background-image:
        linear-gradient(rgba(29,158,117,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(29,158,117,0.04) 1px, transparent 1px);
    background-size: 48px 48px;
}

/* Glow orbs */
.orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    z-index: 0;
    pointer-events: none;
}
.orb1 { width: 500px; height: 500px; background: rgba(29,158,117,0.12); top: -120px; left: -100px; }
.orb2 { width: 400px; height: 400px; background: rgba(8,80,65,0.20);    bottom: -80px; right: -60px; }
.orb3 { width: 300px; height: 300px; background: rgba(255,215,0,0.05);  top: 40%; left: 50%; }

/* Content layer */
.db {
    position: relative;
    z-index: 1;
    padding: 36px 32px;
}

/* ── HERO ── */
.hero {
    border-radius: 24px;
    overflow: hidden;
    position: relative;
    height: 300px;
    margin-bottom: 40px;
    border: 1px solid rgba(29,158,117,0.25);
}

.hero-bg-g {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(8,80,65,0.95) 0%, rgba(15,110,86,0.9) 50%, rgba(29,158,117,0.85) 100%);
}

.hero-pattern {
    position: absolute;
    inset: 0;
    background-image:
        radial-gradient(circle at 20% 80%, rgba(255,215,0,0.07) 0%, transparent 40%),
        radial-gradient(circle at 80% 20%, rgba(255,255,255,0.04) 0%, transparent 40%);
}

.hero-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    gap: 40px;
    padding: 40px 48px;
}

.hero-mosque {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    border: 2px solid rgba(255,215,0,0.3);
    background: rgba(255,215,0,0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
    flex-shrink: 0;
}

.hero-text { color: white; }

.hero-eyebrow {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #9FE1CB;
    margin-bottom: 10px;
}

.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: 30px;
    font-weight: 700;
    line-height: 1.25;
    margin-bottom: 10px;
}

.hero-sub {
    font-size: 13px;
    color: rgba(255,255,255,0.65);
    line-height: 1.7;
    margin-bottom: 18px;
}

.hero-stats { display: flex; gap: 28px; margin-bottom: 20px; }

.hstat-num {
    font-size: 22px;
    font-weight: 700;
    color: #FFD700;
}

.hstat-lbl {
    font-size: 11px;
    color: rgba(255,255,255,0.55);
    margin-top: 2px;
}

.hero-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 22px;
    background: #FFD700;
    color: #0a2e1f;
    font-size: 13px;
    font-weight: 700;
    border-radius: 20px;
    text-decoration: none;
    transition: opacity 0.2s;
}

.hero-btn:hover { opacity: 0.85; text-decoration: none; color: #0a2e1f; }

/* ── SECTION HEADER ── */
.sec-head {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
}

.sec-label {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    font-weight: 700;
    color: #9FE1CB;
    white-space: nowrap;
}

.sec-badge {
    font-size: 10px;
    font-weight: 600;
    padding: 3px 10px;
    background: rgba(29,158,117,0.2);
    color: #5DCAA5;
    border-radius: 20px;
    border: 1px solid rgba(29,158,117,0.25);
    white-space: nowrap;
}

.sec-line {
    flex: 1;
    height: 1px;
    background: rgba(29,158,117,0.2);
}

/* ── GALLERY ── */
.gallery-wrap { position: relative; margin-bottom: 44px; }

.gallery-track {
    display: flex;
    gap: 16px;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding-bottom: 6px;
    scrollbar-width: none;
}

.gallery-track::-webkit-scrollbar { display: none; }

.gallery-slide {
    flex: 0 0 270px;
    height: 170px;
    border-radius: 16px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    background: rgba(15,110,86,0.4);
    border: 1px solid rgba(29,158,117,0.2);
    transition: border-color 0.25s;
}

.gallery-slide:hover { border-color: rgba(29,158,117,0.5); }

.gallery-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.gallery-slide:hover img { transform: scale(1.05); }

.gallery-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 44px;
}

.gallery-cap {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(5,30,20,0.9));
    color: rgba(255,255,255,0.9);
    padding: 28px 14px 12px;
    font-size: 12px;
    font-weight: 500;
}

.gal-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(13,51,34,0.9);
    border: 1px solid rgba(29,158,117,0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 2;
    font-size: 18px;
    color: #9FE1CB;
    transition: background 0.2s;
    line-height: 1;
}

.gal-arrow:hover { background: rgba(29,158,117,0.25); }
.gal-prev { left: -14px; }
.gal-next { right: -14px; }

/* ── DKM GRID ── */
.dkm-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
    gap: 16px;
    margin-bottom: 44px;
}

.dkm-card {
    background: rgba(13,51,34,0.7);
    backdrop-filter: blur(8px);
    border-radius: 18px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    border: 1px solid rgba(29,158,117,0.2);
    transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
}

.dkm-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.3);
    border-color: rgba(29,158,117,0.45);
    text-decoration: none;
}

.dkm-card-top {
    background: linear-gradient(135deg, #085041, #1D9E75);
    height: 56px;
    position: relative;
}

.dkm-avatar {
    position: absolute;
    bottom: -26px;
    left: 50%;
    transform: translateX(-50%);
    width: 52px;
    height: 52px;
    border-radius: 50%;
    border: 3px solid #0d3322;
    object-fit: cover;
}

.dkm-avatar-init {
    position: absolute;
    bottom: -26px;
    left: 50%;
    transform: translateX(-50%);
    width: 52px;
    height: 52px;
    border-radius: 50%;
    border: 3px solid #0d3322;
    background: #0F6E56;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 700;
    color: white;
    font-family: 'Playfair Display', serif;
}

.dkm-body {
    padding: 34px 12px 16px;
    text-align: center;
}

.dkm-nama {
    font-size: 13px;
    font-weight: 600;
    color: #9FE1CB;
    margin-bottom: 3px;
}

.dkm-jab {
    font-size: 11px;
    color: rgba(159,225,203,0.5);
    margin-bottom: 8px;
}

.dkm-chip {
    font-size: 10px;
    font-weight: 600;
    padding: 3px 10px;
    background: rgba(29,158,117,0.15);
    color: #5DCAA5;
    border-radius: 20px;
    border: 1px solid rgba(29,158,117,0.2);
}

.dkm-card-more {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 140px;
    border-style: dashed !important;
    color: #5DCAA5;
    font-size: 13px;
    font-weight: 600;
}

/* ── KAJIAN GRID ── */
.kjn-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
    gap: 16px;
    margin-bottom: 44px;
}

.kjn-card {
    background: rgba(13,51,34,0.7);
    backdrop-filter: blur(8px);
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid rgba(29,158,117,0.18);
    transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
}

.kjn-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.3);
    border-color: rgba(29,158,117,0.4);
}

.kjn-img {
    width: 100%;
    height: 130px;
    object-fit: cover;
    display: block;
}

.kjn-img-ph {
    width: 100%;
    height: 130px;
    background: rgba(8,80,65,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
}

.kjn-body { padding: 13px; }

.hot-badge {
    display: inline-block;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 9px;
    background: rgba(226,75,74,0.15);
    color: #F09595;
    border-radius: 20px;
    border: 1px solid rgba(226,75,74,0.2);
    margin-bottom: 6px;
}

.new-badge {
    display: inline-block;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 9px;
    background: rgba(29,158,117,0.15);
    color: #5DCAA5;
    border-radius: 20px;
    border: 1px solid rgba(29,158,117,0.2);
    margin-bottom: 6px;
}

.kjn-title {
    font-size: 13px;
    font-weight: 600;
    color: #9FE1CB;
    margin-bottom: 5px;
    line-height: 1.4;
}

.kjn-meta {
    font-size: 11px;
    color: rgba(159,225,203,0.5);
    margin-top: 3px;
}

/* ── VIDEO GRID ── */
.vid-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}

.vid-card {
    background: rgba(13,51,34,0.7);
    backdrop-filter: blur(8px);
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid rgba(29,158,117,0.18);
    cursor: pointer;
    transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
}

.vid-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.3);
    border-color: rgba(29,158,117,0.4);
}

.vid-thumb {
    position: relative;
    height: 120px;
    background: rgba(8,80,65,0.6);
    overflow: hidden;
}

.vid-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.75;
}

.vid-play {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255,215,0,0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: #0a2e1f;
    transition: transform 0.2s;
}

.vid-card:hover .vid-play { transform: translate(-50%, -50%) scale(1.1); }

.vid-body { padding: 11px 13px; }

.vid-title {
    font-size: 13px;
    font-weight: 600;
    color: #9FE1CB;
    margin-bottom: 3px;
    line-height: 1.4;
}

.vid-meta {
    font-size: 11px;
    color: rgba(159,225,203,0.5);
}

/* ── RESPONSIVE ── */
@media (max-width: 640px) {
    .db { padding: 20px 16px; }
    .hero { height: auto; }
    .hero-overlay { flex-direction: column; gap: 20px; padding: 28px 24px; align-items: flex-start; }
    .hero-title { font-size: 22px; }
    .hero-stats { gap: 16px; }
}
</style>

<div class="db-wrap">
    {{-- BACKGROUND LAYERS --}}
    <div class="db-bg"></div>
    <div class="db-grid-tex"></div>
    <div class="orb orb1"></div>
    <div class="orb orb2"></div>
    <div class="orb orb3"></div>

    <div class="db">

        {{-- ══ HERO ══ --}}
        <div class="hero">
            <div class="hero-bg-g"></div>
            <div class="hero-pattern"></div>
            <div class="hero-overlay">
                <div class="hero-mosque">🕌</div>
                <div class="hero-text">
                    <div class="hero-eyebrow">Masjid Al-Hasanah</div>
                    <div class="hero-title">Website Resmi &<br>Dewan Kemakmuran Masjid</div>
                    <div class="hero-sub">
                        Komplek Pushubad Cijantung Jl.Radar VII Kel.Kalisari Kec.Pasar Rebo, Jakarta Timur 13790<br>
                        Selamat datang, {{ auth()->user()->name }}
                    </div>
                    <div class="hero-stats">
                        <div class="hstat">
                            <div class="hstat-num">{{ $dkm->count() }}</div>
                            <div class="hstat-lbl">Anggota DKM</div>
                        </div>
                        <div class="hstat">
                            <div class="hstat-num">{{ \App\Models\Kajian::count() }}</div>
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

        {{-- ══ GALERI ══ --}}
        <div class="sec-head">
            <div class="sec-label">Galeri Masjid</div>
            <span class="sec-badge">Dokumentasi</span>
            <div class="sec-line"></div>
        </div>
        <div class="gallery-wrap">
            <button class="gal-arrow gal-prev" onclick="galleryScroll(-1)">‹</button>
            <div class="gallery-track" id="galleryTrack">
                {{--
                    Ganti dengan foto dari database jika sudah ada:
                    @foreach($fotoMasjid as $foto)
                    <div class="gallery-slide">
                        <img src="{{ $foto->url }}" alt="{{ $foto->keterangan }}">
                        <div class="gallery-cap">{{ $foto->keterangan }}</div>
                    </div>
                    @endforeach
                --}}
                <div class="gallery-track" id="galleryTrack">

    {{-- ===== SLOT GAMBAR MASJID ===== --}}
    {{-- Tinggal ganti nama file di bawah ini sesuai folder kamu --}}

        <div class="gallery-slide">
            <img src="{{ asset('images/masjid/Masjid2.jpg') }}">
            <div class="gallery-cap">Halaman Luar Masjid</div>
        </div>

        <div class="gallery-slide">
            <img src="{{ asset('images/masjid/Masjid5.jpg') }}">
            <div class="gallery-cap">Halaman Dalam Masjid</div>
        </div>

        <div class="gallery-slide">
            <img src="{{ asset('images/masjid/Masjid3.jpg') }}">
            <div class="gallery-cap">Kegiatan TPA</div>
        </div>

        <div class="gallery-slide">
            <img src="{{ asset('images/masjid/photo1.jpg') }}">
            <div class="gallery-cap">Kajian Rutin</div>
        </div>

        <div class="gallery-slide">
            <img src="{{ asset('images/masjid/Masjid4.jpg') }}">
            <div class="gallery-cap">Menu Sahur</div>
        </div>

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
                $words = explode(' ', $d->nama);
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

        {{-- ══ TRENDING ══ --}}
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

        {{-- ══ TERBARU ══ --}}
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

        {{-- ══ VIDEO ══ --}}
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
function galleryScroll(dir) {
    document.getElementById('galleryTrack').scrollLeft += dir * 300;
}

function playVideo(el, id) {
    if (!id) return;
    el.querySelector('.vid-thumb').innerHTML = `
        <iframe width="100%" height="120"
            src="https://www.youtube.com/embed/${id}?autoplay=1"
            frameborder="0"
            allow="autoplay; encrypted-media"
            allowfullscreen>
        </iframe>`;
}
</script>

</x-app-layout>
