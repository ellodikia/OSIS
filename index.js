document.addEventListener('DOMContentLoaded', function() {
    // --- Mobile Menu Toggle dengan Overlay ---
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const desktopNav = document.querySelector('.desktop-nav');
    const body = document.body;
    
    // Buat overlay untuk menu mobile
    const overlay = document.createElement('div');
    overlay.className = 'nav-overlay';
    document.body.appendChild(overlay);
    
    if (mobileMenuBtn && desktopNav) {
        mobileMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleMobileMenu();
        });
        
        overlay.addEventListener('click', () => {
            closeMobileMenu();
        });
        
        // Tutup menu ketika klik link di navigasi
        desktopNav.addEventListener('click', (e) => {
            if (e.target.tagName === 'A') {
                closeMobileMenu();
            }
        });
        
        // Fungsi untuk toggle menu mobile
        function toggleMobileMenu() {
            desktopNav.classList.toggle('active');
            overlay.classList.toggle('active');
            mobileMenuBtn.innerHTML = desktopNav.classList.contains('active') ? '✕' : '☰';
            
            // Prevent body scroll ketika menu terbuka
            if (desktopNav.classList.contains('active')) {
                body.style.overflow = 'hidden';
            } else {
                body.style.overflow = '';
            }
        }
        
        // Fungsi untuk menutup menu mobile
        function closeMobileMenu() {
            if (desktopNav.classList.contains('active')) {
                desktopNav.classList.remove('active');
                overlay.classList.remove('active');
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
    
    // --- Image Gallery Lightbox (jika ada) ---
    if (document.querySelector('.gallery-grid')) {
        const galleryItems = document.querySelectorAll('.gallery-item');
        
        galleryItems.forEach(item => {
            item.addEventListener('click', () => {
                const imgSrc = item.querySelector('img').src;
                
                // Create lightbox elements
                const lightbox = document.createElement('div');
                lightbox.className = 'lightbox';
                
                const lightboxImg = document.createElement('img');
                lightboxImg.src = imgSrc;
                lightboxImg.alt = 'Galeri OSIS';
                
                const closeBtn = document.createElement('button');
                closeBtn.className = 'lightbox-close';
                closeBtn.innerHTML = '&times;';
                closeBtn.setAttribute('aria-label', 'Tutup lightbox');

                // Append elements
                lightbox.appendChild(lightboxImg);
                lightbox.appendChild(closeBtn);
                document.body.appendChild(lightbox);
                document.body.style.overflow = 'hidden';

                // Function to close lightbox
                const closeLightbox = () => {
                    document.body.removeChild(lightbox);
                    document.body.style.overflow = '';
                    document.removeEventListener('keydown', handleEsc);
                };

                // Event listeners for closing
                lightbox.addEventListener('click', e => {
                    if (e.target === lightbox) {
                        closeLightbox();
                    }
                });
                
                closeBtn.addEventListener('click', closeLightbox);
                
                const handleEsc = (e) => {
                    if (e.key === 'Escape') {
                        closeLightbox();
                    }
                };
                
                document.addEventListener('keydown', handleEsc);
            });
        });
    }
    
    // --- Form submission placeholder ---
    if (document.querySelector('.form-container')) {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                alert('Formulir berhasil dikirim! Terima kasih.');
                form.reset();
            });
        });
    }
});