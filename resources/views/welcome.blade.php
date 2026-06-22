@extends('layouts.guest')

@section('content')
<style>
    /* Reset content padding for edge-to-edge sections */
    .content {
        padding: 0 !important;
        display: block !important;
    }
    .section-padding {
        padding: 5rem 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    /* Hero Section */
    .hero {
        background: linear-gradient(135deg, rgba(229, 57, 53, 0.05) 0%, rgba(255, 95, 162, 0.1) 100%);
        padding: 10rem 2rem 6rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .hero::before {
        content: '';
        position: absolute;
        top: -50%; left: -50%; width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,95,162,0.1) 0%, rgba(255,255,255,0) 70%);
        z-index: -1;
    }
    .hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }
    .hero h1 span {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .hero p {
        font-size: 1.25rem;
        color: #555;
        max-width: 600px;
        margin: 0 auto 2.5rem;
        line-height: 1.6;
    }
    .hero-btn {
        display: inline-block;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white !important;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: bold !important;
        text-decoration: none;
        box-shadow: 0 10px 25px rgba(229, 57, 53, 0.4);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .hero-btn:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 15px 30px rgba(229, 57, 53, 0.5);
    }

    /* Statistik Section */
    .stats {
        display: flex;
        justify-content: center;
        gap: 4rem;
        background-color: white;
        padding: 3rem 2rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border-radius: 20px;
        margin: -3rem auto 3rem;
        max-width: 1000px;
        position: relative;
        z-index: 10;
        flex-wrap: wrap;
    }
    .stat-item {
        text-align: center;
    }
    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }
    .stat-label {
        font-size: 1rem;
        color: #666;
        font-weight: 500;
    }

    /* Kategori Populer */
    .section-title {
        text-align: center;
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }
    .section-subtitle {
        text-align: center;
        color: #666;
        margin-bottom: 3rem;
        font-size: 1.1rem;
    }
    .categories {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
    }
    .category-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
        border: 1px solid rgba(229, 57, 53, 0.05);
    }
    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(229, 57, 53, 0.15);
        border-color: rgba(229, 57, 53, 0.2);
    }
    .category-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    .category-name {
        font-weight: 700;
        font-size: 1.2rem;
        color: var(--text-dark);
    }

    /* Cara Kerja */
    .how-it-works {
        background: #fdfdfd;
    }
    .steps {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 3rem;
        position: relative;
    }
    .step-card {
        text-align: center;
        position: relative;
        padding: 2rem;
    }
    .step-number {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 800;
        margin: 0 auto 1.5rem;
        box-shadow: 0 10px 20px rgba(229, 57, 53, 0.3);
    }
    .step-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    .step-desc {
        color: #666;
        line-height: 1.6;
    }

    /* Testimoni */
    .testimonials {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }
    .testimonials .section-title, .testimonials .section-subtitle {
        color: white;
    }
    .testimonials .section-subtitle {
        opacity: 0.9;
    }
    .testi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }
    .testi-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        padding: 2rem;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .testi-content {
        font-style: italic;
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }
    .testi-author {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .author-avatar {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
    }
    .author-info h4 {
        margin: 0;
        font-size: 1.1rem;
    }
    .author-info p {
        margin: 0;
        font-size: 0.9rem;
        opacity: 0.8;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .hero h1 { font-size: 2.5rem; }
        .stats { flex-direction: column; gap: 2rem; margin-top: 2rem; }
    }
</style>

<!-- Hero Section -->
<section class="hero">
    <h1>Cari Makan di Kampus <br><span>Lebih Mudah & Cepat</span></h1>
    <p>Ayam Kampus menghubungkan mahasiswa dengan tenant kuliner terbaik di sekitar area kampus. Pesan duluan, ambil tanpa antre!</p>
    <a href="{{ route('register') }}" class="hero-btn">Mulai Pesan Sekarang</a>
</section>

<!-- Statistik -->
<div class="stats">
    <div class="stat-item">
        <div class="stat-number">50+</div>
        <div class="stat-label">Mitra Kuliner</div>
    </div>
    <div class="stat-item">
        <div class="stat-number">200+</div>
        <div class="stat-label">Menu Pilihan</div>
    </div>
    <div class="stat-item">
        <div class="stat-number">10k+</div>
        <div class="stat-label">Mahasiswa Aktif</div>
    </div>
    <div class="stat-item">
        <div class="stat-number">4.9/5</div>
        <div class="stat-label">Rating Rata-rata</div>
    </div>
</div>

<!-- Kategori Populer -->
<section class="section-padding">
    <h2 class="section-title">Kategori Populer</h2>
    <p class="section-subtitle">Temukan makanan favoritmu dari berbagai pilihan</p>
    
    <div class="categories">
        <div class="category-card">
            <div class="category-icon">🍗</div>
            <div class="category-name">Ayam & Geprek</div>
        </div>
        <div class="category-card">
            <div class="category-icon">🍜</div>
            <div class="category-name">Mie & Bakso</div>
        </div>
        <div class="category-card">
            <div class="category-icon">☕</div>
            <div class="category-name">Kopi & Minuman</div>
        </div>
        <div class="category-card">
            <div class="category-icon">🍱</div>
            <div class="category-name">Nasi Kotak</div>
        </div>
    </div>
</section>

<!-- Cara Kerja -->
<section class="how-it-works section-padding" style="max-width: 100%;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <h2 class="section-title">Cara Kerja</h2>
        <p class="section-subtitle">Pesan makanan dalam 3 langkah mudah</p>
        
        <div class="steps">
            <div class="step-card">
                <div class="step-number">1</div>
                <h3 class="step-title">Pilih Menu</h3>
                <p class="step-desc">Jelajahi berbagai menu dari tenant favorit yang ada di sekitar kampusmu.</p>
            </div>
            <div class="step-card">
                <div class="step-number">2</div>
                <h3 class="step-title">Bayar Fleksibel</h3>
                <p class="step-desc">Selesaikan pembayaran secara online dengan berbagai metode yang mudah.</p>
            </div>
            <div class="step-card">
                <div class="step-number">3</div>
                <h3 class="step-title">Ambil / Antar</h3>
                <p class="step-desc">Ambil pesananmu tanpa antre atau tunggu diantar langsung ke kelasmu.</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimoni -->
<section class="testimonials section-padding" style="max-width: 100%;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <h2 class="section-title">Apa Kata Mereka?</h2>
        <p class="section-subtitle">Pengalaman mahasiswa yang telah menggunakan Ayam Kampus</p>
        
        <div class="testi-grid">
            <div class="testi-card">
                <div class="testi-content">"Sangat membantu! Dulu sering telat masuk kelas gara-gara antre makan di kantin. Sekarang tinggal pesan lewat aplikasi, pas istirahat tinggal ambil."</div>
                <div class="testi-author">
                    <div class="author-avatar">B</div>
                    <div class="author-info">
                        <h4>Budi Santoso</h4>
                        <p>Mahasiswa Teknik Informatika</p>
                    </div>
                </div>
            </div>
            <div class="testi-card">
                <div class="testi-content">"Banyak banget promo menarik tiap minggunya. Sebagai anak kos, aplikasi ini benar-benar jadi penyelamat akhir bulan."</div>
                <div class="testi-author">
                    <div class="author-avatar">S</div>
                    <div class="author-info">
                        <h4>Siti Aminah</h4>
                        <p>Mahasiswa Ilmu Komunikasi</p>
                    </div>
                </div>
            </div>
            <div class="testi-card">
                <div class="testi-content">"UI/UX nya sangat modern dan gampang dipakai. Loadingnya cepat dan tenant-nya makin hari makin banyak."</div>
                <div class="testi-author">
                    <div class="author-avatar">D</div>
                    <div class="author-info">
                        <h4>Dimas Pratama</h4>
                        <p>Mahasiswa Manajemen Bisnis</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
