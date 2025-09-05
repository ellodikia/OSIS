document.addEventListener('DOMContentLoaded', function() {
        
        // --- Mobile Menu Toggle (Corrected) ---
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const desktopNav = document.querySelector('.desktop-nav');

        if (mobileMenuBtn && desktopNav) {
            mobileMenuBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                desktopNav.classList.toggle('active');
                mobileMenuBtn.innerHTML = desktopNav.classList.contains('active') ? '✕' : '☰';
            });

            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                // Check if the click is outside the nav AND not on the button itself
                if (!desktopNav.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                    if (desktopNav.classList.contains('active')) {
                        desktopNav.classList.remove('active');
                        mobileMenuBtn.innerHTML = '☰';
                    }
                }
            });

            // Close menu when clicking on a nav link (for single-page apps or hash links)
            desktopNav.addEventListener('click', (e) => {
                if (e.target.tagName === 'A') {
                    desktopNav.classList.remove('active');
                    mobileMenuBtn.innerHTML = '☰';
                }
            });
        }
        
        // --- Tab functionality for profile page ---
        if (document.querySelector('.profile-tabs')) {
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabBtns.forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    tabBtns.forEach(b => b.classList.remove('active'));
                    tabContents.forEach(c => c.classList.remove('active'));
                    
                    btn.classList.add('active');
                    tabContents[index].classList.add('active');
                });
            });
            
            // Activate first tab by default
            if (tabBtns.length > 0) {
                tabBtns[0].click();
            }
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
        
        // --- Improved Image Gallery Lightbox ---
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
                    
                    const closeBtn = document.createElement('button');
                    closeBtn.className = 'lightbox-close';
                    closeBtn.innerHTML = '&times;';

                    // Append elements
                    lightbox.appendChild(lightboxImg);
                    lightbox.appendChild(closeBtn);
                    document.body.appendChild(lightbox);
                    document.body.style.overflow = 'hidden'; // Prevent background scrolling

                    // Function to close lightbox
                    const closeLightbox = () => {
                        document.body.removeChild(lightbox);
                        document.body.style.overflow = ''; // Restore scrolling
                        document.removeEventListener('keydown', handleEsc); // Clean up listener
                    };

                    // Event listeners for closing
                    lightbox.addEventListener('click', e => {
                        if (e.target === lightbox) { // Close only if background is clicked
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

    });