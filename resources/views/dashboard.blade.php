@extends('layouts.app')

@section('title', 'Beranda - Al-Hasanah App')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap');

* { box-sizing: border-box; }

/* ══ BACKGROUND ══ */
.db-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    min-height: 100vh;
    position: relative;
    overflow: hidden;
    background: #0a2e1f;
}
.db-bg {
    position: absolute; inset: 0; z-index: 0;
    background:
        radial-gradient(ellipse 80% 60% at 10% 0%,   rgba(29,158,117,0.18) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 90% 100%, rgba(8,80,65,0.30)    0%, transparent 55%),
        radial-gradient(ellipse 50% 40% at 50% 50%,  rgba(15,110,86,0.08)  0%, transparent 70%),
        linear-gradient(160deg, #0d3322 0%, #0a2219 40%, #071a14 100%);
}
.db-grid-tex {
    position: absolute; inset: 0; z-index: 0;
    background-image:
        linear-gradient(rgba(29,158,117,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(29,158,117,0.04) 1px, transparent 1px);
    background-size: 48px 48px;
}
.orb { position: absolute; border-radius: 50%; filter: blur(80px); z-index: 0; pointer-events: none; }
.orb1 { width:500px; height:500px; background:rgba(29,158,117,0.12); top:-120px; left:-100px; }
.orb2 { width:400px; height:400px; background:rgba(8,80,65,0.20);    bottom:-80px; right:-60px; }
.orb3 { width:300px; height:300px; background:rgba(255,215,0,0.05);  top:40%; left:50%; }
.db { position: relative; z-index: 1; padding: 0 32px 36px; }

/* ══ HERO FULL-IMAGE (baru) ══ */
.hero-full {
    position: relative;
    width: calc(100% + 64px);
    margin-left: -32px;
    height: 100vh;
    min-height: 640px;
    max-height: 900px;
    overflow: hidden;
    margin-bottom: 64px;
}

.hero-full__img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center 30%;
    transform: scale(1.04);
    transition: transform 12s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    filter: brightness(0.78) saturate(0.9);
}

.hero-full:hover .hero-full__img {
    transform: scale(1.08);
}

.hero-full__veil {
    position: absolute;
    inset: 0;
    background:
        linear-gradient(105deg,
            rgba(4,20,12,0.92) 0%,
            rgba(4,20,12,0.72) 38%,
            rgba(4,20,12,0.28) 65%,
            transparent 100%
        ),
        linear-gradient(180deg,
            rgba(4,20,12,0.15) 0%,
            transparent 40%,
            rgba(4,20,12,0.55) 85%,
            rgba(4,20,12,0.82) 100%
        );
}

.hero-full::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent 0%, rgba(244,196,48,0.7) 30%, rgba(244,196,48,0.9) 50%, rgba(244,196,48,0.7) 70%, transparent 100%);
    z-index: 3;
}

.hero-full__content {
    position: absolute;
    inset: 0;
    z-index: 2;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 0 6vw 8vh;
    max-width: 820px;
}

.hero-full__kicker {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 20px;
}

.hero-full__kicker-line {
    width: 36px;
    height: 1px;
    background: rgba(244,196,48,0.75);
}

.hero-full__kicker-text {
    font-family: 'DM Sans', sans-serif;
    font-size: 11px;
    font-weight: 500;
    letter-spacing: 4px;
    text-transform: uppercase;
    color: rgba(244,196,48,0.85);
}

.hero-full__title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(42px, 6.5vw, 82px);
    font-weight: 300;
    line-height: 1.06;
    letter-spacing: -0.5px;
    color: #ffffff;
    margin: 0 0 8px;
}

.hero-full__title em {
    font-style: italic;
    font-weight: 300;
    color: rgba(244,196,48,0.95);
}

.hero-full__sub {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(18px, 2.5vw, 26px);
    font-weight: 300;
    font-style: italic;
    color: rgba(255,255,255,0.68);
    margin: 0 0 28px;
    letter-spacing: 0.3px;
}

.hero-full__divider {
    width: 48px;
    height: 1px;
    background: rgba(244,196,48,0.6);
    margin-bottom: 28px;
}

.hero-full__desc {
    font-family: 'DM Sans', sans-serif;
    font-size: clamp(13px, 1.2vw, 15px);
    font-weight: 300;
    line-height: 1.8;
    color: rgba(255,255,255,0.62);
    max-width: 460px;
    margin-bottom: 40px;
}

.hero-full__cta {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 500;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    text-decoration: none;
    color: #071a14;
    background: rgba(244,196,48,0.95);
    padding: 14px 30px;
    border-radius: 2px;
    transition: background 0.25s, transform 0.25s, gap 0.25s;
}

.hero-full__cta:hover {
    background: #FFD700;
    transform: translateY(-2px);
    gap: 14px;
    text-decoration: none;
    color: #071a14;
}

.hero-full__stats {
    position: absolute;
    bottom: 8vh;
    right: 5vw;
    z-index: 3;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 20px;
}

.hero-full__stat { text-align: right; }

.hero-full__stat-num {
    font-family: 'Cormorant Garamond', serif;
    font-size: 34px;
    font-weight: 300;
    color: rgba(244,196,48,0.9);
    line-height: 1;
}

.hero-full__stat-lbl {
    font-family: 'DM Sans', sans-serif;
    font-size: 10px;
    font-weight: 400;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.45);
    margin-top: 4px;
}

.hero-full__stats-divider {
    width: 28px;
    height: 1px;
    background: rgba(255,255,255,0.15);
    align-self: flex-end;
}

.hero-full__scroll {
    position: absolute;
    bottom: 36px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 3;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    opacity: 0.45;
    animation: scrollHint 2.4s ease-in-out infinite;
}

@keyframes scrollHint {
    0%, 100% { opacity: 0.45; transform: translateX(-50%) translateY(0); }
    50% { opacity: 0.25; transform: translateX(-50%) translateY(6px); }
}

.hero-full__scroll-line {
    width: 1px;
    height: 36px;
    background: rgba(255,255,255,0.5);
}

.hero-full__scroll-text {
    font-family: 'DM Sans', sans-serif;
    font-size: 9px;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.7);
}

/* ══ ADMIN STATS ══ */
.admin-stat-wrap { margin-bottom: 44px; }
.admin-stat-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; }
.admin-stat-card {
    padding: 20px;
    border-radius: 20px;
    background: rgba(13,51,34,0.72);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(29,158,117,0.2);
    box-shadow: 0 18px 40px rgba(0,0,0,0.16);
}
.admin-stat-card small {
    display: block;
    margin-bottom: 10px;
    font-size: 11px;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: rgba(159,225,203,0.56);
}
.admin-stat-card strong {
    display: block;
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    line-height: 1.1;
    color: #FFD700;
}
.admin-stat-card span {
    display: block;
    margin-top: 8px;
    font-size: 12px;
    line-height: 1.7;
    color: rgba(159,225,203,0.58);
}

/* ══ SECTION HEADER ══ */
.sec-head { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; }
.sec-label { font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 700; color: #9FE1CB; white-space: nowrap; }
.sec-badge { font-size: 10px; font-weight: 600; padding: 3px 10px; background: rgba(29,158,117,0.18); color: #5DCAA5; border-radius: 20px; border: 1px solid rgba(29,158,117,0.25); white-space: nowrap; }
.sec-line { flex: 1; height: 1px; background: rgba(29,158,117,0.18); }

/* ══ GALLERY ══ */
.gallery-wrap { position: relative; margin-bottom: 44px; }
.gallery-track { display: flex; gap: 16px; overflow-x: auto; scroll-behavior: smooth; padding-bottom: 6px; scrollbar-width: none; }
.gallery-track::-webkit-scrollbar { display: none; }
.gallery-slide { flex: 0 0 270px; height: 175px; border-radius: 16px; overflow: hidden; position: relative; cursor: pointer; background: rgba(15,110,86,0.3); border: 1px solid rgba(29,158,117,0.2); transition: border-color 0.25s, transform 0.25s; }
.gallery-slide:hover { border-color: rgba(29,158,117,0.55); transform: translateY(-3px); }
.gallery-slide img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.35s; }
.gallery-slide:hover img { transform: scale(1.06); }
.gallery-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 44px; }
.gallery-cap { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(4,20,12,0.92)); color: rgba(255,255,255,0.92); padding: 30px 14px 12px; font-size: 12px; font-weight: 500; }
.gal-arrow { position: absolute; top: 50%; transform: translateY(-50%); width: 36px; height: 36px; border-radius: 50%; background: rgba(10,46,31,0.92); border: 1px solid rgba(29,158,117,0.35); display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 2; font-size: 18px; color: #9FE1CB; transition: background 0.2s; line-height: 1; }
.gal-arrow:hover { background: rgba(29,158,117,0.28); }
.gal-prev { left: -14px; }
.gal-next { right: -14px; }

/* ══ DKM GRID ══ */
.dkm-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 16px; margin-bottom: 44px; }
.dkm-card { background: rgba(13,51,34,0.7); backdrop-filter: blur(8px); border-radius: 18px; overflow: hidden; text-decoration: none; color: inherit; border: 1px solid rgba(29,158,117,0.2); transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s; }
.dkm-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(0,0,0,0.35); border-color: rgba(29,158,117,0.48); text-decoration: none; }
.dkm-card-top { background: linear-gradient(135deg, #064030 0%, #0F6E56 50%, #1D9E75 100%); height: 58px; position: relative; }
.dkm-avatar { position: absolute; bottom: -26px; left: 50%; transform: translateX(-50%); width: 52px; height: 52px; border-radius: 50%; border: 3px solid #0a2e1f; object-fit: cover; }
.dkm-avatar-init { position: absolute; bottom: -26px; left: 50%; transform: translateX(-50%); width: 52px; height: 52px; border-radius: 50%; border: 3px solid #0a2e1f; background: #0F6E56; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 700; color: white; font-family: 'Playfair Display', serif; }
.dkm-body { padding: 34px 12px 18px; text-align: center; }
.dkm-nama { font-size: 13px; font-weight: 600; color: #9FE1CB; margin-bottom: 3px; line-height: 1.4; }
.dkm-jab { font-size: 11px; color: rgba(159,225,203,0.5); margin-bottom: 10px; }
.dkm-chip { font-size: 10px; font-weight: 600; padding: 3px 12px; background: rgba(29,158,117,0.15); color: #5DCAA5; border-radius: 20px; border: 1px solid rgba(29,158,117,0.2); }
.dkm-card-more { display: flex; align-items: center; justify-content: center; min-height: 144px; border-style: dashed !important; color: #5DCAA5; font-size: 13px; font-weight: 600; }

/* ══ JADWAL SHOLAT ══ */
.jadwal-wrap { margin-bottom: 44px; }
.jadwal-card {
    background: rgba(13,51,34,0.75);
    backdrop-filter: blur(12px);
    border-radius: 20px;
    border: 1px solid rgba(29,158,117,0.25);
    overflow: hidden;
    position: relative;
}
.jadwal-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, #1D9E75 30%, #FFD700 50%, #1D9E75 70%, transparent);
}
.jadwal-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 18px 24px 14px;
    border-bottom: 1px solid rgba(29,158,117,0.15);
    flex-wrap: wrap; gap: 10px;
}
.jadwal-header-left { display: flex; align-items: center; gap: 12px; }
.jadwal-icon-wrap {
    width: 40px; height: 40px; border-radius: 10px;
    background: rgba(29,158,117,0.18); border: 1px solid rgba(29,158,117,0.25);
    display: flex; align-items: center; justify-content: center; font-size: 20px;
}
.jadwal-title { font-family: 'Playfair Display', serif; font-size: 16px; font-weight: 700; color: #9FE1CB; }
.jadwal-subtitle { font-size: 11px; color: rgba(159,225,203,0.45); margin-top: 2px; }
.jadwal-date-pill {
    display: flex; align-items: center; gap: 7px;
    font-size: 11px; font-weight: 600; color: #5DCAA5;
    background: rgba(29,158,117,0.15); border: 1px solid rgba(29,158,117,0.22);
    padding: 6px 14px; border-radius: 20px;
}
.jadwal-dot {
    width: 6px; height: 6px; border-radius: 50%; background: #1D9E75;
    animation: pdot 2s infinite;
}
@keyframes pdot { 0%,100%{opacity:1} 50%{opacity:0.25} }
.jadwal-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    padding: 8px 10px 10px;
    gap: 6px;
}
.jadwal-item {
    display: flex; flex-direction: column; align-items: center; gap: 7px;
    padding: 18px 8px; border-radius: 14px; position: relative;
    transition: background 0.2s, border-color 0.2s;
    border: 1px solid transparent;
    cursor: default;
}
.jadwal-item:hover { background: rgba(29,158,117,0.08); }
.jadwal-item + .jadwal-item::after {
    content: ''; position: absolute; left: -3px; top: 18%; bottom: 18%;
    width: 1px; background: rgba(29,158,117,0.12);
}
.jadwal-item.aktif {
    background: rgba(29,158,117,0.13);
    border-color: rgba(29,158,117,0.28);
}
.jadwal-item.aktif + .jadwal-item::after { display: none; }
.jadwal-waktu-icon { font-size: 22px; line-height: 1; }
.jadwal-waktu-nama {
    font-size: 10px; font-weight: 600; letter-spacing: 1px;
    color: rgba(159,225,203,0.5); text-transform: uppercase;
}
.jadwal-waktu-jam {
    font-size: 21px; font-weight: 700; color: #9FE1CB;
    font-family: 'Playfair Display', serif; letter-spacing: 0.5px;
}
.jadwal-item.aktif .jadwal-waktu-jam { color: #FFD700; }
.jadwal-aktif-badge {
    display: none; font-size: 9px; font-weight: 700;
    padding: 2px 8px; background: rgba(255,215,0,0.12);
    color: #FFD700; border-radius: 20px;
    border: 1px solid rgba(255,215,0,0.22); letter-spacing: 0.5px;
}
.jadwal-item.aktif .jadwal-aktif-badge { display: block; }
.jadwal-countdown-bar {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    padding: 10px 24px;
    border-top: 1px solid rgba(29,158,117,0.12);
    font-size: 12px; color: rgba(159,225,203,0.5);
}
.jadwal-countdown-val {
    font-size: 13px; font-weight: 700; color: #5DCAA5;
    font-family: 'Playfair Display', serif;
}
.jadwal-unavail { padding: 28px; text-align: center; font-size: 13px; color: rgba(159,225,203,0.4); }

/* ══ KAJIAN GRID ══ */
.kjn-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(210px, 1fr)); gap: 16px; margin-bottom: 44px; }
.kjn-card { background: rgba(13,51,34,0.7); backdrop-filter: blur(8px); border-radius: 16px; overflow: hidden; border: 1px solid rgba(29,158,117,0.18); transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s; }
.kjn-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.3); border-color: rgba(29,158,117,0.42); }
.kjn-img { width: 100%; height: 135px; object-fit: cover; display: block; }
.kjn-img-ph { width: 100%; height: 135px; background: rgba(8,80,65,0.45); display: flex; align-items: center; justify-content: center; font-size: 34px; }

/* Kajian Play Overlay */
.kjn-play-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 135px;
    background: rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.kjn-card:hover .kjn-play-overlay {
    background: rgba(0,0,0,0.5);
}

.kjn-play-btn {
    width: 50px;
    height: 50px;
    background: rgba(29,158,117,0.8);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    transition: all 0.3s ease;
}

.kjn-card:hover .kjn-play-btn {
    background: rgba(29,158,117,1);
    transform: scale(1.1);
}
.kjn-body { padding: 13px; }
.hot-badge { display: inline-block; font-size: 10px; font-weight: 700; padding: 2px 9px; background: rgba(226,75,74,0.14); color: #F09595; border-radius: 20px; border: 1px solid rgba(226,75,74,0.2); margin-bottom: 6px; }
.new-badge { display: inline-block; font-size: 10px; font-weight: 700; padding: 2px 9px; background: rgba(29,158,117,0.14); color: #5DCAA5; border-radius: 20px; border: 1px solid rgba(29,158,117,0.2); margin-bottom: 6px; }
.kjn-title { font-size: 13px; font-weight: 600; color: #9FE1CB; margin-bottom: 5px; line-height: 1.4; }
.kjn-meta { font-size: 11px; color: rgba(159,225,203,0.5); margin-top: 3px; }

/* ══ VIDEO GRID ══ */
.vid-grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
    gap: 20px; 
}

.vid-card { 
    background: rgba(13,51,34,0.8); 
    border: 1px solid rgba(29,158,117,0.2); 
    border-radius: 16px; 
    overflow: hidden; 
    cursor: pointer; 
    transition: all 0.3s ease; 
}

.vid-card:hover { 
    transform: translateY(-4px); 
    box-shadow: 0 12px 32px rgba(0,0,0,0.3); 
    border-color: rgba(29,158,117,0.5); 
}

.vid-thumb { 
    position: relative; 
    padding-bottom: 56.25%; 
    background: #000; 
}

.vid-thumb img { 
    position: absolute; 
    top: 0; 
    left: 0; 
    width: 100%; 
    height: 100%; 
    object-fit: cover; 
}

.vid-play { 
    position: absolute; 
    top: 50%; 
    left: 50%; 
    transform: translate(-50%, -50%); 
    width: 50px; 
    height: 50px; 
    background: rgba(29,158,117,0.8); 
    border-radius: 50%; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    color: white; 
    font-size: 20px; 
    transition: all 0.3s ease; 
    z-index: 2;
}

.vid-card:hover .vid-play { 
    background: rgba(29,158,117,1); 
    transform: translate(-50%, -50%) scale(1.1); 
}

.vid-duration {
    position: absolute;
    bottom: 8px;
    right: 8px;
    background: rgba(0,0,0,0.8);
    color: #fff;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
    z-index: 2;
}

.vid-body { 
    padding: 16px; 
}

.vid-title { 
    font-size: 14px; 
    font-weight: 600; 
    color: #fff; 
    margin-bottom: 8px; 
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.vid-meta { 
    font-size: 12px; 
    color: rgba(159,225,203,0.7); 
    margin-bottom: 4px; 
}

/* ══ WAKTU SHOLAT CARD ══ */
.waktu-sholat-card {
    background: 
        radial-gradient(ellipse at 20% 10%, rgba(255,215,0,0.15) 0%, transparent 50%),
        radial-gradient(ellipse at 80% 90%, rgba(29,158,117,0.12) 0%, transparent 45%),
        radial-gradient(circle at 50% 50%, rgba(13,51,34,0.95) 0%, rgba(7,26,20,0.98) 100%);
    border-radius: 24px;
    padding: 32px;
    margin-bottom: 40px;
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 24px 58px rgba(0,0,0,0.3);
    position: relative;
    overflow: hidden;
}
.waktu-sholat-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; bottom: 0;
    background-image: 
        radial-gradient(circle at 25% 25%, rgba(255,215,0,0.03) 0%, transparent 25%),
        radial-gradient(circle at 75% 75%, rgba(29,158,117,0.04) 0%, transparent 30%);
    pointer-events: none;
    z-index: 1;
}
.waktu-sholat-content { position: relative; z-index: 2; }
.waktu-sholat-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 24px;
}
.waktu-sholat-title {
    font-family: 'Playfair Display', serif;
    font-size: 28px; font-weight: 700; color: #FFD700; margin: 0;
}
.waktu-sholat-date {
    font-size: 14px; color: rgba(159,225,203,0.8);
    background: rgba(255,255,255,0.1);
    padding: 8px 16px; border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.15);
}
.waktu-sholat-current {
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 20px;
    padding: 24px; margin-bottom: 24px; text-align: center;
}
.waktu-sholat-current-label {
    font-size: 12px; font-weight: 700; letter-spacing: 2px;
    text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 8px;
}
.waktu-sholat-current-name {
    font-family: 'Playfair Display', serif;
    font-size: 32px; font-weight: 700; color: #FFD700; margin-bottom: 8px;
}
.waktu-sholat-current-time {
    font-size: 20px; font-weight: 600; color: #9FE1CB; margin-bottom: 12px;
}
.waktu-sholat-next-info { font-size: 14px; color: rgba(255,255,255,0.7); }
.waktu-sholat-next-info strong { color: #FFD700; font-weight: 600; }
.waktu-sholat-grid {
    display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px;
}
.waktu-sholat-item {
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 16px; padding: 20px 16px; text-align: center;
    transition: all 0.3s ease; position: relative; overflow: hidden;
}
.waktu-sholat-item::before {
    content: ''; position: absolute; top: -50%; left: -50%;
    width: 200%; height: 200%;
    background: radial-gradient(circle, rgba(255,215,0,0.05) 0%, transparent 70%);
    opacity: 0; transition: opacity 0.3s ease; pointer-events: none;
}
.waktu-sholat-item:hover::before { opacity: 1; }
.waktu-sholat-item:hover { transform: translateY(-4px); border-color: rgba(255,215,0,0.3); }
.waktu-sholat-item.current {
    background: linear-gradient(135deg, rgba(255,215,0,0.2), rgba(29,158,117,0.15));
    border-color: rgba(255,215,0,0.4);
    animation: pulse 3s infinite;
}
.waktu-sholat-item.next {
    background: linear-gradient(135deg, rgba(29,158,117,0.2), rgba(13,51,34,0.15));
    border-color: rgba(29,158,117,0.4);
}
@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.02); opacity: 0.95; }
}
.waktu-sholat-icon {
    width: 36px; height: 36px; margin-bottom: 12px;
    display: inline-flex; align-items: center; justify-content: center;
    color: #ffea78; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
}
.waktu-sholat-name {
    font-family: 'Playfair Display', serif;
    font-size: 16px; font-weight: 700; color: #FFD700; margin-bottom: 6px;
}
.waktu-sholat-time {
    font-size: 18px; font-weight: 700; color: #9FE1CB; margin-bottom: 8px;
    font-variant-numeric: tabular-nums;
}
.waktu-sholat-desc { font-size: 11px; color: rgba(255,255,255,0.6); line-height: 1.4; }
.waktu-sholat-status {
    position: absolute; top: 8px; right: 8px;
    padding: 4px 8px; border-radius: 12px;
    font-size: 9px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;
}
.waktu-sholat-status.current {
    background: rgba(255,215,0,0.2); color: #FFD700;
    border: 1px solid rgba(255,215,0,0.3);
}
.waktu-sholat-status.next {
    background: rgba(29,158,117,0.2); color: #5DCAA5;
    border: 1px solid rgba(29,158,117,0.3);
}

/* ══ RESPONSIVE ══ */
@media (max-width: 768px) {
    .db { padding: 0 16px 20px; }

    .hero-full {
        width: calc(100% + 32px);
        margin-left: -16px;
        height: 100svh;
        min-height: 580px;
        max-height: 750px;
        margin-bottom: 40px;
    }
    .hero-full__content {
        padding: 0 24px 10vh;
        max-width: 100%;
    }
    .hero-full__stats { display: none; }
    .hero-full__veil {
        background:
            linear-gradient(180deg,
                rgba(4,20,12,0.35) 0%,
                rgba(4,20,12,0.15) 25%,
                rgba(4,20,12,0.65) 70%,
                rgba(4,20,12,0.92) 100%
            );
    }
    .hero-full__desc { max-width: 100%; }

    .admin-stat-grid { grid-template-columns: 1fr; }
    .jadwal-grid { grid-template-columns: repeat(3,1fr); }
    .waktu-sholat-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .waktu-sholat-card { padding: 24px 20px; margin-bottom: 32px; }
    .waktu-sholat-title { font-size: 24px; }
    .waktu-sholat-current-name { font-size: 28px; }
    .waktu-sholat-current-time { font-size: 18px; }
    .waktu-sholat-item { padding: 16px 12px; }
    .waktu-sholat-name { font-size: 14px; }
    .waktu-sholat-time { font-size: 16px; }
}

@media (max-width: 480px) {
    .jadwal-grid { grid-template-columns: repeat(3,1fr); }
    .waktu-sholat-grid { grid-template-columns: repeat(1, 1fr); }
}
</style>

<div class="db-wrap">
    <div class="db-bg"></div>
    <div class="db-grid-tex"></div>
    <div class="orb orb1"></div>
    <div class="orb orb2"></div>
    <div class="orb orb3"></div>

    <div class="db">

        {{-- ══ HERO FULL-IMAGE ══ --}}
        <div class="hero-full">

            <img
                src="{{ asset('images/masjid/Masjid1.jpg') }}"
                class="hero-full__img"
                alt="Masjid Al-Hasanah"
                onerror="this.style.display='none'"
            >

            <div class="hero-full__veil"></div>

            <div class="hero-full__content">

                <div class="hero-full__kicker">
                    <span class="hero-full__kicker-line"></span>
                    <span class="hero-full__kicker-text">Masjid Al-Hasanah · Jakarta Timur</span>
                </div>

                <h1 class="hero-full__title">
                    Dewan Kemakmuran<br>
                    <em>Masjid Al-Hasanah</em>
                </h1>

                <p class="hero-full__sub">Mengamalkan Ilmu sesuai Al-Quran dan Sunnah, Menjaga Ukhuwah yang kokoh.</p>

                <div class="hero-full__divider"></div>

                <p class="hero-full__desc">
                    Komplek Pushubad Cijantung, Kalisari, Pasar Rebo — Jakarta Timur.<br>
                    Platform pengelolaan masjid modern yang menghubungkan jamaah dengan ilmu dan komunitas.
                </p>

                <a href="/rekomendasi" class="hero-full__cta">
                    Eksplorasi Kajian <span>→</span>
                </a>

            </div>

            <div class="hero-full__stats">
                <div class="hero-full__stat">
                    <div class="hero-full__stat-num">{{ $totalDkm }}</div>
                    <div class="hero-full__stat-lbl">Anggota DKM</div>
                </div>
                <div class="hero-full__stats-divider"></div>
                <div class="hero-full__stat">
                    <div class="hero-full__stat-num">{{ $totalKajian }}</div>
                    <div class="hero-full__stat-lbl">Kajian Aktif</div>
                </div>
                <div class="hero-full__stats-divider"></div>
                <div class="hero-full__stat">
                    <div class="hero-full__stat-num">{{ $videos->count() }}</div>
                    <div class="hero-full__stat-lbl">Video</div>
                </div>
            </div>

            <div class="hero-full__scroll">
                <div class="hero-full__scroll-line"></div>
                <span class="hero-full__scroll-text">Scroll</span>
            </div>

        </div>
        {{-- end hero-full --}}


        {{-- ══ GALERI ══ --}}
        <div class="sec-head">
            <div class="sec-label">Galeri</div>
            <span class="sec-badge">Dokumentasi</span>
            <div class="sec-line"></div>
        </div>
        <div class="gallery-wrap">
            <button class="gal-arrow gal-prev" onclick="galleryScroll(-1)">‹</button>
            <div class="gallery-track" id="galleryTrack">

                <div class="gallery-slide">
                    <img src="{{ asset('images/masjid/Masjid2.jpg') }}" alt="Halaman Luar Masjid"
                         onerror="this.parentElement.querySelector('.gallery-placeholder').style.display='flex';this.style.display='none';">
                    <div class="gallery-placeholder" style="display:none;">🕌</div>
                    <div class="gallery-cap"></div>
                </div>

                <div class="gallery-slide">
                    <img src="{{ asset('images/masjid/Masjid5.jpg') }}" alt="Halaman Dalam Masjid"
                         onerror="this.parentElement.querySelector('.gallery-placeholder').style.display='flex';this.style.display='none';">
                    <div class="gallery-placeholder" style="display:none;">🕌</div>
                    <div class="gallery-cap"></div>
                </div>

                <div class="gallery-slide">
                    <img src="{{ asset('images/masjid/Masjid3.jpg') }}" alt="Kegiatan TPA"
                         onerror="this.parentElement.querySelector('.gallery-placeholder').style.display='flex';this.style.display='none';">
                    <div class="gallery-placeholder" style="display:none;">📖</div>
                    <div class="gallery-cap"></div>
                </div>

                <div class="gallery-slide">
                    <img src="{{ asset('images/masjid/photo1.jpg') }}" alt="Kajian Rutin"
                         onerror="this.parentElement.querySelector('.gallery-placeholder').style.display='flex';this.style.display='none';">
                    <div class="gallery-placeholder" style="display:none;">📚</div>
                    <div class="gallery-cap"></div>
                </div>

                <div class="gallery-slide">
                    <img src="{{ asset('images/masjid/Masjid7.jpg') }}" alt="Kajian Rutin"
                         onerror="this.parentElement.querySelector('.gallery-placeholder').style.display='flex';this.style.display='none';">
                    <div class="gallery-placeholder" style="display:none;">📚</div>
                    <div class="gallery-cap"></div>
                </div>

                <div class="gallery-slide">
                    <img src="{{ asset('images/masjid/Masjid4.jpg') }}" alt="Menu Sahur"
                         onerror="this.parentElement.querySelector('.gallery-placeholder').style.display='flex';this.style.display='none';">
                    <div class="gallery-placeholder" style="display:none;">🌙</div>
                    <div class="gallery-cap"></div>
                </div>

                <div class="gallery-slide">
                    <img src="{{ asset('images/masjid/Masjid8.jpg') }}" alt="Kajian Rutin"
                         onerror="this.parentElement.querySelector('.gallery-placeholder').style.display='flex';this.style.display='none';">
                    <div class="gallery-placeholder" style="display:none;">📚</div>
                    <div class="gallery-cap"></div>
                </div>

                <div class="gallery-slide">
                    <img src="{{ asset('images/masjid/Masjid9.jpg') }}" alt="Kajian Rutin"
                         onerror="this.parentElement.querySelector('.gallery-placeholder').style.display='flex';this.style.display='none';">
                    <div class="gallery-placeholder" style="display:none;">📚</div>
                    <div class="gallery-cap"></div>
                </div>

                <div class="gallery-slide">
                    <img src="{{ asset('images/masjid/Masjid10.jpg') }}" alt="Kajian Rutin"
                         onerror="this.parentElement.querySelector('.gallery-placeholder').style.display='flex';this.style.display='none';">
                    <div class="gallery-placeholder" style="display:none;">📚</div>
                    <div class="gallery-cap"></div>
                </div>

                <div class="gallery-slide">
                    <img src="{{ asset('images/masjid/Masjid11.jpg') }}" alt="Kajian Rutin"
                         onerror="this.parentElement.querySelector('.gallery-placeholder').style.display='flex';this.style.display='none';">
                    <div class="gallery-placeholder" style="display:none;">📚</div>
                    <div class="gallery-cap"></div>
                </div>

                <div class="gallery-slide">
                    <img src="{{ asset('images/masjid/Masjid12.jpg') }}" alt="Kajian Rutin"
                         onerror="this.parentElement.querySelector('.gallery-placeholder').style.display='flex';this.style.display='none';">
                    <div class="gallery-placeholder" style="display:none;">📚</div>
                    <div class="gallery-cap"></div>
                </div>

                <div class="gallery-slide">
                    <img src="{{ asset('images/masjid/Masjid13.jpg') }}" alt="Kajian Rutin"
                         onerror="this.parentElement.querySelector('.gallery-placeholder').style.display='flex';this.style.display='none';">
                    <div class="gallery-placeholder" style="display:none;">📚</div>
                    <div class="gallery-cap"></div>
                </div>

                <div class="gallery-slide">
                    <img src="{{ asset('images/masjid/Masjid14.jpg') }}" alt="Kajian Rutin"
                         onerror="this.parentElement.querySelector('.gallery-placeholder').style.display='flex';this.style.display='none';">
                    <div class="gallery-placeholder" style="display:none;">📚</div>
                    <div class="gallery-cap"></div>
                </div>

            </div>
            <button class="gal-arrow gal-next" onclick="galleryScroll(1)">›</button>
        </div>


        
        {{-- ══ DKM ══ --}}
        <div class="sec-head">
            <div class="sec-label">Anggota DKM</div>
            <span class="sec-badge">Pengurus Aktif</span>
            <div class="sec-line"></div>
        </div>
        <div class="dkm-grid">
            @foreach($dkm as $d)
            @php
                $words    = explode(' ', $d->nama);
                $initials = strtoupper(
                    (isset($words[0]) ? $words[0][0] : '') .
                    (isset($words[1]) ? $words[1][0] : '')
                );
            @endphp
            <a href="/dkm/{{ $d->id }}" class="dkm-card">
                <div class="dkm-card-top">
                    @if($d->foto)
                        <img src="{{ $d->foto }}" class="dkm-avatar" alt="{{ $d->nama }}">
                    @else
                        <div class="dkm-avatar-init">{{ $initials }}</div>
                    @endif
                </div>
                <div class="dkm-body">
                    <div class="dkm-nama">{{ $d->nama }}</div>
                    <div class="dkm-jab">{{ $d->jabatan }}</div>
                    <span class="dkm-chip">{{ $d->jabatan ?? 'Anggota' }}</span>
                </div>
            </a>
            @endforeach
            <a href="/dkm" class="dkm-card dkm-card-more">Lihat Semua →</a>
        </div>


        {{-- ══ PENGUMUMAN ══ --}}
        <div class="sec-head">
            <div class="sec-label">Pengumuman Masjid</div>
            <span class="sec-badge">Terbaru</span>
            <div class="sec-line"></div>
        </div>
        <div class="kjn-grid" style="margin-bottom: 44px;">
            @foreach($pengumuman as $p)
            <div class="kjn-card">
                <img src="{{ $p->gambar ?? 'https://via.placeholder.com/400x200' }}" class="kjn-img" alt="{{ $p->judul }}"
                     onerror="this.style.display='none'">
                <div class="kjn-body">
                    <div class="kjn-title">{{ $p->judul }}</div>
                    <div class="kjn-meta">{{ \Illuminate\Support\Str::limit($p->isi, 80) }}</div>
                    <div class="kjn-meta" style="margin-top:6px;">📅 {{ $p->tanggal }}</div>
                </div>
            </div>
            @endforeach
        </div>


        {{-- ══ TRENDING KAJIAN ══ --}}
        <div class="sec-head">
            <div class="sec-label">Trending Kajian</div>
            <span class="sec-badge">Paling Diminati</span>
            <div class="sec-line"></div>
        </div>
        <div class="kjn-grid">
            @foreach($kajianTrending as $k)
            <div class="kjn-card">
                @if($k->image)
                    <img src="{{ $k->image }}" class="kjn-img" alt="{{ $k->judul }}">
                @else
                    <div class="kjn-img-ph">📖</div>
                @endif
                <div class="kjn-body">
                    <span class="hot-badge">HOT</span>
                    <div class="kjn-title">{{ $k->judul }}</div>
                    <div class="kjn-meta">👤 {{ $k->ustadz->nama ?? '-' }}</div>
                    <div class="kjn-meta">⭐ {{ number_format($k->ratings_avg_rating ?? 0, 1) }}</div>
                </div>
            </div>
            @endforeach
        </div>


        {{-- ══ DASHBOARD STATISTIK ══ --}}
        <div class="admin-stat-wrap">
            <div class="sec-head">
                <div class="sec-label">Dashboard Statistik</div>
                <span class="sec-badge">Admin Insight</span>
                <div class="sec-line"></div>
            </div>
            <div class="admin-stat-grid">
                <div class="admin-stat-card">
                    <small>Total Jamaah</small>
                    <strong>{{ $totalJamaah }}</strong>
                    <span>Total pengguna yang sudah terdaftar dan dapat mengakses platform masjid.</span>
                </div>
                <div class="admin-stat-card">
                    <small>Total Kajian</small>
                    <strong>{{ $totalKajian }}</strong>
                    <span>Seluruh kajian aktif yang tercatat dan siap dijelajahi jamaah.</span>
                </div>
                <div class="admin-stat-card">
                    <small>Total Rating</small>
                    <strong>{{ $totalRating }}</strong>
                    <span>Dataset penilaian yang menjadi fondasi sistem rekomendasi hybrid.</span>
                </div>
                <div class="admin-stat-card">
                    <small>Total Donasi</small>
                    <strong>Rp {{ number_format($totalDonasi, 0, ',', '.') }}</strong>
                    <span>{{ $totalTransaksiDonasi }} transaksi donasi tercatat dalam sistem.</span>
                </div>
            </div>
        </div>


        {{-- ══ WAKTU SHOLAT ══ --}}
        <div class="waktu-sholat-card">
            <div class="waktu-sholat-content">
                <div class="waktu-sholat-header">
                    <h2 class="waktu-sholat-title">Jadwal Sholat Hari Ini</h2>
                    <div class="waktu-sholat-date">{{ $today->locale('id')->translatedFormat('d F Y') }}</div>
                </div>

                <div class="waktu-sholat-current">
                    <div class="waktu-sholat-current-label">Waktu Sholat Saat Ini</div>
                    <div class="waktu-sholat-current-name">{{ $prayerTimes[$currentPrayer]['name'] }}</div>
                    <div class="waktu-sholat-current-time">{{ $prayerTimes[$currentPrayer]['time'] }} WIB</div>
                    <div class="waktu-sholat-next-info">
                        Sholat berikutnya: <strong>{{ $prayerTimes[$nextPrayer]['name'] }}</strong> pukul <strong>{{ $prayerTimes[$nextPrayer]['time'] }} WIB</strong>
                    </div>
                </div>

                <div class="waktu-sholat-grid">
                    @foreach($prayerTimes as $key => $prayer)
                        <div class="waktu-sholat-item 
                            {{ $key === $currentPrayer ? 'current' : '' }} 
                            {{ $key === $nextPrayer ? 'next' : '' }}">
                            
                            @if($key === $currentPrayer)
                                <div class="waktu-sholat-status current">Saat Ini</div>
                            @elseif($key === $nextPrayer)
                                <div class="waktu-sholat-status next">Berikutnya</div>
                            @endif
                            
                            @include('components.prayer-icon', ['icon' => $prayer['icon'], 'class' => 'waktu-sholat-icon'])
                            <h3 class="waktu-sholat-name">{{ $prayer['name'] }}</h3>
                            <div class="waktu-sholat-time">{{ $prayer['time'] }}</div>
                            <p class="waktu-sholat-desc">{{ $prayer['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        {{-- ══ KAJIAN TERBARU ══ --}}
        <div class="sec-head">
            <div class="sec-label">Kitab Kajian</div>
            <span class="sec-badge">Baru Ditambahkan</span>
            <div class="sec-line"></div>
        </div>
        <div class="kjn-grid">
            @foreach($kajianTerbaru as $k)
            @php
                // Extract YouTube video ID
                $videoId = '';
                if ($k->youtube_url) {
                    preg_match('/(youtu\.be\/|v=)([^&\?]+)/', $k->youtube_url, $matches);
                    $videoId = $matches[2] ?? '';
                }
            @endphp
            <div class="kjn-card" @if($videoId) onclick="playKajianVideo(this, '{{ $videoId }}')" style="cursor: pointer;" @endif>
                <div style="position: relative;">
                    @if($k->image)
                        <img src="{{ $k->image }}" class="kjn-img" alt="{{ $k->judul }}">
                        @if($videoId)
                        <div class="kjn-play-overlay">
                            <div class="kjn-play-btn">▶</div>
                        </div>
                        @endif
                    @else
                        <div class="kjn-img-ph">📚</div>
                        @if($videoId)
                        <div class="kjn-play-overlay" style="background: rgba(29,158,117,0.1);">
                            <div class="kjn-play-btn">▶</div>
                        </div>
                        @endif
                    @endif
                </div>
                <div class="kjn-body">
                    @if($videoId)
                    <span class="new-badge" style="background: rgba(255,215,0,0.14); color: #FFD700; border: 1px solid rgba(255,215,0,0.2;">VIDEO</span>
                    @else
                    <span class="new-badge">BARU</span>
                    @endif
                    <div class="kjn-title">{{ $k->judul }}</div>
                    <div class="kjn-meta">👤 {{ $k->ustadz->nama ?? '-' }}</div>
                    <div class="kjn-meta">⭐ {{ number_format($k->ratings_avg_rating ?? 0, 1) }}</div>
                    @if($videoId)
                    <div class="kjn-meta">📹 Video Kajian</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>


        {{-- ══ VIDEO KAJIAN ══ --}}
        <div class="sec-head">
            <div class="sec-label">Video Kajian</div>
            <span class="sec-badge">Youtube</span>
            <div class="sec-line"></div>
        </div>
        <div class="vid-grid">
            @foreach($videos as $v)
            @php
                // Extract YouTube video ID from youtube_url
                $videoId = '';
                if ($v->youtube_url) {
                    // Handle various YouTube URL formats
                    if (preg_match('/youtu\.be\/([^&\?]+)/', $v->youtube_url, $matches)) {
                        $videoId = $matches[1];
                    } elseif (preg_match('/youtube\.com\/.*[?&]v=([^&\?]+)/', $v->youtube_url, $matches)) {
                        $videoId = $matches[1];
                    } elseif (preg_match('/youtube\.com\/.*\/([^\/\?&]+)/', $v->youtube_url, $matches)) {
                        $videoId = $matches[1];
                    }
                }
            @endphp
            <div class="vid-card" @if($videoId) onclick="playVideo(this, '{{ $videoId }}'); return false;" style="cursor: pointer;" title="Click to play: {{ $videoId }}" @endif>
                <div class="vid-thumb">
                    @if($v->thumbnail)
                        <img src="{{ $v->thumbnail }}" 
                             alt="{{ $v->judul }}"
                             onerror="this.style.display='none';"
                             loading="lazy">
                    @else
                        <img src="https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg" 
                             alt="{{ $v->judul }}"
                             onerror="this.style.display='none';"
                             loading="lazy">
                    @endif
                    <div class="vid-play">▶</div>
                </div>
                <div class="vid-body">
                    <div class="vid-title">{{ $v->judul }}</div>
                    <div class="vid-meta">🎤 {{ $v->ustadz }}</div>
                    @if($videoId)
                    <div class="vid-meta" style="color: #FFD700; font-size: 10px;">📹 ID: {{ $videoId }}</div>
                    @endif
                    @if($v->created_at)
                    <div class="vid-meta">📅 {{ $v->created_at->format('d M Y') }}</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

    </div>{{-- end .db --}}
</div>{{-- end .db-wrap --}}

<script>
function galleryScroll(dir) {
    document.getElementById('galleryTrack').scrollLeft += dir * 300;
}

function playVideo(el, id) {
    if (!id) return;
    el.querySelector('.vid-thumb').innerHTML =
        `<iframe width="100%" height="125"
            src="https://www.youtube.com/embed/${id}?autoplay=1"
            frameborder="0" allow="autoplay;encrypted-media" allowfullscreen></iframe>`;
}

(function () {
    const now  = new Date();
    const opts = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
    const elTgl = document.getElementById('jadwal-tanggal');
    if (elTgl) elTgl.textContent = now.toLocaleDateString('id-ID', opts);

    function parseMin(str) {
        if (!str) return null;
        const m = str.match(/(\d{1,2}):(\d{2})/);
        return m ? +m[1] * 60 + +m[2] : null;
    }

    const items  = document.querySelectorAll('#jadwal-grid .jadwal-item');
    if (!items.length) return;

    const nowMin = now.getHours() * 60 + now.getMinutes();
    let aktifIdx = 0;
    let nextIdx  = -1;
    let nextMin  = null;

    items.forEach(function(item, i) {
        const wkt = parseMin(item.dataset.waktu);
        if (wkt !== null && nowMin >= wkt) aktifIdx = i;
    });

    items[aktifIdx].classList.add('aktif');

    for (let i = aktifIdx + 1; i < items.length; i++) {
        const wkt = parseMin(items[i].dataset.waktu);
        if (wkt !== null && wkt > nowMin) { nextIdx = i; nextMin = wkt; break; }
    }

    const elCd = document.getElementById('jadwal-countdown');
    if (elCd && nextMin !== null) {
        function updateCd() {
            const n  = new Date();
            const nm = n.getHours() * 60 + n.getMinutes();
            const diff = nextMin - nm;
            if (diff <= 0) { elCd.textContent = 'Sekarang'; return; }
            const h = Math.floor(diff / 60);
            const m = diff % 60;
            elCd.textContent = (h > 0 ? h + ' jam ' : '') + m + ' menit lagi';
        }
        updateCd();
        setInterval(updateCd, 30000);
    } else if (elCd) {
        elCd.textContent = 'Isya adalah sholat terakhir hari ini';
    }
})();

// Test Function
function testVideoPlay() {
    alert('Test button clicked! Video functionality is working.');
    // Test dengan salah satu video ID yang ada
    playVideo(null, 'BWgwRJjm3sc');
}

// Video Player Function - Simple Modal
function playVideo(card, videoId) {
    console.log('Playing video in modal:', videoId);
    
    // Remove existing modal
    const existing = document.getElementById('videoModal');
    if (existing) existing.remove();
    
    // Create modal overlay
    const modal = document.createElement('div');
    modal.id = 'videoModal';
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.95);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(5px);
    `;
    
    modal.innerHTML = `
        <div style="position: relative; width: 90%; max-width: 900px;">
            <!-- Close Button -->
            <button onclick="this.closest('#videoModal').remove()" style="
                position: absolute;
                top: -50px;
                right: 0;
                background: rgba(29,158,117,0.9);
                color: white;
                border: none;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                font-size: 24px;
                cursor: pointer;
                z-index: 10001;
                transition: all 0.3s ease;
                box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            " onmouseover="this.style.background='rgba(29,158,117,1)'; this.style.transform='scale(1.1)'" 
               onmouseout="this.style.background='rgba(29,158,117,0.9)'; this.style.transform='scale(1)'">×</button>
            
            <!-- Video Container -->
            <div style="position: relative; padding-bottom: 56.25%; height: 0; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.5);">
                <iframe src="https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&showinfo=0&controls=1&modestbranding=1" style="
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    border: none;
                    border-radius: 16px;
                " allowfullscreen></iframe>
            </div>
            
            <!-- Video Info -->
            <div style="
                position: absolute;
                bottom: -40px;
                left: 0;
                right: 0;
                text-align: center;
                color: rgba(255,255,255,0.7);
                font-size: 14px;
            ">
                Press ESC or click outside to close • Click fullscreen button for full screen
            </div>
        </div>
    `;
    
    // Click background to close
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.remove();
        }
    });
    
    // ESC key to close
    const escHandler = (e) => {
        if (e.key === 'Escape') {
            modal.remove();
            document.removeEventListener('keydown', escHandler);
        }
    };
    document.addEventListener('keydown', escHandler);
    
    // Add to page - no scroll manipulation
    document.body.appendChild(modal);
}

// Alternative function untuk modal
function playVideoModal(card, videoId) {
    // Remove existing modal
    const existing = document.getElementById('videoModal');
    if (existing) existing.remove();
    
    // Create simple modal
    const modal = document.createElement('div');
    modal.id = 'videoModal';
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.9);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    `;
    
    modal.innerHTML = `
        <div style="position: relative; width: 90%; max-width: 800px; background: white; padding: 20px; border-radius: 12px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h3>Video Player</h3>
                <button onclick="this.closest('#videoModal').remove()" style="
                    background: red;
                    color: white;
                    border: none;
                    border-radius: 50%;
                    width: 30px;
                    height: 30px;
                    cursor: pointer;
                ">×</button>
            </div>
            <div style="position: relative; padding-bottom: 56.25%; height: 0;">
                <iframe src="https://www.youtube.com/embed/${videoId}?autoplay=1" style="
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    border: none;
                    border-radius: 8px;
                " allowfullscreen></iframe>
            </div>
        </div>
    `;
    
    // Click background to close
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.remove();
        }
    });
    
    document.body.appendChild(modal);
}

// Kajian Video Player Function (for original 3 kajians)
function playKajianVideo(card, videoId) {
    event.stopPropagation();
    
    // Create modal if not exists
    let modal = document.getElementById('videoModal');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'videoModal';
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        `;
        
        modal.innerHTML = `
            <div style="position: relative; width: 90%; max-width: 800px;" onclick="event.stopPropagation()">
                <button onclick="closeVideoModal()" style="
                    position: absolute;
                    top: -40px;
                    right: 0;
                    background: rgba(255,215,0,0.8);
                    color: white;
                    border: none;
                    border-radius: 50%;
                    width: 40px;
                    height: 40px;
                    font-size: 20px;
                    cursor: pointer;
                    z-index: 10000;
                ">×</button>
                <div style="position: relative; padding-bottom: 56.25%; height: 0;">
                    <iframe id="videoFrame" style="
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        border: none;
                        border-radius: 12px;
                    " allowfullscreen></iframe>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Close modal on background click
        modal.addEventListener('click', closeVideoModal);
    }
    
    // Set video source and show modal
    const iframe = document.getElementById('videoFrame');
    iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeVideoModal() {
    const modal = document.getElementById('videoModal');
    const iframe = document.getElementById('videoFrame');
    
    if (modal) {
        modal.style.display = 'none';
        iframe.src = '';
        document.body.style.overflow = '';
    }
}

// Close on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeVideoModal();
    }
});
</script>

<!-- Video Modal -->
<div id="videoModal" style="display: none;"></div>

@endsection