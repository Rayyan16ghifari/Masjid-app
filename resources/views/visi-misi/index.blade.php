@extends('layouts.app')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

* { 
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

.vm-page {
    font-family: 'Plus Jakarta Sans', sans-serif;
    position: relative;
    overflow: hidden;
    background:
        radial-gradient(circle at 20% 20%, rgba(29,158,117,0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(255,215,0,0.08) 0%, transparent 50%),
        linear-gradient(135deg, #0d3322 0%, #0a2219 42%, #071a14 100%);
    min-height: 100vh;
    padding: 40px 0 60px;
    width: 100%;
    margin: 0;
}

.vm-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image:
        linear-gradient(rgba(29,158,117,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(29,158,117,0.03) 1px, transparent 1px);
    background-size: 60px 60px;
    z-index: -1;
    opacity: 0.5;
}

.vm-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 40px;
    position: relative;
    z-index: 1;
}

.vm-header {
    text-align: center;
    margin-bottom: 60px;
    animation: fadeInUp 0.8s ease-out;
}

.vm-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 8px 16px;
    background: rgba(255,215,0,0.1);
    border: 1px solid rgba(255,215,0,0.25);
    border-radius: 50px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #FFD700;
    margin-bottom: 20px;
}

.vm-eyebrow::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #FFD700;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.vm-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(36px, 5vw, 56px);
    font-weight: 700;
    color: #9FE1CB;
    margin-bottom: 16px;
    line-height: 1.2;
}

.vm-subtitle {
    font-size: clamp(16px, 2vw, 18px);
    color: rgba(159,225,203,0.7);
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

.vm-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    margin-bottom: 60px;
}

.vm-card {
    background: rgba(13,51,34,0.8);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(29,158,117,0.2);
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    animation: fadeInUp 0.8s ease-out;
    animation-fill-mode: both;
}

.vm-card:nth-child(1) {
    animation-delay: 0.2s;
}

.vm-card:nth-child(2) {
    animation-delay: 0.4s;
}

.vm-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 70px rgba(0,0,0,0.4);
}

.vm-card-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
}

.vm-card-icon {
    width: 64px;
    height: 64px;
    background: rgba(29,158,117,0.15);
    border: 2px solid rgba(29,158,117,0.25);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: #9FE1CB;
    flex-shrink: 0;
}

.vm-card-title {
    font-family: 'Playfair Display', serif;
    font-size: 32px;
    font-weight: 700;
    color: #9FE1CB;
    margin: 0;
    line-height: 1.2;
}

.vm-card-content {
    color: rgba(255,255,255,0.85);
    line-height: 1.7;
}

.vm-card-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.vm-card-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid rgba(29,158,117,0.1);
    transition: all 0.3s ease;
}

.vm-card-item:last-child {
    border-bottom: none;
}

.vm-card-item:hover {
    background: rgba(29,158,117,0.05);
    border-radius: 12px;
    padding-left: 12px;
    padding-right: 12px;
}

.vm-card-item-icon {
    width: 32px;
    height: 32px;
    background: rgba(29,158,117,0.15);
    border: 1px solid rgba(29,158,117,0.25);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: #9FE1CB;
    flex-shrink: 0;
    margin-top: 2px;
}

.vm-card-item-text {
    flex: 1;
    font-size: 16px;
    color: rgba(255,255,255,0.9);
}

.vm-quote-section {
    background: rgba(13,51,34,0.8);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(29,158,117,0.2);
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    text-align: center;
    animation: fadeInUp 0.8s ease-out;
    animation-delay: 0.6s;
    animation-fill-mode: both;
}

.vm-quote-text {
    font-family: 'Playfair Display', serif;
    font-size: 24px;
    font-style: italic;
    color: #9FE1CB;
    line-height: 1.6;
    margin-bottom: 20px;
}

.vm-quote-author {
    font-size: 16px;
    color: rgba(159,225,203,0.7);
    font-weight: 600;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .vm-container {
        padding: 0 24px;
    }
    
    .vm-content {
        grid-template-columns: 1fr;
        gap: 24px;
    }
    
    .vm-card {
        padding: 24px;
    }
    
    .vm-card-title {
        font-size: 28px;
    }
    
    .vm-quote-section {
        padding: 24px;
    }
    
    .vm-quote-text {
        font-size: 20px;
    }
}

@media (max-width: 480px) {
    .vm-container {
        padding: 0 16px;
    }
    
    .vm-card {
        padding: 20px;
    }
    
    .vm-card-header {
        gap: 12px;
    }
    
    .vm-card-icon {
        width: 48px;
        height: 48px;
        font-size: 20px;
    }
    
    .vm-card-title {
        font-size: 24px;
    }
    
    .vm-card-item-text {
        font-size: 15px;
    }
    
    .vm-quote-section {
        padding: 20px;
    }
    
    .vm-quote-text {
        font-size: 18px;
    }
}
</style>

<div class="vm-page">
    <div class="vm-background"></div>
    
    <div class="vm-container">
        <!-- Header -->
        <header class="vm-header">
            <div class="vm-eyebrow">Identitas Masjid</div>
            <h1 class="vm-title">Visi & Misi</h1>
            <p class="vm-subtitle">
                Pedoman dan arah yang menjadi landasan Masjid Al-Hasanah dalam melayani jamaah dan membangun komunitas yang berlandaskan nilai-nilai Islam.
            </p>
        </header>

        <!-- Main Content -->
        <div class="vm-content">
            <!-- Visi Card -->
            <div class="vm-card">
                <div class="vm-card-header">
                    <div class="vm-card-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h2 class="vm-card-title">Visi</h2>
                </div>
                
                <div class="vm-card-content">
                    <p style="font-size: 18px; margin-bottom: 20px; line-height: 1.8;">
                        Menjadi masjid yang unggul, modern, dan menjadi pusat kegiatan keagamaan, sosial, dan pendidikan yang memberdayakan jamaah serta masyarakat sekitar.
                    </p>
                    
                    <ul class="vm-card-list">
                        <li class="vm-card-item">
                            <div class="vm-card-item-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="vm-card-item-text">
                                Masjid yang menjadi teladan dalam kehidupan beragama
                            </div>
                        </li>
                        <li class="vm-card-item">
                            <div class="vm-card-item-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="vm-card-item-text">
                                Pusat pengembangan spiritual dan intelektual jamaah
                            </div>
                        </li>
                        <li class="vm-card-item">
                            <div class="vm-card-item-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="vm-card-item-text">
                                Landasan pembangunan masyarakat yang rahmatan lil'alamin
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Misi Card -->
            <div class="vm-card">
                <div class="vm-card-header">
                    <div class="vm-card-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h2 class="vm-card-title">Misi</h2>
                </div>
                
                <div class="vm-card-content">
                    <ul class="vm-card-list">
                        <li class="vm-card-item">
                            <div class="vm-card-item-icon">
                                <i class="fas fa-quran"></i>
                            </div>
                            <div class="vm-card-item-text">
                                Menyelenggarakan kegiatan ibadah yang berkualitas dan teratur
                            </div>
                        </li>
                        <li class="vm-card-item">
                            <div class="vm-card-item-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="vm-card-item-text">
                                Mengembangkan program pendidikan Islam untuk semua usia
                            </div>
                        </li>
                        <li class="vm-card-item">
                            <div class="vm-card-item-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="vm-card-item-text">
                                Membangun komunitas jamaah yang solid dan peduli
                            </div>
                        </li>
                        <li class="vm-card-item">
                            <div class="vm-card-item-icon">
                                <i class="fas fa-hands-helping"></i>
                            </div>
                            <div class="vm-card-item-text">
                                Melakukan kegiatan sosial kemasyarakatan yang berkelanjutan
                            </div>
                        </li>
                        <li class="vm-card-item">
                            <div class="vm-card-item-icon">
                                <i class="fas fa-mosque"></i>
                            </div>
                            <div class="vm-card-item-text">
                                Mengembangkan sarana dan prasarana masjid yang modern
                            </div>
                        </li>
                        <li class="vm-card-item">
                            <div class="vm-card-item-icon">
                                <i class="fas fa-globe"></i>
                            </div>
                            <div class="vm-card-item-text">
                                Menjalin kerjasama dengan institusi Islam lainnya
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Quote Section -->
        <div class="vm-quote-section">
            <div class="vm-quote-text">
                "Masjid adalah rumah Allah dan tempat berkumpulnya orang-orang beriman untuk beribadah, belajar, dan bersilaturahmi."
            </div>
            <div class="vm-quote-author">
                — DKM Masjid Al-Hasanah
            </div>
        </div>
    </div>
</div>
@endsection
