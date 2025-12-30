<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';

if(isset($_POST['simpan'])) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $tanggal = $_POST['tanggal'];
    $level = $_POST['level'];
    
    $foto_nama = time() . "_" . $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    if(move_uploaded_file($tmp, "../upload/foto/berita/" . $foto_nama)) {
        $query = "INSERT INTO berita (judul, isi, tanggal, level, foto) VALUES ('$judul', '$isi', '$tanggal', '$level', '$foto_nama')";
        mysqli_query($koneksi, $query);
        header("Location: berita.php");
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
    <title>Tambah Berita | Admin Raksana</title>
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
                        Berita <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i> <span class="text-white">Tambah Data Baru</span>
                    </h1>
                </div>
            </header>
            
            <div class="p-4 md:p-8 flex justify-center">
                <div class="w-full max-w-2xl">
                    <div class="mb-4 lg:hidden">
                        <a href="berita.php" class="text-xs text-slate-500 flex items-center gap-2">
                            <i class="fa-solid fa-arrow-left"></i> Kembali ke List Berita
                        </a>
                    </div>

                    <div class="bg-slate-900/40 border border-slate-800 rounded-3xl overflow-hidden backdrop-blur-sm shadow-2xl">
                        <div class="p-6 md:p-8 border-b border-slate-800 bg-slate-800/30">
                            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">Form Input Berita</h2>
                            <p class="text-slate-500 text-xs mt-1">Lengkapi data di bawah ini untuk menerbitkan berita baru.</p>
                        </div>

                        <form method="post" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
                            <div class="space-y-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest">Judul Berita</label>
                                <input type="text" name="judul" placeholder="Masukkan judul yang menarik..." required 
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest">Konten Lengkap</label>
                                <textarea name="isi" rows="6" placeholder="Tuliskan isi berita di sini..." required
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all resize-none"></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest">Tanggal Publikasi</label>
                                    <input type="date" name="tanggal" required 
                                        class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-600 transition-all">
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest">Kategori / Level</label>
                                    <select name="level" required 
                                        class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-600 transition-all appearance-none cursor-pointer">
                                        <option value="" disabled selected>Pilih Level</option>
                                        <option value="berita">Berita Utama</option>
                                        <option value="pengumuman">Pengumuman Penting</option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest">Foto Pendukung</label>
                                <div class="relative group">
                                    <label class="flex flex-col items-center justify-center w-full min-h-[160px] border-2 border-slate-800 border-dashed rounded-2xl cursor-pointer bg-slate-950 hover:bg-slate-900/50 hover:border-red-900 transition-all overflow-hidden p-4">
                                        
                                        <div id="previewContainer" class="hidden w-full mb-2">
                                            <img id="imagePreview" src="#" class="max-h-48 mx-auto rounded-lg shadow-xl border border-slate-800 object-cover">
                                        </div>

                                        <div id="placeholderUI" class="flex flex-col items-center justify-center py-4">
                                            <i class="fa-solid fa-cloud-arrow-up text-slate-600 text-3xl mb-3 group-hover:text-red-500 transition-colors"></i>
                                            <p class="text-xs text-slate-400 font-medium">Klik untuk upload atau tarik gambar</p>
                                            <p class="text-[10px] text-slate-600 mt-2 uppercase tracking-tighter">JPG, PNG, atau WEBP</p>
                                        </div>
                                        
                                        <input type="file" name="foto" id="fotoInput" class="hidden" accept="image/*" required />
                                    </label>
                                </div>
                            </div>

                            <div class="flex flex-col-reverse md:flex-row items-center justify-end gap-4 pt-6 border-t border-slate-800/50">
                                <a href="berita.php" class="w-full md:w-auto text-center text-xs font-bold uppercase tracking-widest text-slate-500 hover:text-white transition-colors py-3 px-6">Batal</a>
                                <button type="submit" name="simpan" class="w-full md:w-auto bg-red-700 hover:bg-red-600 text-white text-xs font-bold uppercase tracking-widest py-4 px-10 rounded-xl shadow-xl shadow-red-900/20 transition-all active:scale-95 flex items-center justify-center">
                                    <i class="fa-solid fa-paper-plane mr-2"></i>
                                    Terbitkan Berita
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