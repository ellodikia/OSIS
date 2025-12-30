<?php
include 'koneksi.php';
include 'prosesform.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>
    <link rel="icon" type="image/png" href="foto/logo-osis.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: {
                            50: '#fdf2f2',
                            100: '#fde8e8',
                            800: '#800000',
                            900: '#600000',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        #progress-bar { transition: width 0.4s ease-in-out; }
        
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #800000;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .loading-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(255, 255, 255, 0.8);
            z-index: 50;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div id="loadingOverlay" class="loading-overlay">
        <div class="loader mb-4"></div>
        <p class="font-bold text-maroon-800">Mengirim Data...</p>
    </div>

    <?php include 'navbar.php'; ?>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white shadow-2xl rounded-lg overflow-hidden border-t-4 border-maroon-800 relative">
            
            <div class="w-full bg-gray-200 h-2">
                <div id="progress-bar" class="bg-maroon-800 h-2" style="width: 0%"></div>
            </div>

            <div class="p-6 md:p-10">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl md:text-3xl font-bold text-maroon-800 uppercase tracking-tight">
                        Formulir Pendaftaran
                    </h2>
                    <span id="progress-text" class="text-sm font-bold text-maroon-800 bg-maroon-50 px-3 py-1 rounded-full">0%</span>
                </div>

                <?php echo $pesan; ?>

                <form id="regForm" method="post" class="space-y-5">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Unit Sekolah</label>
                            <select name="unit" class="step-input w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-maroon-800 focus:outline-none" required>
                                <option value="" disabled selected>Pilih Unit</option>
                                <option value="smp">SMP</option>
                                <option value="sma">SMA</option>
                                <option value="smk1">SMK 1</option>
                                <option value="smk2">SMK 2</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Kelas / Jurusan</label>
                            <select name="kelas_jurusan" class="step-input w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-maroon-800 focus:outline-none" required>
                                <option value="" disabled selected>Pilih Kelas</option>
                                <optgroup label="SMP">
                                    <option value="7">Kelas 7</option>
                                    <option value="8">Kelas 8</option>
                                    <option value="9">Kelas 9</option>
                                </optgroup>
                                <optgroup label="SMA">
                                    <option value="10">10</option>
                                    <option value="11-ipa">11 IPA</option>
                                    <option value="11-ips">11 IPS</option>
                                    <option value="12-ipa">12 IPA</option>
                                    <option value="12-ips">12 IPS</option>
                                </optgroup>
                                <optgroup label="SMK 1">
                                    <option value="10-tkj">10 TKJ</option>
                                    <option value="10-titl">10 TITL</option>
                                    <option value="10-auto-1">10 AUTO 1</option>
                                    <option value="10-auto-2">10 AUTO 2</option>
                                    <option value="11-tkj">11 TKJ</option>
                                    <option value="11-titl">11 TITL</option>
                                    <option value="11-tkro">11 TKRO</option>
                                    <option value="11-tbsm">11 TBSM</option>
                                    <option value="12-tkj">12 TKJ</option>
                                    <option value="12-titl">12 TITL</option>
                                    <option value="12-tkro">12 TKRO</option>
                                    <option value="12-tbsm">12 TBSM</option>
                                </optgroup>
                                <optgroup label="SMK 2">
                                    <option value="10-rpl">10 RPL</option>
                                    <option value="10-dkv">10 DKV</option>
                                    <option value="10-ph">10 PH</option>
                                    <option value="10-otkp">10 OTKP</option>
                                    <option value="10-akl">10 AKL</option>
                                    <option value="11-rpl">11 RPL</option>
                                    <option value="11-dkv">11 DKV</option>
                                    <option value="11-ph">11 PH</option>
                                    <option value="11-otkp">11 OTKP</option>
                                    <option value="11-akl">11 AKL</option>
                                    <option value="12-rpl">12 RPL</option>
                                    <option value="12-dkv">12 DKV</option>
                                    <option value="12-ph">12 PH</option>
                                    <option value="12-otkp">12 OTKP</option>
                                    <option value="12-akl">12 AKL</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Kategori Perlombaan</label>
                        <select name="perlombaan" class="step-input w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-maroon-800 focus:outline-none" required>
                            <option value="" disabled selected>Pilih Lomba</option>
                            <option value="futsal">Futsal</option>
                            <option value="basket">Basket</option>
                            <option value="voli">Voli</option>
                            <option value="badminton">Badminton</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Nama Tim (Jika ada)</label>
                        <input type="text" name="nama_tim" placeholder="Masukkan nama tim..." 
                               class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-maroon-800 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Nama Peserta</label>
                        <textarea name="nama_peserta" rows="3" placeholder="Jika lebih dari satu, pisahkan dengan koma" 
                                  class="step-input w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-maroon-800 focus:outline-none" required></textarea>
                    </div>

                    <div class="bg-maroon-50 p-4 rounded-lg border-l-4 border-maroon-800">
                        <p class="text-xs text-gray-700 font-medium">
                            <i class="fa-solid fa-circle-info mr-1"></i> Pastikan data sudah benar. Hubungi panitia via 
                            <a href="https://wa.me/6281234567890" class="text-green-600 font-bold hover:underline">WhatsApp <i class="fa-brands fa-whatsapp"></i></a>
                        </p>
                    </div>

                    <div class="pt-4">
                        <button type="submit" name="daftar" 
                                class="w-full bg-maroon-800 hover:bg-maroon-900 text-white font-bold py-4 rounded-xl transition duration-300 shadow-lg transform hover:-translate-y-1 active:scale-95">
                            DAFTAR
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <footer class="py-14 bg-maroon-900 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-6 flex flex-col items-center gap-6 text-center">
        <div class="bg-white p-3 rounded-2xl shadow-xl">
            <img src="image/logo-osis.png" class="h-10 w-auto">
        </div>
        <div class="flex gap-8 text-[11px] font-black uppercase tracking-[0.3em] text-slate-400">
            <a href="https://www.instagram.com/osisraksanamdn/" class="hover:text-red-600 transition">Instagram</a>
            <a href="https://www.tiktok.com/@osisraksanamedan" class="hover:text-red-600 transition">TikTok</a>
            <a href="https://youtube.com/@osisraksanadaily" class="hover:text-red-600 transition">YouTube</a>
        </div>
        <p class="text-[9px] font-bold text-gray-300 uppercase tracking-[0.5em] mt-4">&copy; <?= date('Y') ?> OSIS Raksana Medan • Humas & Infokum</p>
    </div>
</footer>

    <script>
        const inputs = document.querySelectorAll('.step-input');
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');

        function updateProgress() {
            let filledFields = 0;
            inputs.forEach(input => {
                if (input.value.trim() !== '') {
                    filledFields++;
                }
            });
            const percentage = Math.round((filledFields / inputs.length) * 100);
            progressBar.style.width = percentage + '%';
            progressText.innerText = percentage + '%';
        }

        inputs.forEach(input => {
            input.addEventListener('input', updateProgress);
            input.addEventListener('change', updateProgress);
        });

        const form = document.getElementById('regForm');
        const loader = document.getElementById('loadingOverlay');

        form.addEventListener('submit', function() {
            loader.style.display = 'flex';
        });
    </script>
</body>
</html>