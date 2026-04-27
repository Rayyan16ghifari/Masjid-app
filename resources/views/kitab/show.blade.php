@extends('layouts.app')

@section('title', $kitab->nama . ' - Perpustakaan Digital Masjid Al-Hasanah')

@section('content')
<div class="kitab-detail-page">
    
    <!-- Hero Header -->
    <section class="kitab-hero-section">
        <div class="hero-background">
            <div class="hero-pattern"></div>
        </div>
        <div class="hero-content">
            <div class="breadcrumb-modern">
                <a href="/kitab" class="breadcrumb-link">
                    <span>📚</span>
                    <span>Perpustakaan</span>
                </a>
                <span class="breadcrumb-separator">›</span>
                <span class="breadcrumb-current">{{ $kitab->nama }}</span>
            </div>
            
            <div class="kitab-hero-grid">
                <div class="kitab-cover-section">
                    <div class="cover-container">
                        <img src="{{ $kitab->cover_image_url }}" alt="{{ $kitab->nama }}" 
                             onerror="this.src='https://via.placeholder.com/300x400/1a3a2a/9FE1CB?text={{ urlencode($kitab->nama) }}'"
                             class="kitab-cover-image">
                        <div class="cover-overlay">
                            <div class="cover-actions">
                                <button onclick="openPdfViewer()" class="cover-action-btn primary">
                                    <span>📖</span>
                                    <span>Baca Sekarang</span>
                                </button>
                                <a href="/kitab/{{ $kitab->id }}/download" class="cover-action-btn secondary">
                                    <span>⬇️</span>
                                    <span>Download</span>
                                </a>
                            </div>
                        </div>
                        @if($kitab->is_featured)
                        <div class="featured-badge">
                            <span>⭐</span>
                            <span>Pilihan</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="kitab-info-section">
                    <div class="kitab-header-info">
                        <h1 class="kitab-title-hero">{{ $kitab->nama }}</h1>
                        @if($kitab->penulis)
                        <div class="author-info">
                            <span class="author-icon">✍️</span>
                            <span class="author-name">{{ $kitab->penulis }}</span>
                        </div>
                        @endif
                        
                        <div class="kitab-stats-hero">
                            <div class="stat-card">
                                <span class="stat-icon">📄</span>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $kitab->jumlah_halaman ?? '?' }}</span>
                                    <span class="stat-label">Halaman</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <span class="stat-icon">👁️</span>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $kitab->formatted_views }}</span>
                                    <span class="stat-label">Dibaca</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <span class="stat-icon">🏷️</span>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $kitab->kategori }}</span>
                                    <span class="stat-label">Kategori</span>
                                </div>
                            </div>
                        </div>
                        
                        @if($kitab->deskripsi)
                        <div class="kitab-description">
                            <h3 class="description-title">Deskripsi</h3>
                            <p class="description-text">{{ $kitab->deskripsi }}</p>
                        </div>
                        @endif
                        
                        <div class="kitab-metadata">
                            <div class="metadata-grid">
                                <div class="metadata-item">
                                    <span class="metadata-label">Bahasa</span>
                                    <span class="metadata-value">{{ $kitab->bahasa }}</span>
                                </div>
                                @if($kitab->tanggal_terbit)
                                <div class="metadata-item">
                                    <span class="metadata-label">Terbit</span>
                                    <span class="metadata-value">{{ $kitab->tanggal_terbit->format('d M Y') }}</span>
                                </div>
                                @endif
                                <div class="metadata-item">
                                    <span class="metadata-label">Format</span>
                                    <span class="metadata-value">PDF Digital</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="kitab-actions-hero">
                            <button onclick="openPdfViewer()" class="action-btn-hero primary">
                                <span class="btn-icon">📖</span>
                                <span class="btn-text">Baca Kitab</span>
                                <span class="btn-arrow">→</span>
                            </button>
                            <a href="/kitab/{{ $kitab->id }}/download" class="action-btn-hero secondary">
                                <span class="btn-icon">⬇️</span>
                                <span class="btn-text">Download PDF</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reading Tools Section -->
    <section class="reading-tools-section">
        <div class="tools-container">
            <div class="tools-header">
                <h2 class="tools-title">
                    <span>🛠️</span>
                    <span>Alat Baca</span>
                </h2>
                <p class="tools-subtitle">Fitur untuk pengalaman membaca yang lebih baik</p>
            </div>
            
            <div class="tools-grid">
                <div class="tool-card">
                    <div class="tool-icon">🔍</div>
                    <h3 class="tool-title">Pencarian</h3>
                    <p class="tool-description">Cari kata atau topik dalam kitab</p>
                </div>
                <div class="tool-card">
                    <div class="tool-icon">🔖</div>
                    <h3 class="tool-title">Bookmark</h3>
                    <p class="tool-description">Tandai halaman penting</p>
                </div>
                <div class="tool-card">
                    <div class="tool-icon">📝</div>
                    <h3 class="tool-title">Catatan</h3>
                    <p class="tool-description">Buat catatan pribadi</p>
                </div>
                <div class="tool-card">
                    <div class="tool-icon">📊</div>
                    <h3 class="tool-title">Progress</h3>
                    <p class="tool-description">Lacak kemajuan baca</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PDF Viewer Section -->
    <div id="pdfViewer" class="pdf-viewer-modern" style="display: none;">
        <div class="pdf-header-modern">
            <div class="pdf-title-bar">
                <div class="pdf-info">
                    <h3 class="pdf-title">{{ $kitab->nama }}</h3>
                    <span class="pdf-subtitle">{{ $kitab->penulis ?? 'Unknown Author' }}</span>
                </div>
                <button onclick="closePdfViewer()" class="pdf-close-btn">
                    <span>✕</span>
                </button>
            </div>
            
            <div class="pdf-controls-modern">
                <div class="pdf-navigation">
                    <button onclick="previousPage()" class="nav-btn" id="prevBtn">
                        <span>‹</span>
                        <span>Previous</span>
                    </button>
                    <div class="page-input-container">
                        <input type="number" id="pageInput" min="1" value="1" class="page-input">
                        <span class="page-separator">/</span>
                        <span id="totalPages" class="total-pages">{{ $kitab->jumlah_halaman ?? '?' }}</span>
                    </div>
                    <button onclick="nextPage()" class="nav-btn" id="nextBtn">
                        <span>Next</span>
                        <span>›</span>
                    </button>
                </div>
                
                <div class="pdf-tools">
                    <div class="tool-group">
                        <button onclick="zoomOut()" class="tool-btn" title="Zoom Out">
                            <span>🔍-</span>
                        </button>
                        <span class="zoom-level" id="zoomLevel">100%</span>
                        <button onclick="zoomIn()" class="tool-btn" title="Zoom In">
                            <span>🔍+</span>
                        </button>
                        <button onclick="resetZoom()" class="tool-btn" title="Reset Zoom">
                            <span>↻</span>
                        </button>
                    </div>
                    
                    <div class="tool-group">
                        <button onclick="toggleFullscreen()" class="tool-btn" title="Fullscreen">
                            <span>⛶</span>
                        </button>
                        <button onclick="downloadCurrentPage()" class="tool-btn" title="Download Page">
                            <span>⬇️</span>
                        </button>
                        <button onclick="printCurrentPage()" class="tool-btn" title="Print">
                            <span>🖨️</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="pdf-container-modern">
            <div class="pdf-loading" id="pdfLoading" style="display: none;">
                <div class="loading-spinner"></div>
                <p>Memuat kitab...</p>
            </div>
            <iframe id="pdfFrame" src="" class="pdf-frame-modern"></iframe>
        </div>
        
        <div class="pdf-footer">
            <div class="reading-progress">
                <div class="progress-bar">
                    <div class="progress-fill" id="progressFill"></div>
                </div>
                <span class="progress-text" id="progressText">Halaman 1 dari {{ $kitab->jumlah_halaman ?? '?' }}</span>
            </div>
        </div>
    </div>

    <!-- Related Kitabs Section -->
    @if($relatedKitabs->count() > 0)
    <section class="related-section-modern">
        <div class="related-container">
            <div class="related-header">
                <h2 class="related-title">
                    <span>📚</span>
                    <span>Kitab Terkait</span>
                </h2>
                <p class="related-subtitle">Kitab lain yang mungkin Anda minati</p>
            </div>
            
            <div class="related-grid-modern">
                @foreach($relatedKitabs as $related)
                <div class="related-card-modern" onclick="window.location.href='/kitab/{{ $related->id }}'">
                    <div class="related-cover-modern">
                        <img src="{{ $related->cover_image_url }}" alt="{{ $related->nama }}" 
                             onerror="this.src='https://via.placeholder.com/150x200/1a3a2a/9FE1CB?text={{ urlencode($related->nama) }}'">
                        <div class="related-overlay">
                            <div class="related-quick-actions">
                                <button class="quick-action-btn read">
                                    📖
                                </button>
                                <button class="quick-action-btn download">
                                    ⬇️
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="related-info-modern">
                        <h4 class="related-title-modern">{{ $related->nama }}</h4>
                        @if($related->penulis)
                        <p class="related-author-modern">{{ $related->penulis }}</p>
                        @endif
                        <div class="related-meta-modern">
                            <span class="meta-tag">{{ $related->kategori }}</span>
                            <span class="meta-pages">{{ $related->jumlah_halaman ?? '?' }} hal</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

</div>

<style>
/* Kitab Detail Page - Modern Professional Design */
.kitab-detail-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #0d3322 0%, #071a14 50%, #0a1f1a 100%);
    position: relative;
    overflow-x: hidden;
}

/* Hero Section */
.kitab-hero-section {
    position: relative;
    padding: 80px 20px 60px;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(ellipse at 20% 10%, rgba(29,158,117,0.15) 0%, transparent 50%),
        radial-gradient(ellipse at 80% 90%, rgba(255,215,0,0.1) 0%, transparent 50%),
        radial-gradient(circle at 50% 50%, rgba(13,51,34,0.8) 0%, rgba(7,26,20,0.9) 100%);
    pointer-events: none;
}

.hero-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 25% 25%, rgba(29,158,117,0.1) 2px, transparent 2px),
        radial-gradient(circle at 75% 75%, rgba(255,215,0,0.1) 2px, transparent 2px);
    background-size: 60px 60px;
    animation: patternMove 20s linear infinite;
}

@keyframes patternMove {
    0% { transform: translate(0, 0); }
    100% { transform: translate(60px, 60px); }
}

.hero-content {
    max-width: 1200px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

.breadcrumb-modern {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 32px;
    padding: 12px 20px;
    background: rgba(13,51,34,0.8);
    border: 1px solid rgba(29,158,117,0.3);
    border-radius: 12px;
    backdrop-filter: blur(8px);
    width: fit-content;
}

.breadcrumb-link {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #9FE1CB;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.breadcrumb-link:hover {
    color: #5DCAA5;
    transform: translateX(2px);
}

.breadcrumb-separator {
    color: rgba(159,225,203,0.5);
    font-size: 16px;
}

.breadcrumb-current {
    color: rgba(159,225,203,0.9);
    font-size: 14px;
    font-weight: 600;
}

.kitab-hero-grid {
    display: grid;
    grid-template-columns: 400px 1fr;
    gap: 60px;
    align-items: start;
}

/* Cover Section */
.kitab-cover-section {
    animation: fadeInLeft 0.8s ease-out;
}

.cover-container {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.4);
    background: rgba(13,51,34,0.9);
    border: 1px solid rgba(29,158,117,0.3);
    backdrop-filter: blur(8px);
}

.kitab-cover-image {
    width: 100%;
    height: 500px;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.cover-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8));
    display: flex;
    align-items: flex-end;
    padding: 32px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.cover-container:hover .cover-overlay {
    opacity: 1;
}

.cover-actions {
    display: flex;
    gap: 16px;
    width: 100%;
}

.cover-action-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 16px 24px;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.cover-action-btn.primary {
    background: linear-gradient(135deg, rgba(29,158,117,0.9), rgba(29,158,117,0.7));
    color: white;
    box-shadow: 0 8px 24px rgba(29,158,117,0.3);
}

.cover-action-btn.primary:hover {
    background: linear-gradient(135deg, rgba(29,158,117,1), rgba(29,158,117,0.8));
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(29,158,117,0.4);
}

.cover-action-btn.secondary {
    background: linear-gradient(135deg, rgba(255,215,0,0.9), rgba(255,215,0,0.7));
    color: #1a3a2a;
    box-shadow: 0 8px 24px rgba(255,215,0,0.3);
}

.cover-action-btn.secondary:hover {
    background: linear-gradient(135deg, rgba(255,215,0,1), rgba(255,215,0,0.8));
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(255,215,0,0.4);
}

.featured-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    background: linear-gradient(135deg, rgba(255,215,0,0.9), rgba(255,215,0,0.7));
    color: #1a3a2a;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 4px 16px rgba(255,215,0,0.3);
}

/* Info Section */
.kitab-info-section {
    animation: fadeInRight 0.8s ease-out 0.2s both;
}

.kitab-title-hero {
    font-size: 48px;
    font-weight: 700;
    color: #fff;
    line-height: 1.2;
    margin-bottom: 16px;
    background: linear-gradient(135deg, #fff 0%, #9FE1CB 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.author-info {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 32px;
    padding: 12px 20px;
    background: rgba(29,158,117,0.1);
    border: 1px solid rgba(29,158,117,0.3);
    border-radius: 12px;
    width: fit-content;
}

.author-icon {
    font-size: 20px;
    color: #9FE1CB;
}

.author-name {
    font-size: 18px;
    color: #9FE1CB;
    font-weight: 500;
}

.kitab-stats-hero {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 32px;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px;
    background: rgba(13,51,34,0.8);
    border: 1px solid rgba(29,158,117,0.3);
    border-radius: 16px;
    backdrop-filter: blur(8px);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    border-color: rgba(29,158,117,0.6);
    box-shadow: 0 12px 24px rgba(0,0,0,0.2);
}

.stat-icon {
    font-size: 24px;
    color: #FFD700;
}

.stat-content {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.stat-value {
    font-size: 24px;
    font-weight: 700;
    color: #fff;
}

.stat-label {
    font-size: 12px;
    color: rgba(159,225,203,0.7);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.kitab-description {
    margin-bottom: 32px;
}

.description-title {
    font-size: 20px;
    font-weight: 600;
    color: #9FE1CB;
    margin-bottom: 12px;
}

.description-text {
    font-size: 16px;
    color: rgba(159,225,203,0.8);
    line-height: 1.6;
}

.kitab-metadata {
    margin-bottom: 32px;
}

.metadata-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}

.metadata-item {
    display: flex;
    flex-direction: column;
    gap: 6px;
    padding: 16px;
    background: rgba(7,26,20,0.8);
    border: 1px solid rgba(29,158,117,0.2);
    border-radius: 12px;
}

.metadata-label {
    font-size: 12px;
    color: rgba(159,225,203,0.6);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.metadata-value {
    font-size: 16px;
    color: #9FE1CB;
    font-weight: 500;
}

.kitab-actions-hero {
    display: flex;
    gap: 20px;
}

.action-btn-hero {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 20px 32px;
    border: none;
    border-radius: 16px;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    position: relative;
    overflow: hidden;
}

.action-btn-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.action-btn-hero:hover::before {
    left: 100%;
}

.action-btn-hero.primary {
    background: linear-gradient(135deg, rgba(29,158,117,0.9), rgba(29,158,117,0.7));
    color: white;
    box-shadow: 0 12px 32px rgba(29,158,117,0.3);
    flex: 2;
}

.action-btn-hero.primary:hover {
    background: linear-gradient(135deg, rgba(29,158,117,1), rgba(29,158,117,0.8));
    transform: translateY(-3px);
    box-shadow: 0 16px 40px rgba(29,158,117,0.4);
}

.action-btn-hero.secondary {
    background: linear-gradient(135deg, rgba(255,215,0,0.9), rgba(255,215,0,0.7));
    color: #1a3a2a;
    box-shadow: 0 12px 32px rgba(255,215,0,0.3);
    flex: 1;
}

.action-btn-hero.secondary:hover {
    background: linear-gradient(135deg, rgba(255,215,0,1), rgba(255,215,0,0.8));
    transform: translateY(-3px);
    box-shadow: 0 16px 40px rgba(255,215,0,0.4);
}

.btn-arrow {
    font-size: 20px;
    transition: transform 0.3s ease;
}

.action-btn-hero:hover .btn-arrow {
    transform: translateX(4px);
}

/* Reading Tools Section */
.reading-tools-section {
    padding: 60px 20px;
    background: rgba(13,51,34,0.5);
    backdrop-filter: blur(10px);
    border-top: 1px solid rgba(29,158,117,0.2);
    border-bottom: 1px solid rgba(29,158,117,0.2);
}

.tools-container {
    max-width: 1200px;
    margin: 0 auto;
}

.tools-header {
    text-align: center;
    margin-bottom: 48px;
}

.tools-title {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    font-size: 36px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 12px;
}

.tools-subtitle {
    font-size: 18px;
    color: rgba(159,225,203,0.7);
    max-width: 600px;
    margin: 0 auto;
}

.tools-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 24px;
}

.tool-card {
    background: rgba(13,51,34,0.8);
    border: 1px solid rgba(29,158,117,0.3);
    border-radius: 16px;
    padding: 32px 24px;
    text-align: center;
    transition: all 0.3s ease;
    backdrop-filter: blur(8px);
    cursor: pointer;
}

.tool-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 32px rgba(0,0,0,0.2);
    border-color: rgba(29,158,117,0.6);
}

.tool-icon {
    font-size: 48px;
    margin-bottom: 16px;
    display: block;
}

.tool-title {
    font-size: 20px;
    font-weight: 600;
    color: #fff;
    margin-bottom: 8px;
}

.tool-description {
    font-size: 14px;
    color: rgba(159,225,203,0.7);
    line-height: 1.5;
}

/* Modern PDF Viewer */
.pdf-viewer-modern {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.95);
    z-index: 10000;
    display: flex;
    flex-direction: column;
    backdrop-filter: blur(10px);
}

.pdf-header-modern {
    background: linear-gradient(135deg, rgba(13,51,34,0.95), rgba(7,26,20,0.95));
    border-bottom: 1px solid rgba(29,158,117,0.3);
    backdrop-filter: blur(8px);
}

.pdf-title-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 24px;
}

.pdf-info {
    flex: 1;
}

.pdf-title {
    font-size: 20px;
    font-weight: 600;
    color: #fff;
    margin-bottom: 4px;
}

.pdf-subtitle {
    font-size: 14px;
    color: rgba(159,225,203,0.7);
}

.pdf-close-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    background: rgba(226,75,74,0.8);
    color: white;
    font-size: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.pdf-close-btn:hover {
    background: rgba(226,75,74,1);
    transform: scale(1.1);
}

.pdf-controls-modern {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 24px;
    border-top: 1px solid rgba(29,158,117,0.2);
}

.pdf-navigation {
    display: flex;
    align-items: center;
    gap: 16px;
}

.nav-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    background: rgba(29,158,117,0.8);
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.nav-btn:hover {
    background: rgba(29,158,117,1);
    transform: translateY(-1px);
}

.nav-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

.page-input-container {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    background: rgba(7,26,20,0.8);
    border: 1px solid rgba(29,158,117,0.3);
    border-radius: 8px;
}

.page-input {
    width: 60px;
    background: transparent;
    border: none;
    color: #9FE1CB;
    font-size: 14px;
    font-weight: 500;
    text-align: center;
    outline: none;
}

.page-separator {
    color: rgba(159,225,203,0.6);
    font-size: 14px;
}

.total-pages {
    color: #9FE1CB;
    font-size: 14px;
    font-weight: 500;
}

.pdf-tools {
    display: flex;
    gap: 16px;
}

.tool-group {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background: rgba(7,26,20,0.8);
    border: 1px solid rgba(29,158,117,0.3);
    border-radius: 8px;
}

.tool-btn {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 6px;
    background: rgba(29,158,117,0.6);
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.tool-btn:hover {
    background: rgba(29,158,117,1);
    transform: scale(1.1);
}

.zoom-level {
    color: #9FE1CB;
    font-size: 14px;
    font-weight: 500;
    min-width: 50px;
    text-align: center;
}

.pdf-container-modern {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    position: relative;
}

.pdf-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: #9FE1CB;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid rgba(159,225,203,0.3);
    border-top: 4px solid #9FE1CB;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 16px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.pdf-frame-modern {
    width: 100%;
    height: 100%;
    border: none;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.5);
}

.pdf-footer {
    background: rgba(13,51,34,0.95);
    padding: 16px 24px;
    border-top: 1px solid rgba(29,158,117,0.3);
}

.reading-progress {
    display: flex;
    align-items: center;
    gap: 16px;
}

.progress-bar {
    flex: 1;
    height: 4px;
    background: rgba(29,158,117,0.3);
    border-radius: 2px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #1d9e75, #5DCAA5);
    width: 0%;
    transition: width 0.3s ease;
}

.progress-text {
    color: #9FE1CB;
    font-size: 14px;
    font-weight: 500;
    min-width: 150px;
}

/* Related Section */
.related-section-modern {
    padding: 60px 20px;
}

.related-container {
    max-width: 1200px;
    margin: 0 auto;
}

.related-header {
    text-align: center;
    margin-bottom: 48px;
}

.related-title {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    font-size: 36px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 12px;
}

.related-subtitle {
    font-size: 18px;
    color: rgba(159,225,203,0.7);
    max-width: 600px;
    margin: 0 auto;
}

.related-grid-modern {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 32px;
}

.related-card-modern {
    background: linear-gradient(135deg, rgba(13,51,34,0.9), rgba(7,26,20,0.9));
    border: 1px solid rgba(29,158,117,0.3);
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.4s ease;
    backdrop-filter: blur(8px);
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
}

.related-card-modern:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    border-color: rgba(29,158,117,0.6);
}

.related-cover-modern {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.related-cover-modern img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.related-card-modern:hover .related-cover-modern img {
    transform: scale(1.05);
}

.related-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.related-card-modern:hover .related-overlay {
    opacity: 1;
}

.related-quick-actions {
    display: flex;
    gap: 12px;
}

.quick-action-btn {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    font-size: 20px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quick-action-btn.read {
    background: linear-gradient(135deg, rgba(29,158,117,0.9), rgba(29,158,117,0.7));
}

.quick-action-btn.read:hover {
    background: linear-gradient(135deg, rgba(29,158,117,1), rgba(29,158,117,0.8));
    transform: scale(1.1);
}

.quick-action-btn.download {
    background: linear-gradient(135deg, rgba(255,215,0,0.9), rgba(255,215,0,0.7));
}

.quick-action-btn.download:hover {
    background: linear-gradient(135deg, rgba(255,215,0,1), rgba(255,215,0,0.8));
    transform: scale(1.1);
}

.related-info-modern {
    padding: 24px;
}

.related-title-modern {
    font-size: 18px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 8px;
    line-height: 1.3;
}

.related-author-modern {
    color: rgba(159,225,203,0.8);
    font-size: 14px;
    margin-bottom: 12px;
}

.related-meta-modern {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.meta-tag {
    background: rgba(29,158,117,0.2);
    color: #5DCAA5;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}

.meta-pages {
    color: rgba(159,225,203,0.6);
    font-size: 12px;
}

/* Animations */
@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .kitab-hero-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .kitab-cover-image {
        height: 400px;
    }
    
    .kitab-title-hero {
        font-size: 36px;
    }
    
    .kitab-stats-hero {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .metadata-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }
    
    .kitab-actions-hero {
        flex-direction: column;
        gap: 16px;
    }
    
    .tools-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    
    .pdf-controls-modern {
        flex-direction: column;
        gap: 16px;
    }
    
    .pdf-tools {
        justify-content: center;
    }
    
    .related-grid-modern {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .kitab-hero-section {
        padding: 60px 20px 40px;
    }
    
    .kitab-title-hero {
        font-size: 28px;
    }
    
    .cover-actions {
        flex-direction: column;
    }
    
    .tools-grid {
        grid-template-columns: 1fr;
    }
    
    .pdf-navigation {
        flex-direction: column;
        gap: 12px;
    }
    
    .pdf-tools {
        flex-wrap: wrap;
        justify-content: center;
    }
}
</style>

<script>
// Enhanced PDF Viewer JavaScript
let currentPage = 1;
let totalPages = {{ $kitab->jumlah_halaman ?? 50 }};
let currentZoom = 1;
let isFullscreen = false;

function openPdfViewer() {
    const pdfViewer = document.getElementById('pdfViewer');
    const pdfFrame = document.getElementById('pdfFrame');
    const pdfLoading = document.getElementById('pdfLoading');
    
    // Show loading
    pdfLoading.style.display = 'block';
    pdfViewer.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    // Load PDF
    pdfFrame.src = '/kitab/{{ $kitab->id }}/pdf';
    
    // Hide loading after PDF loads
    pdfFrame.onload = function() {
        setTimeout(() => {
            pdfLoading.style.display = 'none';
            updateProgress();
        }, 1000);
    };
    
    // Initialize page input
    document.getElementById('pageInput').value = currentPage;
    document.getElementById('totalPages').textContent = totalPages;
}

function closePdfViewer() {
    const pdfViewer = document.getElementById('pdfViewer');
    const pdfFrame = document.getElementById('pdfFrame');
    
    pdfViewer.style.display = 'none';
    pdfFrame.src = '';
    document.body.style.overflow = '';
    
    // Reset state
    currentPage = 1;
    currentZoom = 1;
    isFullscreen = false;
    updatePageInfo();
    updateZoomLevel();
}

function previousPage() {
    if (currentPage > 1) {
        currentPage--;
        updatePdfPage();
    }
}

function nextPage() {
    if (currentPage < totalPages) {
        currentPage++;
        updatePdfPage();
    }
}

function updatePdfPage() {
    const pdfFrame = document.getElementById('pdfFrame');
    const currentUrl = pdfFrame.src.split('#')[0];
    pdfFrame.src = currentUrl + '#page=' + currentPage;
    updatePageInfo();
    updateProgress();
    updateNavigationButtons();
}

function updatePageInfo() {
    document.getElementById('pageInput').value = currentPage;
    document.getElementById('progressText').textContent = `Halaman ${currentPage} dari ${totalPages}`;
}

function updateProgress() {
    const progress = (currentPage / totalPages) * 100;
    document.getElementById('progressFill').style.width = progress + '%';
}

function updateNavigationButtons() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    prevBtn.disabled = currentPage <= 1;
    nextBtn.disabled = currentPage >= totalPages;
}

function zoomIn() {
    if (currentZoom < 3) {
        currentZoom += 0.25;
        updateZoom();
    }
}

function zoomOut() {
    if (currentZoom > 0.5) {
        currentZoom -= 0.25;
        updateZoom();
    }
}

function resetZoom() {
    currentZoom = 1;
    updateZoom();
}

function updateZoom() {
    const pdfFrame = document.getElementById('pdfFrame');
    pdfFrame.style.transform = `scale(${currentZoom})`;
    updateZoomLevel();
}

function updateZoomLevel() {
    document.getElementById('zoomLevel').textContent = Math.round(currentZoom * 100) + '%';
}

function toggleFullscreen() {
    const pdfViewer = document.getElementById('pdfViewer');
    
    if (!isFullscreen) {
        if (pdfViewer.requestFullscreen) {
            pdfViewer.requestFullscreen();
        } else if (pdfViewer.webkitRequestFullscreen) {
            pdfViewer.webkitRequestFullscreen();
        } else if (pdfViewer.msRequestFullscreen) {
            pdfViewer.msRequestFullscreen();
        }
        isFullscreen = true;
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
        isFullscreen = false;
    }
}

function downloadCurrentPage() {
    // This would require server-side implementation
    alert('Download halaman ini - fitur akan segera tersedia');
}

function printCurrentPage() {
    const pdfFrame = document.getElementById('pdfFrame');
    pdfFrame.contentWindow.print();
}

// Page input handler
document.addEventListener('DOMContentLoaded', function() {
    const pageInput = document.getElementById('pageInput');
    if (pageInput) {
        pageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const page = parseInt(this.value);
                if (page >= 1 && page <= totalPages) {
                    currentPage = page;
                    updatePdfPage();
                } else {
                    this.value = currentPage;
                }
            }
        });
        
        pageInput.addEventListener('blur', function() {
            const page = parseInt(this.value);
            if (isNaN(page) || page < 1 || page > totalPages) {
                this.value = currentPage;
            }
        });
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    const pdfViewer = document.getElementById('pdfViewer');
    
    if (pdfViewer.style.display === 'flex') {
        switch(e.key) {
            case 'Escape':
                closePdfViewer();
                break;
            case 'ArrowLeft':
                previousPage();
                break;
            case 'ArrowRight':
                nextPage();
                break;
            case '+':
            case '=':
                zoomIn();
                break;
            case '-':
                zoomOut();
                break;
            case '0':
                resetZoom();
                break;
            case 'f':
            case 'F':
                if (!e.ctrlKey && !e.metaKey) {
                    e.preventDefault();
                    toggleFullscreen();
                }
                break;
        }
    }
});

// Tool cards click handlers
document.addEventListener('DOMContentLoaded', function() {
    const toolCards = document.querySelectorAll('.tool-card');
    toolCards.forEach(card => {
        card.addEventListener('click', function() {
            const toolTitle = this.querySelector('.tool-title').textContent;
            showToolNotification(toolTitle);
        });
    });
});

function showToolNotification(toolName) {
    // Create a simple notification
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, rgba(29,158,117,0.9), rgba(29,158,117,0.7));
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.3);
        z-index: 10001;
        animation: slideIn 0.3s ease;
    `;
    notification.innerHTML = `
        <div style="display: flex; align-items: center; gap: 12px;">
            <span style="font-size: 20px;">🛠️</span>
            <div>
                <div style="font-weight: 600;">${toolName}</div>
                <div style="font-size: 14px; opacity: 0.9;">Fitur akan segera tersedia</div>
            </div>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Add slide animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>
@endsection
