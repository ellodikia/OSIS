<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';

$query = "SELECT id, nama, jabatan, foto, keterangan, visi_misi FROM pengurus 
          ORDER BY FIELD(jabatan, 
            'Pembina OSIS', 
            'Ketua OSIS', 
            'Wakil Ketua OSIS', 
            'Sekretaris', 
            'Wakil Sekretaris', 
            'Bendahara'
          ) ASC, jabatan ASC, nama ASC";

$data = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Manajemen Pengurus | Admin Raksana</title>
    <link rel="icon" type="image/png" href="../foto/logo-osis.png">
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
                    <h1 class="text-sm font-semibold text-white tracking-wide uppercase">Direktori Pengurus</h1>
                </div>
            </header>
            
            <div class="p-4 md:p-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                    <div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase leading-none">Manajemen Organisasi</h2>
                        <p class="text-slate-500 text-sm mt-2">Ditemukan <span class="text-red-500 font-bold"><?= mysqli_num_rows($data) ?></span> pengurus dalam sistem.</p>
                    </div>
                    <a href="tambah_pengurus.php" class="inline-flex items-center justify-center px-6 py-3.5 bg-red-700 hover:bg-red-600 text-white text-xs font-black uppercase tracking-widest rounded-2xl transition-all shadow-[0_10px_20px_-10px_rgba(185,28,28,0.4)] active:scale-95">
                        <i class="fa-solid fa-user-plus mr-2 text-sm"></i> Tambah Pengurus
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php if(mysqli_num_rows($data) > 0): ?>
                        <?php while ($d = mysqli_fetch_assoc($data)) { 
                            $nama_file = trim($d['foto']); 
                            $path_foto = "../uploads/pengurus/" . $nama_file;
                            if(!empty($nama_file) && file_exists($path_foto)) {
                                $display_foto = $path_foto;
                            } else {
                                $display_foto = 'https://ui-avatars.com/api/?name='.urlencode($d['nama']).'&background=450a0a&color=f87171&bold=true&size=512';
                            }
                        ?>
                            <div class="group bg-slate-900/40 border border-slate-800 rounded-[2.5rem] overflow-hidden flex flex-col hover:border-red-900/50 transition-all duration-500 shadow-xl hover:shadow-red-900/10">
                                
                                <div class="relative pt-8 pb-4 flex justify-center">
                                    <div class="absolute inset-0 bg-gradient-to-b from-red-900/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                    <div class="relative h-32 w-32 rounded-full overflow-hidden border-4 border-slate-800 group-hover:border-red-700 transition-all duration-500 shadow-2xl">
                                        <img src="<?= $display_foto ?>" 
                                             alt="<?= $d['nama'] ?>" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    </div>
                                </div>

                                <div class="p-6 text-center flex-1 flex flex-col">
                                    <div class="mb-4">
                                        <h3 class="text-white font-black text-lg leading-tight group-hover:text-red-400 transition-colors uppercase tracking-tight">
                                            <?= htmlspecialchars($d['nama']) ?>
                                        </h3>
                                        <div class="mt-2">
                                            <span class="bg-red-950/40 text-red-500 text-[10px] font-black px-4 py-1.5 rounded-full border border-red-900/50 uppercase tracking-widest">
                                                <?= $d['jabatan'] ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-6 space-y-2">
                                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest italic">"<?= $d['keterangan'] ?>"</p>
                                        <p class="text-slate-400 text-xs line-clamp-3 leading-relaxed border-t border-slate-800 pt-3 italic">
                                            <?= htmlspecialchars($d['visi_misi']) ?>
                                        </p>
                                    </div>

                                    <div class="mt-auto flex gap-3">
                                        <a href="edit_pengurus.php?id=<?= $d['id'] ?>" 
                                           class="flex-1 flex items-center justify-center gap-2 py-3 bg-slate-800 hover:bg-white text-slate-300 hover:text-slate-950 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all border border-slate-700 shadow-lg">
                                            <i class="fa-solid fa-user-pen"></i> Edit
                                        </a>
                                        <a href="hapus_pengurus.php?id=<?= $d['id'] ?>" 
                                           onclick="return confirm('Hapus pengurus ini permanen?')"
                                           class="h-12 w-12 flex items-center justify-center bg-red-950/20 hover:bg-red-700 text-red-500 hover:text-white rounded-2xl transition-all border border-red-900/40 shadow-lg">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php else: ?>
                        <div class="col-span-full py-32 flex flex-col items-center justify-center border-2 border-dashed border-slate-800 rounded-[3rem]">
                            <div class="w-20 h-20 bg-slate-900 rounded-full flex items-center justify-center mb-6">
                                <i class="fa-solid fa-users-slash text-slate-700 text-3xl"></i>
                            </div>
                            <p class="text-slate-500 font-black uppercase tracking-widest text-sm">Belum ada pengurus terdaftar</p>
                            <a href="tambah_pengurus.php" class="mt-4 text-red-600 hover:text-red-400 text-xs font-bold underline uppercase tracking-tighter">Tambah Data Sekarang</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="h-20 lg:hidden"></div>
        </main>
    </div>

</body>
</html>