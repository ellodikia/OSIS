<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';

$total_berita = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM berita"));
$total_pengurus = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM pengurus"));
$total_kegiatan = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM kegiatan"));
$total_gallery = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM galeri"));

$kegiatan_terdekat = mysqli_query($koneksi, "SELECT * FROM kegiatan ORDER BY tanggal ASC LIMIT 5");
$berita_terbaru = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY tanggal DESC LIMIT 3");
$pengurus_baru = mysqli_query($koneksi, "SELECT * FROM pengurus ORDER BY id DESC LIMIT 4");
?>

<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Dashboard Admin | RaksanaMedan</title>
    <link rel="icon" type="image/png" href="../foto/logo-osis.png">
</head>
<body class="h-full font-sans antialiased text-slate-300">

    <div class="flex min-h-screen relative">
        <?php include 'sidebar.php'; ?>

        <main class="flex-1 overflow-auto bg-slate-950">
            <header class="h-16 border-b border-slate-800 bg-slate-900/60 sticky top-0 z-30 backdrop-blur-md px-4 md:px-8 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button onclick="openSidebar()" class="lg:hidden flex items-center justify-center p-2 rounded-lg bg-slate-800 border border-slate-700 text-white active:scale-90 transition-all">
                        <i class="fa-solid fa-bars-staggered text-base"></i>
                    </button>
                    
                    <h1 class="text-sm font-medium text-slate-400 lg:ml-0 ml-1">
                        <span class="hidden md:inline">Dashboard</span> <span class="text-white">Overview</span>
                    </h1>
                </div>

                <div class="flex items-center gap-4 text-[10px] md:text-xs font-mono">
                    <span id="real-time-clock" class="text-slate-500 italic"></span>
                </div>
            </header>
            
            <div class="p-4 md:p-8">
                <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-1 tracking-tight">Halo, <a href="registrasi.php">Admin</a> OSIS!</h2>
                        <p class="text-[10px] md:text-xs text-slate-500 uppercase tracking-[0.2em] font-medium">Area Humas & Infokum Raksana</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-8">
                    <div class="bg-slate-900 border border-slate-800 p-4 md:p-6 rounded-2xl shadow-lg border-b-2 border-b-blue-600">
                        <i class="fa-solid fa-newspaper text-blue-500 mb-2 md:mb-4"></i>
                        <h3 class="text-xl md:text-3xl font-bold text-white"><?= $total_berita ?></h3>
                        <p class="text-[10px] md:text-sm text-slate-500">Berita</p>
                    </div>
                    <div class="bg-slate-900 border border-slate-800 p-4 md:p-6 rounded-2xl shadow-lg border-b-2 border-b-red-600">
                        <i class="fa-solid fa-user-shield text-red-500 mb-2 md:mb-4"></i>
                        <h3 class="text-xl md:text-3xl font-bold text-white"><?= $total_pengurus ?></h3>
                        <p class="text-[10px] md:text-sm text-slate-500">Pengurus</p>
                    </div>
                    <div class="bg-slate-900 border border-slate-800 p-4 md:p-6 rounded-2xl shadow-lg border-b-2 border-b-amber-600">
                        <i class="fa-solid fa-calendar-day text-amber-500 mb-2 md:mb-4"></i>
                        <h3 class="text-xl md:text-3xl font-bold text-white"><?= $total_kegiatan ?></h3>
                        <p class="text-[10px] md:text-sm text-slate-500">Agenda</p>
                    </div>
                    <div class="bg-slate-900 border border-slate-800 p-4 md:p-6 rounded-2xl shadow-lg border-b-2 border-b-emerald-600">
                        <i class="fa-solid fa-images text-emerald-500 mb-2 md:mb-4"></i>
                        <h3 class="text-xl md:text-3xl font-bold text-white"><?= $total_gallery ?></h3>
                        <p class="text-[10px] md:text-sm text-slate-500">Galeri</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
                    <div class="lg:col-span-2 space-y-6 md:space-y-8">
                        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
                            <div class="p-4 md:p-6 border-b border-slate-800 flex items-center justify-between bg-slate-900/30">
                                <h3 class="font-bold text-white flex items-center gap-3 text-sm md:text-base">
                                    <i class="fa-solid fa-bullhorn text-red-600"></i> Upcoming Agenda
                                </h3>
                                <a href="kalender.php" class="px-3 py-1 bg-slate-800 hover:bg-red-900/30 text-[9px] md:text-[10px] font-bold text-slate-400 hover:text-red-500 rounded-full border border-slate-700 transition-all uppercase tracking-wider">Manage</a>
                            </div>
                            <div class="p-4 md:p-6">
                                <div class="space-y-4">
                                    <?php if(mysqli_num_rows($kegiatan_terdekat) > 0): ?>
                                        <?php while($kgt = mysqli_fetch_assoc($kegiatan_terdekat)): ?>
                                        <div class="flex items-center p-3 rounded-xl hover:bg-slate-950 border border-transparent hover:border-slate-800 transition-all group">
                                            <div class="h-10 w-10 md:h-12 md:w-12 shrink-0 bg-slate-800 rounded-lg flex flex-col items-center justify-center border border-slate-700 group-hover:border-red-600/50 transition-colors">
                                                <span class="text-xs md:text-sm font-bold text-white leading-none"><?= date('d', strtotime($kgt['tanggal'])) ?></span>
                                                <span class="text-[8px] md:text-[9px] uppercase font-bold text-slate-500"><?= date('M', strtotime($kgt['tanggal'])) ?></span>
                                            </div>
                                            <div class="ml-4 flex-1 min-w-0">
                                                <h4 class="text-xs md:text-sm font-semibold text-slate-200 truncate group-hover:text-red-500 transition-colors"><?= $kgt['judul'] ?></h4>
                                                <div class="flex items-center gap-3 mt-1 overflow-hidden">
                                                    <span class="text-[9px] md:text-[10px] text-slate-500 flex items-center gap-1 whitespace-nowrap"><i class="fa-solid fa-location-dot"></i> <?= $kgt['lokasi'] ?></span>
                                                    <span class="text-[9px] md:text-[10px] text-slate-500 flex items-center gap-1 whitespace-nowrap"><i class="fa-solid fa-clock"></i> <?= $kgt['waktu'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <div class="py-10 text-center text-slate-600 italic text-sm">Belum ada agenda terdaftar.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 md:p-6">
                            <h3 class="font-bold text-white mb-4 md:mb-6 flex items-center gap-3 text-sm md:text-base">
                                <i class="fa-solid fa-user-plus text-red-600"></i> Pengurus Baru
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
                                <?php while($pgs = mysqli_fetch_assoc($pengurus_baru)): ?>
                                <div class="flex items-center p-2.5 bg-slate-950 rounded-xl border border-slate-800">
                                    <img src="../uploads/pengurus/<?= $pgs['foto'] ?>" class="h-8 w-8 rounded-full object-cover border border-slate-700 shadow-sm" alt="Avatar">
                                    <div class="ml-3 overflow-hidden">
                                        <p class="text-[10px] md:text-xs font-bold text-white truncate"><?= $pgs['nama'] ?></p>
                                        <p class="text-[8px] md:text-[10px] text-slate-500 truncate uppercase"><?= $pgs['jabatan'] ?></p>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6 md:space-y-8">
                        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-xl bg-gradient-to-br from-slate-900 to-slate-950">
                            <h3 class="font-bold text-white mb-5 flex items-center gap-3 text-xs md:text-sm italic tracking-widest text-slate-500 uppercase">Quick Action</h3>
                            <div class="grid grid-cols-1 gap-2">
                                <a href="tambah_berita.php" class="w-full flex items-center gap-3 px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl hover:border-red-600/50 hover:bg-red-950/10 transition-all text-[11px] md:text-xs group">
                                    <i class="fa-solid fa-file-pen text-slate-600 group-hover:text-red-500"></i>
                                    <span class="font-medium text-slate-400 group-hover:text-white">Tulis Berita Baru</span>
                                </a>
                                <a href="tambah_kalender.php" class="w-full flex items-center gap-3 px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl hover:border-red-600/50 hover:bg-red-950/10 transition-all text-[11px] md:text-xs group">
                                    <i class="fa-solid fa-calendar-plus text-slate-600 group-hover:text-red-500"></i>
                                    <span class="font-medium text-slate-400 group-hover:text-white">Buat Agenda Proker</span>
                                </a>
                            </div>
                        </div>

                        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
                            <div class="p-4 border-b border-slate-800 bg-slate-900/30">
                                <h3 class="font-bold text-white flex items-center gap-3 text-xs"><i class="fa-solid fa-fire text-red-600"></i> Berita Terbaru</h3>
                            </div>
                            <div class="p-3 space-y-4">
                                <?php while($brt = mysqli_fetch_assoc($berita_terbaru)): ?>
                                <div class="group cursor-pointer">
                                    <div class="flex items-start gap-3">
                                        <div class="relative h-10 w-10 shrink-0">
                                            <img src="../upload/foto/berita/<?= $brt['foto'] ?>" class="h-full w-full rounded-lg object-cover grayscale group-hover:grayscale-0 transition-all" alt="News">
                                        </div>
                                        <div class="overflow-hidden">
                                            <h4 class="text-[10px] font-bold text-slate-300 group-hover:text-red-500 transition-colors truncate"><?= $brt['judul'] ?></h4>
                                            <p class="text-[8px] text-slate-600 mt-0.5 uppercase"><i class="fa-regular fa-clock mr-1"></i> <?= date('d M Y', strtotime($brt['tanggal'])) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                            </div>
                            <a href="berita.php" class="block w-full py-3 text-center text-[9px] font-bold text-slate-500 hover:text-white hover:bg-slate-800 border-t border-slate-800 transition-all uppercase tracking-widest">Manajemen Berita</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            const options = { weekday: 'short', day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' };
            document.getElementById('real-time-clock').innerText = now.toLocaleDateString('id-ID', options);
        }
        setInterval(updateTime, 1000); 
        updateTime();
    </script>
</body>
</html>