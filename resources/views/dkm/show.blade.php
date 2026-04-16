@extends('layouts.main')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap');

* { box-sizing: border-box; }

.sp-root {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #f4f6f3;
    min-height: 100vh;
    padding: 40px 24px;
}

/* ── BACK BUTTON ── */
.sp-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 500;
    color: #0F6E56;
    text-decoration: none;
    margin-bottom: 28px;
    padding: 8px 16px;
    background: white;
    border-radius: 20px;
    border: 1px solid #d4e9e2;
    transition: background 0.2s;
}

.sp-back:hover {
    background: #E1F5EE;
    text-decoration: none;
    color: #0F6E56;
}

/* ── WRAPPER ── */
.sp-wrap {
    max-width: 680px;
    margin: 0 auto;
}

/* ── HERO BANNER ── */
.sp-hero {
    background: linear-gradient(135deg, #085041 0%, #1D9E75 100%);
    border-radius: 24px 24px 0 0;
    height: 120px;
    position: relative;
}

/* ── MAIN CARD ── */
.sp-card {
    background: white;
    border-radius: 0 0 24px 24px;
    border: 1px solid #e2e8e5;
    border-top: none;
    padding: 0 36px 36px;
}

/* ── AVATAR ── */
.sp-avatar-wrap {
    display: flex;
    justify-content: center;
}

.sp-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 5px solid white;
    object-fit: cover;
    margin-top: -50px;
    background: #E1F5EE;
}

.sp-avatar-initials {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 5px solid white;
    background: #0F6E56;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: 700;
    color: white;
    font-family: 'Playfair Display', serif;
    margin-top: -50px;
}

/* ── IDENTITY ── */
.sp-identity {
    text-align: center;
    padding: 16px 0 24px;
}

.sp-nama {
    font-family: 'Playfair Display', serif;
    font-size: 26px;
    font-weight: 700;
    color: #085041;
    margin-bottom: 8px;
}

.sp-chip {
    display: inline-block;
    padding: 5px 16px;
    background: #E1F5EE;
    color: #0F6E56;
    font-size: 12px;
    font-weight: 600;
    border-radius: 20px;
    letter-spacing: 0.5px;
}

/* ── DIVIDER ── */
.sp-divider {
    height: 1px;
    background: #f0f0ee;
    margin: 0 0 28px;
}

/* ── BIO ── */
.sp-bio {
    font-size: 14px;
    color: #5F5E5A;
    line-height: 1.8;
    text-align: center;
    margin-bottom: 28px;
    font-style: italic;
}

/* ── INFO GRID ── */
.sp-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 32px;
}

.sp-info-item {
    background: #f9fbf9;
    border-radius: 14px;
    padding: 16px 18px;
    border: 1px solid #eaf2ed;
}

.sp-info-item.full {
    grid-column: 1 / -1;
}

.sp-info-label {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #888780;
    margin-bottom: 5px;
}

.sp-info-val {
    font-size: 14px;
    font-weight: 500;
    color: #085041;
    word-break: break-word;
}

/* ── FOOTER BTN ── */
.sp-footer {
    display: flex;
    justify-content: center;
}

.sp-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: linear-gradient(135deg, #085041, #1D9E75);
    color: white;
    font-size: 13px;
    font-weight: 600;
    border-radius: 20px;
    text-decoration: none;
    transition: opacity 0.2s;
}

.sp-btn:hover {
    opacity: 0.88;
    color: white;
    text-decoration: none;
}

/* ── RESPONSIVE ── */
@media (max-width: 500px) {
    .sp-card { padding: 0 20px 28px; }
    .sp-info-grid { grid-template-columns: 1fr; }
    .sp-info-item.full { grid-column: 1; }
    .sp-nama { font-size: 22px; }
}
</style>

<div class="sp-root">
    <div class="sp-wrap">

        {{-- BACK --}}
        <a href="/dkm" class="sp-back">← Kembali ke Daftar Anggota</a>

        {{-- HERO BANNER --}}
        <div class="sp-hero"></div>

        {{-- MAIN CARD --}}
        <div class="sp-card">

            {{-- AVATAR --}}
            <div class="sp-avatar-wrap">
                @if($d->foto)
                    <img src="{{ $d->foto }}" alt="{{ $d->nama }}" class="sp-avatar">
                @else
                    @php
                        $words = explode(' ', $d->nama);
                        $initials = strtoupper(
                            (isset($words[0]) ? $words[0][0] : '') .
                            (isset($words[1]) ? $words[1][0] : '')
                        );
                    @endphp
                    <div class="sp-avatar-initials">{{ $initials }}</div>
                @endif
            </div>

            {{-- NAMA & JABATAN --}}
            <div class="sp-identity">
                <div class="sp-nama">{{ $d->nama }}</div>
                <span class="sp-chip">{{ $d->jabatan ?? 'Anggota' }}</span>
            </div>

            <div class="sp-divider"></div>

            {{-- BIO --}}
            @if($d->bio)
            <p class="sp-bio">"{{ $d->bio }}"</p>
            @endif

            {{-- INFO DETAIL --}}
            <div class="sp-info-grid">

                @if($d->email)
                <div class="sp-info-item">
                    <div class="sp-info-label">Email</div>
                    <div class="sp-info-val">{{ $d->email }}</div>
                </div>
                @endif

                @if($d->no_hp)
                <div class="sp-info-item">
                    <div class="sp-info-label">No. HP</div>
                    <div class="sp-info-val">{{ $d->no_hp }}</div>
                </div>
                @endif

                @if($d->alamat)
                <div class="sp-info-item full">
                    <div class="sp-info-label">Alamat</div>
                    <div class="sp-info-val">{{ $d->alamat }}</div>
                </div>
                @endif

            </div>

            {{-- FOOTER --}}
            <div class="sp-footer">
                <a href="/dkm" class="sp-btn">← Kembali ke Daftar</a>
            </div>

        </div>{{-- end sp-card --}}

    </div>
</div>

@endsection
