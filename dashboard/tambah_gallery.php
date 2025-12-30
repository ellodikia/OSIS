<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';

if (isset($_POST['submit'])) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $tanggal_upload = date('Y-m-d');

    $nama_file = $_FILES['foto']['name'];
    $ukuran_file = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmp_name = $_FILES['foto']['tmp_name'];

    if ($error === 0) {
        $ekstensi_valid = ['jpg', 'jpeg', 'png', 'webp'];
        $ekstensi_file = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

        if (in_array($ekstensi_file, $ekstensi_valid)) {
            $nama_file_baru = uniqid() . '.' . $ekstensi_file;
            $folder_tujuan = '../upload/foto/galeri/' . $nama_file_baru;

            if (move_uploaded_file($tmp_name, $folder_tujuan)) {
                $query = "INSERT INTO galeri (judul, foto, keterangan, path_foto, tanggal_upload) 
                          VALUES ('$judul', '$nama_file_baru', '$keterangan', '$folder_tujuan', '$tanggal_upload')";
                
                if (mysqli_query($koneksi, $query)) {
                    header("Location: gallery.php");
                    exit;
                }
            }
        }
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
    <title>Unggah Galeri | Admin Raksana</title>
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
                        Galeri <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i> <span class="text-white">Tambah Foto</span>
                    </h1>
                </div>
                <div class="hidden sm:block text-[10px] font-mono text-slate-500 uppercase tracking-widest">Upload Mode</div>
            </header>
            
            <div class="p-4 md:p-8 flex justify-center">
                <div class="w-full max-w-2xl">
                    <div class="mb-4 lg:hidden">
                        <a href="gallery.php" class="text-xs text-slate-500 flex items-center gap-2">
                            <i class="fa-solid fa-arrow-left"></i> Kembali ke Galeri
                        </a>
                    </div>

                    <div class="bg-slate-900/40 border border-slate-800 rounded-3xl overflow-hidden backdrop-blur-sm shadow-2xl">
                        <div class="p-6 md:p-8 border-b border-slate-800 bg-slate-800/30">
                            <h2 class="text-2xl font-bold text-white tracking-tight">Tambah Koleksi Galeri</h2>
                            <p class="text-slate-400 text-sm mt-1">Unggah dokumentasi kegiatan terbaru ke sistem.</p>
                        </div>

                        <form action="" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500">Judul Foto / Kegiatan</label>
                                    <input type="text" name="judul" required placeholder="Contoh: Latihan Dasar Kepemimpinan..." 
                                        class="w-full px-4 py-3.5 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all">
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500">Pilih File Foto</label>
                                    <div class="relative group">
                                        <input type="file" name="foto" id="fotoInput" accept="image/*" required
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div class="w-full p-6 md:p-10 border-2 border-dashed border-slate-800 rounded-2xl bg-slate-950 group-hover:border-red-600/50 transition-all flex flex-col items-center justify-center text-center">
                                            
                                            <div id="previewContainer" class="hidden mb-4">
                                                <img id="imagePreview" src="#" class="max-h-40 md:max-h-56 rounded-xl shadow-2xl border border-slate-700 object-cover">
                                            </div>

                                            <div id="placeholderUI">
                                                <div class="w-12 h-12 md:w-16 md:h-16 bg-slate-900 rounded-2xl flex items-center justify-center mb-4 mx-auto border border-slate-800 group-hover:bg-red-600/10 transition-colors">
                                                    <i class="fa-solid fa-cloud-arrow-up text-2xl md:text-3xl text-slate-600 group-hover:text-red-500"></i>
                                                </div>
                                                <p class="text-sm text-slate-300 font-medium">Klik atau seret gambar ke sini</p>
                                                <p class="text-[10px] text-slate-500 mt-2 uppercase tracking-tighter">JPG, PNG, atau WEBP (Maks. 2MB)</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500">Keterangan Singkat</label>
                                    <textarea name="keterangan" rows="4" required placeholder="Ceritakan sedikit tentang foto ini..." 
                                        class="w-full px-4 py-3.5 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:outline-none focus:border-red-600 transition-all resize-none"></textarea>
                                </div>
                            </div>

                            <div class="pt-4 flex flex-col-reverse md:flex-row gap-4">
                                <a href="gallery.php" 
                                   class="flex-1 inline-flex items-center justify-center px-6 py-4 border border-slate-800 hover:border-slate-600 bg-slate-800/40 text-slate-400 text-xs font-bold uppercase tracking-widest rounded-xl transition-all">
                                    Batal
                                </a>
                                <button type="submit" name="submit" 
                                    class="flex-[2] bg-red-700 hover:bg-red-600 text-white text-xs font-bold uppercase tracking-widest py-4 rounded-xl shadow-xl shadow-red-900/20 active:scale-[0.98] flex items-center justify-center transition-all">
                                    <i class="fa-solid fa-paper-plane mr-2"></i>
                                    Unggah Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="h-10 lg:hidden"></div>
        </main>
    </div>

    <script>
        const fotoInput = document.getElementById('fotoInput');
        const previewContainer = document.getElementById('previewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const placeholderUI = document.getElementById('placeholderUI');

        fotoInput.onchange = evt => {
            const [file] = fotoInput.files;
            if (file) {
                imagePreview.src = URL.createObjectURL(file);
                previewContainer.classList.remove('hidden');
                placeholderUI.classList.add('hidden');
            }
        }
    </script>
</body>
</html>