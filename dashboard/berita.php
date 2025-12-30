<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';

$data = mysqli_query($koneksi, "SELECT id, judul, isi, tanggal, level, foto FROM berita ORDER BY tanggal DESC" );
?>

<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../foto/logo-osis.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Kelola Berita | Admin Raksana</title>
</head>
<body class="h-full font-sans antialiased text-slate-300">

    <div class="flex min-h-screen relative overflow-x-hidden">
        <?php include 'sidebar.php'; ?>

        <main class="flex-1 min-w-0 bg-slate-950">
            <header class="h-16 border-b border-slate-800 bg-slate-900/80 sticky top-0 z-30 backdrop-blur-md px-4 md:px-8 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button type="button" onclick="openSidebar()" class="lg:hidden flex items-center justify-center w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 text-white shadow-lg shadow-black/50">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>
                    <h1 class="text-sm font-semibold text-white tracking-wide">Kelola Berita</h1>
                </div>
            </header>
            
            <div class="p-4 md:p-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                    <div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Manajemen Konten</h2>
                        <p class="text-slate-500 text-sm mt-1">Ditemukan <span class="text-red-500 font-bold"><?= mysqli_num_rows($data) ?></span> berita dalam sistem.</p>
                    </div>
                    <a href="tambah_berita.php" class="inline-flex items-center justify-center px-6 py-3.5 bg-red-700 hover:bg-red-600 text-white text-xs font-black uppercase tracking-widest rounded-2xl transition-all shadow-[0_10px_20px_-10px_rgba(185,28,28,0.4)] active:scale-95">
                        <i class="fa-solid fa-plus mr-2 text-sm"></i> Tambah Berita
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php if(mysqli_num_rows($data) > 0): ?>
                        <?php while($d = mysqli_fetch_assoc($data)) { ?>
                            <div class="group bg-slate-900/40 border border-slate-800 rounded-[2rem] overflow-hidden flex flex-col hover:border-slate-600 transition-all duration-500 shadow-xl hover:shadow-red-900/10 hover:-translate-y-1">
                                
                                <div class="relative h-48 overflow-hidden">
                                    <img src="../upload/foto/berita/<?= $d['foto'] ?>" alt="" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    
                                    <div class="absolute top-4 left-4">
                                        <?php if($d['level'] == 'pengumuman'): ?>
                                            <span class="bg-amber-500 text-black text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-tighter shadow-lg">Pengumuman</span>
                                        <?php else: ?>
                                            <span class="bg-red-600 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-tighter shadow-lg">Berita</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="p-6 flex-1 flex flex-col">
                                    <div class="flex items-center text-[10px] font-bold text-slate-500 mb-3 uppercase tracking-widest">
                                        <i class="fa-regular fa-calendar-check mr-2 text-red-500"></i>
                                        <?= date('d M Y', strtotime($d['tanggal'])) ?>
                                    </div>
                                    
                                    <h3 class="text-white font-bold text-lg leading-tight mb-3 line-clamp-2 group-hover:text-red-400 transition-colors">
                                        <?= htmlspecialchars($d['judul']) ?>
                                    </h3>
                                    
                                    <p class="text-slate-400 text-xs line-clamp-3 mb-6 leading-relaxed italic">
                                        "<?= strip_tags($d['isi']) ?>"
                                    </p>

                                    <div class="mt-auto grid grid-cols-2 gap-3 pt-4 border-t border-slate-800/50">
                                        <a href="edit_berita.php?id=<?= $d['id'] ?>" 
                                           class="flex items-center justify-center gap-2 py-2.5 bg-slate-800 hover:bg-white text-slate-300 hover:text-slate-950 rounded-xl text-[11px] font-bold uppercase transition-all border border-slate-700">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                        <a href="hapus_berita.php?id=<?= $d['id'] ?>" 
                                           onclick="return confirm('Hapus berita ini permanen?')"
                                           class="flex items-center justify-center gap-2 py-2.5 bg-red-950/20 hover:bg-red-700 text-red-500 hover:text-white rounded-xl text-[11px] font-bold uppercase transition-all border border-red-900/40">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php else: ?>
                        <div class="col-span-full py-32 flex flex-col items-center justify-center border-2 border-dashed border-slate-800 rounded-[3rem]">
                            <i class="fa-solid fa-newspaper text-slate-800 text-6xl mb-4"></i>
                            <p class="text-slate-500 font-black uppercase tracking-widest text-sm">Belum ada berita</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="h-20 lg:hidden"></div>
        </main>
    </div>

</body>
</html>