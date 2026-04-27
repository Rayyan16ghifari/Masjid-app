@extends('layouts.app')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

* { box-sizing: border-box; }

.ws-page {
    font-family: 'Plus Jakarta Sans', sans-serif;
    position: relative;
    overflow: hidden;
    border-radius: 28px;
    background: 
        radial-gradient(ellipse at 20% 10%, rgba(255,215,0,0.15) 0%, transparent 50%),
        radial-gradient(ellipse at 80% 90%, rgba(29,158,117,0.12) 0%, transparent 45%),
        radial-gradient(circle at 50% 50%, rgba(13,51,34,0.95) 0%, rgba(7,26,20,0.98) 100%),
        linear-gradient(135deg, #0d3322 0%, #071a14 100%);
    min-height: 100vh;
    padding: 34px 30px 48px;
    color: #fff;
}

/* Abstract background patterns */
.ws-page::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 25% 25%, rgba(255,215,0,0.03) 0%, transparent 25%),
        radial-gradient(circle at 75% 75%, rgba(29,158,117,0.04) 0%, transparent 30%),
        radial-gradient(circle at 50% 10%, rgba(159,225,203,0.02) 0%, transparent 20%),
        radial-gradient(circle at 10% 80%, rgba(255,215,0,0.03) 0%, transparent 22%);
    pointer-events: none;
    z-index: 1;
}

.ws-shell {
    max-width: 1400px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
}

.ws-hero {
    text-align: center;
    margin-bottom: 48px;
    padding: 32px;
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(20px);
    border-radius: 28px;
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 24px 58px rgba(0,0,0,0.3);
}

.ws-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: 11px; font-weight: 700; letter-spacing: 2px;
    text-transform: uppercase; color: #FFD700;
    background: rgba(255,215,0,0.1);
    border: 1px solid rgba(255,215,0,0.25);
    padding: 5px 14px; border-radius: 20px; margin-bottom: 16px;
}

.ws-dot { 
    width: 6px; height: 6px; border-radius: 50%; background: #FFD700; 
    animation: pdot 2s infinite; 
}
@keyframes pdot { 0%,100%{opacity:1} 50%{opacity:.25} }

.ws-title {
    font-family: 'Playfair Display', serif;
    font-size: 48px; font-weight: 700; color: #9FE1CB;
    line-height: 1.2; margin-bottom: 12px;
}

.ws-sub {
    font-size: 18px; color: rgba(159,225,203,0.8);
    line-height: 1.75; max-width: 700px; margin: 0 auto;
}

.ws-location {
    margin-top: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 14px;
    color: rgba(255,255,255,0.7);
}

.ws-location svg {
    width: 16px;
    height: 16px;
    color: #FFD700;
}

.ws-current-status {
    background: linear-gradient(135deg, rgba(255,215,0,0.15), rgba(29,158,117,0.1));
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,215,0,0.2);
    border-radius: 24px;
    padding: 24px;
    margin-bottom: 40px;
    text-align: center;
    box-shadow: 0 20px 44px rgba(0,0,0,0.2);
}

.ws-current-label {
    font-size: 12px; font-weight: 700; letter-spacing: 2px;
    text-transform: uppercase; color: rgba(255,255,255,0.6);
    margin-bottom: 8px;
}

.ws-current-prayer {
    font-family: 'Playfair Display', serif;
    font-size: 36px; font-weight: 700; color: #FFD700;
    margin-bottom: 8px;
}

.ws-current-time {
    font-size: 20px; font-weight: 600; color: #9FE1CB;
    margin-bottom: 12px;
}

.ws-next-info {
    font-size: 14px; color: rgba(255,255,255,0.7);
}

.ws-next-info strong {
    color: #FFD700;
    font-weight: 600;
}

.ws-prayer-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
    margin-bottom: 48px;
}

.ws-prayer-card {
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 24px;
    padding: 32px 24px;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 44px rgba(0,0,0,0.2);
}

.ws-prayer-card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,215,0,0.05) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.ws-prayer-card:hover::before {
    opacity: 1;
}

.ws-prayer-card:hover {
    transform: translateY(-8px);
    border-color: rgba(255,215,0,0.3);
    box-shadow: 0 28px 56px rgba(0,0,0,0.3);
}

.ws-prayer-card.current {
    background: linear-gradient(135deg, rgba(255,215,0,0.2), rgba(29,158,117,0.15));
    border-color: rgba(255,215,0,0.4);
    box-shadow: 0 24px 58px rgba(255,215,0,0.15);
}

.ws-prayer-card.next {
    background: linear-gradient(135deg, rgba(29,158,117,0.2), rgba(13,51,34,0.15));
    border-color: rgba(29,158,117,0.4);
    box-shadow: 0 24px 58px rgba(29,158,117,0.15);
}

.ws-prayer-icon {
    width: 52px;
    height: 52px;
    margin-bottom: 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #ffea78;
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
}

.prayer-icon svg {
    width: 100%;
    height: 100%;
}

.ws-prayer-name {
    font-family: 'Playfair Display', serif;
    font-size: 24px; font-weight: 700; color: #FFD700;
    margin-bottom: 8px;
}

.ws-prayer-time {
    font-size: 32px; font-weight: 700; color: #9FE1CB;
    margin-bottom: 12px;
    font-variant-numeric: tabular-nums;
    letter-spacing: 1px;
}

.ws-prayer-desc {
    font-size: 13px; color: rgba(255,255,255,0.6);
    line-height: 1.5;
}

.ws-prayer-status {
    position: absolute;
    top: 16px;
    right: 16px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 10px; font-weight: 700; letter-spacing: 1px;
    text-transform: uppercase;
}

.ws-prayer-status.current {
    background: rgba(255,215,0,0.2);
    color: #FFD700;
    border: 1px solid rgba(255,215,0,0.3);
}

.ws-prayer-status.next {
    background: rgba(29,158,117,0.2);
    color: #5DCAA5;
    border: 1px solid rgba(29,158,117,0.3);
}

.ws-date-info {
    text-align: center;
    margin-bottom: 32px;
    padding: 16px;
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 20px;
}

.ws-date-info h3 {
    font-family: 'Playfair Display', serif;
    font-size: 20px; font-weight: 700; color: #9FE1CB;
    margin-bottom: 8px;
}

.ws-date-info p {
    font-size: 14px; color: rgba(255,255,255,0.7);
    margin: 0;
}

/* Responsive */
@media (max-width: 968px) {
    .ws-prayer-grid {
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
    }
    
    .ws-title {
        font-size: 40px;
    }
}

@media (max-width: 640px) {
    .ws-page {
        padding: 20px 16px 36px;
    }
    
    .ws-hero {
        padding: 24px 20px;
        margin-bottom: 32px;
    }
    
    .ws-title {
        font-size: 32px;
    }
    
    .ws-sub {
        font-size: 16px;
    }
    
    .ws-current-prayer {
        font-size: 28px;
    }
    
    .ws-current-time {
        font-size: 18px;
    }
    
    .ws-prayer-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .ws-prayer-card {
        padding: 24px 20px;
    }
    
    .ws-prayer-icon {
        font-size: 40px;
    }
    
    .ws-prayer-name {
        font-size: 20px;
    }
    
    .ws-prayer-time {
        font-size: 28px;
    }
}

/* Animation for current prayer */
@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.05); opacity: 0.9; }
}

.ws-prayer-card.current {
    animation: pulse 3s infinite;
}
</style>

<div class="ws-page">
    <div class="ws-shell">
        <!-- Hero Section -->
        <section class="ws-hero">
            <div class="ws-eyebrow">
                <div class="ws-dot"></div>
                Waktu Sholat
            </div>
            <h1 class="ws-title">Jadwal Sholat Harian</h1>
            <p class="ws-sub">
                Jadwal sholat real-time untuk wilayah Jakarta Timur.
                Data diambil langsung dari metode Kementerian Agama RI agar waktu yang tampil lebih akurat untuk jamaah.
            </p>
            <div class="ws-location">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
                <span>Jakarta, Indonesia (6.2088°S, 106.8456°E)</span>
            </div>
        </section>

        <!-- Date Information -->
        <div class="ws-date-info">
            <h3>{{ $today->locale('id')->translatedFormat('l, d F Y') }}</h3>
            <p>{{ $today->locale('id')->format('d F Y') }} • {{ $today->format('H:i') }} WIB</p>
        </div>

        <!-- Current Prayer Status -->
        <div class="ws-current-status">
            <div class="ws-current-label">Waktu Sholat Saat Ini</div>
            <div class="ws-current-prayer">{{ $prayerTimes[$currentPrayer]['name'] }}</div>
            <div class="ws-current-time">{{ $prayerTimes[$currentPrayer]['time'] }} WIB</div>
            <div class="ws-next-info">
                Sholat berikutnya: <strong>{{ $prayerTimes[$nextPrayer]['name'] }}</strong> pukul <strong>{{ $prayerTimes[$nextPrayer]['time'] }} WIB</strong>
            </div>
        </div>

        <!-- Prayer Times Grid -->
        <div class="ws-prayer-grid">
            @foreach($prayerTimes as $key => $prayer)
                <div class="ws-prayer-card 
                    {{ $key === $currentPrayer ? 'current' : '' }} 
                    {{ $key === $nextPrayer ? 'next' : '' }}">
                    
                    @if($key === $currentPrayer)
                        <div class="ws-prayer-status current">Saat Ini</div>
                    @elseif($key === $nextPrayer)
                        <div class="ws-prayer-status next">Berikutnya</div>
                    @endif
                    
                    @include('components.prayer-icon', ['icon' => $prayer['icon'], 'class' => 'ws-prayer-icon'])
                    <h3 class="ws-prayer-name">{{ $prayer['name'] }}</h3>
                    <div class="ws-prayer-time">{{ $prayer['time'] }}</div>
                    <p class="ws-prayer-desc">{{ $prayer['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
// Auto refresh every minute
setInterval(() => {
    location.reload();
}, 60000);

document.addEventListener('DOMContentLoaded', () => {
    const locationLabel = document.querySelector('.ws-location span');
    const dateTitle = document.querySelector('.ws-date-info h3');
    const dateMeta = document.querySelector('.ws-date-info p');
    const nowJakarta = new Date();

    if (locationLabel) {
        locationLabel.textContent = 'Jakarta Timur, Indonesia (6.225014 S, 106.900447 E)';
    }

    if (dateTitle) {
        dateTitle.textContent = new Intl.DateTimeFormat('id-ID', {
            weekday: 'long',
            day: '2-digit',
            month: 'long',
            year: 'numeric',
            timeZone: 'Asia/Jakarta',
        }).format(nowJakarta);
    }

    if (dateMeta) {
        const formattedDate = new Intl.DateTimeFormat('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric',
            timeZone: 'Asia/Jakarta',
        }).format(nowJakarta);
        const formattedTime = new Intl.DateTimeFormat('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false,
            timeZone: 'Asia/Jakarta',
        }).format(nowJakarta);

        dateMeta.textContent = `${formattedDate} | ${formattedTime} WIB`;
        return;

        const datePart = new Intl.DateTimeFormat('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric',
            timeZone: 'Asia/Jakarta',
        }).format(nowJakarta);
        const timePart = new Intl.DateTimeFormat('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false,
            timeZone: 'Asia/Jakarta',
        }).format(nowJakarta);

        dateMeta.textContent = `${datePart} · ${timePart} WIB`;
    }
});

// Add sound notification for prayer times (optional)
function checkPrayerTime() {
    const now = new Date();
    const currentTime = now.getHours().toString().padStart(2, '0') + ':' + 
                       now.getMinutes().toString().padStart(2, '0');
    
    // Check if current time matches any prayer time
    const prayerTimes = @json($prayerTimes);
    for (const [key, prayer] of Object.entries(prayerTimes)) {
        if (currentTime === prayer.time) {
            // Show notification (you can customize this)
            console.log(`Waktu sholat ${prayer.name} telah tiba!`);
            // You could play a sound or show a browser notification here
        }
    }
}

// Check every 30 seconds
setInterval(checkPrayerTime, 30000);
</script>

@endsection
