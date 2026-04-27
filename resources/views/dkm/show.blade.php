@extends('layouts.app')

@section('content')
@php
    $words = preg_split('/\s+/', trim($d->nama ?? '')) ?: [];
    $initials = strtoupper(
        (isset($words[0][0]) ? $words[0][0] : '') .
        (isset($words[1][0]) ? $words[1][0] : '')
    );

    $bioLabel = 'Bidang / Keterangan';
    $normalizedBio = strtolower(trim((string) ($d->bio ?? '')));

    if ($normalizedBio !== '' && (
        str_contains($normalizedBio, 'koordinator') ||
        str_contains($normalizedBio, 'pengurus inti') ||
        str_contains($normalizedBio, 'penasehat')
    )) {
        $bioLabel = 'Koordinator / Bidang';
    }
@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

.sp-root {
    font-family: 'Plus Jakarta Sans', sans-serif;
    min-height: 100vh;
    padding: 38px 20px 56px;
    background:
        radial-gradient(circle at top left, rgba(244, 196, 48, 0.16), transparent 28%),
        radial-gradient(circle at top right, rgba(29, 158, 117, 0.12), transparent 35%),
        linear-gradient(180deg, #f5f7f4 0%, #edf3ef 100%);
}

.sp-wrap {
    max-width: 760px;
    margin: 0 auto;
}

.sp-topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 22px;
}

.sp-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 999px;
    background: #ffffff;
    color: #0f6e56;
    text-decoration: none;
    border: 1px solid #d8e7df;
    font-size: 13px;
    font-weight: 700;
}

.sp-back:hover {
    background: #eff8f4;
    color: #0f6e56;
    text-decoration: none;
}

.sp-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.sp-action-btn,
.sp-action-danger {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 124px;
    padding: 11px 18px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    border: 1px solid transparent;
}

.sp-action-btn {
    background: #ffffff;
    color: #0f6e56;
    border-color: #d8e7df;
}

.sp-action-btn:hover {
    background: #eff8f4;
    color: #0f6e56;
    text-decoration: none;
}

.sp-action-danger {
    background: #fff4f2;
    color: #b34735;
    border-color: #f1c9c1;
}

.sp-action-danger:hover {
    background: #ffe9e5;
    color: #b34735;
}

.sp-flash {
    margin-bottom: 18px;
    border-radius: 18px;
    padding: 16px 18px;
    background: #eef8f4;
    border: 1px solid #cde7dc;
    color: #0a5a46;
    font-size: 14px;
    line-height: 1.7;
}

.sp-hero {
    background: linear-gradient(135deg, #085041 0%, #0f6e56 42%, #1d9e75 100%);
    border-radius: 28px 28px 0 0;
    height: 136px;
    position: relative;
}

.sp-card {
    background: #ffffff;
    border-radius: 0 0 28px 28px;
    border: 1px solid #e2e8e5;
    border-top: none;
    padding: 0 34px 34px;
    box-shadow: 0 28px 70px rgba(10, 46, 31, 0.08);
}

.sp-avatar-wrap {
    display: flex;
    justify-content: center;
}

.sp-avatar,
.sp-avatar-initials {
    width: 108px;
    height: 108px;
    margin-top: -54px;
    border-radius: 50%;
    border: 5px solid #ffffff;
}

.sp-avatar {
    object-fit: cover;
    background: #e1f5ee;
}

.sp-avatar-initials {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #0f6e56;
    color: #ffffff;
    font-size: 34px;
    font-weight: 700;
    font-family: 'Playfair Display', serif;
}

.sp-identity {
    text-align: center;
    padding: 18px 0 24px;
}

.sp-kicker {
    display: inline-flex;
    padding: 6px 14px;
    margin-bottom: 12px;
    border-radius: 999px;
    background: #fff5dd;
    color: #9b6b00;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.sp-nama {
    margin: 0 0 10px;
    font-family: 'Playfair Display', serif;
    font-size: 30px;
    line-height: 1.15;
    color: #085041;
}

.sp-chip-row {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 10px;
}

.sp-chip {
    display: inline-flex;
    padding: 7px 16px;
    border-radius: 999px;
    background: #e7f6f0;
    color: #0f6e56;
    font-size: 12px;
    font-weight: 700;
}

.sp-divider {
    height: 1px;
    background: #edf2ef;
    margin: 0 0 26px;
}

.sp-highlight {
    padding: 16px 18px;
    border-radius: 18px;
    background: #f7fbf8;
    border: 1px solid #e5eeea;
    color: #4c675e;
    font-size: 14px;
    line-height: 1.8;
    margin-bottom: 24px;
}

.sp-highlight strong {
    display: block;
    margin-bottom: 6px;
    color: #0a5a46;
    font-size: 12px;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.sp-info-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 28px;
}

.sp-info-item {
    background: #f9fbf9;
    border-radius: 16px;
    padding: 16px 18px;
    border: 1px solid #eaf2ed;
}

.sp-info-item.full {
    grid-column: 1 / -1;
}

.sp-info-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.4px;
    text-transform: uppercase;
    color: #7b8c85;
    margin-bottom: 6px;
}

.sp-info-val {
    font-size: 14px;
    line-height: 1.7;
    font-weight: 600;
    color: #085041;
    word-break: break-word;
}

.sp-footer {
    display: flex;
    justify-content: center;
}

.sp-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 26px;
    border-radius: 999px;
    background: linear-gradient(135deg, #085041, #1d9e75);
    color: #ffffff;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
}

.sp-btn:hover {
    color: #ffffff;
    text-decoration: none;
    opacity: 0.92;
}

@media (max-width: 640px) {
    .sp-card {
        padding: 0 20px 28px;
    }

    .sp-info-grid {
        grid-template-columns: 1fr;
    }

    .sp-info-item.full {
        grid-column: 1;
    }

    .sp-nama {
        font-size: 24px;
    }
}
</style>

<div class="sp-root">
    <div class="sp-wrap">
        <div class="sp-topbar">
            <a href="{{ route('dkm.index') }}" class="sp-back">< Kembali ke Daftar DKM</a>

            <div class="sp-actions">
                <a href="{{ route('dkm.edit', $d->id) }}" class="sp-action-btn">Edit Data</a>

                <form action="{{ route('dkm.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Hapus data anggota DKM ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="sp-action-danger">Hapus Data</button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="sp-flash">{{ session('success') }}</div>
        @endif

        <div class="sp-hero"></div>

        <div class="sp-card">
            <div class="sp-avatar-wrap">
                @if($d->foto)
                    <img src="{{ $d->foto }}" alt="{{ $d->nama }}" class="sp-avatar">
                @else
                    <div class="sp-avatar-initials">{{ $initials }}</div>
                @endif
            </div>

            <div class="sp-identity">
                <div class="sp-kicker">Profil DKM</div>
                <h1 class="sp-nama">{{ $d->nama }}</h1>

                <div class="sp-chip-row">
                    <span class="sp-chip">{{ $d->jabatan ?? 'Anggota' }}</span>
                    @if($d->bio)
                        <span class="sp-chip">{{ $d->bio }}</span>
                    @endif
                </div>
            </div>

            <div class="sp-divider"></div>

            @if($d->bio)
                <div class="sp-highlight">
                    <strong>{{ $bioLabel }}</strong>
                    {{ $d->bio }}
                </div>
            @endif

            <div class="sp-info-grid">
                <div class="sp-info-item">
                    <div class="sp-info-label">Nama</div>
                    <div class="sp-info-val">{{ $d->nama }}</div>
                </div>

                <div class="sp-info-item">
                    <div class="sp-info-label">Jabatan / Seksi</div>
                    <div class="sp-info-val">{{ $d->jabatan ?? '-' }}</div>
                </div>

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

            <div class="sp-footer">
                <a href="{{ route('dkm.index') }}" class="sp-btn">Kembali ke Struktur DKM</a>
            </div>
        </div>
    </div>
</div>
@endsection
