@extends('layouts.app')

@section('title', 'Donasi - Sedekah')

@section('content')

@php
    $qrisPath = 'images/qris-masjid.png';
    $hasQris  = file_exists(public_path($qrisPath));
@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

* { box-sizing: border-box; }

.dn-page {
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #fff;
    padding: 36px 32px;
}

/* ══ PAGE HEADER ══ */
.dn-head { margin-bottom: 36px; }

.dn-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: 11px; font-weight: 700; letter-spacing: 2px;
    text-transform: uppercase; color: #FFD700;
    background: rgba(255,215,0,0.1);
    border: 1px solid rgba(255,215,0,0.25);
    padding: 5px 14px; border-radius: 20px; margin-bottom: 14px;
}
.dn-dot { width: 6px; height: 6px; border-radius: 50%; background: #FFD700; animation: pdot 2s infinite; }
@keyframes pdot { 0%,100%{opacity:1} 50%{opacity:.25} }

.dn-title {
    font-family: 'Playfair Display', serif;
    font-size: 32px; font-weight: 700; color: #9FE1CB;
    line-height: 1.2; margin-bottom: 10px;
}

.dn-sub {
    font-size: 13px; color: rgba(159,225,203,0.55);
    line-height: 1.75; max-width: 520px;
}

.dn-divider {
    width: 40px; height: 2px; margin-top: 16px;
    background: linear-gradient(90deg, #FFD700, transparent);
    border-radius: 2px;
}

/* ══ MAIN LAYOUT ══ */
.dn-layout {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 24px;
    align-items: start;
}

/* ══ QRIS CARD ══ */
.dn-qris-card {
    background: rgba(13,51,34,0.8);
    backdrop-filter: blur(12px);
    border-radius: px;
    border: 1px solid rgba(29,158,117,0.25);
    overflow: hidden;
    position: relative;
}
.dn-qris-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, #1D9E75 30%, #FFD700 50%, #1D9E75 70%, transparent);
}

/* QRIS header */
.dn-qris-header {
    padding: 22px 28px 18px;
    border-bottom: 1px solid rgba(29,158,117,0.15);
    display: flex; align-items: center; gap: 14px;
}
.dn-qris-icon {
    width: 44px; height: 44px; border-radius: 12px;
    background: rgba(29,158,117,0.18);
    border: 1px solid rgba(29,158,117,0.28);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.dn-qris-header-text {}
.dn-qris-header-title {
    font-family: 'Playfair Display', serif;
    font-size: 17px; font-weight: 700; color: #9FE1CB;
}
.dn-qris-header-sub {
    font-size: 11px; color: rgba(159,225,203,0.45); margin-top: 2px;
}

/* QRIS image area */
.dn-qris-body { padding: 16px 20px; }

.dn-qris-frame {
    background: #ffffff;
    border-radius: 16px;
    padding: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 850px;
    height: 850px;
    margin: 0 auto;
    position: relative;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    border: 2px solid rgba(29,158,117,0.1);
}

.dn-qris-frame img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: contain;
    border-radius: 8px;
}

/* QRIS empty state */
.dn-qris-empty {
    display: flex; flex-direction: column; align-items: center;
    justify-content: center; text-align: center; padding: 48px 24px;
    width: 320px;
    height: 320px;
    margin: 0 auto;
    background: rgba(255,255,255,0.95);
    border-radius: 16px;
    border: 2px dashed rgba(29,158,117,0.3);
}
.dn-qris-empty-icon {
    width: 72px; height: 72px; border-radius: 20px;
    background: linear-gradient(135deg, #ffe680, #f4c430);
    display: flex; align-items: center; justify-content: center;
    font-size: 28px; font-weight: 800; color: #04291f;
    margin-bottom: 16px; letter-spacing: -1px;
}
.dn-qris-empty strong {
    display: block; font-size: 15px; font-weight: 700;
    color: #1a3a2a; margin-bottom: 8px;
}
.dn-qris-empty span {
    font-size: 12px; color: rgba(4,41,31,0.6);
    line-height: 1.65; max-width: 260px;
}
.dn-qris-empty code {
    background: rgba(4,41,31,0.08); padding: 1px 6px;
    border-radius: 4px; font-size: 11px;
}

/* QRIS badge nmid */
.dn-qris-nmid {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 11px; font-weight: 600; color: rgba(159,225,203,0.45);
    margin-top: 14px;
    padding: 5px 12px;
    background: rgba(29,158,117,0.1);
    border: 1px solid rgba(29,158,117,0.18);
    border-radius: 20px;
    width: fit-content; margin-left: auto; margin-right: auto;
}

/* Peruntukan tabs */
.dn-peruntukan {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 12px; margin-top: 20px;
}
.dn-peruntukan-item {
    background: rgba(8,80,65,0.3);
    border: 1px solid rgba(29,158,117,0.2);
    border-radius: 14px; padding: 14px 16px;
    display: flex; align-items: flex-start; gap: 10px;
    transition: border-color .2s, background .2s;
}
.dn-peruntukan-item:hover {
    background: rgba(29,158,117,0.15);
    border-color: rgba(29,158,117,0.4);
}
.dn-peruntukan-emoji { font-size: 22px; flex-shrink: 0; margin-top: 1px; }
.dn-peruntukan-label {
    font-size: 10px; font-weight: 700; letter-spacing: 1px;
    text-transform: uppercase; color: rgba(159,225,203,0.45); margin-bottom: 3px;
}
.dn-peruntukan-val {
    font-size: 13px; font-weight: 600; color: #9FE1CB; line-height: 1.4;
}

/* Download btn */
.dn-btn-wrap { margin-top: 20px; display: flex; gap: 10px; flex-wrap: wrap; }
.dn-btn-primary {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 22px; background: #FFD700; color: #071a14;
    font-size: 13px; font-weight: 700; border-radius: 20px;
    text-decoration: none; transition: opacity .2s, transform .2s;
}
.dn-btn-primary:hover { opacity: .88; transform: translateY(-1px); color: #071a14; text-decoration: none; }
.dn-btn-secondary {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 22px; color: rgba(255,255,255,.8);
    border: 1px solid rgba(255,255,255,.15);
    background: rgba(255,255,255,.07);
    font-size: 13px; font-weight: 600; border-radius: 20px;
    text-decoration: none; transition: background .2s, transform .2s;
}
.dn-btn-secondary:hover { background: rgba(255,255,255,.12); transform: translateY(-1px); color: white; text-decoration: none; }

/* ══ SIDE PANEL ══ */
.dn-side { display: flex; flex-direction: column; gap: 18px; }

/* Statistik donasi */
.dn-stat-card {
    background: rgba(13,51,34,0.75);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    border: 1px solid rgba(29,158,117,0.2);
    overflow: hidden; position: relative;
}
.dn-stat-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, #FFD700 50%, transparent);
}
.dn-stat-header {
    padding: 16px 20px 12px;
    border-bottom: 1px solid rgba(29,158,117,0.12);
    font-family: 'Playfair Display', serif;
    font-size: 15px; font-weight: 700; color: #9FE1CB;
}
.dn-stat-body { padding: 16px 20px; display: flex; flex-direction: column; gap: 12px; }
.dn-stat-row {
    display: flex; align-items: center; justify-content: space-between;
    padding-bottom: 12px; border-bottom: 1px solid rgba(29,158,117,0.08);
}
.dn-stat-row:last-child { padding-bottom: 0; border-bottom: none; }
.dn-stat-lbl { font-size: 11px; color: rgba(159,225,203,0.45); font-weight: 600; }
.dn-stat-val { font-size: 15px; font-weight: 700; color: #FFD700; font-family: 'Playfair Display', serif; }

/* Cara donasi */
.dn-cara-card {
    background: rgba(13,51,34,0.75);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    border: 1px solid rgba(29,158,117,0.2);
    padding: 20px;
}
.dn-cara-title {
    font-family: 'Playfair Display', serif;
    font-size: 15px; font-weight: 700; color: #9FE1CB;
    margin-bottom: 16px; padding-bottom: 12px;
    border-bottom: 1px solid rgba(29,158,117,0.12);
}
.dn-cara-steps { display: flex; flex-direction: column; gap: 14px; }
.dn-cara-step { display: flex; gap: 12px; align-items: flex-start; }
.dn-cara-num {
    width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, #ffe680, #f4c430);
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 800; color: #04291f;
}
.dn-cara-text { font-size: 12px; color: rgba(159,225,203,.6); line-height: 1.68; font-weight: 500; padding-top: 4px; }

/* Rekening manual */
.dn-rekening-card {
    background: rgba(13,51,34,0.75);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    border: 1px solid rgba(255,215,0,0.18);
    padding: 20px;
    position: relative; overflow: hidden;
}
.dn-rekening-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, #FFD700 50%, transparent);
}
.dn-rekening-title {
    font-family: 'Playfair Display', serif;
    font-size: 15px; font-weight: 700; color: #FFD700;
    margin-bottom: 14px; display: flex; align-items: center; gap: 8px;
}
.dn-rekening-item {
    background: rgba(8,80,65,0.3);
    border: 1px solid rgba(29,158,117,0.18);
    border-radius: 12px; padding: 13px 14px;
    margin-bottom: 10px;
}
.dn-rekening-item:last-child { margin-bottom: 0; }
.dn-rekening-bank {
    font-size: 10px; font-weight: 700; letter-spacing: 1.2px;
    text-transform: uppercase; color: rgba(159,225,203,0.45); margin-bottom: 4px;
}
.dn-rekening-no {
    font-size: 16px; font-weight: 700; color: #9FE1CB;
    font-family: 'Playfair Display', serif; letter-spacing: 1px;
}
.dn-rekening-atas {
    font-size: 11px; color: rgba(159,225,203,0.5); margin-top: 3px;
}

/* ══ RESPONSIVE ══ */
@media (max-width: 1024px) {
    .dn-layout { grid-template-columns: 1fr; }
    .dn-side { display: grid; grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .dn-page { padding: 20px 16px; }
    .dn-title { font-size: 24px; }
    .dn-peruntukan { grid-template-columns: 1fr; }
    .dn-side { grid-template-columns: 1fr; }
    .dn-btn-wrap a { flex: 1; justify-content: center; }
}
</style>

<div class="dn-page">

    {{-- ══ PAGE HEADER ══ --}}
    <div class="dn-head">
        <div class="dn-eyebrow">
            <div class="dn-dot"></div>
            Donasi Masjid
        </div>
        <h1 class="dn-title">Donasi untuk Masjid<br>Al-Hasanah</h1>
        <p class="dn-sub">
            Salurkan donasi Anda dengan mudah melalui QRIS. Setiap donasi
            Anda menjadi jariyah yang mengalir terus untuk kemakmuran masjid
            dan kebaikan umat.
        </p>
        <div class="dn-divider"></div>
    </div>

    {{-- ══ MAIN LAYOUT ══ --}}
    <div class="dn-layout">

        {{-- QRIS CARD BESAR --}}
        <div class="dn-qris-card">

            <div class="dn-qris-header">
                <div class="dn-qris-icon">🕌</div>
                <div class="dn-qris-header-text">
                    <div class="dn-qris-header-title">QRIS Masjid Al-Hasanah</div>
                    <div class="dn-qris-header-sub">Scan untuk donasi · Berlaku untuk semua jenis pembayaran</div>
                </div>
            </div>

            <div class="dn-qris-body">

                {{-- ── GAMBAR QRIS ── --}}
                <div class="dn-qris-frame">
                    @if($hasQris)
                        <img
                            src="{{ asset($qrisPath) }}"
                            alt="QRIS Donasi Masjid Al-Hasanah"
                        >
                    @else
                        {{--
                            CARA PASANG QRIS:
                            1. Simpan file QRIS dengan nama: qris-masjid.png
                            2. Letakkan di folder: public/images/
                            3. Refresh halaman — gambar otomatis muncul
                        --}}
                        <div class="dn-qris-empty">
                            <div class="dn-qris-empty-icon">QR</div>
                            <strong>QRIS belum dipasang</strong>
                            <span>
                                Simpan gambar QRIS dengan nama
                                <code>qris-masjid.png</code>
                                di folder
                                <code>public/images/</code>
                            </span>
                        </div>
                    @endif
                </div>

                {{-- NMID info --}}
                <div class="dn-qris-nmid">
                    NMID: ID2025405499158 &nbsp;·&nbsp; Masjid Al-Hasanah
                </div>

                {{-- PERUNTUKAN --}}
                <div class="dn-peruntukan">
                    <div class="dn-peruntukan-item">
                        <div class="dn-peruntukan-emoji">🔧</div>
                        <div>
                            <div class="dn-peruntukan-label">Peruntukan 1</div>
                            <div class="dn-peruntukan-val">Operasional Masjid</div>
                        </div>
                    </div>
                    <div class="dn-peruntukan-item">
                        <div class="dn-peruntukan-emoji">🏗️</div>
                        <div>
                            <div class="dn-peruntukan-label">Peruntukan 2</div>
                            <div class="dn-peruntukan-val">Pembangunan & Renovasi</div>
                        </div>
                    </div>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="dn-btn-wrap">
                    @if($hasQris)
                        <a href="{{ asset($qrisPath) }}" download class="dn-btn-primary">
                            ↓ Unduh QRIS
                        </a>
                    @endif
                    <a href="/kontak" class="dn-btn-secondary">
                        ✉ Konfirmasi Donasi
                    </a>
                </div>

            </div>
        </div>
        {{-- END QRIS CARD --}}


        {{-- SIDE PANEL --}}
        <div class="dn-side">

            {{-- Statistik --}}
            <div class="dn-stat-card">
                <div class="dn-stat-header">📊 Statistik Donasi</div>
                <div class="dn-stat-body">
                    <div class="dn-stat-row">
                        <div class="dn-stat-lbl">Total Donasi Masuk</div>
                        <div class="dn-stat-val">
                            Rp {{ isset($totalDonasi) ? number_format($totalDonasi,0,',','.') : '—' }}
                        </div>
                    </div>
                    <div class="dn-stat-row">
                        <div class="dn-stat-lbl">Jumlah Transaksi</div>
                        <div class="dn-stat-val">
                            {{ isset($totalTransaksiDonasi) ? $totalTransaksiDonasi : '—' }} transaksi
                        </div>
                    </div>
                    <div class="dn-stat-row">
                        <div class="dn-stat-lbl">Donatur Aktif</div>
                        <div class="dn-stat-val">
                            {{ isset($totalDonatur) ? $totalDonatur : '—' }} orang
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cara Donasi --}}
            <div class="dn-cara-card">
                <div class="dn-cara-title">Cara Donasi via QRIS</div>
                <div class="dn-cara-steps">
                    <div class="dn-cara-step">
                        <div class="dn-cara-num">1</div>
                        <div class="dn-cara-text">
                            Buka aplikasi mobile banking, e-wallet, atau pembayaran yang mendukung QRIS.
                        </div>
                    </div>
                    <div class="dn-cara-step">
                        <div class="dn-cara-num">2</div>
                        <div class="dn-cara-text">
                            Pilih menu <strong style="color:#9FE1CB">Scan QR / QRIS</strong> lalu arahkan kamera ke kode QRIS di atas.
                        </div>
                    </div>
                    <div class="dn-cara-step">
                        <div class="dn-cara-num">3</div>
                        <div class="dn-cara-text">
                            Masukkan nominal donasi sesuai kemampuan, lalu selesaikan pembayaran.
                        </div>
                    </div>
                    <div class="dn-cara-step">
                        <div class="dn-cara-num">4</div>
                        <div class="dn-cara-text">
                            Simpan bukti transaksi. Donasi Anda tercatat sebagai amal jariyah insyaAllah.
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rekening Manual --}}
            <div class="dn-rekening-card">
                <div class="dn-rekening-title">
                    🏦 Transfer Melalu Rekening
                </div>
                <div class="dn-rekening-item">
                    <div class="dn-rekening-bank">Bank BSI (Bank Syariah Indonesia)</div>
                    <div class="dn-rekening-no">7123 4567 89</div>
                    <div class="dn-rekening-atas">a.n. DKM Masjid Al-Hasanah</div>
                </div>
                <div class="dn-rekening-item">
                    <div class="dn-rekening-bank">Bank BRI</div>
                    <div class="dn-rekening-no">0987 6543 210</div>
                    <div class="dn-rekening-atas">a.n. DKM Masjid Al-Hasanah</div>
                </div>
                <p style="font-size:11px;color:rgba(159,225,203,.35);margin-top:12px;line-height:1.6;">
                    * Setelah transfer, harap konfirmasi ke sekretariat masjid atau klik tombol Konfirmasi Donasi.
                </p>
            </div>

        </div>
        {{-- END SIDE --}}

    </div>
</div>

@endsection
