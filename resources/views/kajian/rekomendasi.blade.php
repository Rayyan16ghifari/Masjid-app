<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap');

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
        radial-gradient(ellipse 80% 60% at 10% 0%,   rgba(29,158,117,0.18) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 90% 100%, rgba(8,80,65,0.30)    0%, transparent 55%),
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

/* ── HEADER ── */
.rk-head { text-align: center; margin-bottom: 44px; }

.rk-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #5DCAA5;
    background: rgba(29,158,117,0.15);
    border: 1px solid rgba(29,158,117,0.25);
    padding: 6px 16px;
    border-radius: 20px;
    margin-bottom: 16px;
}

.rk-title {
    font-family: 'Playfair Display', serif;
    font-size: 34px;
    font-weight: 700;
    color: #9FE1CB;
    margin-bottom: 12px;
    line-height: 1.25;
}

.rk-sub {
    font-size: 14px;
    color: rgba(159,225,203,0.55);
    max-width: 460px;
    margin: 0 auto 0;
    line-height: 1.7;
}

/* ── DIAGRAM ALUR ── */
.diagram {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    margin: 40px 0 44px;
    flex-wrap: wrap;
}

.d-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    width: 140px;
}

.d-icon {
    width: 62px;
    height: 62px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    border: 2px solid rgba(29,158,117,0.35);
    background: rgba(13,51,34,0.8);
    transition: border-color 0.2s;
}

.d-step:hover .d-icon { border-color: rgba(29,158,117,0.7); }

.d-label {
    font-size: 12px;
    font-weight: 600;
    color: #9FE1CB;
    text-align: center;
    line-height: 1.4;
}

.d-sub {
    font-size: 11px;
    color: rgba(159,225,203,0.4);
    text-align: center;
    line-height: 1.4;
}

.d-arrow {
    font-size: 22px;
    color: rgba(29,158,117,0.35);
    margin: 0 -4px;
    padding-bottom: 32px;
}

/* ── STAT PILLS ── */
.stat-row {
    display: flex;
    gap: 14px;
    justify-content: center;
    margin-bottom: 44px;
    flex-wrap: wrap;
}

.stat-pill {
    background: rgba(13,51,34,0.7);
    border: 1px solid rgba(29,158,117,0.2);
    border-radius: 14px;
    padding: 14px 28px;
    text-align: center;
    backdrop-filter: blur(8px);
}

.sp-num {
    font-size: 24px;
    font-weight: 700;
    color: #FFD700;
    font-family: 'Playfair Display', serif;
}

.sp-lbl {
    font-size: 11px;
    color: rgba(159,225,203,0.5);
    margin-top: 4px;
}

/* ── SEC HEAD ── */
.sec-head { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; }
.sec-label { font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 700; color: #9FE1CB; white-space: nowrap; }
.sec-badge { font-size: 10px; font-weight: 600; padding: 3px 10px; background: rgba(29,158,117,0.2); color: #5DCAA5; border-radius: 20px; border: 1px solid rgba(29,158,117,0.25); }
.sec-line { flex: 1; height: 1px; background: rgba(29,158,117,0.2); }

/* ── GRID ── */
.r-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 18px;
}

.r-card {
    background: rgba(13,51,34,0.7);
    backdrop-filter: blur(8px);
    border-radius: 18px;
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
    height: 140px;
    object-fit: cover;
    display: block;
}

.r-img-ph {
    width: 100%;
    height: 140px;
    background: rgba(8,80,65,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    position: relative;
}

.r-rec-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(255,215,0,0.12);
    border: 1px solid rgba(255,215,0,0.28);
    color: #FFD700;
    font-size: 10px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
}

.r-body { padding: 14px; }

.r-title {
    font-size: 14px;
    font-weight: 600;
    color: #9FE1CB;
    margin-bottom: 6px;
    line-height: 1.4;
}

.r-meta {
    font-size: 11px;
    color: rgba(159,225,203,0.5);
    margin-top: 3px;
}

.r-chip {
    margin-top: 12px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 10px;
    font-weight: 700;
    padding: 4px 12px;
    background: rgba(255,215,0,0.1);
    color: #FFD700;
    border-radius: 20px;
    border: 1px solid rgba(255,215,0,0.2);
}

/* ── EMPTY ── */
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
    max-width: 420px;
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
    line-height: 1.7;
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
    transition: opacity 0.2s;
}

.empty-btn:hover { opacity: 0.85; text-decoration: none; color: #0a2e1f; }

@media (max-width: 640px) {
    .rk { padding: 20px 16px; }
    .rk-title { font-size: 26px; }
    .diagram { gap: 8px; }
    .d-arrow { display: none; }
    .d-step { width: 110px; }
}
</style>

<div class="rk-wrap">
    <div class="rk-bg"></div>
    <div class="rk-tex"></div>
    <div class="orb orb1"></div>
    <div class="orb orb2"></div>

    <div class="rk">

        {{-- ══ HEADER ══ --}}
        <div class="rk-head">
            <div><div class="rk-eyebrow">✦ Powered by Collaborative Filtering</div></div>
            <div class="rk-title">Rekomendasi Kajian<br>Khusus Untuk Kamu</div>
            <div class="rk-sub">Sistem menganalisa pola rating jamaah lain yang memiliki selera serupa untuk menemukan kajian yang paling relevan bagimu.</div>
        </div>

        {{-- ══ DIAGRAM ALUR ══ --}}
        <div class="diagram">
            <div class="d-step">
                <div class="d-icon">⭐</div>
                <div class="d-label">Kamu Beri Rating</div>
                <div class="d-sub">Nilai kajian yang sudah ditonton</div>
            </div>
            <div class="d-arrow">→</div>
            <div class="d-step">
                <div class="d-icon">🔍</div>
                <div class="d-label">Analisa Kesamaan</div>
                <div class="d-sub">Temukan jamaah berselera mirip</div>
            </div>
            <div class="d-arrow">→</div>
            <div class="d-step">
                <div class="d-icon">🧠</div>
                <div class="d-label">Cosine Similarity</div>
                <div class="d-sub">Hitung skor kemiripan vektor</div>
            </div>
            <div class="d-arrow">→</div>
            <div class="d-step">
                <div class="d-icon">🎯</div>
                <div class="d-label">Kajian Terpilih</div>
                <div class="d-sub">Rekomendasi personal untukmu</div>
            </div>
        </div>

        @php $recommended = $recommended ?? collect(); @endphp

        @if(!$recommended->isEmpty())
        {{-- STAT PILLS --}}
        <div class="stat-row">
            <div class="stat-pill">
                <div class="sp-num">{{ $recommended->count() }}</div>
                <div class="sp-lbl">Kajian Cocok</div>
            </div>
            <div class="stat-pill">
                <div class="sp-num">{{ \App\Models\Rating::where('user_id', auth()->id())->count() }}</div>
                <div class="sp-lbl">Rating Kamu</div>
            </div>
            <div class="stat-pill">
                <div class="sp-num">{{ \App\Models\Kajian::count() }}</div>
                <div class="sp-lbl">Total Kajian</div>
            </div>
        </div>

        {{-- HASIL --}}
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
                        📖
                        <div class="r-rec-badge">✦ Match</div>
                    </div>
                @endif
                <div class="r-body">
                    <div class="r-title">{{ $k->judul }}</div>
                    <div class="r-meta">👤 {{ $k->ustadz->nama ?? '-' }}</div>
                    <div class="r-meta">📖 {{ $k->kitab->nama ?? '-' }}</div>
                    @if($k->hari)
                    <div class="r-meta">🗓 {{ $k->hari }} - Pekan {{ $k->pekan }}</div>
                    @endif
                    @if($k->waktu)
                    <div class="r-meta">⏰ {{ $k->waktu }}</div>
                    @endif
                    @if($k->lokasi)
                    <div class="r-meta">📍 {{ $k->lokasi }}</div>
                    @endif
                    <span class="r-chip">✨ Direkomendasikan</span>
                </div>
            </div>
            @endforeach
        </div>

        @else
        {{-- EMPTY STATE --}}
        <div class="empty-wrap">
            <div class="empty-box">
                <div class="empty-icon">🤔</div>
                <div class="empty-title">Belum Ada Rekomendasi</div>
                <div class="empty-sub">
                    Berikan rating pada kajian yang sudah kamu ikuti agar sistem bisa memahami preferensimu dan menemukan kajian yang cocok.
                </div>
                <a href="/kajian" class="empty-btn">📚 Lihat Kajian</a>
            </div>
        </div>
        @endif

    </div>
</div>
</x-app-layout>
