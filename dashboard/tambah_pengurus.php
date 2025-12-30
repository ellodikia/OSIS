<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';

if(isset($_POST['simpan'])) {
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
            $query = "INSERT INTO pengurus (nama, jabatan, keterangan, visi_misi, foto) VALUES ('$nama', '$jabatan', '$keterangan', '$visi_misi', '$foto_baru')";
        }
    } else {
        $query = "INSERT INTO pengurus (nama, jabatan, keterangan, visi_misi, foto) VALUES ('$nama', '$jabatan', '$keterangan', '$visi_misi', '')";
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
    <title>Tambah Pengurus | Admin Raksana</title>
    <link rel="icon" type="image/png" href="../foto/logo-osis.png">
</head>
<body class="h-full font-sans antialiased text-slate-300">

    <div class="flex min-h-screen relative overflow-x-hidden">
        <?php include 'sidebar.php'; ?>

        <main class="flex-1 min-w-0 bg-slate-950">
            <header class="h-16 border-b border-slate-800 bg-slate-900/80 sticky top-0 z-30 backdrop-blur-md px-4 md:px-8 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button type="button" onclick="openSidebar()" class="lg:hidden flex items-center justify-center w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 text-white shadow-lg">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>
                    <h1 class="text-sm font-semibold text-white tracking-wide">
                        <span class="text-slate-500">Pengurus</span> 
                        <span class="mx-2 text-slate-700">/</span> 
                        Tambah Pengurus
                    </h1>
                </div>
            </header>
            
            <div class="p-4 md:p-8">
                <div class="max-w-5xl mx-auto">
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                        <div>
                            <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Entri Personil</h2>
                            <p class="text-slate-500 text-sm mt-1 font-medium italic">Silahkan lengkapi biodata pengurus baru.</p>
                        </div>
                        <a href="pengurus.php" class="inline-flex items-center justify-center text-[11px] font-bold text-slate-400 hover:text-white transition-all uppercase tracking-widest bg-slate-900/50 px-5 py-3 rounded-xl border border-slate-800 w-fit">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                        </a>
                    </div>

                    <div class="bg-slate-900/40 border border-slate-800 rounded-[2rem] overflow-hidden shadow-2xl backdrop-blur-sm">
                        <form method="post" enctype="multipart/form-data" class="p-6 md:p-10">
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                                
                                <div class="lg:col-span-5 flex flex-col items-center">
                                    <label class="block w-full text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 text-center">Foto Profil</label>
                                    <div class="relative group cursor-pointer" onclick="document.getElementById('foto-input').click()">
                                        <div class="w-48 h-48 md:w-56 md:h-56 rounded-[2.5rem] overflow-hidden border-4 border-slate-800 bg-slate-950 shadow-2xl transition-all duration-500 group-hover:border-red-600">
                                            <img src="https://ui-avatars.com/api/?name=User&background=450a0a&color=f87171&bold=true&size=512" class="w-full h-full object-cover" id="preview">
                                        </div>
                                        <div class="absolute inset-0 flex flex-col items-center justify-center bg-red-950/60 opacity-0 group-hover:opacity-100 transition-all rounded-[2.5rem] backdrop-blur-sm">
                                            <i class="fa-solid fa-camera text-2xl text-white mb-2"></i>
                                            <span class="text-[9px] font-black text-white uppercase tracking-widest">Ganti Foto</span>
                                        </div>
                                    </div>
                                    <input type="file" name="foto" id="foto-input" accept="image/*" onchange="previewImage(event)" class="hidden">
                                    <p class="mt-4 text-[10px] text-slate-500 italic">Klik pada gambar untuk mengunggah</p>
                                </div>

                                <div class="lg:col-span-7 space-y-6">
                                    <div class="group">
                                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                                        <input type="text" name="nama" placeholder="Masukkan nama lengkap" required 
                                            class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white focus:border-red-600 transition-all text-sm outline-none shadow-inner">
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Jabatan</label>
                                            <div class="relative">
                                                <select name="jabatan" class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white focus:border-red-600 transition-all text-sm outline-none appearance-none cursor-pointer shadow-inner">
                                                    <option value="Pembina OSIS">Pembina OSIS</option>
                                                    <option value="Ketua OSIS">Ketua OSIS</option>
                                                    <option value="Wakil Ketua OSIS">Wakil Ketua OSIS</option>
                                                    <option value="Sekretaris">Sekretaris</option>
                                                    <option value="Bendahara">Bendahara</option>
                                                    <option value="Anggota">Anggota</option>
                                                </select>
                                                <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-600 pointer-events-none text-xs"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Keterangan</label>
                                            <input type="text" name="keterangan" placeholder="Periode 2024/2025" 
                                                class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white focus:border-red-600 transition-all text-sm outline-none shadow-inner">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Visi & Misi</label>
                                        <textarea name="visi_misi" rows="5" required placeholder="Tuliskan visi misi di sini..."
                                            class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white focus:border-red-600 transition-all resize-none text-sm leading-relaxed outline-none shadow-inner"></textarea>
                                    </div>

                                    <div class="pt-4">
                                        <button type="submit" name="simpan" class="w-full bg-red-700 hover:bg-red-600 text-white font-black py-5 rounded-2xl transition-all shadow-xl active:scale-[0.98] text-[11px] uppercase tracking-[0.2em]">
                                            <i class="fa-solid fa-save mr-2"></i> Simpan Data Pengurus
                                        </button>
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
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>