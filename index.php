<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSIS Website - SMA Contoh</title>
    <link rel="stylesheet" href="index.css">
    <!-- Include Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container header-container">
            <div class="logo-container">
                <img src="foto/logo-sekolah.png" alt="Logo Sekolah" class="logo">
                <img src="foto/logo-osis.png" alt="Logo OSIS" class="logo">
            </div>
            
            <nav class="desktop-nav">
                <a href="index.php">Beranda</a>
                <a href="struktur.php">Struktur OSIS</a>
                <a href="kalender.php">Kalender Kegiatan</a>
                <a href="news.php">Berita & Pengumuman</a>
            </nav>
            
            <button class="mobile-menu-btn">☰</button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-content">
            <h1>Selamat Datang di Website OSIS</h1>
            <p>Organisasi Siswa Intra Sekolah Yayasan Pendidikan Raksana  Bertindak dan Bersatu untuk Satu</p>
            <a href="#main-content" class="btn btn-primary">Jelajahi Sekarang</a>
        </div>
    </section>

    <!-- Main Content -->
    <main id="main-content">
        <!-- News Section -->
        <section class="section">
            <div class="container">
                <h2 class="section-title">Berita Terkini</h2>
                
                <div class="news-grid">
                    <!-- News Item 1 -->
                    <article class="news-card">
                        <img src="news1.jpg" alt="Kegiatan OSIS" class="news-img">
                        <div class="news-content">
                            <span class="news-date">15 Agustus 2023</span>
                            <h3 class="news-title">Pelantikan Pengurus OSIS Periode 2023/2024</h3>
                            <p class="news-excerpt">Acara pelantikan pengurus OSIS baru telah dilaksanakan dengan khidmat di aula sekolah...</p>
                            <a href="#" class="read-more">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </article>
                    
                    <!-- News Item 2 -->
                    <article class="news-card">
                        <img src="news2.jpg" alt="Kegiatan OSIS" class="news-img">
                        <div class="news-content">
                            <span class="news-date">10 Agustus 2023</span>
                            <h3 class="news-title">OSIS Gelar Bakti Sosial di Panti Asuhan</h3>
                            <p class="news-excerpt">Sebagai bentuk kepedulian sosial, OSIS mengadakan kegiatan bakti sosial di Panti Asuhan...</p>
                            <a href="#" class="read-more">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </article>
                    
                    <!-- News Item 3 -->
                    <article class="news-card">
                        <img src="news3.jpg" alt="Kegiatan OSIS" class="news-img">
                        <div class="news-content">
                            <span class="news-date">5 Agustus 2023</span>
                            <h3 class="news-title">Persiapan Menuju Class Meeting Semester Ganjil</h3>
                            <p class="news-excerpt">OSIS sedang mempersiapkan serangkaian kegiatan class meeting yang akan dilaksanakan...</p>
                            <a href="#" class="read-more">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </article>
                </div>
            </div>
        </section>
        
        <!-- Announcements Section -->
        <section class="section bg-gray-100">
            <div class="container">
                <h2 class="section-title">Pengumuman Penting</h2>
                
                <div class="announcement-list">
                    <!-- Announcement 1 -->
                    <div class="announcement-item">
                        <span class="announcement-badge">BARU</span>
                        <div>
                            <h3>Pendaftaran Ekstrakurikuler Tahun Ajaran 2023/2024</h3>
                            <p>Batas akhir pendaftaran: 20 Agustus 2023</p>
                        </div>
                    </div>
                    
                    <!-- Announcement 2 -->
                    <div class="announcement-item">
                        <span class="announcement-badge">BARU</span>
                        <div>
                            <h3>Jadwal Pemilihan Ketua OSIS Periode 2023/2024</h3>
                            <p>Akan dilaksanakan pada 25-27 Agustus 2023</p>
                        </div>
                    </div>
                    
                    <!-- Announcement 3 -->
                    <div class="announcement-item">
                        <div>
                            <h3>Pembagian Kelas untuk Class Meeting</h3>
                            <p>Lihat pengumuman di papan pengumuman sekolah</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Quick Links Section -->
        <section class="section">
            <div class="container">
                <div class="quick-links">
                    <!-- Quick Link 1 -->
                    <a href="strukturosis.html" class="quick-link-card">
                        <div class="quick-link-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Profil OSIS</h3>
                        <p>Kenali struktur dan program kerja OSIS kami</p>
                    </a>
                    
                    <!-- Quick Link 2 -->
                    <a href="calendar.html" class="quick-link-card">
                        <div class="quick-link-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3>Kalender Kegiatan</h3>
                        <p>Jadwal kegiatan OSIS dan sekolah</p>
                    </a>
                    
                    <!-- Quick Link 3 -->
                    <a href="forms.html" class="quick-link-card">
                        <div class="quick-link-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h3>Formulir</h3>
                        <p>Pendaftaran dan pengajuan proposal</p>
                    </a>
                    
                    <!-- Quick Link 4 -->
                    <a href="contact.html" class="quick-link-card">
                        <div class="quick-link-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3>Hubungi Kami</h3>
                        <p>Saran dan kritik untuk OSIS</p>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <!-- About Column -->
                <div class="footer-column">
                    <h3>Tentang OSIS</h3>
                    <p>Organisasi Siswa Intra Sekolah (OSIS) merupakan organisasi resmi sekolah yang bertujuan untuk mengembangkan potensi siswa dan menyalurkan aspirasi siwa.</p>
                </div>
                
                <!-- Contact Column -->
                <div class="footer-column">
                    <h3>Kontak Kami</h3>
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Jl. Gajah Mada N0. 20 Medan, Sumatera Utara, Indonesia</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>osisraksana@.sch.id</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span></span>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media Column -->
                <div class="footer-column">
                    <h3>Media Sosial</h3>
                    <p>Ikuti kami di media sosial untuk informasi terbaru</p>
                    <div class="social-links">
                        <a href="https://www.instagram.com/osisraksanamdn/" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2025 OSIS Yayasan Pendidikan Raksana. Semua Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="index.js"></script>
    <script>
    
    </script>
</body>
</html>