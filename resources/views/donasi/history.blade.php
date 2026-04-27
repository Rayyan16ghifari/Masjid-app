@extends('layouts.app')

@section('content')
@php
    $totalNominal = $donasi->sum('nominal');
    $pendingCount = $donasi->where('status', 'pending')->count();
    $completedCount = $donasi->filter(function ($item) {
        return in_array(strtolower($item->status), ['settlement', 'success', 'paid']);
    })->count();
@endphp
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

* { box-sizing: border-box; }

.dh-page {
    font-family: 'Plus Jakarta Sans', sans-serif;
    position: relative;
    overflow: hidden;
    border-radius: 28px;
    background:
        radial-gradient(ellipse 70% 50% at 12% 0%, rgba(29,158,117,0.18) 0%, transparent 60%),
        radial-gradient(ellipse 60% 45% at 100% 100%, rgba(8,80,65,0.26) 0%, transparent 55%),
        linear-gradient(160deg, #0d3322 0%, #0a2219 42%, #071a14 100%);
    padding: 36px 32px;
    color: #ecfff7;
}

.dh-grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(29,158,117,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(29,158,117,0.04) 1px, transparent 1px);
    background-size: 48px 48px;
    pointer-events: none;
}

.dh-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
}

.dh-orb-a {
    width: 320px;
    height: 320px;
    top: -90px;
    right: -40px;
    background: rgba(29,158,117,0.14);
}

.dh-shell {
    position: relative;
    z-index: 1;
}

.dh-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 18px;
    flex-wrap: wrap;
    margin-bottom: 24px;
}

.dh-kicker {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #5dcaa5;
    margin-bottom: 16px;
}

.dh-kicker::before {
    content: '';
    width: 8px;
    height: 8px;
    border-radius: 999px;
    background: #1d9e75;
}

.dh-title {
    margin: 0 0 10px;
    font-family: 'Playfair Display', serif;
    font-size: 32px;
    color: #f7fff9;
}

.dh-copy {
    margin: 0;
    max-width: 560px;
    font-size: 14px;
    line-height: 1.8;
    color: rgba(236,255,247,0.7);
}

.dh-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 18px;
    border-radius: 16px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    transition: transform 0.2s, opacity 0.2s;
}

.dh-action-primary {
    background: linear-gradient(135deg, #ffd700 0%, #e8be20 100%);
    color: #082116;
}

.dh-action-secondary {
    border: 1px solid rgba(29,158,117,0.22);
    background: rgba(29,158,117,0.12);
    color: #9fe1cb;
}

.dh-action:hover {
    transform: translateY(-1px);
    text-decoration: none;
    opacity: 0.92;
}

.dh-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.dh-stat-row {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 24px;
}

.dh-stat {
    padding: 18px 20px;
    border-radius: 20px;
    background: rgba(13,51,34,0.72);
    border: 1px solid rgba(29,158,117,0.18);
    backdrop-filter: blur(12px);
}

.dh-stat strong {
    display: block;
    margin-bottom: 8px;
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    color: #ffd700;
    line-height: 1.1;
}

.dh-stat span {
    font-size: 12px;
    color: rgba(159,225,203,0.62);
}

.dh-card {
    background: rgba(13,51,34,0.72);
    backdrop-filter: blur(14px);
    border: 1px solid rgba(29,158,117,0.2);
    border-radius: 26px;
    box-shadow: 0 22px 60px rgba(0,0,0,0.22);
    overflow: hidden;
}

.dh-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    flex-wrap: wrap;
    padding: 24px 24px 18px;
    border-bottom: 1px solid rgba(29,158,117,0.12);
}

.dh-card-head h2 {
    margin: 0;
    font-family: 'Playfair Display', serif;
    font-size: 24px;
    color: #f7fff9;
}

.dh-card-head p {
    margin: 6px 0 0;
    font-size: 12px;
    color: rgba(159,225,203,0.56);
}

.dh-badge {
    padding: 8px 12px;
    border-radius: 999px;
    border: 1px solid rgba(29,158,117,0.2);
    background: rgba(29,158,117,0.12);
    color: #9fe1cb;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.dh-table-wrap {
    overflow-x: auto;
}

.dh-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 760px;
}

.dh-table th,
.dh-table td {
    padding: 18px 24px;
    text-align: left;
}

.dh-table th {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: rgba(159,225,203,0.5);
    border-bottom: 1px solid rgba(29,158,117,0.12);
}

.dh-table td {
    font-size: 13px;
    color: #ecfff7;
    border-bottom: 1px solid rgba(29,158,117,0.08);
}

.dh-table tr:last-child td {
    border-bottom: 0;
}

.dh-muted {
    display: block;
    margin-top: 4px;
    font-size: 11px;
    color: rgba(159,225,203,0.5);
}

.dh-amount {
    font-size: 15px;
    font-weight: 700;
    color: #ffd700;
}

.dh-status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 12px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}

.dh-status-pending {
    background: rgba(255,215,0,0.12);
    border: 1px solid rgba(255,215,0,0.18);
    color: #ffd700;
}

.dh-status-success {
    background: rgba(29,158,117,0.16);
    border: 1px solid rgba(29,158,117,0.22);
    color: #9fe1cb;
}

.dh-status-neutral {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.12);
    color: rgba(236,255,247,0.72);
}

.dh-empty {
    padding: 36px 24px;
    text-align: center;
}

.dh-empty h3 {
    margin: 0 0 10px;
    font-family: 'Playfair Display', serif;
    font-size: 24px;
    color: #f7fff9;
}

.dh-empty p {
    margin: 0 auto 20px;
    max-width: 440px;
    font-size: 13px;
    line-height: 1.8;
    color: rgba(159,225,203,0.6);
}

@media (max-width: 760px) {
    .dh-page {
        padding: 22px 16px;
        border-radius: 24px;
    }

    .dh-title {
        font-size: 28px;
    }

    .dh-stat-row {
        grid-template-columns: 1fr;
    }

    .dh-card-head,
    .dh-table th,
    .dh-table td {
        padding-left: 16px;
        padding-right: 16px;
    }
}
</style>

<div class="dh-page">
    <div class="dh-grid"></div>
    <div class="dh-orb dh-orb-a"></div>

    <div class="dh-shell">
        <div class="dh-head">
            <div>
                <div class="dh-kicker">Donasi Masjid</div>
                <h1 class="dh-title">Riwayat Donasi</h1>
                <p class="dh-copy">Lihat daftar transaksi, nominal, metode pembayaran, dan status donasi Anda dalam satu tampilan yang lebih rapi.</p>
            </div>

            <div class="dh-actions">
                <a href="{{ route('donasi') }}" class="dh-action dh-action-primary">Buat Donasi Baru</a>
                <a href="{{ route('dashboard') }}" class="dh-action dh-action-secondary">Kembali ke Dashboard</a>
            </div>
        </div>

        <div class="dh-stat-row">
            <div class="dh-stat">
                <strong>{{ $donasi->count() }}</strong>
                <span>Total transaksi yang tercatat pada akun Anda.</span>
            </div>
            <div class="dh-stat">
                <strong>Rp {{ number_format($totalNominal, 0, ',', '.') }}</strong>
                <span>Akumulasi nominal seluruh donasi yang pernah Anda buat.</span>
            </div>
            <div class="dh-stat">
                <strong>{{ $pendingCount }}/{{ $completedCount }}</strong>
                <span>Perbandingan status pending dan transaksi yang sudah selesai.</span>
            </div>
        </div>

        <div class="dh-card">
            <div class="dh-card-head">
                <div>
                    <h2>Daftar Transaksi</h2>
                    <p>Urutan terbaru ditampilkan paling atas agar mudah dipantau.</p>
                </div>
                <div class="dh-badge">{{ $donasi->count() }} transaksi</div>
            </div>

            @if($donasi->isEmpty())
                <div class="dh-empty">
                    <h3>Belum ada donasi yang tercatat</h3>
                    <p>Setelah Anda membuat transaksi pertama, riwayat donasi akan muncul di halaman ini lengkap dengan status pembayarannya.</p>
                    <a href="{{ route('donasi') }}" class="dh-action dh-action-primary">Mulai Donasi Sekarang</a>
                </div>
            @else
                <div class="dh-table-wrap">
                    <table class="dh-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis Donasi</th>
                                <th>Nominal</th>
                                <th>Metode</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donasi as $d)
                                @php
                                    $status = strtolower($d->status ?? 'unknown');
                                    $statusLabel = ucwords(str_replace('_', ' ', $status));
                                    $statusClass = in_array($status, ['settlement', 'success', 'paid'])
                                        ? 'dh-status-success'
                                        : ($status === 'pending' ? 'dh-status-pending' : 'dh-status-neutral');
                                @endphp
                                <tr>
                                    <td>
                                        {{ optional($d->created_at)->format('d M Y, H:i') }}
                                        <span class="dh-muted">Waktu transaksi dibuat</span>
                                    </td>
                                    <td>
                                        {{ ucfirst($d->jenis) }}
                                        <span class="dh-muted">Kategori donasi yang dipilih</span>
                                    </td>
                                    <td class="dh-amount">Rp {{ number_format($d->nominal, 0, ',', '.') }}</td>
                                    <td>
                                        {{ strtoupper($d->metode ?? '-') }}
                                        <span class="dh-muted">Gateway pembayaran</span>
                                    </td>
                                    <td>
                                        <span class="dh-status {{ $statusClass }}">{{ $statusLabel }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
