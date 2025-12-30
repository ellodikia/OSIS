<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM galeri ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Kelola Galeri | Admin Raksana</title>
    <link rel="icon" type="image/png" href="../foto/logo-osis.png">
</head>
<body class="h-full font-sans antialiased text-slate-300">

    <div class="flex min-h-screen relative overflow-x-hidden">
        <?php include 'sidebar.php'; ?>

        <main class="flex-1 min-w-0 bg-slate-950">
            <header class="h-16 border-b border-slate-800 bg-slate-900/80 sticky top-0 z-30 backdrop-blur-md px-4 md:px-8 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button type="button" onclick="openSidebar()" class="lg:hidden flex items-center justify-center w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 text-white active:scale-95 transition-all">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>
                    
                    <h1 class="text-sm font-semibold text-slate-400">
                        Admin <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i> <span class="text-white font-bold">Kelola Galeri</span>
                    </h1>
                </div>
            </header>
            
            <div class="p-4 md:p-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Koleksi Foto</h2>
                        <p class="text-slate-500 text-sm mt-1">
                            Ditemukan <span class="text-red-500 font-bold"><?= mysqli_num_rows($data) ?></span> item dalam dokumentasi.
                        </p>
                    </div>
                    <a href="tambah_gallery.php" class="inline-flex items-center justify-center px-6 py-3 bg-red-700 hover:bg-red-600 text-white text-sm font-bold rounded-2xl transition-all shadow-lg shadow-red-900/20 active:scale-95">
                        <i class="fa-solid fa-cloud-arrow-up mr-2 text-base"></i>
                        Unggah Foto Baru
                    </a>
                </div>

                <div class="rounded-3xl border border-slate-800 bg-slate-900/40 backdrop-blur-sm shadow-2xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-800 bg-slate-800/30">
                                    <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">Pratinjau & Judul</th>
                                    <th class="hidden lg:table-cell px-6 py-5 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">Keterangan</th>
                                    <th class="hidden md:table-cell px-6 py-5 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">Tgl Upload</th>
                                    <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 text-center">Opsi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/50">
                                <?php if(mysqli_num_rows($data) > 0): ?>
                                    <?php while($d = mysqli_fetch_array($data)) { ?>
                                    <tr class="hover:bg-slate-800/40 transition-all group">
                                        <td class="px-6 py-5">
                                            <div class="flex items-center space-x-4">
                                                <div class="h-14 w-20 md:h-16 md:w-24 flex-shrink-0 overflow-hidden rounded-xl border border-slate-700 bg-slate-800 group-hover:border-red-600/50 transition-colors shadow-lg">
                                                    <img src="../upload/foto/galeri/<?= $d['foto'] ?>" 
                                                         alt="<?= htmlspecialchars($d['judul']) ?>" 
                                                         class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700">
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="font-bold text-white text-sm md:text-base truncate group-hover:text-red-400 transition-colors">
                                                        <?= htmlspecialchars($d['judul']) ?>
                                                    </div>
                                                    <div class="md:hidden flex items-center text-[10px] text-slate-500 mt-1 uppercase font-bold tracking-tighter">
                                                        <i class="fa-regular fa-calendar-days mr-1 text-red-800"></i>
                                                        <?= date('d M Y', strtotime($d['tanggal_upload'])) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="hidden lg:table-cell px-6 py-5">
                                            <div class="max-w-xs text-xs text-slate-400 line-clamp-2 leading-relaxed">
                                                <?= htmlspecialchars($d['keterangan']) ?>
                                            </div>
                                        </td>

                                        <td class="hidden md:table-cell px-6 py-5">
                                            <div class="inline-flex items-center px-3 py-1 rounded-full bg-slate-950 border border-slate-800 text-[11px] font-medium text-slate-400">
                                                <i class="fa-regular fa-calendar-days mr-2 text-red-900"></i>
                                                <?= date('d M Y', strtotime($d['tanggal_upload'])) ?>
                                            </div>
                                        </td>

                                        <td class="px-6 py-5">
                                            <div class="flex justify-center items-center gap-2 md:gap-3">
                                                <a href="edit_gallery.php?id=<?= $d['id'] ?>" 
                                                   class="h-9 w-9 md:h-10 md:w-10 flex items-center justify-center bg-slate-800 hover:bg-white text-slate-400 hover:text-slate-900 rounded-xl transition-all border border-slate-700 hover:border-white group/btn shadow-lg">
                                                    <i class="fa-solid fa-pen-to-square text-xs md:text-sm"></i>
                                                </a>
                                                <a href="hapus_gallery.php?id=<?= $d['id'] ?>" 
                                                   onclick="return confirm('Hapus foto ini secara permanen?')" 
                                                   class="h-9 w-9 md:h-10 md:w-10 flex items-center justify-center bg-red-950/20 hover:bg-red-700 text-red-500 hover:text-white rounded-xl transition-all border border-red-900/40 hover:border-red-500 group/btn shadow-lg">
                                                    <i class="fa-solid fa-trash-can text-xs md:text-sm"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="py-32 text-center">
                                            <div class="relative inline-block mb-4">
                                                <i class="fa-solid fa-images text-slate-800 text-7xl"></i>
                                                <i class="fa-solid fa-circle-exclamation absolute -bottom-1 -right-1 text-red-600 text-2xl"></i>
                                            </div>
                                            <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Belum ada foto yang diunggah</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="h-20 lg:hidden"></div>
        </main>
    </div>

</body>
</html>