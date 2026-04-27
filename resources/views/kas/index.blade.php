@extends('layouts.app')

@section('content')

<style>
    .kas-page {
        color: #ffffff;
    }

    .kas-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 26px;
    }

    .kas-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        padding: 8px 12px;
        border: 1px solid rgba(244,196,48,0.28);
        border-radius: 999px;
        color: #f4c430;
        background: rgba(244,196,48,0.1);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 1.8px;
        text-transform: uppercase;
    }

    .kas-title {
        margin: 0;
        font-size: clamp(26px, 3vw, 40px);
        line-height: 1.1;
        font-weight: 800;
        letter-spacing: -0.8px;
    }

    .kas-description {
        max-width: 680px;
        margin: 12px 0 0;
        color: rgba(255,255,255,0.72);
        font-size: 15px;
        line-height: 1.7;
        font-weight: 500;
    }

    .kas-date-badge {
        min-width: max-content;
        padding: 12px 16px;
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 18px;
        color: rgba(255,255,255,0.78);
        background: rgba(255,255,255,0.08);
        font-size: 13px;
        font-weight: 700;
    }

    .summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .box {
        position: relative;
        overflow: hidden;
        padding: 22px;
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 24px;
        background: linear-gradient(145deg, rgba(255,255,255,0.14), rgba(255,255,255,0.06));
        box-shadow: 0 18px 48px rgba(0,0,0,0.18);
    }

    .box::after {
        content: "";
        position: absolute;
        right: -28px;
        top: -28px;
        width: 96px;
        height: 96px;
        border-radius: 50%;
        background: rgba(244,196,48,0.14);
    }

    .box-label {
        margin: 0 0 14px;
        color: rgba(255,255,255,0.68);
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .box-value {
        display: block;
        font-size: clamp(22px, 2.4vw, 32px);
        line-height: 1;
        font-weight: 800;
        letter-spacing: -0.6px;
    }

    .box-note {
        margin-top: 12px;
        color: rgba(255,255,255,0.58);
        font-size: 12px;
        font-weight: 600;
    }

    .text-income {
        color: #62d394;
    }

    .text-expense {
        color: #ff7b7b;
    }

    .text-balance {
        color: #f4c430;
    }

    .kas-panel {
        margin-bottom: 24px;
        padding: 22px;
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 26px;
        background: rgba(2,32,24,0.58);
        box-shadow: 0 18px 48px rgba(0,0,0,0.16);
    }

    .panel-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
    }

    .panel-title {
        margin: 0;
        font-size: 18px;
        font-weight: 800;
    }

    .panel-subtitle {
        margin: 6px 0 0;
        color: rgba(255,255,255,0.6);
        font-size: 13px;
        line-height: 1.6;
    }

    .kas-form {
        display: grid;
        grid-template-columns: 1.4fr 1fr 0.8fr 1fr auto;
        gap: 12px;
        align-items: end;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        color: rgba(255,255,255,0.74);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.8px;
        text-transform: uppercase;
    }

    .form-control {
        width: 100%;
        height: 46px;
        border: 1px solid rgba(255,255,255,0.14);
        border-radius: 14px;
        padding: 0 14px;
        color: #ffffff;
        background: rgba(255,255,255,0.08);
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        outline: none;
        transition: 0.2s ease;
    }

    .form-control::placeholder {
        color: rgba(255,255,255,0.42);
    }

    .form-control:focus {
        border-color: rgba(244,196,48,0.72);
        background: rgba(255,255,255,0.12);
        box-shadow: 0 0 0 4px rgba(244,196,48,0.1);
    }

    .form-control option {
        color: #04291f;
    }

    .btn-submit {
        height: 46px;
        border: none;
        border-radius: 14px;
        padding: 0 18px;
        color: #04291f;
        background: linear-gradient(135deg, #ffe680, #f4c430);
        box-shadow: 0 12px 24px rgba(244,196,48,0.2);
        cursor: pointer;
        font-family: inherit;
        font-size: 14px;
        font-weight: 800;
        transition: 0.22s ease;
        white-space: nowrap;
    }

    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 16px 30px rgba(244,196,48,0.28);
    }

    .table-panel {
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 26px;
        background: rgba(2,32,24,0.58);
        box-shadow: 0 18px 48px rgba(0,0,0,0.16);
    }

    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 20px 22px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .table-title {
        margin: 0;
        font-size: 18px;
        font-weight: 800;
    }

    .table-count {
        padding: 8px 12px;
        border-radius: 999px;
        color: #f4c430;
        background: rgba(244,196,48,0.1);
        font-size: 12px;
        font-weight: 800;
    }

    .table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        min-width: 720px;
    }

    .table th {
        padding: 15px 18px;
        color: rgba(255,255,255,0.62);
        background: rgba(255,255,255,0.05);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.9px;
        text-align: left;
        text-transform: uppercase;
    }

    .table td {
        padding: 16px 18px;
        border-top: 1px solid rgba(255,255,255,0.08);
        color: rgba(255,255,255,0.84);
        font-size: 14px;
        font-weight: 600;
    }

    .table tr:hover td {
        background: rgba(255,255,255,0.04);
    }

    .badge-type {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 11px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        text-transform: capitalize;
    }

    .badge-income {
        color: #62d394;
        background: rgba(98,211,148,0.12);
    }

    .badge-expense {
        color: #ff7b7b;
        background: rgba(255,123,123,0.12);
    }

    .amount-income {
        color: #62d394;
        font-weight: 800;
    }

    .amount-expense {
        color: #ff7b7b;
        font-weight: 800;
    }

    .empty-state {
        padding: 34px 20px;
        color: rgba(255,255,255,0.64);
        text-align: center;
        font-size: 14px;
        font-weight: 600;
    }

    @media (max-width: 1024px) {
        .kas-header {
            flex-direction: column;
        }

        .summary {
            grid-template-columns: 1fr;
        }

        .kas-form {
            grid-template-columns: 1fr 1fr;
        }

        .btn-submit {
            width: 100%;
        }
    }

    @media (max-width: 640px) {
        .kas-panel,
        .table-panel,
        .box {
            border-radius: 20px;
        }

        .kas-form {
            grid-template-columns: 1fr;
        }

        .table-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<div class="kas-page">
    <div class="kas-header">
        <div>
            <div class="kas-eyebrow">Kas Masjid</div>
            <h2 class="kas-title">Informasi Kas Masjid</h2>
            <p class="kas-description">Pantau pemasukan, pengeluaran, dan saldo kas Masjid Al-Hasanah secara lebih rapi, transparan, dan mudah dibaca.</p>
        </div>
        <div class="kas-date-badge">{{ now()->translatedFormat('d F Y') }}</div>
    </div>

    <div class="summary">
        <div class="box">
            <p class="box-label">Total Masuk</p>
            <b class="box-value text-income">Rp {{ number_format($totalMasuk ?? 0) }}</b>
            <div class="box-note">Akumulasi dana masuk</div>
        </div>

        <div class="box">
            <p class="box-label">Total Keluar</p>
            <b class="box-value text-expense">Rp {{ number_format($totalKeluar ?? 0) }}</b>
            <div class="box-note">Akumulasi dana keluar</div>
        </div>

        <div class="box">
            <p class="box-label">Saldo Saat Ini</p>
            <b class="box-value text-balance">Rp {{ number_format($saldo ?? 0) }}</b>
            <div class="box-note">Sisa saldo kas tersedia</div>
        </div>
    </div>

    <div class="kas-panel">
        <div class="panel-heading">
            <div>
                <h3 class="panel-title">Tambah Transaksi Kas</h3>
                <p class="panel-subtitle">Masukkan data pemasukan atau pengeluaran kas masjid dengan lengkap.</p>
            </div>
        </div>

        <form method="POST" action="/kas" class="kas-form">
            @csrf

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <input id="keterangan" class="form-control" name="keterangan" placeholder="Contoh: Infak Jumat" required>
            </div>

            <div class="form-group">
                <label for="nominal">Nominal</label>
                <input id="nominal" class="form-control" name="nominal" type="number" placeholder="Contoh: 500000" required>
            </div>

            <div class="form-group">
                <label for="tipe">Tipe</label>
                <select id="tipe" class="form-control" name="tipe" required>
                    <option value="masuk">Masuk</option>
                    <option value="keluar">Keluar</option>
                </select>
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input id="tanggal" class="form-control" type="date" name="tanggal" required>
            </div>

            <button type="submit" class="btn-submit">Tambah</button>
        </form>
    </div>

    <div class="table-panel">
        <div class="table-header">
            <h3 class="table-title">Riwayat Transaksi</h3>
            <div class="table-count">{{ isset($kas) ? count($kas) : 0 }} transaksi</div>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Tipe</th>
                        <th>Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kas as $k)
                        <tr>
                            <td>{{ $k->tanggal }}</td>
                            <td>{{ $k->keterangan }}</td>
                            <td>
                                <span class="badge-type {{ $k->tipe == 'masuk' ? 'badge-income' : 'badge-expense' }}">
                                    {{ $k->tipe }}
                                </span>
                            </td>
                            <td class="{{ $k->tipe == 'masuk' ? 'amount-income' : 'amount-expense' }}">
                                Rp {{ number_format($k->nominal) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-state">Belum ada data transaksi kas masjid.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
