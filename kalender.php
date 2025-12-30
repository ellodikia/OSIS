<?php
session_start();
include 'koneksi.php'; 

$is_admin = isset($_SESSION['level']) && $_SESSION['level'] == 'admin';

$sql_kegiatan = "SELECT * FROM kegiatan ORDER BY tanggal ASC";
$events_data = [];
$kegiatan_result = $koneksi->query($sql_kegiatan);

if ($kegiatan_result) {
    while($row = $kegiatan_result->fetch_assoc()) {
        $events_data[] = [
            'id' => $row['id'],
            'date' => date('Y-m-d', strtotime($row['tanggal'])), 
            'title' => htmlspecialchars($row['judul']),
            'time' => htmlspecialchars($row['waktu']),
            'location' => htmlspecialchars($row['lokasi'])
        ];
    }
}
$events_json = json_encode($events_data);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Kegiatan | OSIS Raksana Medan</title>
    <link rel="icon" type="image/png" href="foto/logo-osis.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: { 700: '#800000', 800: '#660000', 900: '#4a0404', 50: '#fff5f5' }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #fdfaf5; }
        
        .calendar-container { border-radius: 15px; overflow: hidden; border: 1px solid #e5e7eb; background: #fff; }
        .calendar-table { width: 100%; table-layout: fixed; border-collapse: collapse; }
        .calendar-table th { background-color: #800000; color: white; padding: 10px 0; font-size: 0.75rem; }
        
        .calendar-table td { 
            height: 50px; vertical-align: middle; text-align: center; 
            border: 1px solid #f3f4f6; cursor: pointer; font-weight: 500; transition: 0.2s;
            font-size: 0.875rem;
        }

        @media (min-width: 768px) {
            .calendar-table th { font-size: 0.85rem; padding: 12px 0; }
            .calendar-table td { height: 75px; font-size: 1rem; }
        }

        .calendar-table td:hover { background-color: #fef2f2; }
        .today { background-color: #fbbf24 !important; color: #4a0404 !important; font-weight: 800 !important; }
        
        .has-event { position: relative; color: #800000; font-weight: bold; }
        .has-event::after {
            content: ''; position: absolute; bottom: 5px; left: 50%;
            transform: translateX(-50%); width: 4px; height: 4px;
            background-color: #800000; border-radius: 50%;
        }
        @media (min-width: 768px) {
            .has-event::after { width: 5px; height: 5px; bottom: 8px; }
        }

        .custom-scroll::-webkit-scrollbar { width: 4px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #800000; border-radius: 10px; }
    </style>
</head>
<body class="font-sans antialiased text-slate-900">

<?php include 'navbar.php'; ?>

<main class="max-w-7xl mx-auto px-4 md:px-6 py-6 md:py-10">
    
    <div class="flex justify-center mb-6 md:mb-10">
        <div class="bg-white px-5 py-3 md:px-8 md:py-4 rounded-xl md:rounded-2xl shadow-sm border border-gray-100 text-center w-full md:w-auto">
            <p id="current-datetime" class="text-maroon-800 font-bold text-sm md:text-xl"></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 md:gap-10">
        
        <div class="lg:col-span-7 bg-white p-4 md:p-8 rounded-[1.5rem] md:rounded-[2.5rem] shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6 md:mb-8">
                <button id="prev-month" class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center bg-maroon-800 text-white rounded-lg md:rounded-xl hover:bg-maroon-700 transition">
                    <i class="fas fa-chevron-left text-xs md:text-base"></i>
                </button>
                <h2 id="current-month-year" class="text-base md:text-2xl font-black text-maroon-900 uppercase tracking-tight"></h2>
                <button id="next-month" class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center bg-maroon-800 text-white rounded-lg md:rounded-xl hover:bg-maroon-700 transition">
                    <i class="fas fa-chevron-right text-xs md:text-base"></i>
                </button>
            </div>

            <div class="calendar-container">
                <table class="calendar-table">
                    <thead>
                        <tr>
                            <th>Sen</th><th>Sel</th><th>Rab</th><th>Kam</th><th>Jum</th><th>Sab</th><th class="text-red-400">Min</th>
                        </tr>
                    </thead>
                    <tbody id="calendar-table-body"></tbody>
                </table>
            </div>
        </div>

        <div class="lg:col-span-5 flex flex-col gap-6 md:gap-8">
            
            <div class="bg-white p-6 md:p-8 rounded-[1.5rem] md:rounded-[2.5rem] shadow-sm border border-gray-100 order-1 lg:order-none">
                <h3 class="text-lg md:text-xl font-black text-maroon-900 mb-4 md:mb-6 flex items-center gap-3">
                    <i class="fas fa-bolt text-yellow-500"></i> AGENDA TERDEKAT
                </h3>
                <div id="upcoming-list" class="space-y-3 md:space-y-4 max-h-[250px] md:max-h-[300px] overflow-y-auto custom-scroll pr-1 md:pr-2"></div>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-[1.5rem] md:rounded-[2.5rem] shadow-sm border border-gray-100 order-2 lg:order-none">
                <h3 class="text-md md:text-lg font-bold text-maroon-900 mb-4">
                    DETAIL: <span id="selected-date-label" class="text-red-600 text-sm md:text-lg italic">Pilih Tanggal</span>
                </h3>
                <div id="events-detail-container" class="min-h-[80px] md:min-h-[100px] flex flex-col justify-center">
                    <p class="text-center text-gray-400 italic text-xs md:text-sm">Klik tanggal untuk melihat info</p>
                </div>
            </div>
        </div>
    </div>
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
<script>
    const eventsData = <?= $events_json ?>;
    let currentDisplayDate = new Date();

    function updateClock() {
        const now = new Date();
        const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
        const timeStr = now.getHours().toString().padStart(2, '0') + ':' + 
                        now.getMinutes().toString().padStart(2, '0') + ':' + 
                        now.getSeconds().toString().padStart(2, '0');
        document.getElementById('current-datetime').innerText = now.toLocaleDateString('id-ID', options) + ' | ' + timeStr;
    }
    setInterval(updateClock, 1000);
    updateClock();

    function renderCalendar() {
        const year = currentDisplayDate.getFullYear();
        const month = currentDisplayDate.getMonth();
        document.getElementById('current-month-year').innerText = new Intl.DateTimeFormat('id-ID', { month: 'long', year: 'numeric' }).format(currentDisplayDate);

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const tbody = document.getElementById('calendar-table-body');
        tbody.innerHTML = '';

        let adjustedFirstDay = (firstDay === 0) ? 6 : firstDay - 1;
        let date = 1;

        for (let i = 0; i < 6; i++) {
            let row = document.createElement('tr');
            let filled = false;
            for (let j = 0; j < 7; j++) {
                let cell = document.createElement('td');
                if (i === 0 && j < adjustedFirstDay) {
                    cell.innerHTML = "";
                } else if (date > daysInMonth) {
                    cell.innerHTML = "";
                } else {
                    filled = true;
                    const dStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
                    cell.innerText = date;
                    
                    const today = new Date().toISOString().split('T')[0];
                    if (dStr === today) cell.classList.add('today');
                    if (eventsData.some(e => e.date === dStr)) cell.classList.add('has-event');
                    
                    cell.onclick = () => showDetail(dStr);
                    date++;
                }
                row.appendChild(cell);
            }
            if (filled) tbody.appendChild(row);
        }
        renderUpcoming();
    }

    function showDetail(dateStr) {
        const d = new Date(dateStr);
        const formattedLabel = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
        document.getElementById('selected-date-label').innerText = formattedLabel;
        
        const filtered = eventsData.filter(e => e.date === dateStr);
        const container = document.getElementById('events-detail-container');
        
        if (filtered.length > 0) {
            container.innerHTML = filtered.map(e => `
                <div class="p-4 md:p-5 bg-maroon-50 rounded-xl md:rounded-2xl border-l-4 md:border-l-8 border-maroon-800 shadow-sm transition-all hover:scale-[1.01] mb-2">
                    <h5 class="font-black text-maroon-900 mb-1 uppercase text-xs md:text-sm leading-tight">${e.title}</h5>
                    <div class="text-[10px] md:text-[11px] text-maroon-700 space-y-1">
                        <p><i class="fas fa-clock w-4"></i> ${e.time || '--:--'}</p>
                        <p><i class="fas fa-map-marker-alt w-4"></i> ${e.location}</p>
                    </div>
                </div>
            `).join('');
        } else {
            container.innerHTML = `<p class="text-center text-gray-400 text-xs md:text-sm italic py-4">Tidak ada agenda pada tanggal ini.</p>`;
        }
    }

    function renderUpcoming() {
        const list = document.getElementById('upcoming-list');
        const today = new Date().toISOString().split('T')[0];
        const upcoming = eventsData.filter(e => e.date >= today).slice(0, 4);

        if (upcoming.length > 0) {
            list.innerHTML = upcoming.map(e => `
                <div class="flex items-center gap-3 md:gap-4 p-3 md:p-4 rounded-xl md:rounded-2xl bg-gray-50 border border-gray-100 hover:bg-white hover:shadow-md transition cursor-pointer" onclick="showDetail('${e.date}')">
                    <div class="bg-maroon-800 text-white w-10 h-10 md:w-12 md:h-12 rounded-lg md:rounded-xl flex items-center justify-center shrink-0">
                        <i class="fas fa-calendar-alt text-sm md:text-base"></i>
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="font-bold text-maroon-900 text-xs md:text-sm truncate">${e.title}</h4>
                        <p class="text-[9px] md:text-[10px] text-gray-500 uppercase font-bold tracking-widest">${e.date}</p>
                    </div>
                </div>
            `).join('');
        } else {
            list.innerHTML = `<p class="text-center text-gray-400 text-xs md:text-sm">Belum ada agenda mendatang.</p>`;
        }
    }

    document.getElementById('prev-month').onclick = () => { currentDisplayDate.setMonth(currentDisplayDate.getMonth() - 1); renderCalendar(); };
    document.getElementById('next-month').onclick = () => { currentDisplayDate.setMonth(currentDisplayDate.getMonth() + 1); renderCalendar(); };

    renderCalendar();
</script>
</body>
</html>