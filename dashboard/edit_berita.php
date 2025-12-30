<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';

$id = mysqli_real_escape_string($koneksi, $_GET['id']);
$data = mysqli_query($koneksi, "SELECT * FROM berita WHERE id='$id'");
$d = mysqli_fetch_assoc($data);

if (!$d) { header("Location: berita.php"); exit; }

if(isset($_POST['update'])) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $tanggal = $_POST['tanggal'];
    $level = $_POST['level'];
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    if($foto) {
        $foto_baru = time() . "_" . $foto;
        move_uploaded_file($tmp, "../upload/foto/berita/". $foto_baru);
        if(file_exists("../upload/foto/berita/".$d['foto'])) { unlink("../upload/foto/berita/".$d['foto']); }
        $query = "UPDATE berita SET judul='$judul', isi='$isi', tanggal='$tanggal', level='$level', foto='$foto_baru' WHERE id='$id'";
    } else {
        $query = "UPDATE berita SET judul='$judul', isi='$isi', tanggal='$tanggal', level='$level' WHERE id='$id'";
    }
    mysqli_query($koneksi, $query);
    header("Location: berita.php");
}
?>

<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Edit Berita | Raksana Admin</title>
    <link rel="icon" type="image/png" href="../foto/logo-osis.png">
</head>
<body class="h-full font-sans antialiased text-slate-300">

    <div class="flex min-h-screen relative overflow-x-hidden">
        <?php include 'sidebar.php'; ?>

        <main class="flex-1 min-w-0 bg-slate-950">
            <header class="h-16 border-b border-slate-800 bg-slate-900/80 sticky top-0 z-30 backdrop-blur-md px-4 md:px-8 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button type="button" onclick="openSidebar()" class="lg:hidden flex items-center justify-center w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 text-white hover:bg-red-600 transition-all">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>
                    
                    <h1 class="text-sm font-semibold text-slate-400">
                        Kelola <span class="hidden sm:inline">Berita</span> <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i> <span class="text-white">Edit</span>
                    </h1>
                </div>
                <div class="text-[10px] font-mono text-slate-500 hidden sm:block">EDIT_MODE_ACTIVE</div>
            </header>
            
            <div class="p-4 md:p-6 lg:p-8">
                <div class="mb-6 lg:hidden">
                    <a href="berita.php" class="text-xs text-slate-500 flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke List Berita
                    </a>
                </div>

                <div class="max-w-4xl mx-auto">
                    <form method="post" enctype="multipart/form-data" class="bg-slate-900 rounded-2xl border border-slate-800 shadow-2xl overflow-hidden">
                        
                        <div class="p-6 border-b border-slate-800 bg-slate-800/20">
                            <h2 class="text-xl font-bold text-white tracking-tight">Perbarui Informasi Berita</h2>
                        </div>

                        <div class="p-6 md:p-8 space-y-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Judul Artikel</label>
                                <input type="text" name="judul" value="<?= $d['judul'] ?>" required 
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none transition-all">
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Konten / Isi Berita</label>
                                <textarea name="isi" rows="10" required
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none transition-all"><?= $d['isi'] ?></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Tanggal Publikasi</label>
                                    <input type="date" name="tanggal" value="<?= $d['tanggal'] ?>" required 
                                        class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Kategori / Level</label>
                                    <select name="level" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition-all cursor-pointer">
                                        <option value="berita" <?= $d['level'] == 'berita' ? 'selected' : '' ?>>Berita Umum</option>
                                        <option value="pengumuman" <?= $d['level'] == 'pengumuman' ? 'selected' : '' ?>>Pengumuman Penting</option>
                                    </select>
                                </div>
                            </div>

                            <div class="pt-4 space-y-4">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block">Media Gambar</label>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 p-4 bg-slate-950 rounded-2xl border border-slate-800">
                                    <div class="sm:col-span-1">
                                        <p class="text-[9px] text-slate-600 mb-2 uppercase font-bold text-center">Preview Saat Ini</p>
                                        <img class="w-full aspect-video sm:aspect-square object-cover rounded-xl border border-slate-800" src="../upload/foto/berita/<?= $d['foto'] ?>" alt="Preview">
                                    </div>
                                    <div class="sm:col-span-2 flex flex-col justify-center">
                                        <input type="file" name="foto" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-red-600/10 file:text-red-500 hover:file:bg-red-600/20 transition-all cursor-pointer">
                                        <p class="mt-3 text-[10px] text-slate-600 leading-relaxed italic">*Pilih file baru untuk mengganti foto. Maksimal 2MB (JPG/PNG).</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 bg-slate-800/20 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-end gap-4">
                            <a href="berita.php" class="w-full sm:w-auto text-center px-6 py-3 text-xs font-bold text-slate-500 hover:text-white transition-colors order-2 sm:order-1">
                                BATAL
                            </a>
                            <button type="submit" name="update" class="w-full sm:w-auto px-8 py-3 bg-red-700 hover:bg-red-600 text-white text-xs font-bold rounded-xl transition-all shadow-xl shadow-red-900/20 order-1 sm:order-2 active:scale-95">
                                SIMPAN PERUBAHAN
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="h-10 lg:hidden"></div>
        </main>
    </div>

</body>
</html>