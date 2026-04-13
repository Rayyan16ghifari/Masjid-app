<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap');

* { box-sizing: border-box; }

.dkm-root {
    font-family: 'Plus Jakarta Sans', sans-serif;
    padding: 48px 40px;
    background: #f4f6f3;
    min-height: 100vh;
}

/* ── HEADER ── */
.dkm-header {
    text-align: center;
    margin-bottom: 48px;
}

.dkm-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #0F6E56;
    margin-bottom: 14px;
    background: #E1F5EE;
    padding: 6px 14px;
    border-radius: 20px;
}

.dkm-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #1D9E75;
}

.dkm-title {
    font-family: 'Playfair Display', serif;
    font-size: 36px;
    font-weight: 700;
    color: #085041;
    line-height: 1.2;
    margin-bottom: 12px;
}

.dkm-subtitle {
    font-size: 14px;
    color: #5F5E5A;
    max-width: 420px;
    margin: 0 auto;
    line-height: 1.7;
}

.dkm-divider {
    width: 48px;
    height: 3px;
    background: linear-gradient(90deg, #1D9E75, #5DCAA5);
    border-radius: 4px;
    margin: 18px auto 0;
}

/* ── COUNT BAR ── */
.dkm-count-bar {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin-bottom: 32px;
    font-size: 13px;
    color: #888780;
}

.dkm-count-num {
    font-size: 13px;
    font-weight: 600;
    color: #085041;
    background: #E1F5EE;
    padding: 3px 10px;
    border-radius: 12px;
}

/* ── GRID ── */
.dkm-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 24px;
    max-width: 1100px;
    margin: 0 auto;
}

/* ── CARD ── */
.dkm-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    border: 1px solid #e2e8e5;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    position: relative;
}

.dkm-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 48px rgba(15, 110, 86, 0.13);
    text-decoration: none;
    color: inherit;
}

/* ── CARD TOP ── */
.dkm-card-top {
    background: linear-gradient(135deg, #085041 0%, #1D9E75 100%);
    height: 80px;
    position: relative;
}

.dkm-badge-ribbon {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(255, 255, 255, 0.15);
    color: white;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 4px 10px;
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.25);
}

/* ── AVATAR ── */
.dkm-avatar-wrap {
    position: absolute;
    bottom: -36px;
    left: 50%;
    transform: translateX(-50%);
}

.dkm-avatar {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    border: 4px solid white;
    object-fit: cover;
    background: #E1F5EE;
}

.dkm-avatar-initials {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    border: 4px solid white;
    background: #0F6E56;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    font-weight: 700;
    color: white;
    font-family: 'Playfair Display', serif;
}

/* ── CARD BODY ── */
.dkm-card-body {
    padding: 50px 20px 24px;
    text-align: center;
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.dkm-nama {
    font-size: 15px;
    font-weight: 600;
    color: #085041;
    margin-bottom: 4px;
}

.dkm-jabatan-text {
    font-size: 12px;
    color: #888780;
    margin-bottom: 14px;
}

.dkm-chip {
    display: inline-block;
    padding: 5px 14px;
    background: #E1F5EE;
    color: #0F6E56;
    font-size: 11px;
    font-weight: 600;
    border-radius: 20px;
    letter-spacing: 0.5px;
}

/* ── CARD FOOTER ── */
.dkm-card-footer {
    border-top: 1px solid #f0f0ee;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-size: 12px;
    color: #1D9E75;
    font-weight: 500;
}

.dkm-arrow {
    display: inline-block;
    transition: transform 0.2s;
}

.dkm-card:hover .dkm-arrow {
    transform: translateX(4px);
}
</style>

<div class="dkm-root">

    {{-- HEADER --}}
    <div class="dkm-header">
        <div class="dkm-eyebrow">
            <div class="dkm-dot"></div>
            Dewan Kemakmuran Masjid
        </div>
        <h1 class="dkm-title">Pengurus &amp; Anggota DKM</h1>
        <p class="dkm-subtitle">
            Mereka yang berdedikasi dalam memakmurkan masjid
            dan melayani jamaah dengan sepenuh hati.
        </p>
        <div class="dkm-divider"></div>
    </div>

    {{-- COUNT BAR --}}
    <div class="dkm-count-bar">
        <span>Menampilkan</span>
        <span class="dkm-count-num">{{ $dkm->count() }} Anggota</span>
        <span>aktif</span>
    </div>

    {{-- GRID --}}
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

            {{-- TOP BANNER --}}
            <div class="dkm-card-top">
                <div class="dkm-badge-ribbon">DKM</div>
                <div class="dkm-avatar-wrap">
                    @if($d->foto)
                        <img src="{{ $d->foto }}" alt="{{ $d->nama }}" class="dkm-avatar">
                    @else
                        <div class="dkm-avatar-initials">{{ $initials }}</div>
                    @endif
                </div>
            </div>

            {{-- BODY --}}
            <div class="dkm-card-body">
                <div class="dkm-nama">{{ $d->nama }}</div>
                <div class="dkm-jabatan-text">{{ $d->jabatan }}</div>
                <span class="dkm-chip">{{ $d->jabatan ?? 'Anggota' }}</span>
            </div>

            {{-- FOOTER --}}
            <div class="dkm-card-footer">
                Lihat Profil
                <span class="dkm-arrow">→</span>
            </div>

        </a>
        @endforeach
    </div>

</div>
</x-app-layout>
