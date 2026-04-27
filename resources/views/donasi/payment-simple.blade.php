@extends('layouts.app')

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
    border: 1px solid rgba(29,158,117,0.25);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #9fe1cb;
    margin-bottom: 16px;
}

.dp-title {
    font-family: 'Playfair Display', serif;
    font-size: 32px;
    font-weight: 700;
    color: #9fe1cb;
    line-height: 1.2;
    margin-bottom: 16px;
}

.dp-copy {
    font-size: 14px;
    color: rgba(236,255,247,0.65);
    line-height: 1.7;
    margin-bottom: 32px;
}

.dp-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 32px;
}

.dp-panel {
    background: rgba(6,40,28,0.42);
    border: 1px solid rgba(29,158,117,0.15);
    border-radius: 24px;
    padding: 28px;
}

.dp-panel h2 {
    font-family: 'Playfair Display', serif;
    font-size: 20px;
    font-weight: 700;
    color: #9fe1cb;
    margin-bottom: 20px;
}

.dp-step {
    display: flex;
    align-items: flex-start;
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
    color: rgba(159,225,203,0.7);
    margin-bottom: 16px;
}

.dp-button {
    width: 100%;
    padding: 16px 24px;
    background: linear-gradient(135deg, #1D9E75, #15803D);
    color: white;
    border: none;
    border-radius: 16px;
    font-size: 15px;
    font-weight: 700;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 8px 24px rgba(29,158,117,0.3);
}

.dp-button:hover {
    background: linear-gradient(135deg, #15803D, #14532D);
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(29,158,117,0.4);
}

.dp-button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

.dp-link {
    display: inline-flex;
    align-items: center;
    color: rgba(159,225,203,0.7);
    text-decoration: none;
    font-size: 13px;
    transition: color 0.2s ease;
}

.dp-link:hover {
    color: #9fe1cb;
    text-decoration: none;
}

/* Form Styles */
.dp-form-group {
    margin-bottom: 20px;
}

.dp-form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: rgba(159,225,203,0.8);
    margin-bottom: 8px;
}

.dp-form-input {
    width: 100%;
    padding: 12px 16px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(29,158,117,0.2);
    border-radius: 12px;
    color: white;
    font-size: 14px;
    transition: all 0.3s ease;
}

.dp-form-input:focus {
    outline: none;
    border-color: rgba(159,225,203,0.5);
    background: rgba(255,255,255,0.12);
}

.dp-form-input::placeholder {
    color: rgba(255,255,255,0.4);
}

.dp-form-select {
    width: 100%;
    padding: 12px 16px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(29,158,117,0.2);
    border-radius: 12px;
    color: white;
    font-size: 14px;
    cursor: pointer;
}

.dp-form-select:focus {
    outline: none;
    border-color: rgba(159,225,203,0.5);
    background: rgba(255,255,255,0.12);
}

.dp-form-select option {
    background: #0d3322;
    color: white;
}

.dp-amount-buttons {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
    margin-bottom: 16px;
}

.dp-amount-btn {
    padding: 10px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(29,158,117,0.2);
    border-radius: 8px;
    color: rgba(159,225,203,0.8);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.dp-amount-btn:hover,
.dp-amount-btn.active {
    background: rgba(29,158,117,0.2);
    border-color: rgba(159,225,203,0.4);
    color: #9fe1cb;
}

/* Responsive */
@media (max-width: 768px) {
    .dp-page {
        padding: 20px 16px;
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

    .dp-amount-buttons {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<div class="dp-page">
    <div class="dp-grid"></div>

    <div class="dp-shell">
        <div class="dp-card">
            <span class="dp-pill">Pembayaran Donasi</span>
            <h1 class="dp-title">Lengkapi Data Donasi Anda</h1>
            <p class="dp-copy">
                Isi formulir di bawah ini untuk melanjutkan proses donasi. 
                Setelah submit, silakan transfer ke rekening yang tersedia.
            </p>

            <div class="dp-layout">
                <div class="dp-panel">
                    <h2>Formulir Donasi</h2>
                    
                    <form action="{{ route('donasi.store') }}" method="POST" class="dp-form">
                        @csrf
                        
                        <div class="dp-form-group">
                            <label class="dp-form-label">Nama Lengkap *</label>
                            <input type="text" 
                                   name="nama" 
                                   class="dp-form-input" 
                                   placeholder="Masukkan nama lengkap Anda"
                                   required>
                            @error('nama')
                                <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="dp-form-group">
                            <label class="dp-form-label">Email</label>
                            <input type="email" 
                                   name="email" 
                                   class="dp-form-input" 
                                   placeholder="email@example.com">
                            @error('email')
                                <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="dp-form-group">
                            <label class="dp-form-label">Nomor WhatsApp *</label>
                            <input type="tel" 
                                   name="no_hp" 
                                   class="dp-form-input" 
                                   placeholder="08123456789"
                                   required>
                            @error('no_hp')
                                <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="dp-form-group">
                            <label class="dp-form-label">Jenis Donasi</label>
                            <select name="jenis" class="dp-form-select">
                                <option value="infaq">Infaq</option>
                                <option value="zakat">Zakat</option>
                                <option value="wakaf">Wakaf</option>
                                <option value="sedekah">Sedekah</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="dp-form-group">
                            <label class="dp-form-label">Nominal Donasi (Rp) *</label>
                            <div class="dp-amount-buttons">
                                <button type="button" class="dp-amount-btn" onclick="setAmount(10000)">10.000</button>
                                <button type="button" class="dp-amount-btn" onclick="setAmount(25000)">25.000</button>
                                <button type="button" class="dp-amount-btn" onclick="setAmount(50000)">50.000</button>
                                <button type="button" class="dp-amount-btn" onclick="setAmount(100000)">100.000</button>
                                <button type="button" class="dp-amount-btn" onclick="setAmount(250000)">250.000</button>
                                <button type="button" class="dp-amount-btn" onclick="setAmount(500000)">500.000</button>
                            </div>
                            <input type="number" 
                                   name="nominal" 
                                   id="nominal"
                                   class="dp-form-input" 
                                   placeholder="Masukkan nominal donasi"
                                   min="1000"
                                   required>
                            @error('nominal')
                                <div class="text-red-400 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="dp-form-group">
                            <label class="dp-form-label">Pesan (Opsional)</label>
                            <textarea name="pesan" 
                                      class="dp-form-input" 
                                      rows="3"
                                      placeholder="Tuliskan pesan atau doa Anda"></textarea>
                        </div>

                        <button type="submit" class="dp-button">
                            Kirim Donasi
                        </button>
                    </form>
                </div>

                <div class="dp-panel dp-action-card">
                    <div>
                        <h2>Informasi Pembayaran</h2>
                        <div class="dp-status">
                            Setelah submit formulir, Anda akan menerima informasi rekening untuk transfer donasi.
                        </div>
                        
                        <div class="dp-note">
                            <strong>Cara Pembayaran:</strong><br>
                            1. Isi formulir donasi di samping<br>
                            2. Klik "Kirim Donasi"<br>
                            3. Transfer ke rekening yang ditampilkan<br>
                            4. Konfirmasi pembayaran via WhatsApp
                        </div>
                    </div>

                    <div>
                        <a href="{{ route('donasi.index') }}" class="dp-link">← Kembali ke Halaman Donasi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function setAmount(amount) {
    document.getElementById('nominal').value = amount;
    
    // Remove active class from all buttons
    document.querySelectorAll('.dp-amount-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Add active class to clicked button
    event.target.classList.add('active');
}

// Format currency input
document.getElementById('nominal').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value) {
        value = parseInt(value);
        e.target.value = value;
    }
});
</script>
@endsection
