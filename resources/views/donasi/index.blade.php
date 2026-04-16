@extends('layouts.main')

@section('content')
@php($selectedType = old('jenis', 'infaq'))
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

* { box-sizing: border-box; }

.dn-page {
    font-family: 'Plus Jakarta Sans', sans-serif;
    position: relative;
    overflow: hidden;
    border-radius: 28px;
    background:
        radial-gradient(ellipse 70% 50% at 12% 0%, rgba(29,158,117,0.18) 0%, transparent 60%),
        radial-gradient(ellipse 60% 45% at 100% 100%, rgba(8,80,65,0.28) 0%, transparent 55%),
        linear-gradient(160deg, #0d3322 0%, #0a2219 42%, #071a14 100%);
    padding: 36px 32px;
    color: #ecfff7;
}

.dn-grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(29,158,117,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(29,158,117,0.04) 1px, transparent 1px);
    background-size: 48px 48px;
    pointer-events: none;
}

.dn-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
}

.dn-orb-a {
    width: 360px;
    height: 360px;
    top: -110px;
    left: -60px;
    background: rgba(29,158,117,0.14);
}

.dn-orb-b {
    width: 300px;
    height: 300px;
    right: -70px;
    bottom: -110px;
    background: rgba(255,215,0,0.07);
}

.dn-shell {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.dn-alert {
    padding: 16px 18px;
    border-radius: 18px;
    border: 1px solid rgba(255,255,255,0.12);
    backdrop-filter: blur(10px);
    box-shadow: 0 18px 45px rgba(0,0,0,0.18);
}

.dn-alert strong {
    display: block;
    margin-bottom: 6px;
}

.dn-alert-success {
    background: rgba(13,83,60,0.75);
    color: #dff8ea;
    border-color: rgba(93,202,165,0.26);
}

.dn-alert-error {
    background: rgba(92,24,24,0.7);
    color: #ffdede;
    border-color: rgba(255,145,145,0.22);
}

.dn-alert ul {
    margin: 10px 0 0;
    padding-left: 18px;
}

.dn-layout {
    display: grid;
    grid-template-columns: minmax(0, 1.08fr) minmax(340px, 0.92fr);
    gap: 24px;
    align-items: start;
}

.dn-card {
    background: rgba(13,51,34,0.72);
    backdrop-filter: blur(14px);
    border: 1px solid rgba(29,158,117,0.2);
    border-radius: 26px;
    box-shadow: 0 22px 60px rgba(0,0,0,0.22);
}

.dn-hero {
    position: relative;
    overflow: hidden;
    padding: 32px;
}

.dn-hero::after {
    content: '';
    position: absolute;
    width: 220px;
    height: 220px;
    right: -55px;
    top: -55px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255,215,0,0.12), transparent 68%);
}

.dn-kicker {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #5dcaa5;
    margin-bottom: 18px;
}

.dn-kicker::before {
    content: '';
    width: 8px;
    height: 8px;
    border-radius: 999px;
    background: #1d9e75;
}

.dn-title {
    margin: 0 0 14px;
    font-family: 'Playfair Display', serif;
    font-size: 34px;
    line-height: 1.18;
    color: #f7fff9;
    max-width: 620px;
}

.dn-copy {
    margin: 0;
    max-width: 560px;
    font-size: 14px;
    line-height: 1.9;
    color: rgba(236,255,247,0.72);
}

.dn-stat-row {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
    margin: 28px 0 20px;
}

.dn-stat {
    padding: 18px;
    border-radius: 18px;
    background: rgba(6,40,28,0.52);
    border: 1px solid rgba(29,158,117,0.18);
}

.dn-stat strong {
    display: block;
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    line-height: 1;
    color: #ffd700;
    margin-bottom: 8px;
}

.dn-stat span {
    font-size: 12px;
    color: rgba(159,225,203,0.64);
}

.dn-feature-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
}

.dn-feature {
    padding: 18px;
    border-radius: 18px;
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(29,158,117,0.14);
}

.dn-feature h3 {
    margin: 0 0 8px;
    font-size: 15px;
    color: #ecfff7;
}

.dn-feature p {
    margin: 0;
    font-size: 12px;
    line-height: 1.7;
    color: rgba(159,225,203,0.62);
}

.dn-hero-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-top: 24px;
    padding-top: 22px;
    border-top: 1px solid rgba(29,158,117,0.14);
}

.dn-secondary-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 18px;
    border-radius: 16px;
    border: 1px solid rgba(29,158,117,0.22);
    background: rgba(29,158,117,0.12);
    color: #9fe1cb;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: background 0.2s, transform 0.2s;
}

.dn-secondary-link:hover {
    background: rgba(29,158,117,0.22);
    transform: translateY(-1px);
    color: #9fe1cb;
    text-decoration: none;
}

.dn-mini-note {
    font-size: 12px;
    color: rgba(159,225,203,0.56);
}

.dn-form-card {
    padding: 32px;
}

.dn-pill {
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

.dn-form-card h2 {
    margin: 16px 0 10px;
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    line-height: 1.18;
    color: #f7fff9;
}

.dn-form-card > p {
    margin: 0 0 24px;
    font-size: 13px;
    line-height: 1.8;
    color: rgba(236,255,247,0.68);
}

.dn-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.dn-field label {
    display: block;
    margin-bottom: 10px;
    font-size: 13px;
    font-weight: 600;
    color: #ecfff7;
}

.dn-inline-label {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 10px;
}

.dn-inline-label span {
    font-size: 11px;
    color: rgba(159,225,203,0.52);
}

.dn-input-wrap {
    display: flex;
    align-items: center;
    border-radius: 18px;
    background: rgba(6,40,28,0.68);
    border: 1px solid rgba(29,158,117,0.18);
    transition: border-color 0.2s, box-shadow 0.2s;
}

.dn-input-wrap:focus-within {
    border-color: rgba(29,158,117,0.5);
    box-shadow: 0 0 0 4px rgba(29,158,117,0.08);
}

.dn-prefix {
    padding-left: 18px;
    font-size: 16px;
    font-weight: 700;
    color: #ffd700;
}

.dn-input-wrap input {
    width: 100%;
    border: 0;
    outline: none;
    background: transparent;
    padding: 16px 18px 16px 12px;
    font-size: 20px;
    font-weight: 700;
    color: #f7fff9;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.dn-input-wrap input::placeholder {
    color: rgba(159,225,203,0.26);
    font-weight: 500;
}

.dn-input-wrap input::-webkit-outer-spin-button,
.dn-input-wrap input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.dn-input-wrap input[type=number] {
    -moz-appearance: textfield;
}

.dn-helper {
    margin-top: 8px;
    font-size: 12px;
    line-height: 1.7;
    color: rgba(159,225,203,0.54);
}

.dn-quick-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.dn-quick-btn {
    border: 1px solid rgba(29,158,117,0.18);
    background: rgba(255,255,255,0.03);
    color: #dff8ea;
    padding: 11px 14px;
    border-radius: 14px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s, border-color 0.2s, transform 0.2s;
}

.dn-quick-btn:hover,
.dn-quick-btn.active {
    background: rgba(29,158,117,0.18);
    border-color: rgba(29,158,117,0.38);
    transform: translateY(-1px);
}

.dn-type-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
}

.dn-type-card input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.dn-type-box {
    display: block;
    min-height: 140px;
    padding: 18px;
    border-radius: 18px;
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(29,158,117,0.18);
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s, transform 0.2s, box-shadow 0.2s;
}

.dn-type-card:hover .dn-type-box,
.dn-type-card input:checked + .dn-type-box {
    background: rgba(29,158,117,0.14);
    border-color: rgba(29,158,117,0.48);
    box-shadow: 0 14px 28px rgba(0,0,0,0.16);
    transform: translateY(-2px);
}

.dn-type-title {
    display: block;
    margin-bottom: 8px;
    font-size: 15px;
    font-weight: 700;
    color: #f7fff9;
}

.dn-type-copy {
    display: block;
    font-size: 12px;
    line-height: 1.7;
    color: rgba(159,225,203,0.58);
}

.dn-summary {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 16px 18px;
    border-radius: 20px;
    background: linear-gradient(135deg, rgba(255,215,0,0.12), rgba(29,158,117,0.14));
    border: 1px solid rgba(255,215,0,0.16);
}

.dn-summary small {
    display: block;
    margin-bottom: 6px;
    font-size: 11px;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: rgba(236,255,247,0.58);
}

.dn-summary strong {
    display: block;
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    line-height: 1.1;
    color: #ffd700;
}

.dn-summary-type {
    padding: 9px 14px;
    border-radius: 999px;
    background: rgba(6,40,28,0.55);
    border: 1px solid rgba(29,158,117,0.22);
    font-size: 12px;
    font-weight: 700;
    color: #9fe1cb;
    text-transform: uppercase;
    white-space: nowrap;
}

.dn-flow {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 10px;
}

.dn-flow-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 14px;
    border-radius: 16px;
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(29,158,117,0.12);
    font-size: 12px;
    color: rgba(236,255,247,0.7);
}

.dn-flow-item span {
    width: 26px;
    height: 26px;
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

.dn-submit {
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
    transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
    box-shadow: 0 18px 40px rgba(255,215,0,0.16);
}

.dn-submit:hover {
    transform: translateY(-1px);
    box-shadow: 0 22px 48px rgba(255,215,0,0.2);
}

@media (max-width: 1080px) {
    .dn-layout,
    .dn-feature-grid {
        grid-template-columns: 1fr;
    }

    .dn-stat-row {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

@media (max-width: 760px) {
    .dn-page {
        padding: 22px 16px;
        border-radius: 24px;
    }

    .dn-hero,
    .dn-form-card {
        padding: 24px 20px;
    }

    .dn-title {
        font-size: 28px;
    }

    .dn-stat-row,
    .dn-type-grid,
    .dn-flow {
        grid-template-columns: 1fr;
    }

    .dn-hero-footer,
    .dn-summary {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

<div class="dn-page">
    <div class="dn-grid"></div>
    <div class="dn-orb dn-orb-a"></div>
    <div class="dn-orb dn-orb-b"></div>

    <div class="dn-shell">
        @if(session('success'))
            <div class="dn-alert dn-alert-success">
                <strong>Donasi berhasil diproses.</strong>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="dn-alert dn-alert-error">
                <strong>Form donasi masih perlu diperiksa.</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="dn-layout">
            <section class="dn-card dn-hero">
                <div class="dn-kicker">Masjid Al-Hasanah</div>
                <h1 class="dn-title">Salurkan donasi dengan tampilan yang lebih rapi, nyaman, dan meyakinkan.</h1>
                <p class="dn-copy">
                    Zakat, infaq, dan sedekah kini bisa ditunaikan melalui alur yang lebih profesional.
                    Pilih nominal dengan cepat, cek ringkasan transaksi, lalu lanjutkan ke pembayaran secara aman.
                </p>

                <div class="dn-stat-row">
                    <div class="dn-stat">
                        <strong>3</strong>
                        <span>Pilihan jenis donasi untuk kebutuhan ibadah yang berbeda.</span>
                    </div>
                    <div class="dn-stat">
                        <strong>24/7</strong>
                        <span>Halaman tersedia kapan saja saat Anda ingin berdonasi.</span>
                    </div>
                    <div class="dn-stat">
                        <strong>Rp 1 rb</strong>
                        <span>Minimal transaksi yang ringan untuk memudahkan kontribusi awal.</span>
                    </div>
                </div>

                <div class="dn-feature-grid">
                    <div class="dn-feature">
                        <h3>Proses lebih aman</h3>
                        <p>Pembayaran dilanjutkan ke Midtrans agar alur transaksi terasa lebih terpercaya dan familiar.</p>
                    </div>
                    <div class="dn-feature">
                        <h3>Input lebih jelas</h3>
                        <p>Nominal, jenis donasi, dan ringkasan transaksi disusun ulang supaya lebih mudah dibaca.</p>
                    </div>
                    <div class="dn-feature">
                        <h3>Riwayat lebih terarah</h3>
                        <p>Setelah pembayaran, Anda bisa kembali mengecek status donasi dari halaman riwayat.</p>
                    </div>
                </div>

                <div class="dn-hero-footer">
                    <a href="{{ route('donasi.history') }}" class="dn-secondary-link">Lihat Riwayat Donasi</a>
                </div>
            </section>

            <section class="dn-card dn-form-card">
                <span class="dn-pill">Form Donasi</span>
                <h2>Tunaikan Infaq terbaik Anda</h2>
                <p>Isi nominal donasi, pilih kategorinya, lalu lanjutkan ke proses pembayaran.</p>

                <form method="POST" action="{{ route('donasi.store') }}" class="dn-form">
                    @csrf

                    <div class="dn-field">
                        <label for="nominal">Nominal donasi</label>
                        <div class="dn-input-wrap">
                            <span class="dn-prefix">Rp</span>
                            <input
                                id="nominal"
                                type="number"
                                name="nominal"
                                value="{{ old('nominal') }}"
                                min="1000"
                                step="1000"
                                placeholder="Masukkan nominal donasi"
                                required
                            >
                        </div>
                        <div class="dn-helper">Minimal donasi Rp 1.000. Anda juga bisa memakai nominal cepat di bawah ini.</div>
                    </div>

                    <div class="dn-field">
                        <div class="dn-inline-label">
                            <label for="quick-donation">Pilih nominal cepat</label>
                            <span>Opsional</span>
                        </div>
                        <div class="dn-quick-list" id="quick-donation">
                            @foreach([25000, 50000, 100000, 250000] as $amount)
                                <button
                                    type="button"
                                    class="dn-quick-btn {{ (int) old('nominal') === $amount ? 'active' : '' }}"
                                    data-amount="{{ $amount }}"
                                >
                                    Rp {{ number_format($amount, 0, ',', '.') }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="dn-field">
                        <label>Jenis donasi</label>
                        <div class="dn-type-grid">
                            <label class="dn-type-card">
                                <input type="radio" name="jenis" value="zakat" {{ $selectedType === 'zakat' ? 'checked' : '' }}>
                                <span class="dn-type-box">
                                    <span class="dn-type-title">Zakat</span>
                                    <span class="dn-type-copy">Pilihan untuk penunaian zakat sesuai niat dan kebutuhan ibadah Anda.</span>
                                </span>
                            </label>

                            <label class="dn-type-card">
                                <input type="radio" name="jenis" value="infaq" {{ $selectedType === 'infaq' ? 'checked' : '' }}>
                                <span class="dn-type-box">
                                    <span class="dn-type-title">Infaq</span>
                                    <span class="dn-type-copy">Cocok untuk kontribusi umum yang fleksibel bagi kebutuhan operasional masjid.</span>
                                </span>
                            </label>

                            <label class="dn-type-card">
                                <input type="radio" name="jenis" value="sedekah" {{ $selectedType === 'sedekah' ? 'checked' : '' }}>
                                <span class="dn-type-box">
                                    <span class="dn-type-title">Sedekah</span>
                                    <span class="dn-type-copy">Pilihan sederhana untuk berbagi kebaikan kapan pun Anda ingin membantu.</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="dn-summary">
                        <div>
                            <small>Ringkasan donasi</small>
                            <strong id="dnSummaryNominal">
                                {{ old('nominal') ? 'Rp ' . number_format(old('nominal'), 0, ',', '.') : 'Rp 0' }}
                            </strong>
                        </div>
                        <div class="dn-summary-type" id="dnSummaryJenis">{{ ucfirst($selectedType) }}</div>
                    </div>

                    <div class="dn-flow">
                        <div class="dn-flow-item"><span>1</span>Isi nominal</div>
                        <div class="dn-flow-item"><span>2</span>Pilih jenis</div>
                        <div class="dn-flow-item"><span>3</span>Lanjut bayar</div>
                    </div>

                    <button type="submit" class="dn-submit">Lanjut ke Pembayaran</button>
                </form>
            </section>
        </div>
    </div>
</div>

<script>
(function () {
    const amountInput = document.getElementById('nominal');
    const summaryNominal = document.getElementById('dnSummaryNominal');
    const summaryJenis = document.getElementById('dnSummaryJenis');
    const quickButtons = document.querySelectorAll('.dn-quick-btn');
    const jenisInputs = document.querySelectorAll('input[name="jenis"]');

    function formatCurrency(value) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value || 0);
    }

    function syncNominal() {
        const amount = parseInt(amountInput.value || '0', 10) || 0;
        summaryNominal.textContent = formatCurrency(amount);

        quickButtons.forEach(function (button) {
            button.classList.toggle('active', parseInt(button.dataset.amount, 10) === amount);
        });
    }

    function syncJenis() {
        const checked = document.querySelector('input[name="jenis"]:checked');
        summaryJenis.textContent = checked
            ? checked.value.charAt(0).toUpperCase() + checked.value.slice(1)
            : '-';
    }

    quickButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            amountInput.value = button.dataset.amount;
            syncNominal();
            amountInput.focus();
        });
    });

    amountInput.addEventListener('input', syncNominal);

    jenisInputs.forEach(function (input) {
        input.addEventListener('change', syncJenis);
    });

    syncNominal();
    syncJenis();
})();
</script>
@endsection
