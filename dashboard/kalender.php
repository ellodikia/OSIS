<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';

$query = "SELECT id, tanggal, judul, waktu, lokasi, penanggung_jawab, deskripsi FROM kegiatan ORDER BY tanggal DESC";
$data = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Manajemen Agenda | Admin Raksana</title>
    <link rel="icon" type="image/png" href="../foto/logo-osis.png">
</head>
<body class="h-full font-sans antialiased text-slate-300">

    <div class="flex min-h-screen relative overflow-x-hidden">
        <?php include 'sidebar.php'; ?>

        <main class="flex-1 min-w-0 bg-slate-950">
            <header class="h-16 border-b border-slate-800 bg-slate-900/80 sticky top-0 z-30 backdrop-blur-md px-4 md:px-8 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button type="button" onclick="toggleSidebar()" class="lg:hidden flex items-center justify-center w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 text-white">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>
                    <h1 class="text-sm font-semibold text-white tracking-wide uppercase">Kalender <span class="text-red-500">Raksana</span></h1>
                </div>
            </header>
            
            <div class="p-4 md:p-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                    <div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase leading-none">Agenda Kegiatan</h2>
                        <p class="text-slate-500 text-sm mt-2">Terdaftar <span class="text-red-500 font-bold"><?= mysqli_num_rows($data) ?></span> jadwal dalam sistem.</p>
                    </div>
                    <a href="tambah_kalender.php" class="inline-flex items-center justify-center px-6 py-3.5 bg-red-700 hover:bg-red-600 text-white text-xs font-black uppercase tracking-widest rounded-2xl transition-all shadow-[0_10px_20px_-10px_rgba(185,28,28,0.4)] active:scale-95">
                        <i class="fa-solid fa-calendar-plus mr-2 text-sm"></i> Tambah Agenda
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php if(mysqli_num_rows($data) > 0): ?>
                        <?php while ($d = mysqli_fetch_assoc($data)) { ?>
                            <div class="group bg-slate-900/40 border border-slate-800 rounded-[2.5rem] overflow-hidden flex flex-col hover:border-red-900/50 transition-all duration-500 shadow-xl hover:shadow-red-900/10 relative">
                                
                                <div class="absolute top-6 right-6 z-10">
                                    <div class="bg-slate-950/80 backdrop-blur-md border border-slate-700 px-3 py-1.5 rounded-2xl text-center">
                                        <span class="block text-xs font-black text-red-500 leading-none"><?= date('d', strtotime($d['tanggal'])) ?></span>
                                        <span class="block text-[8px] font-bold text-slate-400 uppercase tracking-tighter"><?= date('M', strtotime($d['tanggal'])) ?></span>
                                    </div>
                                </div>

                                <div class="p-8 flex-1 flex flex-col">
                                    <div class="mb-6">
                                        <div class="flex items-center text-red-500 text-[9px] font-black uppercase tracking-[0.2em] mb-2">
                                            <i class="fa-regular fa-clock mr-1.5"></i> <?= $d['waktu'] ?>
                                        </div>
                                        <h3 class="text-white font-black text-lg leading-tight group-hover:text-red-400 transition-colors uppercase tracking-tight">
                                            <?= htmlspecialchars($d['judul']) ?>
                                        </h3>
                                    </div>

                                    <div class="space-y-4 mb-8">
                                        <div class="flex items-start gap-3">
                                            <div class="mt-1 w-5 flex justify-center text-red-600 text-xs">
                                                <i class="fa-solid fa-location-dot"></i>
                                            </div>
                                            <p class="text-xs text-slate-400 font-medium leading-relaxed">
                                                <?= htmlspecialchars($d['lokasi']) ?>
                                            </p>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <div class="mt-1 w-5 flex justify-center text-red-600 text-xs">
                                                <i class="fa-solid fa-user-tie"></i>
                                            </div>
                                            <p class="text-xs text-slate-500 font-bold uppercase tracking-tighter">
                                                PJ: <?= htmlspecialchars($d['penanggung_jawab']) ?>
                                            </p>
                                        </div>
                                        <div class="pt-4 border-t border-slate-800/50">
                                            <p class="text-xs text-slate-500 italic line-clamp-3 leading-relaxed">
                                                "<?= htmlspecialchars($d['deskripsi']) ?>"
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-auto flex gap-3">
                                        <a href="edit_kalender.php?id=<?= $d['id'] ?>" 
                                           class="flex-1 flex items-center justify-center gap-2 py-3 bg-slate-800 hover:bg-white text-slate-300 hover:text-slate-950 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all border border-slate-700 shadow-lg">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                        <a href="hapus_kalender.php?id=<?= $d['id'] ?>" 
                                           onclick="return confirm('Hapus agenda ini permanen?')"
                                           class="h-11 w-11 flex items-center justify-center bg-red-950/20 hover:bg-red-700 text-red-500 hover:text-white rounded-2xl transition-all border border-red-900/40 shadow-lg">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php else: ?>
                        <div class="col-span-full py-32 flex flex-col items-center justify-center border-2 border-dashed border-slate-800 rounded-[3rem]">
                            <div class="w-20 h-20 bg-slate-900 rounded-full flex items-center justify-center mb-6">
                                <i class="fa-solid fa-calendar-xmark text-slate-700 text-3xl"></i>
                            </div>
                            <p class="text-slate-500 font-black uppercase tracking-widest text-sm">Belum ada agenda terdaftar</p>
                            <a href="tambah_kalender.php" class="mt-4 text-red-600 hover:text-red-400 text-xs font-bold underline uppercase tracking-tighter">Buat Agenda Baru</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="h-20 lg:hidden"></div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('main-sidebar');
            if (sidebar) sidebar.classList.toggle('-translate-x-full');
        }
    </script>
</body>
</html>