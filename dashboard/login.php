<?php
session_start();
include '../koneksi.php'; 

if (isset($_SESSION['admin_logged_in'])) {
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM user_admin WHERE username = '$username'");
    
    if (mysqli_num_rows($query) === 1) {
        $data = mysqli_fetch_assoc($query);
        
        if ($password === $data['password']) { 
            
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user'] = $data['username'];
            $_SESSION['admin_nama'] = $data['nama_admin']; 
            $_SESSION['admin_foto'] = $data['foto'];       
            $_SESSION['admin_level'] = $data['level'];

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | OSIS Raksana</title>
    <link rel="icon" type="image/png" href="../foto/logo-osis.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: radial-gradient(circle at top left, #4a0404 0%, #1a0101 100%);
            background-attachment: fixed;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 antialiased">

    <div class="w-full max-w-[420px]">
        
        <div class="flex justify-center mb-8">
            <div class="bg-white/10 backdrop-blur-md p-4 rounded-3xl border border-white/20 shadow-2xl">
                <img src="../foto/logo-osis.png" alt="Logo" class="h-16 w-auto drop-shadow-lg">
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.5)] overflow-hidden transition-all duration-500">
            <div class="p-8 sm:p-12">
                <div class="text-center mb-8">
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-800 uppercase tracking-tighter">
                        Portal <span class="text-red-600">Admin</span>
                    </h1>
                    <p class="text-slate-400 text-xs sm:text-sm mt-1 font-medium tracking-wide">HUMAS & INFOKUM</p>
                </div>

                <?php if(isset($error)): ?>
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl flex items-center gap-3 animate-bounce">
                        <i class="fas fa-exclamation-circle text-lg"></i>
                        <p class="text-xs sm:text-sm font-bold"><?= $error; ?></p>
                    </div>
                <?php endif; ?>

                <form action="" method="POST" class="space-y-5">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-1">Username</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-300 group-focus-within:text-red-500 transition-colors">
                                <i class="fas fa-user text-sm"></i>
                            </span>
                            <input type="text" name="username" required
                                class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white transition-all text-slate-700 font-bold placeholder:text-slate-300 placeholder:font-normal"
                                placeholder="Username admin">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-1">Security Key</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-300 group-focus-within:text-red-500 transition-colors">
                                <i class="fas fa-shield-halved text-sm"></i>
                            </span>
                            <input type="password" name="password" id="password" required
                                class="w-full pl-12 pr-12 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white transition-all text-slate-700 font-bold placeholder:text-slate-300 placeholder:font-normal"
                                placeholder="••••••••">
                            
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-300 hover:text-red-600 transition-colors">
                                <i id="eye-icon" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" name="login"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-2xl shadow-[0_10px_30px_rgba(220,38,38,0.3)] transition-all active:scale-95 flex items-center justify-center gap-3 tracking-[0.2em] text-xs mt-8">
                        AUTHENTICATE <i class="fas fa-chevron-right text-[10px]"></i>
                    </button>
                </form>

                <div class="mt-8 text-center border-t border-slate-50 pt-6">
                    <a href="../index.php" class="text-slate-400 hover:text-red-600 text-[10px] transition font-black uppercase tracking-widest inline-flex items-center gap-2">
                        <i class="fas fa-arrow-left text-[9px]"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
        
        <p class="text-center text-white/20 text-[10px] font-bold mt-8 tracking-widest uppercase">
            &copy; 2024 Humas & Infokum Raksana
        </p>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>