@extends('layouts.app')

@section('title', 'Galeri - Foto Kegiatan')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

* { box-sizing: border-box; }

.gl-page {
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #fff;
    padding: 36px 32px;
    min-height: 100vh;
    background:
        radial-gradient(ellipse 70% 50% at 12% 0%, rgba(29,158,117,0.18) 0%, transparent 60%),
        radial-gradient(ellipse 60% 45% at 100% 100%, rgba(8,80,65,0.26) 0%, transparent 55%),
        linear-gradient(160deg, #0d3322 0%, #0a2219 42%, #071a14 100%);
}

/* Hero Section */
.gl-hero {
    margin-bottom: 48px;
    text-align: center;
}

.gl-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: 11px; font-weight: 700; letter-spacing: 2px;
    text-transform: uppercase; color: #FFD700;
    background: rgba(255,215,0,0.1);
    border: 1px solid rgba(255,215,0,0.25);
    padding: 5px 14px; border-radius: 20px; margin-bottom: 16px;
}

.gl-dot {
    width: 6px; height: 6px; border-radius: 50%; background: #FFD700;
    animation: pdot 2s infinite;
}
@keyframes pdot { 0%,100%{opacity:1} 50%{opacity:.25} }

.gl-title {
    font-family: 'Playfair Display', serif;
    font-size: 42px; font-weight: 700; color: #9FE1CB;
    line-height: 1.2; margin-bottom: 12px;
}

.gl-sub {
    font-size: 16px; color: rgba(159,225,203,0.7);
    line-height: 1.75; max-width: 600px; margin: 0 auto 24px;
}

.gl-divider {
    width: 60px; height: 3px; margin: 0 auto 24px;
    background: linear-gradient(90deg, #FFD700, transparent);
    border-radius: 2px;
}

/* Search and Filter Section */
.gl-controls {
    background: rgba(13,51,34,0.8);
    backdrop-filter: blur(12px);
    border-radius: 24px;
    border: 1px solid rgba(29,158,117,0.25);
    padding: 24px 28px;
    margin-bottom: 40px;
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

.gl-search-group {
    flex: 1;
    min-width: 280px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.gl-search-input {
    flex: 1;
    background: rgba(8,80,65,0.3);
    border: 1px solid rgba(29,158,117,0.2);
    border-radius: 16px;
    padding: 12px 16px;
    color: #fff;
    font-size: 14px;
    font-weight: 500;
    transition: border-color 0.2s, background 0.2s;
}

.gl-search-input::placeholder {
    color: rgba(159,225,203,0.4);
}

.gl-search-input:focus {
    outline: none;
    border-color: rgba(29,158,117,0.5);
    background: rgba(8,80,65,0.4);
}

.gl-filter-select {
    background: rgba(8,80,65,0.3);
    border: 1px solid rgba(29,158,117,0.2);
    border-radius: 16px;
    padding: 12px 16px;
    color: #fff;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
}

.gl-filter-select:focus {
    outline: none;
    border-color: rgba(29,158,117,0.5);
    background: rgba(8,80,65,0.4);
}

.gl-search-btn {
    background: linear-gradient(135deg, #ffe680, #f4c430);
    color: #071a14;
    border: none;
    border-radius: 16px;
    padding: 12px 24px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: opacity 0.2s, transform 0.2s;
    white-space: nowrap;
}

.gl-search-btn:hover {
    opacity: 0.88;
    transform: translateY(-1px);
}

/* Gallery Grid */
.gl-gallery-container {
    margin-bottom: 48px;
}

.gl-month-section {
    margin-bottom: 48px;
}

.gl-month-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
}

.gl-month-title {
    font-family: 'Playfair Display', serif;
    font-size: 24px; font-weight: 700; color: #FFD700;
}

.gl-month-count {
    font-size: 14px; color: rgba(159,225,203,0.6);
    background: rgba(29,158,117,0.15);
    padding: 6px 12px; border-radius: 20px;
    border: 1px solid rgba(29,158,117,0.25);
}

.gl-month-line {
    flex: 1; height: 1px; background: rgba(29,158,117,0.2);
}

.gl-gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}

.gl-gallery-item {
    background: rgba(13,51,34,0.8);
    backdrop-filter: blur(12px);
    border-radius: 20px;
    border: 1px solid rgba(29,158,117,0.25);
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
    cursor: pointer;
}

.gl-gallery-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.3);
    border-color: rgba(29,158,117,0.5);
}

.gl-gallery-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
    transition: transform 0.3s;
}

.gl-gallery-item:hover .gl-gallery-image {
    transform: scale(1.05);
}

.gl-gallery-content {
    padding: 16px;
}

.gl-gallery-date {
    font-size: 12px; font-weight: 600; letter-spacing: 1px;
    text-transform: uppercase; color: rgba(159,225,203,0.5);
    margin-bottom: 8px;
}

.gl-gallery-title {
    font-size: 16px; font-weight: 600; color: #9FE1CB;
    line-height: 1.4; margin-bottom: 8px;
}

.gl-gallery-category {
    display: inline-block;
    font-size: 11px; font-weight: 600; padding: 4px 10px;
    background: rgba(29,158,117,0.15); color: #5DCAA5;
    border-radius: 20px; border: 1px solid rgba(29,158,117,0.25);
}

/* Lightbox */
.gl-lightbox {
    display: none;
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(4,41,31,0.95);
    z-index: 1000;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.gl-lightbox.active {
    display: flex;
}

.gl-lightbox-content {
    max-width: 90%;
    max-height: 90%;
    position: relative;
}

.gl-lightbox-image {
    max-width: 100%;
    max-height: 80vh;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.5);
}

.gl-lightbox-close {
    position: absolute;
    top: -40px; right: 0;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 50%;
    width: 40px; height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    transition: background 0.2s;
}

.gl-lightbox-close:hover {
    background: rgba(255,255,255,0.2);
}

.gl-lightbox-title {
    text-align: center;
    margin-top: 16px;
    font-size: 18px; font-weight: 600; color: #9FE1CB;
}

/* Responsive */
@media (max-width: 768px) {
    .gl-page { padding: 20px 16px; }
    .gl-title { font-size: 32px; }
    .gl-sub { font-size: 14px; }

    .gl-controls {
        flex-direction: column;
        align-items: stretch;
    }

    .gl-search-group {
        min-width: auto;
    }

    .gl-gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 16px;
    }

    .gl-month-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .gl-month-line {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .gl-gallery-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="gl-page">

    {{-- Hero Section --}}
    <div class="gl-hero">
        <div class="gl-eyebrow">
            <div class="gl-dot"></div>
            Dokumentasi
        </div>
        <h1 class="gl-title">GALERI</h1>
        <p class="gl-sub">
            Dokumentasi visual berbagai kegiatan, pembangunan, dan momen berharga
            dalam perjalanan Masjid Al-Hasanah melayani jamaah.
        </p>
        <div class="gl-divider"></div>
    </div>

    {{-- Search and Filter --}}
    <div class="gl-controls">
        <div class="gl-search-group">
            <input
                type="text"
                class="gl-search-input"
                placeholder="Cari nama album..."
                id="searchInput"
            >
            <select class="gl-filter-select" id="monthFilter">
                <option value="">Filter Bulan</option>
                @foreach($groupedPhotos as $month => $photos)
                    <option value="{{ $month }}">{{ $month }}</option>
                @endforeach
            </select>
        </div>
        <button class="gl-search-btn" onclick="filterGallery()">
            CARI ALBUM
        </button>
    </div>

    {{-- Gallery Container --}}
    <div class="gl-gallery-container" id="galleryContainer">
        @foreach($groupedPhotos as $month => $photos)
            <div class="gl-month-section" data-month="{{ $month }}">
                <div class="gl-month-header">
                    <h2 class="gl-month-title">{{ $month }}</h2>
                    <span class="gl-month-count">{{ $photos->count() }} foto</span>
                    <div class="gl-month-line"></div>
                </div>

                <div class="gl-gallery-grid">
                    @foreach($photos as $photo)
                        <div class="gl-gallery-item"
                             data-title="{{ $photo['title'] }}"
                             data-category="{{ $photo['category'] }}"
                             onclick="openLightbox('{{ asset($photo['src']) }}', '{{ $photo['title'] }}')">
                            <img
                                src="{{ asset($photo['src']) }}"
                                alt="{{ $photo['title'] }}"
                                class="gl-gallery-image"
                                onerror="this.src='https://via.placeholder.com/280x200/1a3a2a/9FE1CB?text=Foto+Tidak+Tersedia'"
                            >
                            <div class="gl-gallery-content">
                                <div class="gl-gallery-date">{{ date('d M Y', strtotime($photo['date'])) }}</div>
                                <h3 class="gl-gallery-title">{{ $photo['title'] }}</h3>
                                <span class="gl-gallery-category">{{ $photo['category'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- Lightbox --}}
    <div class="gl-lightbox" id="lightbox" onclick="closeLightbox()">
        <div class="gl-lightbox-content">
            <button class="gl-lightbox-close" onclick="closeLightbox()">×</button>
            <img src="" alt="" class="gl-lightbox-image" id="lightboxImage">
            <div class="gl-lightbox-title" id="lightboxTitle"></div>
        </div>
    </div>

</div>

<script>
function openLightbox(imageSrc, title) {
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightboxImage');
    const lightboxTitle = document.getElementById('lightboxTitle');

    lightboxImage.src = imageSrc;
    lightboxTitle.textContent = title;
    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    lightbox.classList.remove('active');
    document.body.style.overflow = '';
}

function filterGallery() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const monthFilter = document.getElementById('monthFilter').value;
    const monthSections = document.querySelectorAll('.gl-month-section');
    const galleryItems = document.querySelectorAll('.gl-gallery-item');

    monthSections.forEach(section => {
        const sectionMonth = section.dataset.month;

        // Filter by month first
        if (monthFilter && sectionMonth !== monthFilter) {
            section.style.display = 'none';
            return;
        }

        // Then filter by search within the visible section
        let hasVisibleItems = false;
        const itemsInSection = section.querySelectorAll('.gl-gallery-item');

        itemsInSection.forEach(item => {
            const title = item.dataset.title.toLowerCase();
            const category = item.dataset.category.toLowerCase();

            if (searchInput === '' || title.includes(searchInput) || category.includes(searchInput)) {
                item.style.display = '';
                hasVisibleItems = true;
            } else {
                item.style.display = 'none';
            }
        });

        section.style.display = hasVisibleItems ? '' : 'none';
    });

    // Show message if no results
    const visibleSections = Array.from(monthSections).filter(section => section.style.display !== 'none');
    if (visibleSections.length === 0) {
        showNoResults();
    } else {
        hideNoResults();
    }
}

function showNoResults() {
    const container = document.getElementById('galleryContainer');
    if (!document.getElementById('noResults')) {
        const noResults = document.createElement('div');
        noResults.id = 'noResults';
        noResults.className = 'gl-no-results';
        noResults.innerHTML = `
            <div style="text-align: center; padding: 60px 20px; color: rgba(159,225,203,0.6);">
                <div style="font-size: 48px; margin-bottom: 16px;">? </div>
                <h3 style="color: #9FE1CB; margin-bottom: 8px;">Tidak Ada Hasil</h3>
                <p>Coba gunakan kata kunci lain atau reset filter untuk melihat semua foto.</p>
            </div>
        `;
        container.appendChild(noResults);
    }
}

function hideNoResults() {
    const noResults = document.getElementById('noResults');
    if (noResults) {
        noResults.remove();
    }
}

// Real-time search
document.getElementById('searchInput').addEventListener('input', filterGallery);
document.getElementById('monthFilter').addEventListener('change', filterGallery);

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeLightbox();
    }
});
</script>

@endsection
