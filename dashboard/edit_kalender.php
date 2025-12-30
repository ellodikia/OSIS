<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';

if (!isset($_GET['id'])) { header("Location: kalender.php"); exit; }

$id = mysqli_real_escape_string($koneksi, $_GET['id']);
$query_data = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE id='$id'");
$d = mysqli_fetch_assoc($query_data);

if (!$d) { header("Location: kalender.php"); exit; }

if(isset($_POST['update'])) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $waktu = mysqli_real_escape_string($koneksi, $_POST['waktu']);
    $lokasi = mysqli_real_escape_string($koneksi, $_POST['lokasi']);
    $penanggung_jawab = mysqli_real_escape_string($koneksi, $_POST['penanggung_jawab']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    $query = "UPDATE kegiatan SET 
                tanggal='$tanggal', 
                judul='$judul', 
                waktu='$waktu', 
                lokasi='$lokasi', 
                penanggung_jawab='$penanggung_jawab', 
                deskripsi='$deskripsi' 
              WHERE id='$id'";
    
    if(mysqli_query($koneksi, $query)) {
        header('Location: kalender.php');
        exit();
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
    <title>Edit Kegiatan | Admin Raksana</title>
    <link rel="icon" type="image/png" href="../foto/logo-osis.png">
</head>
<body class="h-full font-sans antialiased text-slate-300">

    <div class="flex min-h-screen relative overflow-x-hidden">
        <?php include 'sidebar.php'; ?>

        <main class="flex-1 min-w-0 bg-slate-950 flex flex-col">
            <header class="h-16 border-b border-slate-800 bg-slate-900/50 flex items-center justify-between px-4 md:px-8 sticky top-0 z-20 backdrop-blur-md">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 border border-slate-700 text-white">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>
                    <h1 class="text-xs md:text-sm font-medium text-slate-400 uppercase tracking-widest">
                        Kelola Kalender <span class="mx-2 text-slate-600">/</span> <span class="text-white">Edit Agenda</span>
                    </h1>
                </div>
            </header>
            
            <div class="p-4 md:p-8 lg:p-12 flex justify-center">
                <div class="w-full max-w-4xl">
                    
                    <div class="border-l-4 border-red-700 bg-slate-900/20 p-6 md:p-10">
                        <div class="mb-10">
                            <h2 class="text-3xl font-black text-white tracking-tighter uppercase italic">Update Informasi Agenda</h2>
                            <p class="text-slate-500 text-sm mt-1 uppercase tracking-tighter">ID Kegiatan: #<?= $id ?></p>
                        </div>

                        <form action="" method="POST" class="space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                                
                                <div class="md:col-span-2">
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-red-600 mb-3">Judul Kegiatan</label>
                                    <input type="text" name="judul" value="<?= htmlspecialchars($d['judul']) ?>" required 
                                        class="w-full bg-transparent border-b-2 border-slate-800 py-3 text-white text-xl focus:outline-none focus:border-red-600 transition-all placeholder:text-slate-800">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-3">Tanggal Pelaksanaan</label>
                                    <input type="date" name="tanggal" value="<?= $d['tanggal'] ?>" required 
                                        class="w-full bg-slate-900/50 border border-slate-800 px-4 py-3 rounded-xl text-white focus:outline-none focus:border-red-600 transition-all [color-scheme:dark]">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-3">Waktu/Durasi</label>
                                    <input type="text" name="waktu" value="<?= htmlspecialchars($d['waktu']) ?>" required 
                                        class="w-full bg-slate-900/50 border border-slate-800 px-4 py-3 rounded-xl text-white focus:outline-none focus:border-red-600 transition-all">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-3">Lokasi / Media</label>
                                    <input type="text" name="lokasi" value="<?= htmlspecialchars($d['lokasi']) ?>" required 
                                        class="w-full bg-slate-900/50 border border-slate-800 px-4 py-3 rounded-xl text-white focus:outline-none focus:border-red-600 transition-all">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-3">Penanggung Jawab</label>
                                    <input type="text" name="penanggung_jawab" value="<?= htmlspecialchars($d['penanggung_jawab']) ?>" required 
                                        class="w-full bg-slate-900/50 border border-slate-800 px-4 py-3 rounded-xl text-white focus:outline-none focus:border-red-600 transition-all">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-3">Deskripsi Singkat</label>
                                    <textarea name="deskripsi" rows="4" required 
                                        class="w-full bg-slate-900/50 border border-slate-800 px-4 py-3 rounded-xl text-white focus:outline-none focus:border-red-600 transition-all resize-none"><?= htmlspecialchars($d['deskripsi']) ?></textarea>
                                </div>
                            </div>

                            <div class="pt-10 flex flex-col md:flex-row items-center gap-4">
                                <button type="submit" name="update" 
                                    class="w-full md:w-auto px-10 py-4 bg-red-700 hover:bg-red-600 text-white font-black text-xs uppercase tracking-[0.2em] rounded-xl transition-all shadow-lg shadow-red-900/20 active:scale-95 flex items-center justify-center">
                                    <i class="fa-solid fa-rotate mr-3"></i> Perbarui Agenda
                                </button>
                                
                                <a href="kalender.php" 
                                    class="w-full md:w-auto px-10 py-4 bg-slate-800 hover:bg-slate-700 text-slate-400 font-bold text-xs uppercase tracking-widest rounded-xl transition-all flex items-center justify-center">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="h-10 md:hidden"></div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('main-sidebar');
            if (sidebar) {
                sidebar.classList.toggle('-translate-x-full');
            }
        }
    </script>
</body>
</html>