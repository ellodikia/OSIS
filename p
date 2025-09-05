<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Kegiatan OSIS</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Open+Sans:wght@400;600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="kalender.css">
    <style>
        
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container header-container">
            <div class="logo-container">
                <img src="foto/logo-sekolah.png" alt="Logo Sekolah" class="logo">
                <img src="foto/logo-osis.png" alt="Logo OSIS" class="logo">
            </div>
            
            <div class="datetime-container">
                <div id="current-datetime"></div>
            </div>
            
            <nav class="desktop-nav">
                <a href="index.html">Beranda</a>
                <a href="struktur.html">Struktur OSIS</a>
                <a href="kalender.html">Kalender Kegiatan</a>
                <a href="news.html">Berita & Pengumuman</a>
            </nav>
            
            <button class="mobile-menu-btn">☰</button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container calendar-container">
        <section class="calendar-section">
            <h1>Kalender Kegiatan OSIS</h1>
            
            <div class="calendar-grid">
                <!-- Calendar Card -->
                <!-- Tambahkan di bagian kalender-card (ganti yang sebelumnya) -->
<div class="calendar-card">
    <div class="calendar-header">
        <button id="prev-month"><i class="fas fa-chevron-left"></i></button>
        <h2 id="current-month-year">November 2023</h2>
        <button id="next-month"><i class="fas fa-chevron-right"></i></button>
    </div>
    <table class="calendar-table" id="calendar-table">
        <!-- Akan diisi oleh JavaScript -->
    </table>
</div>
                
                <!-- Events Card -->
                <div class="events-card">
                    <h2>Kegiatan Mendatang</h2>
                    <ul class="events-list" id="events-list">
                        <!-- Will be filled by JavaScript -->
                    </ul>
                </div>
            </div>
        </section>
        
        
    </main>

    <!-- Modal -->
    <div class="modal" id="event-modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2 id="modal-title">Judul Kegiatan</h2>
            <div class="modal-body">
                <div class="modal-info">
                    <p><i class="fas fa-calendar-day"></i> <span id="modal-date">Tanggal</span></p>
                    <p><i class="fas fa-clock"></i> <span id="modal-time">Waktu</span></p>
                    <p><i class="fas fa-map-marker-alt"></i> <span id="modal-location">Lokasi</span></p>
                    <p><i class="fas fa-user-tie"></i> <span id="modal-person">Penanggung Jawab</span></p>
                </div>
                <div class="modal-description">
                    <h3>Deskripsi Kegiatan</h3>
                    <p id="modal-description">Deskripsi kegiatan akan muncul di sini.</p>
                    
                    <h3>Persiapan yang Diperlukan</h3>
                    <ul id="modal-preparations">
                        <!-- Will be filled by JavaScript -->
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn reminder-btn"><i class="fas fa-bell"></i> Atur Pengingat</button>
                <button class="btn share-btn"><i class="fas fa-share-alt"></i> Bagikan</button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container footer-container">
            <div class="footer-section">
                <h3>Tentang OSIS</h3>
                <p>Organisasi Siswa Intra Sekolah (OSIS) SMA Negeri 1 Contoh adalah organisasi resmi siswa yang menjadi wadah pengembangan potensi siswa melalui berbagai kegiatan.</p>
            </div>
            
            <div class="footer-section">
                <h3>Link Cepat</h3>
                <ul class="footer-links">
                    <li><a href="index.html">Beranda</a></li>
                    <li><a href="struktur.html">Struktur OSIS</a></li>
                    <li><a href="kalender.html">Kalender Kegiatan</a></li>
                    <li><a href="news.html">Berita & Pengumuman</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Kontak Kami</h3>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Jl. Pendidikan No. 123, Kota Contoh</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>osis@sman1contoh.sch.id</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>(021) 1234-5678</span>
                    </div>
                </div>
            </div>
            
            <div class="footer-section">
                <h3>Sosial Media</h3>
                <div class="social-media">
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                </div>
                <div class="newsletter">
                    <p>Berlangganan newsletter:</p>
                    <form class="subscribe-form">
                        <input type="email" placeholder="Email Anda">
                        <button type="submit"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; 2023 OSIS SMA Negeri 1 Contoh. All Rights Reserved.</p>
                <p class="credits">Dikembangkan oleh Tim IT OSIS</p>
            </div>
        </div>
    </footer>

    <script>
/* ============================
   Data Kegiatan OSIS
============================ */
const events = [
    {
        id: 1,
        date: '1 Nov',
        title: 'Rapat Perencanaan',
        time: '13.00 - 15.00 WIB',
        location: 'Ruang OSIS',
        person: 'Ketua OSIS',
        description: 'Rapat awal bulan untuk merencanakan kegiatan OSIS selama bulan November. Akan dibahas pembagian tugas dan anggaran untuk setiap kegiatan.',
        preparations: [
            'Membawa proposal kegiatan',
            'Daftar anggaran kegiatan',
            'Notulensi rapat'
        ]
    },
    {
        id: 2,
        date: '15 Nov',
        title: 'Rapat Koordinasi OSIS',
        time: '14.00 WIB',
        location: 'Aula Sekolah',
        person: 'Ketua OSIS',
        description: 'Rapat koordinasi bulanan untuk membahas program kerja dan evaluasi kegiatan OSIS selama bulan ini. Akan dibahas juga persiapan untuk acara Pentas Seni akhir bulan.',
        preparations: [
            'Membawa proposal kegiatan',
            'Menyiapkan laporan kegiatan',
            'Membawa alat tulis'
        ]
    },
    {
        id: 3,
        date: '18 Nov',
        title: 'Lomba Kebersihan Kelas',
        time: '08.00 - 12.00 WIB',
        location: 'Seluruh ruang kelas',
        person: 'Seksi Kebersihan',
        description: 'Lomba kebersihan kelas antar kelas dengan penilaian dari tim juri OSIS dan guru. Kriteria penilaian meliputi kebersihan lantai, kerapian meja, kebersihan jendela, dan kreativitas dekorasi.',
        preparations: [
            'Menyiapkan peralatan kebersihan',
            'Koordinasi dengan wali kelas',
            'Menyiapkan hadiah untuk pemenang'
        ]
    },
    {
        id: 4,
        date: '25 Nov',
        title: 'Pentas Seni',
        time: '08.00-14.00 WIB',
        location: 'Lapangan sekolah',
        person: 'Seksi Seni & Budaya',
        description: 'Pentas seni tahunan yang menampilkan berbagai bakat siswa SMA Negeri 1 Contoh. Akan ada pertunjukan musik, tari, drama, dan pameran karya seni siswa.',
        preparations: [
            'Latihan rutin peserta pentas',
            'Penyiapan panggung dan sound system',
            'Undangan untuk orang tua dan tamu'
        ]
    },
    {
        id: 5,
        date: '30 Nov',
        title: 'Pengumpulan Proposal Kegiatan',
        time: 'Sampai jam 15.00 WIB',
        location: 'Ruangan OSIS',
        person: 'Sekretaris OSIS',
        description: 'Batas akhir pengumpulan proposal kegiatan untuk program kerja OSIS semester depan. Proposal harus sudah disetujui oleh pembina OSIS dan memenuhi format yang ditentukan.',
        preparations: [
            'Format proposal dapat diunduh di website',
            'Konsultasi dengan pembina OSIS',
            'Print proposal rangkap 2'
        ]
    }
];

/* ============================
   Utility
============================ */
const monthNamesFull = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", 
                       "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
const monthNamesShort = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", 
                        "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

/* ============================
   Mobile Menu
============================ */
document.querySelector('.mobile-menu-btn')?.addEventListener('click', () => {
    document.querySelector('nav.desktop-nav').classList.toggle('active');
});

/* ============================
   Waktu Real-Time
============================ */
function updateDateTime() {
    const now = new Date();
    const options = { 
        weekday: 'long', year: 'numeric', month: 'long', 
        day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit'
    };
    document.getElementById('current-datetime').textContent = now.toLocaleDateString('id-ID', options);
}
setInterval(updateDateTime, 1000);
updateDateTime();

/* ============================
   List Events
============================ */
const eventsList = document.getElementById('events-list');
events.forEach(event => {
    const li = document.createElement('li');
    li.innerHTML = `
        <div class="event-date">${event.date}</div>
        <div class="event-details">
            <h3>${event.title}</h3>
            <p>${event.location}, ${event.time}</p>
        </div>
    `;
    li.addEventListener('click', () => openModal(event));
    eventsList.appendChild(li);
});

/* ============================
   Calendar Generator
============================ */
let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

function generateCalendar(month, year) {
    const calendarTable = document.getElementById('calendar-table');
    const monthYearDisplay = document.getElementById('current-month-year');
    calendarTable.innerHTML = '';
    monthYearDisplay.textContent = `${monthNamesFull[month]} ${year}`;

    // header hari
    const dayNames = ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"];
    const headerRow = document.createElement('tr');
    dayNames.forEach(day => {
        const th = document.createElement('th');
        th.textContent = day;
        headerRow.appendChild(th);
    });
    calendarTable.appendChild(headerRow);

    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const firstDay = new Date(year, month, 1).getDay();
    const adjustedFirstDay = firstDay === 0 ? 6 : firstDay - 1;

    let date = 1;
    for (let i = 0; i < 6 && date <= daysInMonth; i++) {
        const row = document.createElement('tr');
        for (let j = 0; j < 7; j++) {
            const cell = document.createElement('td');
            if (i === 0 && j < adjustedFirstDay || date > daysInMonth) {
                cell.textContent = '';
            } else {
                cell.textContent = date;

                // highlight hari ini
                const today = new Date();
                if (date === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                    cell.classList.add('today');
                }

                // cek event
                const dateStr = `${date} ${monthNamesShort[month]}`;
                const event = events.find(e => e.date === dateStr);
                if (event) {
                    cell.classList.add('has-event');
                    cell.addEventListener('click', () => openModal(event));
                }
                date++;
            }
            row.appendChild(cell);
        }
        calendarTable.appendChild(row);
    }
}

// navigasi bulan
document.getElementById('prev-month').addEventListener('click', () => {
    currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
    if (currentMonth === 11) currentYear--;
    generateCalendar(currentMonth, currentYear);
});
document.getElementById('next-month').addEventListener('click', () => {
    currentMonth = (currentMonth === 11) ? 0 : currentMonth + 1;
    if (currentMonth === 0) currentYear++;
    generateCalendar(currentMonth, currentYear);
});
generateCalendar(currentMonth, currentYear);

/* ============================
   Modal
============================ */
function openModal(event) {
    document.getElementById('modal-title').textContent = event.title;
    document.getElementById('modal-date').textContent = event.date + ' 2023';
    document.getElementById('modal-time').textContent = event.time;
    document.getElementById('modal-location').textContent = event.location;
    document.getElementById('modal-person').textContent = event.person;
    document.getElementById('modal-description').textContent = event.description;

    const prepList = document.getElementById('modal-preparations');
    prepList.innerHTML = '';
    event.preparations.forEach(prep => {
        const li = document.createElement('li');
        li.textContent = prep;
        prepList.appendChild(li);
    });

    document.getElementById('event-modal').style.display = 'block';
}
document.querySelector('.close-modal').addEventListener('click', () => {
    document.getElementById('event-modal').style.display = 'none';
});
window.addEventListener('click', e => {
    if (e.target.id === 'event-modal') {
        document.getElementById('event-modal').style.display = 'none';
    }
});

/* ============================
   Extra Button Actions
============================ */
document.querySelector('.share-btn')?.addEventListener('click', () => {
    alert('Fitur berbagi akan membuka pilihan platform sosial media.');
});
document.querySelector('.reminder-btn')?.addEventListener('click', () => {
    alert('Pengingat telah ditambahkan ke kalender Anda!');
});
</script>

</body>
</html>