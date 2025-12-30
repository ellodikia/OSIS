document.addEventListener('DOMContentLoaded', function() {
            // --- Mobile Menu Toggle dengan Overlay ---
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            const nav = document.querySelector('.nav');
            const overlay = document.querySelector('.nav-overlay');
            const body = document.body;
            
            if (mobileMenuBtn && nav) {
                mobileMenuBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    toggleMobileMenu();
                });
                
                if (overlay) {
                    overlay.addEventListener('click', () => {
                        closeMobileMenu();
                    });
                }
                
                // Tutup menu ketika klik link di navigasi
                nav.addEventListener('click', (e) => {
                    if (e.target.tagName === 'A') {
                        closeMobileMenu();
                    }
                });
                
                // Fungsi untuk toggle menu mobile
                function toggleMobileMenu() {
                    nav.classList.toggle('active');
                    if (overlay) {
                        overlay.classList.toggle('active');
                    }
                    mobileMenuBtn.innerHTML = nav.classList.contains('active') ? '✕' : '☰';
                    
                    // Prevent body scroll ketika menu terbuka
                    if (nav.classList.contains('active')) {
                        body.style.overflow = 'hidden';
                    } else {
                        body.style.overflow = '';
                    }
                }
                
                // Fungsi untuk menutup menu mobile
                function closeMobileMenu() {
                    if (nav.classList.contains('active')) {
                        nav.classList.remove('active');
                        if (overlay) {
                            overlay.classList.remove('active');
                        }
                        mobileMenuBtn.innerHTML = '☰';
                        body.style.overflow = '';
                    }
                }
            }
            
            // --- Animasi Scroll untuk Sections ---
            const sections = document.querySelectorAll('.section');
            
            // Fungsi untuk memeriksa apakah elemen terlihat di viewport
            function isElementInViewport(el) {
                const rect = el.getBoundingClientRect();
                return (
                    rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.9 &&
                    rect.bottom >= 0
                );
            }
            
            // Fungsi untuk menangani animasi scroll
            function handleScrollAnimation() {
                sections.forEach(section => {
                    if (isElementInViewport(section)) {
                        section.classList.add('visible');
                    }
                });
            }
            
            // Jalankan saat scroll dan saat load pertama
            window.addEventListener('scroll', handleScrollAnimation);
            window.addEventListener('load', handleScrollAnimation);
            handleScrollAnimation(); // Jalankan sekali saat pertama dimuat
        });