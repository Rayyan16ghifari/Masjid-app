@extends('layouts.app')

@section('title', 'Kitab Kajian - Perpustakaan Digital')

@section('content')
<div class="kitab-page">
    
    <!-- Hero Section -->
    <section class="kitab-hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">
                    <span class="hero-title-main">Perpustakaan Digital</span>
                    <span class="hero-title-sub">Kitab Kajian Islam</span>
                </h1>
                <p class="hero-description">
                    Jelajahi koleksi kitab-kitab klasik Islam yang komprehensif. 
                    Dari hadis, aqidah, hingga tafsir - semua tersedia dalam format digital.
                </p>
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ \App\Models\Kitab::active()->count() }}</span>
                        <span class="stat-label">Kitab Tersedia</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ number_format(\App\Models\Kitab::sum('jumlah_halaman')/1000, 1) }}K</span>
                        <span class="stat-label">Total Halaman</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ number_format(\App\Models\Kitab::sum('views')) }}</span>
                        <span class="stat-label">Total Dibaca</span>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="floating-books">
                    <div class="book book-1">📚</div>
                    <div class="book book-2">📖</div>
                    <div class="book book-3">📕</div>
                    <div class="book book-4">📗</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Search and Filter Section -->
    <section class="search-section">
        <div class="search-container">
            <div class="search-wrapper">
                <form action="/kitab/search" method="GET" class="search-form">
                    <div class="search-input-wrapper">
                        <div class="search-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M21 21L16.514 16.506L21 21ZM19 10.5C19 15.194 15.194 19 10.5 19C5.806 19 2 15.194 2 10.5C2 5.806 5.806 2 10.5 2C15.194 2 19 5.806 19 10.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <input type="text" name="q" placeholder="Cari kitab, penulis, atau kata kunci..." 
                               class="search-input" value="{{ request('q') }}">
                        <button type="submit" class="search-btn">
                            <span>Cari</span>
                        </button>
                    </div>
                </form>
                
                <!-- Quick Filters -->
                <div class="quick-filters">
                    <button class="filter-btn active" data-category="all">
                        <span class="filter-icon">📚</span>
                        <span>Semua</span>
                    </button>
                    <button class="filter-btn" data-category="Hadis">
                        <span class="filter-icon">📝</span>
                        <span>Hadis</span>
                    </button>
                    <button class="filter-btn" data-category="Aqidah">
                        <span class="filter-icon">🕌</span>
                        <span>Aqidah</span>
                    </button>
                    <button class="filter-btn" data-category="Tafsir">
                        <span class="filter-icon">📖</span>
                        <span>Tafsir</span>
                    </button>
                    <button class="filter-btn" data-category="Fikih">
                        <span class="filter-icon">⚖️</span>
                        <span>Fikih</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Kitabs -->
    @if($featuredKitabs->count() > 0)
    <section class="featured-section">
        <div class="section-header">
            <h2 class="section-title">
                <span class="title-icon">⭐</span>
                Kitab Pilihan
            </h2>
            <p class="section-subtitle">Kitab-kitab terbaik yang direkomendasikan untuk Anda baca</p>
        </div>
        
        <div class="featured-kitabs">
            @foreach($featuredKitabs as $kitab)
            <div class="featured-card" onclick="window.location.href='/kitab/{{ $kitab->id }}'">
                <div class="featured-cover">
                    <img src="{{ $kitab->cover_image_url }}" alt="{{ $kitab->nama }}" 
                         onerror="this.src='https://via.placeholder.com/300x400/1a3a2a/9FE1CB?text={{ urlencode($kitab->nama) }}'; console.log('Image error for: {{ $kitab->nama }}')">
                    <div class="featured-overlay">
                        <div class="featured-badge">
                            <span>⭐</span>
                            <span>Pilihan</span>
                        </div>
                        <div class="featured-actions">
                            <button class="action-btn read-btn" onclick="event.stopPropagation(); window.location.href='/kitab/{{ $kitab->id }}'">
                                <span>📖</span>
                                <span>Baca</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="featured-content">
                    <h3 class="featured-title">{{ $kitab->nama }}</h3>
                    @if($kitab->penulis)
                    <p class="featured-author">{{ $kitab->penulis }}</p>
                    @endif
                    <div class="featured-meta">
                        <div class="meta-item">
                            <span class="meta-icon">📄</span>
                            <span>{{ $kitab->jumlah_halaman ?? '?' }} hal</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-icon">👁️</span>
                            <span>{{ $kitab->formattedViews }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-icon">🏷️</span>
                            <span>{{ $kitab->kategori }}</span>
                        </div>
                    </div>
                    @if($kitab->deskripsi)
                    <p class="featured-description">{{ substr($kitab->deskripsi, 0, 100) . (strlen($kitab->deskripsi) > 100 ? '...' : '') }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- All Kitabs -->
    <section class="all-kitabs-section">
        <div class="section-header">
            <h2 class="section-title">
                <span class="title-icon">📚</span>
                Koleksi Lengkap
            </h2>
            <p class="section-subtitle">{{ $allKitabs->count() }} kitab tersedia untuk dibaca</p>
        </div>
        
        <div class="kitab-grid">
            @foreach($allKitabs as $kitab)
            <div class="kitab-card" onclick="window.location.href='/kitab/{{ $kitab->id }}'">
                <div class="kitab-cover">
                    <img src="{{ $kitab->cover_image_url }}" alt="{{ $kitab->nama }}" 
                         onerror="this.src='https://via.placeholder.com/200x280/1a3a2a/9FE1CB?text={{ urlencode($kitab->nama) }}'; console.log('Image error for: {{ $kitab->nama }}')">
                    <div class="kitab-overlay">
                        <div class="overlay-content">
                            <div class="quick-actions">
                                <button class="quick-btn read-btn" onclick="event.stopPropagation(); window.location.href='/kitab/{{ $kitab->id }}'">
                                    📖
                                </button>
                                <button class="quick-btn download-btn" onclick="event.stopPropagation(); window.location.href='/kitab/{{ $kitab->id }}/download'">
                                    ⬇️
                                </button>
                            </div>
                            <div class="kitab-info">
                                <h4 class="kitab-title">{{ $kitab->nama }}</h4>
                                @if($kitab->penulis)
                                <p class="kitab-author">{{ $kitab->penulis }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($kitab->is_featured)
                    <div class="featured-ribbon">
                        <span>⭐</span>
                    </div>
                    @endif
                </div>
                <div class="kitab-content">
                    <h3 class="kitab-title">{{ $kitab->nama }}</h3>
                    @if($kitab->penulis)
                    <p class="kitab-author">{{ $kitab->penulis }}</p>
                    @endif
                    <div class="kitab-meta">
                        <span class="category-tag">{{ $kitab->kategori }}</span>
                        <span class="pages-info">{{ $kitab->jumlah_halaman ?? '?' }} halaman</span>
                    </div>
                    <div class="kitab-stats">
                        <span class="stat">
                            <span class="stat-icon">👁️</span>
                            <span>{{ $kitab->formattedViews }}</span>
                        </span>
                        @if($kitab->tanggal_terbit)
                        <span class="stat">
                            <span class="stat-icon">📅</span>
                            <span>{{ $kitab->tanggal_terbit->format('M Y') }}</span>
                        </span>
                        @endif
                    </div>
                    <div class="kitab-actions">
                        <button class="action-btn primary-btn" onclick="event.stopPropagation(); window.location.href='/kitab/{{ $kitab->id }}'">
                            <span>📖</span>
                            <span>Baca Sekarang</span>
                        </button>
                        <button class="action-btn secondary-btn" onclick="event.stopPropagation(); window.location.href='/kitab/{{ $kitab->id }}/download'">
                            <span>⬇️</span>
                            <span>Download</span>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $allKitabs->links() }}
        </div>
    </section>

</div>

<style>
/* Kitab Page - Modern Professional Design */
.kitab-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #0d3322 0%, #071a14 50%, #0a1f1a 100%);
    position: relative;
    overflow-x: hidden;
}

/* Hero Section */
.kitab-hero {
    padding: 80px 20px 60px;
    position: relative;
    overflow: hidden;
}

.kitab-hero::before {
    content: '';
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

.hero-content {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
    position: relative;
    z-index: 1;
}

.hero-text {
    animation: fadeInUp 0.8s ease-out;
}

.hero-title {
    margin-bottom: 24px;
}

.hero-title-main {
    display: block;
    font-size: 48px;
    font-weight: 700;
    color: #fff;
    line-height: 1.2;
    margin-bottom: 8px;
    background: linear-gradient(135deg, #fff 0%, #9FE1CB 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-title-sub {
    display: block;
    font-size: 20px;
    font-weight: 400;
    color: #5DCAA5;
    margin-bottom: 16px;
}

.hero-description {
    font-size: 18px;
    color: rgba(159,225,203,0.8);
    line-height: 1.6;
    margin-bottom: 40px;
    max-width: 500px;
}

.hero-stats {
    display: flex;
    gap: 40px;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 32px;
    font-weight: 700;
    color: #FFD700;
    margin-bottom: 8px;
    text-shadow: 0 2px 10px rgba(255,215,0,0.3);
}

.stat-label {
    font-size: 14px;
    color: rgba(159,225,203,0.7);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.hero-visual {
    position: relative;
    height: 300px;
    animation: fadeInRight 0.8s ease-out 0.2s both;
}

.floating-books {
    position: relative;
    width: 100%;
    height: 100%;
}

.book {
    position: absolute;
    font-size: 48px;
    animation: float 3s ease-in-out infinite;
}

.book-1 {
    top: 20%;
    left: 20%;
    animation-delay: 0s;
}

.book-2 {
    top: 60%;
    left: 50%;
    animation-delay: 0.5s;
}

.book-3 {
    top: 30%;
    left: 70%;
    animation-delay: 1s;
}

.book-4 {
    top: 70%;
    left: 30%;
    animation-delay: 1.5s;
}

/* Search Section */
.search-section {
    padding: 40px 20px;
    background: rgba(13,51,34,0.5);
    backdrop-filter: blur(10px);
    border-top: 1px solid rgba(29,158,117,0.2);
    border-bottom: 1px solid rgba(29,158,117,0.2);
}

.search-container {
    max-width: 800px;
    margin: 0 auto;
}

.search-wrapper {
    background: rgba(13,51,34,0.8);
    border: 1px solid rgba(29,158,117,0.3);
    border-radius: 20px;
    padding: 24px;
    backdrop-filter: blur(8px);
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
}

.search-form {
    margin-bottom: 24px;
}

.search-input-wrapper {
    display: flex;
    align-items: center;
    background: rgba(7,26,20,0.8);
    border: 2px solid rgba(29,158,117,0.3);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.search-input-wrapper:focus-within {
    border-color: rgba(29,158,117,0.6);
    box-shadow: 0 0 20px rgba(29,158,117,0.2);
}

.search-icon {
    padding: 0 20px;
    color: rgba(159,225,203,0.6);
}

.search-input {
    flex: 1;
    background: transparent;
    border: none;
    padding: 16px 0;
    color: #9FE1CB;
    font-size: 16px;
    outline: none;
}

.search-input::placeholder {
    color: rgba(159,225,203,0.5);
}

.search-btn {
    background: linear-gradient(135deg, rgba(29,158,117,0.9), rgba(29,158,117,0.7));
    border: none;
    padding: 16px 32px;
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    border-left: 1px solid rgba(29,158,117,0.3);
}

.search-btn:hover {
    background: linear-gradient(135deg, rgba(29,158,117,1), rgba(29,158,117,0.8));
    transform: translateY(-1px);
}

.quick-filters {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    justify-content: center;
}

.filter-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    background: rgba(7,26,20,0.8);
    border: 1px solid rgba(29,158,117,0.3);
    border-radius: 12px;
    color: rgba(159,225,203,0.7);
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-btn:hover {
    background: rgba(29,158,117,0.2);
    border-color: rgba(29,158,117,0.5);
    color: #9FE1CB;
    transform: translateY(-2px);
}

.filter-btn.active {
    background: linear-gradient(135deg, rgba(29,158,117,0.8), rgba(29,158,117,0.6));
    border-color: rgba(29,158,117,0.8);
    color: white;
}

/* Section Headers */
.section-header {
    text-align: center;
    margin-bottom: 48px;
}

.section-title {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    font-size: 36px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 12px;
}

.title-icon {
    font-size: 32px;
}

.section-subtitle {
    font-size: 18px;
    color: rgba(159,225,203,0.7);
    max-width: 600px;
    margin: 0 auto;
}

/* Featured Section */
.featured-section {
    padding: 60px 20px;
}

.featured-carousel {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 32px;
}

.featured-card {
    background: linear-gradient(135deg, rgba(13,51,34,0.9), rgba(7,26,20,0.9));
    border: 1px solid rgba(29,158,117,0.3);
    border-radius: 20px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.4s ease;
    backdrop-filter: blur(8px);
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
}

.featured-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    border-color: rgba(29,158,117,0.6);
}

.featured-cover {
    position: relative;
    height: 300px;
    overflow: hidden;
}

.featured-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.featured-card:hover .featured-cover img {
    transform: scale(1.08);
}

.featured-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.7));
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 20px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.featured-card:hover .featured-overlay {
    opacity: 1;
}

.featured-badge {
    align-self: flex-start;
    background: linear-gradient(135deg, rgba(255,215,0,0.9), rgba(255,215,0,0.7));
    color: #1a3a2a;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 4px 12px rgba(255,215,0,0.3);
}

.featured-actions {
    align-self: flex-end;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: linear-gradient(135deg, rgba(29,158,117,0.9), rgba(29,158,117,0.7));
    border: none;
    border-radius: 12px;
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 16px rgba(29,158,117,0.3);
}

.action-btn:hover {
    background: linear-gradient(135deg, rgba(29,158,117,1), rgba(29,158,117,0.8));
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(29,158,117,0.4);
}

.featured-content {
    padding: 24px;
}

.featured-title {
    font-size: 22px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 8px;
    line-height: 1.3;
}

.featured-author {
    color: rgba(159,225,203,0.8);
    font-size: 16px;
    margin-bottom: 16px;
}

.featured-meta {
    display: flex;
    gap: 16px;
    margin-bottom: 16px;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    color: rgba(159,225,203,0.6);
}

.meta-icon {
    font-size: 16px;
}

.featured-description {
    color: rgba(159,225,203,0.7);
    font-size: 14px;
    line-height: 1.5;
}

/* All Kitabs Section */
.all-kitabs-section {
    padding: 60px 20px;
}

.kitab-grid {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 32px;
}

.kitab-card {
    background: linear-gradient(135deg, rgba(13,51,34,0.9), rgba(7,26,20,0.9));
    border: 1px solid rgba(29,158,117,0.3);
    border-radius: 20px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.4s ease;
    backdrop-filter: blur(8px);
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
}

.kitab-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    border-color: rgba(29,158,117,0.6);
}

.kitab-cover {
    position: relative;
    height: 240px;
    overflow: hidden;
}

.kitab-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.kitab-card:hover .kitab-cover img {
    transform: scale(1.05);
}

.kitab-overlay {
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

.kitab-card:hover .kitab-overlay {
    opacity: 1;
}

.overlay-content {
    text-align: center;
    color: white;
}

.quick-actions {
    display: flex;
    gap: 12px;
    margin-bottom: 16px;
    justify-content: center;
}

.quick-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    font-size: 20px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quick-btn.read-btn {
    background: linear-gradient(135deg, rgba(29,158,117,0.9), rgba(29,158,117,0.7));
}

.quick-btn.read-btn:hover {
    background: linear-gradient(135deg, rgba(29,158,117,1), rgba(29,158,117,0.8));
    transform: scale(1.1);
}

.quick-btn.download-btn {
    background: linear-gradient(135deg, rgba(255,215,0,0.9), rgba(255,215,0,0.7));
}

.quick-btn.download-btn:hover {
    background: linear-gradient(135deg, rgba(255,215,0,1), rgba(255,215,0,0.8));
    transform: scale(1.1);
}

.featured-ribbon {
    position: absolute;
    top: 16px;
    right: 16px;
    background: linear-gradient(135deg, rgba(255,215,0,0.9), rgba(255,215,0,0.7));
    color: #1a3a2a;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    box-shadow: 0 4px 12px rgba(255,215,0,0.3);
}

.kitab-content {
    padding: 24px;
}

.kitab-title {
    font-size: 20px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 8px;
    line-height: 1.3;
}

.kitab-author {
    color: rgba(159,225,203,0.8);
    font-size: 16px;
    margin-bottom: 16px;
}

.kitab-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.category-tag {
    background: rgba(29,158,117,0.2);
    color: #5DCAA5;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}

.pages-info {
    color: rgba(159,225,203,0.6);
    font-size: 14px;
}

.kitab-stats {
    display: flex;
    gap: 16px;
    margin-bottom: 20px;
}

.stat {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    color: rgba(159,225,203,0.6);
}

.kitab-actions {
    display: flex;
    gap: 12px;
}

.primary-btn {
    flex: 2;
    background: linear-gradient(135deg, rgba(29,158,117,0.9), rgba(29,158,117,0.7));
    color: white;
}

.secondary-btn {
    flex: 1;
    background: linear-gradient(135deg, rgba(255,215,0,0.9), rgba(255,215,0,0.7));
    color: #1a3a2a;
}

/* Pagination */
.pagination-wrapper {
    max-width: 1200px;
    margin: 60px auto 40px;
    text-align: center;
}

.pagination-wrapper .pagination {
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
}

.pagination-wrapper .pagination a {
    background: rgba(13,51,34,0.8);
    color: #9FE1CB;
    padding: 12px 20px;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid rgba(29,158,117,0.3);
}

.pagination-wrapper .pagination a:hover {
    background: rgba(29,158,117,0.8);
    border-color: rgba(29,158,117,0.6);
    transform: translateY(-2px);
}

.pagination-wrapper .pagination .active {
    background: linear-gradient(135deg, rgba(29,158,117,0.9), rgba(29,158,117,0.7));
    border-color: rgba(29,158,117,0.8);
}

/* Animations */
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

@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20px);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-content {
        grid-template-columns: 1fr;
        gap: 40px;
        text-align: center;
    }
    
    .hero-title-main {
        font-size: 36px;
    }
    
    .hero-stats {
        justify-content: center;
        gap: 20px;
    }
    
    .featured-carousel {
        grid-template-columns: 1fr;
    }
    
    .kitab-grid {
        grid-template-columns: 1fr;
    }
    
    .quick-filters {
        justify-content: center;
    }
    
    .search-input-wrapper {
        flex-direction: column;
    }
    
    .search-btn {
        border-left: none;
        border-top: 1px solid rgba(29,158,117,0.3);
        border-radius: 0 0 14px 14px;
    }
}

@media (max-width: 480px) {
    .kitab-hero {
        padding: 60px 20px 40px;
    }
    
    .hero-title-main {
        font-size: 28px;
    }
    
    .hero-description {
        font-size: 16px;
    }
    
    .section-title {
        font-size: 28px;
    }
    
    .featured-card,
    .kitab-card {
        border-radius: 16px;
    }
    
    .kitab-actions {
        flex-direction: column;
    }
}
</style>

<script>
// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get category
            const category = this.dataset.category;
            
            // Filter kitabs (this would need backend implementation)
            if (category !== 'all') {
                window.location.href = `/kitab/kategori/${category}`;
            } else {
                window.location.href = '/kitab';
            }
        });
    });
    
    // Add smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>
@endsection
