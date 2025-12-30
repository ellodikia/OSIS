<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';

if (!isset($_GET['id'])) { header("Location: pengurus.php"); exit; }

$id = mysqli_real_escape_string($koneksi, $_GET['id']);
$query_data = mysqli_query($koneksi, "SELECT * FROM pengurus WHERE id='$id'");
$d = mysqli_fetch_assoc($query_data);

if (!$d) { header("Location: pengurus.php"); exit; }

if(isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $visi_misi = mysqli_real_escape_string($koneksi, $_POST['visi_misi']);

    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $target_dir = "../uploads/pengurus/";

    if($foto) {
        $foto_baru = time() . "_" . $foto;
        if(move_uploaded_file($tmp, $target_dir . $foto_baru)) {
            if(!empty($d['foto']) && file_exists($target_dir . $d['foto'])) {
                unlink($target_dir . $d['foto']);
            }
            $query = "UPDATE pengurus SET nama='$nama', jabatan='$jabatan', keterangan='$keterangan', visi_misi='$visi_misi', foto='$foto_baru' WHERE id='$id'";
        }
    } else {
        $query = "UPDATE pengurus SET nama='$nama', jabatan='$jabatan', keterangan='$keterangan', visi_misi='$visi_misi' WHERE id='$id'";
    }

    if(mysqli_query($koneksi, $query)) {
        echo "<script>window.location='pengurus.php?status=sukses';</script>";
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
    <title>Edit Pengurus | Admin Raksana</title>
    <link rel="icon" type="image/png" href="../foto/logo-osis.png">
</head>
<body class="h-full font-sans antialiased text-slate-300">

    <div class="flex min-h-screen relative">
        <?php include 'sidebar.php'; ?>

        <main class="flex-1 min-w-0 bg-slate-950 overflow-y-auto">
            <header class="h-16 border-b border-slate-800 bg-slate-900/80 sticky top-0 z-30 backdrop-blur-md px-4 md:px-8 flex items-center">
                <button type="button" onclick="toggleSidebar()" class="lg:hidden flex items-center justify-center w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 text-white mr-4">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
                <h1 class="text-sm font-semibold text-white tracking-wide uppercase">Manajemen Struktur > <span class="text-red-500">Edit</span></h1>
            </header>
            
            <div class="p-4 md:p-8 flex justify-center">
                <div class="w-full max-w-5xl">
                    
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
                        <div>
                            <h2 class="text-2xl font-black text-white tracking-tighter uppercase leading-none">Edit Profil</h2>
                            <p class="text-slate-500 text-sm mt-2 font-medium">Ubah detail informasi pengurus terpilih.</p>
                        </div>
                        <a href="pengurus.php" class="inline-flex items-center text-[10px] font-black text-slate-400 hover:text-white transition-all uppercase tracking-[0.2em] bg-slate-900 px-4 py-2 rounded-lg border border-slate-800">
                            <i class="fa-solid fa-chevron-left mr-2"></i> Kembali
                        </a>
                    </div>

                    <div class="bg-slate-900/40 border border-slate-800 rounded-[2.5rem] overflow-hidden shadow-2xl backdrop-blur-sm">
                        <form method="post" enctype="multipart/form-data" class="p-6 md:p-10">
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                                
                                <div class="lg:col-span-7 space-y-6">
                                    <div class="group">
                                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 group-focus-within:text-red-500 transition-colors">Nama Lengkap</label>
                                        <input type="text" name="nama" value="<?= htmlspecialchars($d['nama']) ?>" required 
                                            class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-red-600 transition-all text-sm">
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3">Jabatan</label>
                                            <input type="text" name="jabatan" value="<?= htmlspecialchars($d['jabatan']) ?>" required 
                                                class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-red-600 transition-all text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3">Keterangan</label>
                                            <input type="text" name="keterangan" value="<?= htmlspecialchars($d['keterangan']) ?>" 
                                                class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-red-600 transition-all text-sm">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3">Visi & Misi</label>
                                        <textarea name="visi_misi" rows="6" required
                                            class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-red-600 transition-all resize-none text-sm leading-relaxed"><?= htmlspecialchars($d['visi_misi']) ?></textarea>
                                    </div>
                                </div>

                                <div class="lg:col-span-5 flex flex-col items-center">
                                    <label class="block w-full text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 text-center">Foto Profil</label>
                                    
                                    <div class="relative group cursor-pointer" onclick="document.getElementById('foto-input').click()">
                                        <div class="w-52 h-52 md:w-64 md:h-64 rounded-[3rem] overflow-hidden border-4 border-slate-800 bg-slate-950 shadow-2xl transition-all duration-500 group-hover:border-red-600">
                                            <?php 
                                                $path_tampil = "../uploads/pengurus/" . $d['foto'];
                                                if(empty($d['foto']) || !file_exists($path_tampil)) {
                                                    $path_tampil = 'https://ui-avatars.com/api/?name='.urlencode($d['nama']).'&background=450a0a&color=f87171&bold=true&size=512';
                                                }
                                            ?>
                                            <img src="<?= $path_tampil ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" id="preview">
                                        </div>
                                        <div class="absolute inset-0 flex flex-col items-center justify-center bg-red-900/60 opacity-0 group-hover:opacity-100 transition-all rounded-[3rem] backdrop-blur-sm">
                                            <i class="fa-solid fa-camera text-3xl text-white mb-2"></i>
                                            <span class="text-[10px] font-black text-white uppercase tracking-widest">Ganti Foto</span>
                                        </div>
                                    </div>

                                    <input type="file" name="foto" id="foto-input" accept="image/*" onchange="previewImage(event)" class="hidden">
                                    
                                    <div class="w-full mt-10">
                                        <button type="submit" name="update" class="w-full bg-red-700 hover:bg-red-600 text-white font-black py-4 rounded-2xl transition-all shadow-xl active:scale-95 text-xs uppercase tracking-widest">
                                            <i class="fa-solid fa-floppy-disk mr-2 text-sm"></i> Simpan Perubahan
                                        </button>
                                        <p class="text-[9px] text-slate-600 text-center mt-4 uppercase tracking-[0.2em] font-bold italic">Raksana Admin System v2.0</p>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="h-20 lg:hidden"></div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('aside');
            if (sidebar) {
                sidebar.classList.toggle('-translate-x-full');
            }
        }

        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>