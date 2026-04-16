@extends('layouts.main')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

* { box-sizing: border-box; }

.ct-page {
    font-family: 'Plus Jakarta Sans', sans-serif;
    position: relative;
    overflow: hidden;
    border-radius: 28px;
    background:
        radial-gradient(circle at top left, rgba(29,158,117,0.12), transparent 24%),
        linear-gradient(180deg, #f6f9f7 0%, #eef4f1 100%);
    min-height: 100vh;
    padding: 34px 30px 48px;
}

.ct-shell {
    max-width: 1160px;
    margin: 0 auto;
}

.ct-hero {
    border-radius: 28px;
    padding: 32px;
    margin-bottom: 24px;
    background:
        radial-gradient(circle at 100% 0%, rgba(255,215,0,0.16), transparent 22%),
        linear-gradient(135deg, #0b4c3d 0%, #0f6e56 48%, #1d9e75 100%);
    color: white;
    box-shadow: 0 24px 58px rgba(8, 80, 65, 0.14);
}

.ct-kicker {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 14px;
    border-radius: 999px;
    margin-bottom: 16px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.16);
}

.ct-kicker::before {
    content: '';
    width: 7px;
    height: 7px;
    border-radius: 999px;
    background: #ffd700;
}

.ct-title {
    margin: 0 0 12px;
    font-family: 'Playfair Display', serif;
    font-size: 38px;
    line-height: 1.15;
}

.ct-copy {
    margin: 0;
    max-width: 620px;
    font-size: 14px;
    line-height: 1.85;
    color: rgba(255,255,255,0.82);
}

.ct-grid {
    display: grid;
    grid-template-columns: minmax(0, 0.9fr) minmax(0, 1.1fr);
    gap: 22px;
}

.ct-card {
    background: white;
    border: 1px solid #dfe9e4;
    border-radius: 24px;
    box-shadow: 0 20px 44px rgba(11, 76, 61, 0.05);
}

.ct-card-body {
    padding: 24px;
}

.ct-section-title {
    margin: 0 0 18px;
    font-family: 'Playfair Display', serif;
    font-size: 26px;
    color: #085041;
}

.ct-info-list {
    display: grid;
    gap: 14px;
}

.ct-info-item {
    padding: 16px 18px;
    border-radius: 18px;
    background: #f6faf8;
    border: 1px solid #e2ebe6;
}

.ct-info-label {
    display: block;
    margin-bottom: 6px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #6e827a;
}

.ct-info-value {
    font-size: 14px;
    line-height: 1.8;
    color: #21483f;
}

.ct-action-row {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 20px;
}

.ct-btn {
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

.ct-btn-primary {
    background: linear-gradient(135deg, #ffd700 0%, #e8be20 100%);
    color: #082116;
}

.ct-btn-secondary {
    background: #e1f5ee;
    border: 1px solid #cceade;
    color: #0f6e56;
}

.ct-btn:hover {
    transform: translateY(-1px);
    text-decoration: none;
    opacity: 0.92;
}

.ct-map {
    overflow: hidden;
    border-radius: 24px;
    min-height: 100%;
}

.ct-map iframe {
    width: 100%;
    height: 100%;
    min-height: 460px;
    border: 0;
    display: block;
}

@media (max-width: 880px) {
    .ct-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 640px) {
    .ct-page {
        padding: 20px 16px 36px;
    }

    .ct-hero,
    .ct-card-body {
        padding: 22px 18px;
    }

    .ct-title {
        font-size: 30px;
    }

    .ct-map iframe {
        min-height: 320px;
    }
}
</style>

<div class="ct-page">
    <div class="ct-shell">
        <section class="ct-hero">
            <div class="ct-kicker">Kontak Resmi</div>
            <h1 class="ct-title">Hubungi Masjid Al-Hasanah</h1>
            <p class="ct-copy">
                Untuk pertanyaan jadwal kajian, koordinasi kegiatan, ataupun konfirmasi informasi masjid,
                Anda dapat menggunakan kontak resmi berikut ini. Lokasi juga tersedia langsung melalui peta.
            </p>
        </section>

        <div class="ct-grid">
            <section class="ct-card">
                <div class="ct-card-body">
                    <h2 class="ct-section-title">Informasi Kontak</h2>

                    <div class="ct-info-list">
                        <div class="ct-info-item">
                            <span class="ct-info-label">Alamat Masjid</span>
                            <div class="ct-info-value">{{ $contact['address'] }}</div>
                        </div>

                        <div class="ct-info-item">
                            <span class="ct-info-label">WhatsApp</span>
                            <div class="ct-info-value">{{ $contact['whatsapp'] }}</div>
                        </div>

                        <div class="ct-info-item">
                            <span class="ct-info-label">Email</span>
                            <div class="ct-info-value">{{ $contact['email'] }}</div>
                        </div>

                        <div class="ct-info-item">
                            <span class="ct-info-label">Narahubung</span>
                            <div class="ct-info-value">{{ $contact['contactName'] }} • {{ $contact['contactRole'] }}</div>
                        </div>
                    </div>

                    <div class="ct-action-row">
                        <a href="{{ $contact['whatsappLink'] }}" target="_blank" rel="noreferrer" class="ct-btn ct-btn-primary">Chat WhatsApp</a>
                        <a href="mailto:{{ $contact['email'] }}" class="ct-btn ct-btn-secondary">Kirim Email</a>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($contact['address']) }}" target="_blank" rel="noreferrer" class="ct-btn ct-btn-secondary">Buka Maps</a>
                    </div>
                </div>
            </section>

            <section class="ct-card ct-map">
                <iframe
                    src="{{ $contact['mapsEmbed'] }}"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Lokasi Masjid Al-Hasanah"
                ></iframe>
            </section>
        </div>
    </div>
</div>
@endsection
