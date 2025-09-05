<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur OSIS - SMA Contoh</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* ===========================
           CSS Reset & Base Styles
        ============================ */
        :root {
            /* 🎨 Warna Utama (Maroon) */
            --primary: #800000;
            --primary-light: #a00000;
            --primary-dark: #600000;

            /* 🌟 Warna Aksen (Golden) */
            --secondary: #d4a017;
            --secondary-light: #e6b422;
            --secondary-dark: #b8860b;

            /* ⚪ Warna Netral */
            --light: #fff5f5;
            --light-gray: #f8e8e8;
            --medium-gray: #e0c8c8;
            --dark: #2a0a0a;
            --darker: #1a0505;

            /* ✅ Warna Status */
            --success: #228B22;
            --danger: #CC0000;

            /* ✍️ Typography */
            --font-heading: 'Poppins', sans-serif;
            --font-body: 'Open Sans', sans-serif;

            /* 🌫️ Shadows */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
                    0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
                        0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
                        0 10px 10px -5px rgba(0, 0, 0, 0.04);

            /* ⏩ Transition */
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-body);
            line-height: 1.6;
            color: var(--dark);
            background-color: var(--light);
            overflow-x: hidden;
        }

        h1, h2, h3, h4 {
            font-family: var(--font-heading);
            font-weight: 700;
            line-height: 1.3;
        }

        h1 { font-size: 2.5rem; }
        h2 { font-size: 2rem; }
        h3 { font-size: 1.5rem; }
        h4 { font-size: 1.25rem; }

        a {
            text-decoration: none;
            color: inherit;
            transition: var(--transition);
        }

        img { max-width: 100%; height: auto; display: block; }
        ul { list-style: none; }

        button {
            cursor: pointer;
            border: none;
            background: none;
            font-family: inherit;
        }

        /* ===========================
           Layout Helpers
        ============================ */
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .section-padding { padding: 4rem 0; }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }
        .section-title h2 {
            position: relative;
            display: inline-block;
            color: var(--darker);
        }
        .section-title h2::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background-color: var(--secondary);
            margin: 1rem auto 0;
            border-radius: 2px;
        }

        /* ===========================
           Buttons
        ============================ */
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            text-align: center;
            transition: var(--transition);
            box-shadow: var(--shadow);
        }
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        .btn-secondary {
            background-color: var(--secondary);
            color: var(--darker);
        }
        .btn-secondary:hover {
            background-color: var(--secondary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* ===========================
           Header & Navigation
        ============================ */
        header {
            position: sticky;
            top: 0;
            background-color: white;
            box-shadow: var(--shadow-sm);
            z-index: 100;
            transition: var(--transition);
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }
        .logo-container { display: flex; align-items: center; gap: 1rem; }
        .logo { height: 50px; transition: var(--transition); }
        .logo:hover { transform: scale(1.05); }

        nav.desktop-nav {
            display: flex;
            gap: 1.5rem;
        }
        nav.desktop-nav a {
            font-weight: 600;
            transition: var(--transition);
            position: relative;
            padding: 0.5rem 0;
        }
        nav.desktop-nav a:hover { color: var(--primary); }
        nav.desktop-nav a::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 0; height: 2px;
            background-color: var(--primary);
            transition: var(--transition);
        }
        nav.desktop-nav a:hover::after { width: 100%; }

        /* Tombol menu mobile */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark);
            z-index: 1001;
            transition: var(--transition);
        }
        .mobile-menu-btn:hover { color: var(--primary); }

        /* ===========================
           Mobile Navigation
        ============================ */
        @media (max-width: 768px) {
            .mobile-menu-btn { display: block; }
            nav.desktop-nav { display: none; }
        }
        .mobile-nav {
            position: fixed;
            top: 0; right: -100%;
            width: 80%; max-width: 300px;
            height: 100vh;
            background-color: white;
            box-shadow: -5px 0 15px rgba(0,0,0,0.1);
            z-index: 1000;
            transition: right 0.3s ease;
            padding: 5rem 2rem;
            display: flex; flex-direction: column; gap: 1rem;
        }
        .mobile-nav.active { right: 0; }
        .mobile-nav a {
            padding: 0.75rem 0;
            width: 100%;
            border-bottom: 1px solid #eee;
            font-weight: 600;
        }
        .close-mobile-menu {
            position: absolute;
            top: 1.5rem; right: 1.5rem;
            font-size: 1.75rem;
            background: none;
            border: none;
            color: var(--dark);
        }

        /* ===========================
           Main Content (Organisasi)
        ============================ */
        .main-content { 
            padding: 4rem 0;
            min-height: calc(100vh - 400px); /* Ensure footer stays at bottom */
        }

        .org-structure {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 2rem 0;
            width: 100%;
        }
        
        .org-level {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
            width: 100%;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .pembina {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .bph-container, .dept-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1.5rem;
            width: 100%;
        }

        .connector-line {
            width: 2px;
            height: 40px;
            background-color: var(--medium-gray);
            margin: 0.5rem 0;
        }

        .dept-title {
            width: 100%;
            text-align: center;
            margin-bottom: 1rem;
            color: var(--primary);
        }

        /* Kartu anggota */
        .member-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            width: 220px;
            text-align: center;
            box-shadow: var(--shadow);
            cursor: pointer;
            transition: var(--transition);
            border: 1px solid var(--medium-gray);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .member-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-light);
        }
        .member-photo {
            width: 100px; 
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--secondary);
            margin: 0 auto 1rem;
            transition: var(--transition);
        }
        .member-card:hover .member-photo {
            border-color: var(--secondary-dark);
            transform: scale(1.05);
        }
        .member-name {
            font-weight: 700;
            color: var(--darker);
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }
        .member-position {
            color: var(--primary);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
            background-color: rgba(128, 0, 0, 0.1);
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            display: inline-block;
        }

        /* ===========================
           Modal (Detail Anggota)
        ============================ */
        .modal {
            display: none;
            position: fixed; 
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.7);
            z-index: 2000;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .modal.active { 
            display: flex; 
            opacity: 1; 
        }
        .modal-content {
            background-color: white;
            border-radius: 0.75rem;
            width: 90%; 
            max-width: 700px;
            padding: 2rem;
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }
        .modal.active .modal-content { 
            transform: translateY(0); 
        }
        .close-modal {
            position: absolute; 
            top: 1rem; right: 1rem;
            font-size: 1.75rem;
            cursor: pointer;
            color: var(--dark);
            transition: var(--transition);
            background: none;
            border: none;
            width: 40px; height: 40px;
            display: flex; 
            align-items: center; 
            justify-content: center;
            border-radius: 50%;
        }
        .close-modal:hover {
            color: var(--danger);
            background-color: rgba(239,68,68,0.1);
        }

        .modal-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        .modal-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--secondary);
        }
        .modal-info {
            flex: 1;
            text-align: left;
        }
        .modal-position {
            color: var(--primary);
            font-weight: 600;
            margin: 0.5rem 0;
            font-size: 1.1rem;
        }
        .modal-section {
            margin-bottom: 1.5rem;
        }
        .modal-section h4 {
            color: var(--primary);
            margin-bottom: 0.75rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        .modal-section h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background-color: var(--secondary);
        }
        .modal-section ul {
            padding-left: 1.25rem;
        }
        .modal-section li {
            margin-bottom: 0.5rem;
            position: relative;
            padding-left: 1rem;
        }
        .modal-section li::before {
            content: '•';
            position: absolute;
            left: 0;
            color: var(--secondary);
        }

        /* ===========================
           Footer
        ============================ */
        footer {
            background-color: var(--darker);
            color: white;
            padding: 4rem 0 2rem;
        }
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        .footer-column h3 {
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.75rem;
            color: white;
        }
        .footer-column h3::after {
            content: '';
            position: absolute; bottom: 0; left: 0;
            width: 50px; height: 3px;
            background-color: var(--secondary);
        }
        .footer-column p {
            color: rgba(255,255,255,0.8);
            margin-bottom: 1.5rem;
            line-height: 1.7;
        }
        .quick-links a {
            color: rgba(255,255,255,0.8);
            transition: var(--transition);
            display: inline-block;
            padding: 0.25rem 0;
        }
        .quick-links a:hover {
            color: var(--secondary);
            transform: translateX(5px);
        }
        .social-links {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
        }
        .social-link {
            display: flex; align-items: center; justify-content: center;
            width: 40px; height: 40px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.1);
            transition: var(--transition);
            color: white; font-size: 1.1rem;
        }
        .social-link:hover {
            background-color: var(--secondary);
            color: var(--darker);
            transform: translateY(-3px);
        }
        .contact-info-footer {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .contact-item-footer {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: rgba(255,255,255,0.8);
        }
        .contact-item-footer i {
            color: var(--secondary);
            width: 20px;
            text-align: center;
        }
        .copyright {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            font-size: 0.9rem;
            color: rgba(255,255,255,0.6);
        }

        /* ===========================
           Animations
        ============================ */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ===========================
           Responsive Improvements
        ============================ */
        @media (max-width: 992px) {
            .section-padding { padding: 3rem 0; }
            .modal-header { 
                flex-direction: column; 
                text-align: center;
                gap: 1.5rem;
            }
            .modal-photo { 
                margin-bottom: 1rem; 
                width: 100px;
                height: 100px;
            }
            .modal-info {
                text-align: center;
            }
        }

        @media (max-width: 768px) {
            .section-title h2 { font-size: 1.75rem; }
            .member-card { 
                width: 180px; 
                padding: 1.25rem;
            }
            .member-photo { 
                width: 80px; 
                height: 80px; 
            }
            .modal-content { 
                padding: 1.5rem; 
            }
            .org-level {
                gap: 1rem;
            }
        }

        @media (max-width: 576px) {
            .container { padding: 0 1rem; }
            .section-padding { padding: 2.5rem 0; }
            .section-title { margin-bottom: 2rem; }
            .member-card { 
                width: 160px; 
                padding: 1rem;
            }
            .member-name { font-size: 1rem; }
            .member-position { font-size: 0.8rem; }
            .footer-content { grid-template-columns: 1fr; }
            .modal-section h4 {
                font-size: 1.1rem;
            }
            .org-level {
                gap: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .member-card {
                width: 140px;
            }
            .member-photo {
                width: 70px;
                height: 70px;
            }
        }
    </style>
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
                <a href="index.html">Beranda</a>
                <a href="struktur.html" class="active">Struktur OSIS</a>
                <a href="kalender.html">Kalender Kegiatan</a>
                <a href="news.html">Berita & Pengumuman</a>
            </nav>
            
            <button class="mobile-menu-btn" id="mobileMenuBtn">☰</button>
        </div>
    </header>

    <!-- Mobile Navigation -->
    <nav class="mobile-nav" id="mobileNav">
        <button class="close-mobile-menu" id="closeMobileMenu">&times;</button>
        <a href="index.php">Beranda</a>
        <a href="struktur.php" class="active">Struktur OSIS</a>
        <a href="kalender.php">Kalender Kegiatan</a>
        <a href="news.php">Berita & Pengumuman</a>
        <a href="gallery.php">Galeri Kegiatan</a>
        <a href="forms.php">Formulir</a>
        <a href="contact.php">Kontak</a>
    </nav>

    <!-- Main Content -->
    <main class="main-content container" id="structure">
        <div class="section-title">
            <h2>Struktur Kepengurusan</h2>
        </div>
        
        <section class="org-structure">
            <!-- Level 1: Pembina -->
            <div class="org-level">
                <div class="pembina">
                    <div class="member-card" onclick="showMemberDetail('pembina')">
                        <img src="https://randomuser.me/api/portraits/men/60.jpg" alt="Pembina OSIS" class="member-photo">
                        <div class="member-name">Dr. Ahmad Fauzi, M.Pd</div>
                        <div class="member-position">Pembina OSIS</div>
                    </div>
                </div>
            </div>

            <!-- Garis penghubung -->
            <div class="connector-line"></div>

            <!-- Level 2: Ketua dan Wakil -->
            <div class="org-level">
                <div class="bph-container">
                    <div class="member-card" onclick="showMemberDetail('ketua')">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Ketua OSIS" class="member-photo">
                        <div class="member-name">Andi Wijaya</div>
                        <div class="member-position">Ketua OSIS</div>
                    </div>
                    <div class="member-card" onclick="showMemberDetail('wakil')">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Wakil Ketua OSIS" class="member-photo">
                        <div class="member-name">Budi Santoso</div>
                        <div class="member-position">Wakil Ketua OSIS</div>
                    </div>
                </div>
            </div>

            <!-- Garis penghubung -->
            <div class="connector-line"></div>

            <!-- Level 3: BPH Lainnya -->
            <div class="org-level">
                <div class="bph-container">
                    <div class="member-card" onclick="showMemberDetail('sekretaris')">
                        <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Sekretaris" class="member-photo">
                        <div class="member-name">Citra Dewi</div>
                        <div class="member-position">Sekretaris Umum</div>
                    </div>
                    <div class="member-card" onclick="showMemberDetail('wakil-sekretaris')">
                        <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Wakil Sekretaris" class="member-photo">
                        <div class="member-name">Dian Pratama</div>
                        <div class="member-position">Wakil Sekretaris</div>
                    </div>
                    <div class="member-card" onclick="showMemberDetail('bendahara')">
                        <img src="https://randomuser.me/api/portraits/women/33.jpg" alt="Bendahara" class="member-photo">
                        <div class="member-name">Eka Putri</div>
                        <div class="member-position">Bendahara</div>
                    </div>
                    <div class="member-card" onclick="showMemberDetail('wakil-bendahara')">
                        <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Wakil Bendahara" class="member-photo">
                        <div class="member-name">Fajar Nugroho</div>
                        <div class="member-position">Wakil Bendahara</div>
                    </div>
                </div>
            </div>

            <!-- Garis penghubung -->
            <div class="connector-line"></div>

            <!-- Level 4: Departemen -->
            <div class="org-level">
                <h3 class="dept-title">Koordinator Departemen</h3>
            </div>
            <div class="org-level">
                <div class="dept-container">
                    <!-- Departemen 1: Ketaqwaan -->
                    <div class="member-card" onclick="showMemberDetail('ketaqwaan')">
                        <img src="https://randomuser.me/api/portraits/women/55.jpg" alt="Koordinator Bidang Ketaqwaan" class="member-photo">
                        <div class="member-name">Gita Maharani</div>
                        <div class="member-position">Ketaqwaan</div>
                    </div>
                    
                    <!-- Departemen 2: Pendidikan -->
                    <div class="member-card" onclick="showMemberDetail('pendidikan')">
                        <img src="https://randomuser.me/api/portraits/men/66.jpg" alt="Koordinator Bidang Pendidikan" class="member-photo">
                        <div class="member-name">Indra Permana</div>
                        <div class="member-position">Pendidikan</div>
                    </div>
                    
                    <!-- Departemen 3: Kesehatan -->
                    <div class="member-card" onclick="showMemberDetail('kesehatan')">
                        <img src="https://randomuser.me/api/portraits/men/77.jpg" alt="Koordinator Bidang Kesehatan" class="member-photo">
                        <div class="member-name">Kevin Pratama</div>
                        <div class="member-position">Kesehatan</div>
                    </div>
                    
                    <!-- Departemen 4: Olahraga -->
                    <div class="member-card" onclick="showMemberDetail('olahraga')">
                        <img src="https://randomuser.me/api/portraits/men/88.jpg" alt="Koordinator Bidang Olahraga" class="member-photo">
                        <div class="member-name">Mario Susanto</div>
                        <div class="member-position">Olahraga</div>
                    </div>
                    
                    <!-- Departemen 5: Seni & Budaya -->
                    <div class="member-card" onclick="showMemberDetail('seni')">
                        <img src="https://randomuser.me/api/portraits/women/99.jpg" alt="Koordinator Bidang Seni" class="member-photo">
                        <div class="member-name">Nia Ramadhani</div>
                        <div class="member-position">Seni & Budaya</div>
                    </div>
                    
                    <!-- Departemen 6: Humas -->
                    <div class="member-card" onclick="showMemberDetail('humas')">
                        <img src="https://randomuser.me/api/portraits/women/12.jpg" alt="Koordinator Bidang Humas" class="member-photo">
                        <div class="member-name">Olivia Putri</div>
                        <div class="member-position">Humas</div>
                    </div>
                    
                    <!-- Departemen 7: Lingkungan Hidup -->
                    <div class="member-card" onclick="showMemberDetail('lingkungan')">
                        <img src="https://randomuser.me/api/portraits/men/15.jpg" alt="Koordinator Bidang Lingkungan" class="member-photo">
                        <div class="member-name">Putra Wijaya</div>
                        <div class="member-position">Lingkungan Hidup</div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal Detail Anggota -->
    <div class="modal" id="memberModal">
        <div class="modal-content">
            <button class="close-modal" onclick="closeModal()">&times;</button>
            <div class="modal-header">
                <img id="modalPhoto" src="" alt="Foto Anggota" class="modal-photo">
                <div class="modal-info">
                    <h3 id="modalName">Nama Anggota</h3>
                    <div id="modalPosition" class="modal-position">Jabatan</div>
                    <p id="modalClass">Kelas: XII IPA 1</p>
                    <p id="modalNis">NIS: 12345678</p>
                </div>
            </div>
            
            <div class="modal-section">
                <h4>Visi</h4>
                <p id="modalVisi">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris.</p>
            </div>
            
            <div class="modal-section">
                <h4>Misi</h4>
                <ul id="modalMisi">
                    <li>Misi pertama akan ditampilkan di sini</li>
                    <li>Misi kedua akan ditampilkan di sini</li>
                    <li>Misi ketiga akan ditampilkan di sini</li>
                </ul>
            </div>
            
            <div class="modal-section">
                <h4>Program Kerja</h4>
                <ul id="modalProgram">
                    <li>Program pertama akan ditampilkan di sini</li>
                    <li>Program kedua akan ditampilkan di sini</li>
                </ul>
            </div>
        </div>
    </div>

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

    <script src="struktur.js"></script>
</body>
</html>