@extends('layouts.main')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

* { box-sizing: border-box; }

.dp-page {
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

.dp-grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(29,158,117,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(29,158,117,0.04) 1px, transparent 1px);
    background-size: 48px 48px;
    pointer-events: none;
}

.dp-shell {
    position: relative;
    z-index: 1;
}

.dp-card {
    background: rgba(13,51,34,0.74);
    backdrop-filter: blur(14px);
    border: 1px solid rgba(29,158,117,0.2);
    border-radius: 28px;
    padding: 32px;
    box-shadow: 0 22px 60px rgba(0,0,0,0.22);
}

.dp-pill {
    display: inline-flex;
    padding: 6px 12px;
    border-radius: 999px;
    background: rgba(29,158,117,0.16);
    border: 1px solid rgba(29,158,117,0.22);
    color: #5dcaa5;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.dp-title {
    margin: 16px 0 10px;
    font-family: 'Playfair Display', serif;
    font-size: 34px;
    line-height: 1.18;
    color: #f7fff9;
    max-width: 640px;
}

.dp-copy {
    margin: 0 0 26px;
    max-width: 660px;
    font-size: 14px;
    line-height: 1.8;
    color: rgba(236,255,247,0.7);
}

.dp-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(320px, 0.9fr);
    gap: 20px;
}

.dp-panel {
    padding: 22px;
    border-radius: 22px;
    background: rgba(6,40,28,0.56);
    border: 1px solid rgba(29,158,117,0.16);
}

.dp-panel h2 {
    margin: 0 0 16px;
    font-family: 'Playfair Display', serif;
    font-size: 24px;
    color: #f7fff9;
}

.dp-step {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid rgba(29,158,117,0.12);
    font-size: 13px;
    color: rgba(236,255,247,0.74);
}

.dp-step:last-child {
    border-bottom: 0;
    padding-bottom: 0;
}

.dp-step span {
    width: 28px;
    height: 28px;
    border-radius: 999px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: rgba(29,158,117,0.18);
    color: #9fe1cb;
    font-size: 12px;
    font-weight: 700;
    flex-shrink: 0;
}

.dp-note {
    margin-top: 18px;
    padding: 14px 16px;
    border-radius: 16px;
    background: rgba(255,215,0,0.08);
    border: 1px solid rgba(255,215,0,0.12);
    font-size: 12px;
    line-height: 1.7;
    color: rgba(255,244,200,0.8);
}

.dp-action-card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: 18px;
    background: linear-gradient(150deg, rgba(29,158,117,0.16), rgba(255,215,0,0.06));
    border-color: rgba(255,215,0,0.12);
}

.dp-status {
    padding: 14px 16px;
    border-radius: 16px;
    background: rgba(6,40,28,0.56);
    border: 1px solid rgba(29,158,117,0.16);
    font-size: 13px;
    line-height: 1.7;
    color: rgba(236,255,247,0.78);
}

.dp-button {
    width: 100%;
    border: 0;
    border-radius: 18px;
    padding: 16px 18px;
    background: linear-gradient(135deg, #ffd700 0%, #e8be20 100%);
    color: #082116;
    font-size: 14px;
    font-weight: 800;
    letter-spacing: 0.4px;
    cursor: pointer;
    transition: transform 0.2s, opacity 0.2s;
}

.dp-button:hover:not(:disabled) {
    transform: translateY(-1px);
}

.dp-button:disabled {
    cursor: wait;
    opacity: 0.7;
}

.dp-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 16px;
    border-radius: 16px;
    text-decoration: none;
    border: 1px solid rgba(29,158,117,0.22);
    background: rgba(29,158,117,0.12);
    color: #9fe1cb;
    font-size: 13px;
    font-weight: 600;
}

.dp-link:hover {
    text-decoration: none;
    color: #9fe1cb;
    opacity: 0.92;
}

@media (max-width: 820px) {
    .dp-page {
        padding: 22px 16px;
        border-radius: 24px;
    }

    .dp-card {
        padding: 24px 20px;
    }

    .dp-title {
        font-size: 28px;
    }

    .dp-layout {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="dp-page">
    <div class="dp-grid"></div>

    <div class="dp-shell">
        <div class="dp-card">
            <span class="dp-pill">Pembayaran Donasi</span>
            <h1 class="dp-title">Selangkah lagi untuk menyelesaikan donasi Anda.</h1>
            <p class="dp-copy">
                Klik tombol pembayaran untuk membuka Midtrans, pilih metode transaksi yang Anda inginkan,
                lalu selesaikan prosesnya sampai status donasi tercatat.
            </p>

            <div class="dp-layout">
                <div class="dp-panel">
                    <h2>Alur Pembayaran</h2>

                    <div class="dp-step"><span>1</span>Klik tombol bayar untuk membuka popup Midtrans.</div>
                    <div class="dp-step"><span>2</span>Pilih metode pembayaran yang paling nyaman bagi Anda.</div>
                    <div class="dp-step"><span>3</span>Selesaikan transaksi dan tunggu statusnya diperbarui.</div>

                    <div class="dp-note">
                        Jika popup tertutup sebelum selesai, Anda bisa mencoba kembali atau cek halaman riwayat
                        untuk melihat status transaksi terakhir.
                    </div>
                </div>

                <div class="dp-panel dp-action-card">
                    <div>
                        <h2>Siap Diproses</h2>
                        <div class="dp-status" id="pay-status">Sistem siap membuka halaman Midtrans untuk melanjutkan pembayaran.</div>
                    </div>

                    <div>
                        <button id="pay-button" class="dp-button" type="button">Bayar Sekarang</button>
                    </div>

                    <a href="{{ route('donasi.history') }}" class="dp-link">Lihat Riwayat Donasi</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="YOUR_CLIENT_KEY"></script>

<script>
const payButton = document.getElementById('pay-button');
const payStatus = document.getElementById('pay-status');

payButton.addEventListener('click', function () {
    payButton.disabled = true;
    payStatus.textContent = 'Membuka popup Midtrans, mohon tunggu sebentar.';

    snap.pay(@json($snapToken), {
        onSuccess: function () {
            payStatus.textContent = 'Pembayaran berhasil. Anda akan diarahkan ke riwayat donasi.';
            window.location.href = '{{ route('donasi.history') }}';
        },
        onPending: function () {
            payButton.disabled = false;
            payStatus.textContent = 'Pembayaran belum selesai. Silakan lanjutkan transaksi atau cek kembali riwayat donasi.';
        },
        onError: function () {
            payButton.disabled = false;
            payStatus.textContent = 'Pembayaran gagal diproses. Silakan coba kembali beberapa saat lagi.';
        },
        onClose: function () {
            payButton.disabled = false;
            payStatus.textContent = 'Popup pembayaran ditutup sebelum transaksi selesai.';
        }
    });
});
</script>
@endsection
