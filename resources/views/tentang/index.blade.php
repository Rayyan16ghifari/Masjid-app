@extends('layouts.app')

@section('content')

<style>
    .about-page {
        color: #ffffff;
    }

    .about-card {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 32px;
        background:
            radial-gradient(circle at 14% 8%, rgba(244,196,48,0.16), transparent 28%),
            radial-gradient(circle at 92% 12%, rgba(98,211,148,0.14), transparent 30%),
            linear-gradient(135deg, rgba(3,32,24,0.94), rgba(7,67,47,0.62));
        box-shadow: 0 26px 75px rgba(0,0,0,0.24);
    }

    .about-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.035) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.035) 1px, transparent 1px);
        background-size: 46px 46px;
        pointer-events: none;
    }

    .about-card::after {
        content: "";
        position: absolute;
        right: -130px;
        bottom: -160px;
        width: 380px;
        height: 380px;
        border-radius: 50%;
        background: rgba(244,196,48,0.08);
        pointer-events: none;
    }

    .about-inner {
        position: relative;
        z-index: 1;
        padding: 38px;
    }

    .about-header {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 28px;
        align-items: start;
        margin-bottom: 30px;
        padding-bottom: 28px;
        border-bottom: 1px solid rgba(255,255,255,0.12);
    }

    .about-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
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

    .about-kicker::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #f4c430;
    }

    .about-heading {
        margin: 0;
        max-width: 760px;
        font-size: clamp(32px, 4vw, 54px);
        line-height: 1.05;
        font-weight: 800;
        letter-spacing: -1.2px;
    }

    .about-lead {
        max-width: 760px;
        margin: 16px 0 0;
        color: rgba(255,255,255,0.74);
        font-size: 15px;
        line-height: 1.85;
        font-weight: 500;
    }

    .about-logo-panel {
        width: 158px;
        min-height: 158px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 18px;
        border: 1px solid rgba(255,255,255,0.13);
        border-radius: 28px;
        background: rgba(255,255,255,0.08);
        text-align: center;
    }

    .about-logo-mark {
        width: 76px;
        height: 76px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 20%, #fff3ad, #f4c430 58%, #c99513);
        box-shadow: 0 16px 35px rgba(244,196,48,0.22);
    }

    .about-logo-mark svg {
        width: 48px;
        height: 48px;
        display: block;
    }

    .about-logo-text {
        color: rgba(255,255,255,0.82);
        font-size: 12px;
        line-height: 1.45;
        font-weight: 800;
        letter-spacing: 1.2px;
        text-transform: uppercase;
    }

    .about-content-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(300px, 0.8fr);
        gap: 24px;
        align-items: start;
    }

    .about-story {
        padding: 24px;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 26px;
        background: rgba(2,32,24,0.48);
    }

    .about-story p {
        margin: 0 0 16px;
        color: rgba(255,255,255,0.75);
        font-size: 15px;
        line-height: 1.9;
        font-weight: 500;
    }

    .about-story p:last-child {
        margin-bottom: 0;
    }

    .about-story strong {
        color: #ffffff;
    }

    .about-side {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .about-section-box {
        padding: 22px;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 24px;
        background: rgba(255,255,255,0.07);
    }

    .about-section-title {
        margin: 0 0 10px;
        color: #f4c430;
        font-size: 15px;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .about-section-text {
        margin: 0;
        color: rgba(255,255,255,0.74);
        font-size: 14px;
        line-height: 1.75;
        font-weight: 500;
    }

    .about-list {
        display: grid;
        gap: 10px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .about-list li {
        position: relative;
        padding-left: 24px;
        color: rgba(255,255,255,0.74);
        font-size: 14px;
        line-height: 1.65;
        font-weight: 600;
    }

    .about-list li::before {
        content: "";
        position: absolute;
        left: 0;
        top: 9px;
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #f4c430;
        box-shadow: 0 0 0 4px rgba(244,196,48,0.12);
    }

    .about-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-top: 24px;
    }

    .about-stat {
        padding: 18px;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 22px;
        background: rgba(255,255,255,0.06);
    }

    .about-stat strong {
        display: block;
        margin-bottom: 7px;
        color: #f4c430;
        font-size: 25px;
        line-height: 1;
        font-weight: 800;
    }

    .about-stat span {
        color: rgba(255,255,255,0.64);
        font-size: 12px;
        line-height: 1.55;
        font-weight: 700;
    }

    .about-footer-note {
        margin-top: 24px;
        padding-top: 22px;
        border-top: 1px solid rgba(255,255,255,0.12);
        color: rgba(255,255,255,0.58);
        font-size: 13px;
        line-height: 1.7;
        font-weight: 600;
        text-align: center;
    }

    @media (max-width: 980px) {
        .about-header,
        .about-content-grid {
            grid-template-columns: 1fr;
        }

        .about-logo-panel {
            width: 100%;
            min-height: auto;
            flex-direction: row;
            justify-content: flex-start;
            text-align: left;
        }
    }

    @media (max-width: 640px) {
        .about-card {
            border-radius: 24px;
        }

        .about-inner {
            padding: 22px;
        }

        .about-stats {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="about-page">
    <article class="about-card">
        <div class="about-inner">
            <header class="about-header">
                <div>
                    <div class="about-kicker">Tentang Masjid</div>
                    <h2 class="about-heading">Masjid Al-Hasanah sebagai pusat ibadah, dakwah, dan pembinaan umat.</h2>
                    <p class="about-lead">Masjid Al-Hasanah hadir sebagai ruang yang menyatukan ibadah, ilmu, pelayanan sosial, dan teknologi agar kegiatan kemasjidan semakin tertata, terbuka, dan mudah diakses oleh jamaah.</p>
                </div>

                <div class="about-logo-panel">
                    <span class="about-logo-mark" aria-hidden="true">
                        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M32 8C25.2 13.4 21.8 18.8 21.8 24.3C21.8 29.9 26.4 34.5 32 34.5C37.6 34.5 42.2 29.9 42.2 24.3C42.2 18.8 38.8 13.4 32 8Z" fill="#063827"/>
                            <path d="M14 31.5C14 29 16 27 18.5 27H45.5C48 27 50 29 50 31.5V50H14V31.5Z" fill="#063827"/>
                            <path d="M20 50V37.5C20 35.6 21.6 34 23.5 34C25.4 34 27 35.6 27 37.5V50H20Z" fill="#F4C430"/>
                            <path d="M37 50V37.5C37 35.6 38.6 34 40.5 34C42.4 34 44 35.6 44 37.5V50H37Z" fill="#F4C430"/>
                            <path d="M29 50V39C29 37.3 30.3 36 32 36C33.7 36 35 37.3 35 39V50H29Z" fill="#F4C430"/>
                            <path d="M10 50H54" stroke="#063827" stroke-width="4" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="about-logo-text">Masjid Al-Hasanah<br>Komplek Puskomlekad</span>
                </div>
            </header>

            <div class="about-content-grid">
                <section class="about-story">
                    <strong>Masjid Al-Hasanah</strong> bermula dari tempat ibadah sederhana di lingkungan Komplek Pushubad, Kalisari, Pasar Rebo. Dengan dukungan warga dan jamaah, masjid ini terus berkembang menjadi pusat kegiatan keislaman yang berlandaskan Al-Qur'an dan Sunnah. <Melalui>Selain menjadi tempat shalat berjamaah, Masjid Al-Hasanah juga aktif menghadirkan kajian rutin, pembelajaran Al-Qur'an untuk anak-anak(TPA), kegiatan sosial, serta layanan informasi masjid yang lebih modern dan mudah dijangkau. Melalui platform digital ini, pengelolaan kegiatan masjid diharapkan menjadi lebih tertata, transparan, dan bermanfaat bagi jamaah, pengurus, serta masyarakat sekitar.</p>

                    <div class="about-stats">
                        <div class="about-stat">
                            <strong>24/7</strong>
                            <span>Akses informasi masjid secara digital</span>
                        </div>
                        <div class="about-stat">
                            <strong>1</strong>
                            <span>Pusat informasi kegiatan masjid</span>
                        </div>
                        <div class="about-stat">
                            <strong>2026</strong>
                            <span>Pengembangan layanan digital masjid</span>
                        </div>
                    </div>
                </section>

                <aside class="about-side">
                    <div class="about-section-box">
                        <h3 class="about-section-title">Visi</h3>
                        <p class="about-section-text">Menjadi pusat dakwah Islam yang unggul dalam pembinaan umat berbasis ilmu, pelayanan, dan pemanfaatan teknologi.</p>
                    </div>

                    <div class="about-section-box">
                        <h3 class="about-section-title">Misi</h3>
                        <ul class="about-list">
                            <li>Menyediakan kajian Islam yang berkualitas dan mudah diikuti jamaah.</li>
                            <li>Meningkatkan literasi Islam dan kepedulian sosial masyarakat.</li>
                            <li>Mengelola informasi masjid secara tertib, modern, dan transparan.</li>
                            <li>Membangun komunitas jamaah yang kuat, ramah, dan saling mendukung.</li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </article>
</div>

@endsection
