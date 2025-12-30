<?php
include 'koneksi.php';

$query_berita = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY tanggal DESC");

$berita_array = [];
while ($row = mysqli_fetch_assoc($query_berita)) {
    $berita_array[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="gtwT1jJQ8f5oJbn27cZN-3dyV3__a9VokBPpend4IPc" />
    <meta name="keywords" content="osisraksana, osis raksana, SMA Raksana, OSIS Medan, organisasi siswa, Osis Raksana">
    <meta name="author" content="OSIS Raksana">
    <link rel="icon" type="image/png" href="foto/logo-osis.png">
    <link rel="icon" type="image/png" href="foto/logo-osis.png">
    <title>OSIS Raksana Medan | Official Website</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: {
                            700: '#800000',
                            800: '#660000',
                            900: '#4a0404',
                            950: '#1a0202',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        .masonry-grid {
            column-count: 2;
            column-gap: 12px;
        }
        
        @media (min-width: 768px) {
            .masonry-grid {
                column-count: 3;
                column-gap: 24px;
            }
        }

        .break-inside-avoid { 
            break-inside: avoid; 
            display: inline-block;
            width: 100%;
        }

        @keyframes modalFadeIn { 
            from { opacity: 0; transform: translate(-50%, -48%); } 
            to { opacity: 1; transform: translate(-50%, -50%); } 
        }
        .animate-modal { animation: modalFadeIn 0.3s ease-out forwards; }
        
        html { scroll-behavior: smooth; }

        .modal-content::-webkit-scrollbar {
            width: 5px;
        }
        .modal-content::-webkit-scrollbar-thumb {
            background: #800000;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-slate-900">

<?php include 'navbar.php'; ?>

<section class="relative w-full h-[450px] md:h-[650px] overflow-hidden bg-maroon-950 flex items-center">
    <div id="carousel" class="absolute inset-0 w-full h-full">
        <div class="carousel-slide absolute inset-0 opacity-100 transition-opacity duration-1000">
            <img src="image/4.png" class="w-full h-full object-cover opacity-40">
        </div>
        <div class="carousel-slide absolute inset-0 opacity-0 transition-opacity duration-1000">
            <img src="image/3.jpg" class="w-full h-full object-cover opacity-40">
        </div>
    </div>

    <div class="relative z-10 mx-auto max-w-7xl px-6 w-full text-center md:text-left">
        <span class="inline-block px-4 py-1.5 bg-red-600 text-white rounded-full text-[10px] font-black mb-6 tracking-[0.3em] shadow-xl uppercase">Official Website</span>
        <h1 class="text-4xl md:text-8xl font-black text-white leading-[0.9] mb-6 tracking-tighter italic">
            OSIS <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-orange-400 italic">Raksana Medan</span>
        </h1>
        
        <div class="flex flex-col sm:flex-row gap-5 justify-center md:justify-start items-center">
            <a href="#berita" class="bg-white text-maroon-900 font-black px-8 py-4 rounded-2xl shadow-2xl hover:bg-red-600 hover:text-white transition-all text-xs uppercase tracking-widest">Eksplorasi Berita</a>
            
            <div class="flex items-center gap-4">
                <a href="https://www.instagram.com/osisraksanamdn/" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-xl bg-white/10 text-white hover:bg-white hover:text-pink-600 transition backdrop-blur-md border border-white/20"><i class="fab fa-instagram text-xl"></i></a>
                <a href="https://www.tiktok.com/@osisraksanamedan" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-xl bg-white/10 text-white hover:bg-white hover:text-black transition backdrop-blur-md border border-white/20"><i class="fab fa-tiktok text-xl"></i></a>
                <a href="https://youtube.com/@osisraksanadaily" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-xl bg-white/10 text-white hover:bg-red-600 transition backdrop-blur-md border border-white/20"><i class="fab fa-youtube text-xl"></i></a>
            </div>
        </div>
    </div>
</section>

<section id="berita" class="max-w-7xl mx-auto px-4 md:px-6 py-16">
    <div class="mb-12 border-l-8 border-red-600 pl-6">
        <h2 class="text-3xl md:text-5xl font-black text-maroon-900 tracking-tighter uppercase italic leading-none">Warta <span class="text-red-600">Raksana</span></h2>
        <p class="text-gray-400 text-[10px] md:text-xs mt-3 uppercase tracking-[0.4em] font-bold">Informasi Terkini & Dokumentasi Kegiatan</p>
    </div>

    <div class="masonry-grid">
        <?php foreach ($berita_array as $b): ?>
        <div onclick="openModal('modal-<?= $b['id'] ?>')" 
             class="break-inside-avoid mb-4 md:mb-8 group cursor-pointer">
            
            <div class="relative bg-white rounded-[1.5rem] md:rounded-[2.5rem] overflow-hidden shadow-sm border border-gray-100 transition-all duration-500 hover:shadow-2xl hover:-translate-y-2">
                
                <div class="relative overflow-hidden aspect-auto bg-gray-100">
                    <img src="upload/foto/berita/<?= $b['foto'] ?>" 
                         class="w-full h-auto object-cover transition duration-700 group-hover:scale-110"
                         alt="<?= $b['judul'] ?>">
                    
                    <div class="absolute top-3 left-3 md:top-6 md:left-6">
                        <span class="bg-red-600/90 backdrop-blur-md text-white text-[8px] md:text-[10px] px-3 py-1 rounded-lg font-black uppercase tracking-widest shadow-lg">
                            <?= $b['level'] ?>
                        </span>
                    </div>
                </div>

                <div class="p-5 md:p-8">
                    <h3 class="font-black text-maroon-900 text-sm md:text-xl mb-3 leading-tight line-clamp-2 group-hover:text-red-600 transition-colors italic">
                        <?= $b['judul'] ?>
                    </h3>
                    
                    <p class="hidden md:block text-gray-500 text-sm line-clamp-3 leading-relaxed mb-6 font-medium">
                        <?= strip_tags($b['isi']) ?>
                    </p>
                    
                    <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                        <span class="text-[9px] md:text-[11px] font-bold text-gray-400 uppercase tracking-widest">
                            <i class="far fa-calendar-alt text-red-500 mr-1.5"></i> <?= date('d M Y', strtotime($b['tanggal'])) ?>
                        </span>
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-all">
                            <i class="fas fa-arrow-right text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<footer class="py-14 bg-maroon-900 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-6 flex flex-col items-center gap-6 text-center">
        <div class="bg-white p-3 rounded-2xl shadow-xl">
            <img src="image/logo-osis.png" class="h-10 w-auto">
        </div>
        <div class="flex gap-8 text-[11px] font-black uppercase tracking-[0.3em] text-slate-400">
            <a href="https://www.instagram.com/osisraksanamdn/" class="hover:text-red-600 transition">Instagram</a>
            <a href="https://www.tiktok.com/@osisraksanamedan" class="hover:text-red-600 transition">TikTok</a>
            <a href="https://youtube.com/@osisraksanadaily" class="hover:text-red-600 transition">YouTube</a>
        </div>
        <p class="text-[9px] font-bold text-gray-300 uppercase tracking-[0.5em] mt-4">&copy; <?= date('Y') ?> OSIS Raksana Medan • Humas & Infokum</p>
    </div>
</footer>

<div id="news-overlay" onclick="closeModal()" class="hidden fixed inset-0 bg-maroon-950/90 z-[99] backdrop-blur-xl transition-all duration-300"></div>

<?php foreach($berita_array as $b): ?>
<div id="modal-<?= $b['id'] ?>" class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[94%] max-w-3xl bg-white rounded-[2rem] md:rounded-[3.5rem] z-[100] shadow-2xl overflow-hidden max-h-[85vh] flex flex-col animate-modal border border-white/20">
    <div class="relative h-52 md:h-96 flex-none overflow-hidden">
        <img src="upload/foto/berita/<?= $b['foto'] ?>" class="w-full h-full object-cover">
        <button onclick="closeModal()" class="absolute top-5 right-5 bg-white/10 backdrop-blur-md text-white hover:bg-red-600 w-12 h-12 rounded-full flex items-center justify-center transition shadow-2xl border border-white/20">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="p-6 md:p-14 overflow-y-auto modal-content">
        <div class="flex items-center gap-3 mb-4">
            <span class="text-[10px] font-black text-red-600 uppercase tracking-widest italic"><?= $b['level'] ?></span>
            <span class="text-gray-200">/</span>
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest"><?= date('l, d F Y', strtotime($b['tanggal'])) ?></span>
        </div>
        <h2 class="text-2xl md:text-4xl font-black text-maroon-900 mb-8 leading-[1.1] tracking-tighter italic uppercase"><?= $b['judul'] ?></h2>
        <div class="h-1.5 w-24 bg-red-600 mb-10 rounded-full shadow-lg shadow-red-500/30"></div>
        <div class="prose prose-slate max-w-none text-gray-600 text-sm md:text-lg leading-relaxed font-medium whitespace-pre-line">
            <?= $b['isi'] ?>
        </div>
        
        <button onclick="closeModal()" class="mt-12 w-full bg-slate-900 hover:bg-red-600 text-white font-black py-5 rounded-2xl text-[10px] uppercase tracking-[0.3em] transition-all active:scale-95 shadow-xl">Tutup</button>
    </div>
</div>
<?php endforeach; ?>

<script>
    let cur = 0; 
    const slides = document.querySelectorAll('.carousel-slide');
    function cycleCarousel() {
        if(slides.length > 1) {
            slides[cur].classList.replace('opacity-100','opacity-0'); 
            cur = (cur + 1) % slides.length; 
            slides[cur].classList.replace('opacity-0','opacity-100');
        }
    }
    setInterval(cycleCarousel, 5000);

    function openModal(id) { 
        document.getElementById(id).classList.remove('hidden'); 
        document.getElementById('news-overlay').classList.remove('hidden'); 
        document.body.style.overflow = 'hidden'; 
    }
    function closeModal() { 
        document.querySelectorAll('[id^="modal-"]').forEach(m => m.classList.add('hidden')); 
        document.getElementById('news-overlay').classList.add('hidden'); 
        document.body.style.overflow = 'auto'; 
    }
    window.onkeydown = (e) => { if(e.key === "Escape") closeModal(); };
</script>

</body>
</html>