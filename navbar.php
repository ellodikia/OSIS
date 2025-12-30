<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<style>
    .nav-dropdown {
        display: none;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
    }
    .group:hover .nav-dropdown {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    #mobile-menu {
        transform: translateX(100%);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    #mobile-menu.active {
        transform: translateX(0);
    }
    
    #mobile-overlay {
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    #mobile-overlay.active {
        opacity: 1;
        visibility: visible;
    }
</style>

<header class="bg-maroon-900 shadow-lg sticky top-0 z-[999]">
  <nav class="mx-auto flex max-w-7xl items-center justify-between p-5 lg:px-8">
    
    <div class="flex lg:flex-1 gap-4 items-center">
        <img src="image/logo-sekolah.jpg" alt="Logo Sekolah" class="h-10 w-10 rounded-full bg-white border-2 border-white/20" />
        <a href="dashboard/login.php"><img src="image/logo-osis.png" alt="Logo OSIS" class="h-10 w-auto" /></a>
        <span class="text-white font-bold text-lg hidden sm:block tracking-tight">OSIS <span class="text-red-500">RAKSANA</span></span>
    </div>
    
    <div class="flex lg:hidden">
      <button type="button" onclick="toggleMenu()" class="text-white p-2 focus:outline-none">
        <i class="fas fa-bars text-2xl"></i>
      </button>
    </div>

    <div class="hidden lg:flex lg:gap-x-10 items-center">
      <a href="index.php" class="text-sm font-semibold transition <?= ($current_page == 'index.php') ? 'text-white border-b-2 border-red-500 pb-1' : 'text-white/90 hover:text-white' ?>">Beranda</a>
      
      <div class="relative group">
          <button class="flex items-center gap-1 text-sm font-semibold transition outline-none py-2 <?= ($current_page == 'pengurus.php' || $current_page == 'sub-organisasi.php') ? 'text-white border-b-2 border-red-500 pb-1' : 'text-white/90 hover:text-white' ?>">
              Organisasi <i class="fas fa-chevron-down text-[10px] group-hover:rotate-180 transition-transform"></i>
          </button>
          
          <div class="nav-dropdown absolute right-0 w-56 pt-2">
              <div class="bg-white text-maroon-900 py-2 rounded-xl shadow-2xl border border-gray-100 overflow-hidden">
                  <a href="pengurus.php" class="block px-4 py-3 text-sm hover:bg-maroon-50 transition <?= ($current_page == 'pengurus.php') ? 'bg-gray-100 font-bold text-maroon-800' : '' ?>">
                      <i class="fas fa-sitemap mr-2 opacity-70"></i> Struktur Pengurus
                  </a>
                  <a href="sub-organisasi.php" class="block px-4 py-3 text-sm hover:bg-maroon-50 transition <?= ($current_page == 'sub-organisasi.php') ? 'bg-gray-100 font-bold text-maroon-800' : '' ?>">
                      <i class="fas fa-users mr-2 opacity-70"></i> Ekskul & Sub-Org
                  </a>
              </div>
          </div>
      </div>

      <a href="kalender.php" class="text-sm font-semibold transition <?= ($current_page == 'kalender.php') ? 'text-white border-b-2 border-red-500 pb-1' : 'text-white/90 hover:text-white' ?>">Agenda</a>
      <a href="gallery.php" class="text-sm font-semibold transition <?= ($current_page == 'gallery.php') ? 'text-white border-b-2 border-red-500 pb-1' : 'text-white/90 hover:text-white' ?>">Galeri</a>
      <a href="form.php" class="text-sm font-semibold transition <?= ($current_page == 'form.php') ? 'text-white border-b-2 border-red-500 pb-1' : 'text-white/90 hover:text-white' ?>">Formulir</a>
    </div>

    <div class="hidden lg:flex lg:flex-1 lg:justify-end"></div>
  </nav>

  <div id="mobile-overlay" onclick="toggleMenu()" class="fixed inset-0 bg-black/60 z-[1000] lg:hidden"></div>

  <div id="mobile-menu" class="fixed inset-y-0 right-0 w-[280px] z-[1001] bg-maroon-900 shadow-2xl lg:hidden flex flex-col">
      <div class="p-6 flex items-center justify-between border-b border-white/10 bg-maroon-950">
        <img src="image/logo-osis.png" alt="Logo" class="h-10 w-auto" />
        <button onclick="toggleMenu()" class="text-white hover:text-red-500 transition">
            <i class="fas fa-times text-2xl"></i>
        </button>
      </div>

      <div class="p-6 space-y-2 overflow-y-auto flex-1">
          <a href="index.php" class="flex items-center gap-4 text-lg font-medium p-3 rounded-lg <?= ($current_page == 'index.php') ? 'bg-red-600 text-white shadow-inner' : 'text-white hover:bg-white/10' ?>">
            <i class="fas fa-home w-6"></i> Beranda
          </a>
          
          <div class="pt-4 pb-2">
            <p class="text-white/40 text-[10px] uppercase tracking-[0.2em] font-black px-3 mb-2">Organisasi</p>
            <a href="pengurus.php" class="flex items-center gap-4 text-lg font-medium p-3 rounded-lg <?= ($current_page == 'pengurus.php') ? 'text-red-500' : 'text-white hover:bg-white/10' ?>">
                <i class="fas fa-sitemap w-6"></i> Struktur
            </a>
            <a href="sub-organisasi.php" class="flex items-center gap-4 text-lg font-medium p-3 rounded-lg <?= ($current_page == 'sub-organisasi.php') ? 'text-red-500' : 'text-white hover:bg-white/10' ?>">
                <i class="fas fa-users w-6"></i> Sub - Org & Ekskul
            </a>
          </div>

          <div class="pt-4">
            <p class="text-white/40 text-[10px] uppercase tracking-[0.2em] font-black px-3 mb-2">Informasi</p>
            <a href="kalender.php" class="flex items-center gap-4 text-lg font-medium p-3 rounded-lg <?= ($current_page == 'kalender.php') ? 'text-red-500' : 'text-white hover:bg-white/10' ?>">
                <i class="fas fa-calendar-alt w-6"></i> Agenda
            </a>
            <a href="gallery.php" class="flex items-center gap-4 text-lg font-medium p-3 rounded-lg <?= ($current_page == 'gallery.php') ? 'text-red-500' : 'text-white hover:bg-white/10' ?>">
                <i class="fas fa-images w-6"></i> Galeri
            </a>
            <a href="form.php" class="flex items-center gap-4 text-lg font-medium p-3 rounded-lg <?= ($current_page == 'form.php') ? 'text-red-500' : 'text-white hover:bg-white/10' ?>">
                <i class="fas fa-images w-6"></i> Formulir
            </a>
          </div>
      </div>

      <div class="p-6 bg-maroon-950 text-center border-t border-white/10">
          <p class="text-white/30 text-[10px] uppercase tracking-widest font-bold">&copy; OSIS Raksana</p>
      </div>
  </div>
</header>

<script>
function toggleMenu() {
    const menu = document.getElementById('mobile-menu');
    const overlay = document.getElementById('mobile-overlay');
    
    menu.classList.toggle('active');
    overlay.classList.toggle('active');
    
    if (menu.classList.contains('active')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = 'auto';
    }
}

window.addEventListener('resize', () => {
    if (window.innerWidth >= 1024) {
        document.getElementById('mobile-menu').classList.remove('active');
        document.getElementById('mobile-overlay').classList.remove('active');
        document.body.style.overflow = 'auto';
    }
});
</script>