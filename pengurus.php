<?php
include 'koneksi.php';

$sql_pengurus = "SELECT * FROM pengurus ORDER BY id ASC";
$pengurus_result = $koneksi->query($sql_pengurus);

$data_pembina = [];
$data_ketua_wakil = [];
$data_bph = [];
$data_departemen = [];

if ($pengurus_result) {
    while ($row = $pengurus_result->fetch_assoc()) {
        $jabatan_lower = trim(strtolower($row['jabatan']));

        if (strpos($jabatan_lower, 'pembina') !== false) {
            $data_pembina[] = $row;
        } elseif (strpos($jabatan_lower, 'ketua osis') !== false || strpos($jabatan_lower, 'wakil ketua osis') !== false) {
            $data_ketua_wakil[] = $row;
        } elseif (strpos($jabatan_lower, 'sekretaris') !== false || strpos($jabatan_lower, 'bendahara') !== false) {
            $data_bph[] = $row;
        } else {
            $data_departemen[] = $row;
        }
    }
}

$departemen_grouped = [];
foreach ($data_departemen as $dep) {
    $title = $dep['jabatan'];
    if (preg_match('/(Keagamaan|Kreativitas Sastra dan Budaya|Bahasa Asing|Kesehatan|Prestasi|Humas|Pengamanan)/i', $title, $matches)) {
        $group_key = $matches[0];
    } else {
        $group_key = "Lainnya";
    }
    $departemen_grouped[$group_key][] = $dep;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Pengurus | OSIS Raksana Medan</title>
    <link rel="icon" type="image/png" href="foto/logo-osis.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: { 700: '#800000', 800: '#660000', 900: '#4a0404', 950: '#1a0202' }
                    }
                }
            }
        }
    </script>
    <style>
        .bg-pattern { background-color: #fdfaf5; background-image: url("https://www.transparenttextures.com/patterns/cubes.png"); }
    </style>
</head>
<body class="bg-pattern font-sans antialiased text-slate-900">

<?php include 'navbar.php'; ?>

<main class="max-w-7xl mx-auto px-4 md:px-6 py-10 md:py-16">
    <div class="text-center mb-10 md:mb-16">
        <h1 class="text-2xl md:text-4xl font-black text-maroon-900 mb-3 tracking-tight uppercase px-4">Struktur Pengurus OSIS</h1>
        <div class="w-12 md:w-16 h-1 bg-red-600 mx-auto rounded-full"></div>
    </div>

    <?php
    function render_cards($data, $border_color = 'border-maroon-700/10', $tag_color = 'text-cyan-600 bg-gray-50') {
        foreach($data as $item): ?>
            <div class="bg-white p-6 md:p-12 rounded-[2rem] md:rounded-[3.5rem] shadow-xl border border-gray-100 text-center hover:shadow-2xl hover:-translate-y-2 md:hover:-translate-y-3 transition-all duration-300 w-full sm:w-[calc(50%-1.25rem)] lg:w-[calc(33.333%-2.5rem)]">
                <img src="uploads/pengurus/<?= $item['foto'] ?>" 
                     class="w-32 h-32 md:w-40 md:h-40 mx-auto rounded-full object-cover border-4 <?= $border_color ?> shadow-md mb-6 md:mb-8">
                <h3 class="text-xl md:text-2xl font-black text-maroon-900 mb-2"><?= $item['nama'] ?></h3>
                <p class="<?= $tag_color ?> font-bold text-[10px] md:text-sm px-4 py-1.5 rounded-full inline-block uppercase tracking-wider">
                    <?= $item['jabatan'] ?>
                </p>
            </div>
        <?php endforeach;
    }
    ?>

    <section class="mb-16 md:mb-20">
        <div class="flex items-center gap-3 mb-8 border-b-2 border-maroon-900/10 pb-4">
            <i class="fas fa-user-tie text-lg md:text-xl text-maroon-900"></i>
            <h2 class="text-lg md:text-xl font-bold text-maroon-900 uppercase tracking-wide">Pembina OSIS</h2>
        </div>
        <div class="flex flex-wrap justify-center gap-5 md:gap-10">
            <?php render_cards($data_pembina, 'border-maroon-700/10', 'text-blue-600 bg-blue-50'); ?>
        </div>
    </section>

    <section class="mb-16 md:mb-20">
        <div class="flex items-center gap-3 mb-8 border-b-2 border-maroon-900/10 pb-4">
            <i class="fas fa-crown text-lg md:text-xl text-maroon-900"></i>
            <h2 class="text-lg md:text-xl font-bold text-maroon-900 uppercase tracking-wide">Ketua & Wakil Ketua</h2>
        </div>
        <div class="flex flex-wrap justify-center gap-5 md:gap-10">
            <?php render_cards($data_ketua_wakil, 'border-red-600', 'text-gray-500 bg-gray-50'); ?>
        </div>
    </section>

    <section class="mb-16 md:mb-20">
        <div class="flex items-center gap-3 mb-8 border-b-2 border-maroon-900/10 pb-4">
            <i class="fas fa-briefcase text-lg md:text-xl text-maroon-900"></i>
            <h2 class="text-lg md:text-xl font-bold text-maroon-900 uppercase tracking-wide">Badan Pengurus Harian</h2>
        </div>
        <div class="flex flex-wrap justify-center gap-5 md:gap-10">
            <?php render_cards($data_bph); ?>
        </div>
    </section>

    <section class="mb-16 md:mb-20">
        <div class="flex items-center gap-3 mb-8 border-b-2 border-maroon-900/10 pb-4">
            <i class="fas fa-users-cog text-lg md:text-xl text-maroon-900"></i>
            <h2 class="text-lg md:text-xl font-bold text-maroon-900 uppercase tracking-wide">Departemen</h2>
        </div>

        <?php foreach($departemen_grouped as $group_name => $members): ?>
            <div class="mb-12 md:mb-16">
                <div class="inline-flex items-center gap-3 mb-6 md:mb-8">
                    <div class="w-1.5 h-5 md:w-2 md:h-6 bg-red-600 rounded-full"></div>
                    <h3 class="text-md md:text-lg font-black text-maroon-800 uppercase tracking-wider">Dep. <?= $group_name ?></h3>
                </div>
                
                <div class="flex flex-wrap justify-center gap-5 md:gap-10">
                    <?php render_cards($members, 'border-maroon-700/10', 'text-gray-500 bg-gray-50'); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</main>

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

</body>
</html>