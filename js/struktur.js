    // JavaScript untuk modal dan navigasi mobile
        document.addEventListener('DOMContentLoaded', function() {
        // Modal functionality
        const modalOverlay = document.querySelector('.modal-overlay');
        const modals = document.querySelectorAll('.modal');
        const clickableElements = document.querySelectorAll('.clickable');
        const closeModalButtons = document.querySelectorAll('.close-modal');
        
        // Open modal
        clickableElements.forEach(element => {
            element.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal');
            const modal = document.getElementById(`modal-${modalId}`);
            
            if (modal) {
                modal.classList.add('active');
                modalOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
            });
        });
        
        // Close modal
        function closeModal() {
            modals.forEach(modal => modal.classList.remove('active'));
            modalOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
        
        closeModalButtons.forEach(button => {
            button.addEventListener('click', closeModal);
        });
        
        modalOverlay.addEventListener('click', closeModal);
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
        
        // Mobile menu functionality
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const nav = document.querySelector('.nav');
        const navOverlay = document.querySelector('.nav-overlay');
        
        mobileMenuBtn.addEventListener('click', function() {
            nav.classList.toggle('active');
            navOverlay.classList.toggle('active');
        });
        
        navOverlay.addEventListener('click', function() {
            nav.classList.remove('active');
            navOverlay.classList.remove('active');
        });
        });
        // Enhanced admin functionality
document.addEventListener('DOMContentLoaded', function() {
    // File upload preview
    const fileInput = document.getElementById('foto');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Tidak ada file dipilih';
            const label = document.querySelector('.file-upload-label span');
            if (label) {
                label.textContent = fileName;
            }
        });
    }

    // Admin card hover effects
    const adminCards = document.querySelectorAll('.admin-main .card');
    adminCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Form validation enhancement
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
                submitBtn.disabled = true;
            }
        });
    });
});