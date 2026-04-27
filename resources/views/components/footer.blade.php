<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

.ft-footer {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: linear-gradient(135deg, #0a2219 0%, #071a14 100%);
    color: #fff;
    margin-top: auto;
    border-top: 1px solid rgba(29,158,117,0.2);
}

.ft-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 48px 32px 24px;
}

.ft-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 48px;
    margin-bottom: 32px;
}

.ft-section h3 {
    font-family: 'Playfair Display', serif;
    font-size: 20px;
    font-weight: 700;
    color: #FFD700;
    margin-bottom: 16px;
    position: relative;
    padding-bottom: 8px;
}

.ft-section h3::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 2px;
    background: linear-gradient(90deg, #FFD700, transparent);
}

.ft-description {
    font-size: 14px;
    line-height: 1.6;
    color: rgba(159,225,203,0.8);
    margin-bottom: 16px;
}

.ft-info-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 12px;
}

.ft-info-icon {
    width: 20px;
    height: 20px;
    flex-shrink: 0;
    color: #5DCAA5;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ft-info-text {
    font-size: 14px;
    line-height: 1.5;
    color: rgba(159,225,203,0.9);
}

.ft-info-text a {
    color: #9FE1CB;
    text-decoration: none;
    transition: color 0.2s;
}

.ft-info-text a:hover {
    color: #FFD700;
}

.ft-social-links {
    display: flex;
    gap: 12px;
}

.ft-social-link {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(29,158,117,0.2);
    border: 1px solid rgba(29,158,117,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9FE1CB;
    text-decoration: none;
    transition: all 0.2s;
}

.ft-social-link:hover {
    background: rgba(29,158,117,0.3);
    border-color: rgba(29,158,117,0.5);
    color: #FFD700;
    transform: translateY(-2px);
}

.ft-bottom {
    border-top: 1px solid rgba(29,158,117,0.2);
    padding-top: 24px;
    text-align: center;
}

.ft-copyright {
    font-size: 13px;
    color: rgba(159,225,203,0.6);
    margin-bottom: 8px;
}

.ft-links {
    display: flex;
    justify-content: center;
    gap: 24px;
    flex-wrap: wrap;
}

.ft-links a {
    font-size: 13px;
    color: rgba(159,225,203,0.7);
    text-decoration: none;
    transition: color 0.2s;
}

.ft-links a:hover {
    color: #9FE1CB;
}

/* Responsive */
@media (max-width: 968px) {
    .ft-grid {
        grid-template-columns: 1fr 1fr;
        gap: 32px;
    }
    
    .ft-section:last-child {
        grid-column: span 2;
    }
}

@media (max-width: 640px) {
    .ft-container {
        padding: 32px 20px 20px;
    }
    
    .ft-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }
    
    .ft-section:last-child {
        grid-column: span 1;
    }
    
    .ft-section h3 {
        font-size: 18px;
    }
    
    .ft-links {
        flex-direction: column;
        gap: 8px;
    }
}
</style>

<footer class="ft-footer">
    <div class="ft-container">
        <div class="ft-grid">
            <!-- Masjid Al-Hasanah Section -->
            <div class="ft-section">
                <h3>Masjid Al-Hasanah</h3>
                <p class="ft-description">
                    Masjid Al-Hasanah adalah pusat kegiatan spiritual dan pendidikan Islam yang 
                    berlokasi di Komplek Pushubad Cijantung, Jakarta Timur. Kami berkomitmen 
                    untuk menjadi pencerah masyarakat melalui berbagai program kajian, 
                    pendidikan Al-Quran, dan kegiatan sosial kemasyarakatan.
                </p>
                <p class="ft-description">
                    Dengan semangat "Al-Hasanah" (kebaikan), kami terus berupaya memberikan 
                    layanan terbaik bagi jamaah dan masyarakat sekitar.
                </p>
            </div>

            <!-- Kontak & Lokasi Section -->
            <div class="ft-section">
                <h3>KONTAK & LOKASI</h3>
                <div class="ft-info-item">
                    <div class="ft-info-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <div class="ft-info-text">
                        Komplek Pushubad Cijantung Jl. Radar VII<br>
                        Kel. Kalisari, Kec. Pasar Rebo<br>
                        Jakarta Timur 13790
                    </div>
                </div>
                <div class="ft-info-item">
                    <div class="ft-info-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                    </div>
                    <div class="ft-info-text">
                        <a href="https://wa.me/6281934178960" target="_blank">+62 819-3417-8960</a>
                    </div>
                </div>
                <div class="ft-info-item">
                    <div class="ft-info-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                    <div class="ft-info-text">
                        <a href="mailto:info@masjidalhasanah.id">info@masjidalhasanah.id</a>
                    </div>
                </div>
            </div>

            <!-- Ikuti Sosial Media Section -->
            <div class="ft-section">
                <h3>IKUTI SOSIAL MEDIA</h3>
                <p class="ft-description" style="margin-bottom: 20px;">
                    Dapatkan informasi terbaru tentang kegiatan dan jadwal masjid melalui media sosial kami.
                </p>
                <div class="ft-social-links">
                    <a href="https://instagram.com/masjidalhasanah" target="_blank" class="ft-social-link" title="Instagram">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" fill="white"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke="white" stroke-width="2" stroke-linecap="round"></line>
                        </svg>
                    </a>
                    <a href="https://youtube.com/masjidalhasanah" target="_blank" class="ft-social-link" title="YouTube">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.4 19.54C5.12 20 12 20 12 20s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58zM9.75 15.02V8.98L15.5 12l-5.75 3.02z" fill="white"></path>
                        </svg>
                    </a>
                    <a href="https://facebook.com/masjidalhasanah" target="_blank" class="ft-social-link" title="Facebook">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" fill="white"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="ft-bottom">
            <div class="ft-copyright">
                © 2026 Masjid Al-Hasanah. All rights reserved.
            </div>
            <div class="ft-links">
                <a href="/tentang">Tentang Kami</a>
                <a href="/kontak">Kontak</a>
                <a href="/faq">FAQ</a>
                <a href="/pengumuman">Pengumuman</a>
                <a href="/donasi">Donasi</a>
            </div>
        </div>
    </div>
</footer>
