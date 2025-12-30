<?php
session_start();
include 'koneksi.php'; 

$sql_galeri = "SELECT * FROM galeri ORDER BY tanggal_upload DESC";
$result_galeri = $koneksi->query($sql_galeri);

$all_photos = [];
if ($result_galeri) {
    while($row = $result_galeri->fetch_assoc()) {
        $all_photos[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri | OSIS Raksana</title>
    <link rel="icon" type="image/png" href="foto/logo-osis.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: { 700: '#800000', 800: '#660000', 900: '#4a0404', 950: '#1a0202' }
                    },
                    borderRadius: {
                        '4xl': '2rem',
                        '5xl': '3rem',
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #fdfaf5; scroll-behavior: smooth; }
        .gallery-item { transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
        @media (min-width: 768px) {
            .gallery-item:hover { transform: translateY(-8px); }
        }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-thumb { background: #800000; border-radius: 10px; }
    </style>
</head>
<body class="font-sans antialiased text-slate-900">

<?php include 'navbar.php'; ?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 py-10 md:py-16">
    <div class="relative mb-12 md:mb-20 text-center">
        <span class="absolute -top-4 md:-top-8 left-1/2 -translate-x-1/2 text-maroon-700/5 text-6xl sm:text-8xl md:text-9xl font-black uppercase tracking-tighter select-none">Memories</span>
        <div class="relative">
            <h1 class="text-3xl sm:text-5xl md:text-6xl font-black text-maroon-900 mb-2 tracking-tight uppercase">Dokumentasi <span class="text-red-600">OSIS</span></h1>
            <p class="text-gray-500 font-medium max-w-xl mx-auto italic text-xs md:text-base px-6">"Menangkap setiap detik berharga dalam bingkai pengabdian."</p>
            <div class="flex justify-center gap-2 mt-4">
                <div class="h-1 w-10 bg-maroon-800 rounded-full"></div>
                <div class="h-1 w-3 bg-red-500 rounded-full"></div>
            </div>
        </div>
    </div>

    <div class="flex flex-col gap-6 md:gap-10">
        <?php 
        $chunks = array_chunk($all_photos, 5); 
        foreach ($chunks as $index => $batch): 
            $isEven = ($index % 2 == 0);
        ?>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-5">
                
                <?php foreach ($batch as $key => $photo): 
                    $image_path = "admin/" . $photo['path_foto'];
                    
                    if ($key == 0): 
                ?>
                    <div class="col-span-2 row-span-2 relative group gallery-item rounded-3xl md:rounded-[3.5rem] overflow-hidden shadow-xl h-[350px] sm:h-[450px] md:h-[520px] <?= !$isEven ? 'md:order-last' : '' ?>">
                        <img src="<?= $image_path ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-maroon-950/90 via-transparent to-transparent"></div>
                        
                        <div class="absolute bottom-0 left-0 p-5 md:p-10 w-full">
                            <h3 class="text-white text-xl md:text-3xl font-black mb-2 uppercase leading-tight"><?= htmlspecialchars($photo['judul']) ?></h3>
                            <p class="text-white/70 text-xs md:text-sm line-clamp-2 mb-4"><?= htmlspecialchars($photo['keterangan']) ?></p>
                            <button onclick="openLightbox('<?= $photo['path_foto'] ?>', '<?= addslashes($photo['judul']) ?>', '<?= addslashes($photo['keterangan']) ?>')" class="bg-white text-maroon-900 px-6 py-2 rounded-full font-bold text-xs md:text-sm hover:bg-red-600 hover:text-white transition shadow-lg">Lihat Detail</button>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="relative group gallery-item rounded-2xl md:rounded-[2rem] overflow-hidden shadow-md h-[170px] sm:h-[215px] md:h-[250px]">
                        <img src="<?= $image_path ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        
                        <div class="absolute inset-0 bg-maroon-900/80 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center p-4 text-center">
                            <h4 class="text-white font-bold text-[10px] md:text-xs mb-3 line-clamp-2 uppercase"><?= htmlspecialchars($photo['judul']) ?></h4>
                            <div class="flex gap-2">
                                <button onclick="openLightbox('<?= $photo['path_foto'] ?>', '<?= addslashes($photo['judul']) ?>', '<?= addslashes($photo['keterangan']) ?>')" class="bg-white text-maroon-900 w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center text-xs shadow-xl"><i class="fas fa-eye"></i></button>
                                <a href="<?= $image_path ?>" download class="bg-red-600 text-white w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center text-xs shadow-xl"><i class="fas fa-download"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endif; endforeach; ?>

            </div>
        <?php endforeach; ?>
    </div>
</main>

<div id="lightbox-modal" class="fixed inset-0 z-[1000] hidden bg-maroon-950/98 backdrop-blur-xl flex items-center justify-center p-3 sm:p-6">
    <button onclick="closeLightbox()" class="absolute top-4 right-4 md:top-8 md:right-8 text-white/50 hover:text-white text-3xl md:text-5xl transition z-[1001]"><i class="fas fa-times"></i></button>
    
    <div class="max-w-6xl w-full flex flex-col md:flex-row bg-white rounded-3xl md:rounded-[3rem] overflow-hidden shadow-2xl transform scale-95 opacity-0 transition-all duration-300 max-h-[90vh]" id="modal-content">
        <div class="md:w-2/3 bg-black flex items-center justify-center overflow-hidden">
            <img id="modal-img" src="" class="max-h-[50vh] md:max-h-[85vh] w-full object-contain">
        </div>
        
        <div class="md:w-1/3 p-6 md:p-12 flex flex-col justify-center relative bg-white">
            <div class="hidden md:block absolute top-0 right-0 p-8 opacity-5 text-8xl font-black text-maroon-900 select-none">OSIS</div>
            <span class="text-red-600 font-bold tracking-[0.2em] md:tracking-[0.3em] uppercase text-[10px] md:text-xs mb-3 block">Detail Dokumentasi</span>
            <h2 id="modal-title" class="text-xl md:text-3xl font-black text-maroon-900 mb-4 md:mb-6 uppercase leading-tight"></h2>
            <p id="modal-desc" class="text-gray-500 leading-relaxed text-xs md:text-base mb-8 md:mb-10 overflow-y-auto max-h-[200px] pr-2"></p>
            
            <a id="modal-download-btn" href="" download class="flex items-center justify-center gap-3 bg-maroon-900 text-white px-8 py-4 rounded-xl md:rounded-2xl font-black text-xs md:text-sm hover:bg-red-700 transition-all shadow-xl">
                <i class="fas fa-cloud-download-alt"></i> DOWNLOAD IMAGE
            </a>
        </div>
    </div>
</div>
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
<script>
    function openLightbox(path, title, desc) {
        const modal = document.getElementById('lightbox-modal');
        const content = document.getElementById('modal-content');
        const img = document.getElementById('modal-img');
        const titleEl = document.getElementById('modal-title');
        const descEl = document.getElementById('modal-desc');
        const downloadBtn = document.getElementById('modal-download-btn');

        img.src = "admin/" + path;
        titleEl.innerText = title;
        descEl.innerText = desc;
        downloadBtn.href = "admin/" + path;

        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden'; 
    }

    function closeLightbox() {
        const modal = document.getElementById('lightbox-modal');
        const content = document.getElementById('modal-content');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
        document.body.style.overflow = 'auto'; 
    }

    document.getElementById('lightbox-modal').addEventListener('click', function(e) {
        if(e.target === this) closeLightbox();
    });
</script>

</body>
</html>