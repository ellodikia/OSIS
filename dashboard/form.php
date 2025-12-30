<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM formulir ORDER BY id DESC");
$semua_data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $semua_data[] = $row;
}

function filterUnit($data, $unit) {
    $filtered = array_filter($data, function($item) use ($unit) {
        return strtolower($item['unit']) == strtolower($unit);
    });

    usort($filtered, function($a, $b) {
        return strcmp(strtolower($a['perlombaan']), strtolower($b['perlombaan']));
    });

    return $filtered;
}

$units = ['smp', 'sma', 'smk1', 'smk2'];
?>

<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
    <title>Kelola Formulir | RaksanaMedan</title>
    <link rel="icon" type="image/png" href="../foto/logo-osis.png">
    <style>
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .tab-btn.active { 
            border-bottom: 2px solid #ef4444; 
            color: white; 
            background: rgba(255,255,255,0.05);
        }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-300">

    <div class="flex min-h-screen relative">
        <?php include 'sidebar.php'; ?>

        <main class="flex-1 overflow-auto bg-slate-950">
            <header class="h-16 border-b border-slate-800 bg-slate-900/60 sticky top-0 z-30 backdrop-blur-md px-4 md:px-8 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button onclick="openSidebar()" class="lg:hidden p-2 rounded-lg bg-slate-800 text-white"><i class="fa-solid fa-bars-staggered"></i></button>
                    <h1 class="text-sm font-medium text-white tracking-tight">Data Pendaftar</h1>
                </div>
                <button onclick="exportAktif()" class="bg-green-600 hover:bg-green-700 text-white text-[10px] md:text-xs font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition-all">
                    <i class="fa-solid fa-file-excel"></i> Export Tab Aktif
                </button>
            </header>

            <div class="p-4 md:p-8">
                <div class="flex border-b border-slate-800 mb-6 overflow-x-auto whitespace-nowrap">
                    <?php foreach ($units as $index => $u): ?>
                        <button onclick="showTab('<?= $u ?>')" id="btn-<?= $u ?>" 
                                class="tab-btn px-6 py-3 text-sm font-bold uppercase tracking-widest text-slate-500 hover:text-white transition-all <?= $index === 0 ? 'active' : '' ?>">
                            <?= strtoupper($u) ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <?php foreach ($units as $index => $u): 
                    $data_unit = filterUnit($semua_data, $u);
                ?>
                    <div id="tab-<?= $u ?>" class="tab-content <?= $index === 0 ? 'active' : '' ?>">
                        <div class="mb-4 flex justify-between items-center px-2">
                            <h2 class="text-xl font-black italic uppercase text-red-500"><?= $u ?> <span class="text-slate-500 text-sm font-normal not-italic">/ <?= count($data_unit) ?> Peserta</span></h2>
                        </div>

                        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-2xl">
                            <div class="overflow-x-auto">
                                <table id="table-<?= $u ?>" class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-slate-800/50 border-b border-slate-700">
                                            <th class="p-4 text-[10px] font-black uppercase text-slate-400">Kelas</th>
                                            <th class="p-4 text-[10px] font-black uppercase text-slate-400">Lomba</th>
                                            <th class="p-4 text-[10px] font-black uppercase text-slate-400">Tim</th>
                                            <th class="p-4 text-[10px] font-black uppercase text-slate-400">Nama Peserta</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-800">
                                        <?php if(count($data_unit) > 0): ?>
                                            <?php foreach ($data_unit as $d) : ?>
                                                <tr class="hover:bg-slate-800/30 transition-colors">
                                                    <td class="p-4 text-sm font-bold text-slate-200"><?= $d['kelas_jurusan'] ?></td>
                                                    <td class="p-4 text-sm text-red-400 font-medium"><?= ucwords($d['perlombaan']) ?></td>
                                                    <td class="p-4 text-sm italic text-slate-500"><?= $d['nama_tim'] ?: '-' ?></td>
                                                    <td class="p-4 text-sm font-semibold text-white"><?= $d['nama_peserta'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="4" class="p-10 text-center text-slate-600 italic text-sm">Belum ada pendaftar di unit ini.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <script>
        function showTab(unit) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            
            document.getElementById('tab-' + unit).classList.add('active');
            document.getElementById('btn-' + unit).classList.add('active');
            
            window.activeUnit = unit;
        }

        window.activeUnit = '<?= $units[0] ?>';

        function exportAktif() {
            let table = document.getElementById("table-" + window.activeUnit);
            TableToExcel.convert(table, {
                name: "Data_Peserta_" + window.activeUnit.toUpperCase() + ".xlsx",
                sheet: { name: "Data" }
            });
        }
    </script>
</body>
</html>