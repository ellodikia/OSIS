<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['register'])) {
    $username_baru = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nama_admin = mysqli_real_escape_string($koneksi, $_POST['nama_admin']);
    $password_baru = $_POST['password'];
    $verifikasi_input = $_POST['password_verifikasi'];

    $query_cek = mysqli_query($koneksi, "SELECT password FROM user_admin WHERE username = 'Humas & Infokum'");
    $data_utama = mysqli_fetch_assoc($query_cek);
    $password_master = $data_utama['password'];

    if ($verifikasi_input === $password_master) {
        $cek_user = mysqli_query($koneksi, "SELECT id FROM user_admin WHERE username = '$username_baru'");
        
        if (mysqli_num_rows($cek_user) > 0) {
            $error = "Username sudah terdaftar!";
        } else {
            $nama_file = $_FILES['foto']['name'];
            $tmp_file = $_FILES['foto']['tmp_name'];
            
            if (!empty($nama_file)) {
                $ekstensi_boleh = array('png', 'jpg', 'jpeg');
                $x = explode('.', $nama_file);
                $ekstensi = strtolower(end($x));
                $nama_foto_baru = $username_baru . "_" . time() . "." . $ekstensi;

                if (in_array($ekstensi, $ekstensi_boleh) === true) {
                    if(!is_dir('foto_admin')) mkdir('foto_admin');
                    move_uploaded_file($tmp_file, 'foto_admin/' . $nama_foto_baru);
                    $foto_final = $nama_foto_baru;
                } else {
                    $error = "Ekstensi gambar harus PNG atau JPG!";
                }
            } else {
                $foto_final = 'default.png';
            }

            if (!isset($error)) {
                $query_simpan = "INSERT INTO user_admin (username, password, nama_admin, foto, level) 
                                 VALUES ('$username_baru', '$password_baru', '$nama_admin', '$foto_final', 'admin')";
                
                if (mysqli_query($koneksi, $query_simpan)) {
                    $success = "Akun Admin $username_baru berhasil dibuat!";
                } else {
                    $error = "Gagal menyimpan ke database.";
                }
            }
        }
    } else {
        $error = "Password Verifikasi Salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Admin | OSIS Raksana</title>
    <link rel="icon" type="image/png" href="../foto/logo-osis.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="h-full bg-slate-950 text-slate-200 font-sans antialiased">

    <div class="flex min-h-screen relative overflow-x-hidden">
        <?php include 'sidebar.php'; ?>

        <main class="flex-1 min-w-0 flex flex-col">
            <header class="h-16 border-b border-slate-800 bg-slate-900/50 flex items-center justify-between px-4 md:px-8 sticky top-0 z-30 backdrop-blur-md">
                <div class="flex items-center gap-4">
                    <button onclick="openSidebar()" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 border border-slate-700 text-white active:scale-95 transition-all">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>
                    <h1 class="text-xs md:text-sm font-medium text-slate-400 uppercase tracking-widest">
                        Pengaturan <span class="mx-2 text-slate-600">/</span> <span class="text-white">Tambah Admin</span>
                    </h1>
                </div>
            </header>

            <div class="p-4 md:p-8 flex-1">
                <div class="max-w-2xl mx-auto py-4 md:py-8">
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl md:text-3xl font-black text-white uppercase tracking-tighter italic">
                            Registrasi <span class="text-red-600 italic">Admin Baru</span>
                        </h2>
                        <p class="text-slate-500 text-xs mt-2 uppercase tracking-widest">Pastikan data yang diinput sudah benar</p>
                    </div>
                    
                    <?php if(isset($error)): ?>
                        <div class="bg-red-500/10 border-l-4 border-red-500 text-red-500 p-4 rounded-r-xl mb-6 flex items-center gap-3 animate-pulse">
                            <i class="fas fa-triangle-exclamation"></i>
                            <p class="text-sm font-bold uppercase tracking-tight"><?= $error; ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($success)): ?>
                        <div class="bg-green-500/10 border-l-4 border-green-500 text-green-500 p-4 rounded-r-xl mb-6 flex items-center gap-3">
                            <i class="fas fa-check-circle"></i>
                            <p class="text-sm font-bold uppercase tracking-tight"><?= $success; ?></p>
                        </div>
                    <?php endif; ?>

                    <form action="" method="POST" enctype="multipart/form-data" class="space-y-6 bg-slate-900/30 p-6 md:p-10 rounded-2xl border border-slate-800 shadow-2xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-red-600/5 blur-3xl rounded-full -mr-16 -mt-16"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-2">Username</label>
                                <input type="text" name="username" placeholder="cth: admin_baru" required 
                                    class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none text-white transition-all placeholder:text-slate-700">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-2">Nama Lengkap</label>
                                <input type="text" name="nama_admin" placeholder="Nama Admin" required 
                                    class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none text-white transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-2">Password Akun Baru</label>
                                <input type="password" name="password" required 
                                    class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none text-white transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-2">Foto Profil</label>
                                <div class="relative group">
                                    <input type="file" name="foto" 
                                        class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-slate-800 file:text-white hover:file:bg-red-600 file:transition-all cursor-pointer bg-slate-950 border border-slate-800 rounded-xl p-1">
                                </div>
                            </div>
                        </div>

                        <div class="bg-red-950/10 p-5 rounded-xl border border-red-900/20 mt-8">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-red-500 mb-3 flex items-center gap-2">
                                <i class="fas fa-shield-halved"></i> Otorisasi Humas & Infokum
                            </label>
                            <input type="password" name="password_verifikasi" required placeholder="Masukkan password master..."
                                class="w-full px-4 py-3 bg-slate-950 border border-red-900/30 rounded-xl focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none text-white transition-all placeholder:text-slate-800 text-sm">
                            <p class="text-[9px] text-slate-600 mt-2 italic">*Hanya admin utama yang dapat memberikan otorisasi pembuatan akun baru.</p>
                        </div>

                        <button type="submit" name="register" 
                            class="w-full bg-red-700 hover:bg-red-600 text-white font-black py-4 rounded-xl transition-all shadow-lg shadow-red-900/20 uppercase tracking-[0.2em] text-xs mt-4 active:scale-[0.98]">
                            Konfirmasi & Simpan Akun
                        </button>
                    </form>

                    <div class="mt-8 text-center">
                        <a href="dashboard.php" class="text-[10px] font-bold text-slate-600 hover:text-red-500 uppercase tracking-widest transition-colors">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="h-10 lg:hidden"></div>
        </main>
    </div>

</body>
</html>