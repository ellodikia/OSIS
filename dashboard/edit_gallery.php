<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';

if (!isset($_GET['id'])) { header("Location: gallery.php"); exit; }

$id = mysqli_real_escape_string($koneksi, $_GET['id']);
$query_data = mysqli_query($koneksi, "SELECT * FROM galeri WHERE id='$id'");
$d = mysqli_fetch_assoc($query_data);

if (!$d) { header("Location: gallery.php"); exit; }

if(isset($_POST['update'])) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $tanggal_upload = mysqli_real_escape_string($koneksi, $_POST['tanggal_upload']);

    if ($_FILES['foto']['name'] != "") {
        $nama_file = $_FILES['foto']['name'];
        $tmp_name = $_FILES['foto']['tmp_name'];
        $ekstensi_file = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        
        $nama_file_baru = uniqid() . '.' . $ekstensi_file;
        $folder_tujuan = '../upload/foto/galeri/' . $nama_file_baru;

        if (move_uploaded_file($tmp_name, $folder_tujuan)) {
            if (file_exists($d['path_foto'])) {
                unlink($d['path_foto']);
            }
            
            $query = "UPDATE galeri SET 
                        judul='$judul', 
                        keterangan='$keterangan', 
                        tanggal_upload='$tanggal_upload', 
                        foto='$nama_file_baru', 
                        path_foto='$folder_tujuan' 
                      WHERE id='$id'";
        }
    } else {
        $query = "UPDATE galeri SET 
                    judul='$judul', 
                    keterangan='$keterangan', 
                    tanggal_upload='$tanggal_upload' 
                  WHERE id='$id'";
    }
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: gallery.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Edit Galeri | Admin Raksana</title>
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
                        Galeri <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i> <span class="text-white">Edit Foto</span>
                    </h1>
                </div>
                <div class="hidden sm:block text-[10px] font-mono text-slate-500 uppercase tracking-widest">Editor Mode</div>
            </header>
            
            <div class="p-4 md:p-6 lg:p-10 flex justify-center">
                <div class="w-full max-w-3xl">
                    <a href="gallery.php" class="lg:hidden inline-flex items-center text-xs text-slate-500 mb-4 hover:text-white transition-colors">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Galeri
                    </a>

                    <div class="bg-slate-900/40 border border-slate-800 rounded-3xl overflow-hidden backdrop-blur-sm shadow-2xl">
                        <div class="p-6 md:p-8 border-b border-slate-800 bg-slate-800/30">
                            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">Edit Dokumentasi</h2>
                            <p class="text-slate-400 text-xs md:text-sm mt-1">Sesuaikan informasi atau ganti foto koleksi galeri.</p>
                        </div>

                        <form action="" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-8">
                            <div class="space-y-3">
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500">Preview & Update Foto</label>
                                <div class="relative group">
                                    <input type="file" name="foto" id="fotoInput" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="w-full overflow-hidden rounded-2xl border-2 border-dashed border-slate-800 bg-slate-950 transition-all group-hover:border-red-600/50">
                                        <img id="imagePreview" src="../upload/foto/galeri/<?= $d['foto'] ?>" class="w-full h-48 md:h-80 object-cover opacity-60 group-hover:opacity-100 transition-all duration-500">
                                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                            <div class="bg-slate-900/90 px-5 py-2.5 rounded-xl border border-slate-700 shadow-2xl text-[10px] font-bold uppercase tracking-widest text-white group-hover:bg-red-600 group-hover:border-red-500 transition-all">
                                                <i class="fa-solid fa-camera-rotate mr-2 text-xs"></i> Klik untuk Ganti Foto
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-[10px] text-slate-600 italic leading-relaxed text-center">*Gunakan foto orientasi landscape untuk hasil terbaik. Kosongkan jika tidak diganti.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2 space-y-2">
                                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500">Judul Dokumentasi</label>
                                    <input type="text" name="judul" value="<?= htmlspecialchars($d['judul']) ?>" required 
                                        class="w-full px-4 py-3.5 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all" placeholder="Contoh: Latihan Dasar Kepemimpinan">
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500">Tanggal Kegiatan</label>
                                    <input type="date" name="tanggal_upload" value="<?= $d['tanggal_upload'] ?>" required 
                                        class="w-full px-4 py-3.5 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:outline-none focus:border-red-600 transition-all [color-scheme:dark]">
                                </div>

                                <div class="md:col-span-2 space-y-2">
                                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500">Keterangan Singkat</label>
                                    <textarea name="keterangan" rows="4" required 
                                        class="w-full px-4 py-3.5 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:outline-none focus:border-red-600 transition-all resize-none" placeholder="Deskripsikan momen dalam foto ini..."><?= htmlspecialchars($d['keterangan']) ?></textarea>
                                </div>
                            </div>

                            <div class="pt-6 flex flex-col-reverse md:flex-row gap-4">
                                <a href="gallery.php" class="flex-1 inline-flex items-center justify-center px-6 py-4 border border-slate-800 bg-slate-800/50 text-slate-400 text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-slate-800 hover:text-white transition-all">
                                    Batal
                                </a>
                                <button type="submit" name="update" class="flex-[2] bg-red-700 hover:bg-red-600 text-white text-xs font-bold uppercase tracking-widest py-4 rounded-xl shadow-xl shadow-red-900/20 flex items-center justify-center transition-all active:scale-[0.98]">
                                    <i class="fa-solid fa-check-double mr-2 text-sm"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="h-12 lg:hidden"></div>
        </main>
    </div>

    <script>
        const fotoInput = document.getElementById('fotoInput');
        const imagePreview = document.getElementById('imagePreview');

        fotoInput.onchange = evt => {
            const [file] = fotoInput.files;
            if (file) {
                imagePreview.src = URL.createObjectURL(file);
                imagePreview.classList.remove('opacity-60');
                imagePreview.classList.add('opacity-100');
            }
        }
    </script>
</body>
</html>