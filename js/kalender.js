// Real-time clock
function updateDateTime() {
    const now = new Date();
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit' 
    };
    document.getElementById('current-datetime').textContent = now.toLocaleDateString('id-ID', options);
}
setInterval(updateDateTime, 1000);
updateDateTime();

// Calendar Data
let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

// Format events data dari PHP dengan benar
function formatEventsFromPHP(eventsData) {
    const monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
    
    return eventsData.map(event => {
        const eventDate = new Date(event.date);
        const formattedDate = `${eventDate.getDate()} ${monthNames[eventDate.getMonth()]}`;
        
        return {
            ...event,
            date: formattedDate,
            originalDate: event.date // Simpan original date untuk referensi
        };
    });
}

let events = [];

function generateCalendar(month, year) {
    const calendarTable = document.getElementById('calendar-table');
    const monthYearDisplay = document.getElementById('current-month-year');
    calendarTable.innerHTML = '';
    
    const monthNames = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
    
    const shortMonthNames = [
        "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", 
        "Jul", "Agu", "Sep", "Okt", "Nov", "Des"
    ];
    
    monthYearDisplay.textContent = `${monthNames[month]} ${year}`;
    
    // Urutan hari: Senin sampai Minggu
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
    
    // Adjust untuk mulai dari Senin (1) bukan Minggu (0)
    // Jika Sunday (0) -> menjadi 6, Monday (1) -> 0, Tuesday (2) -> 1, etc.
    const adjustedFirstDay = firstDay === 0 ? 6 : firstDay - 1;
    
    let date = 1;
    
    for (let i = 0; i < 6; i++) {
        if (date > daysInMonth) break;
        
        const row = document.createElement('tr');
        
        for (let j = 0; j < 7; j++) {
            const cell = document.createElement('td');
            
            if (i === 0 && j < adjustedFirstDay) {
                cell.textContent = '';
                cell.classList.add('empty');
            } else if (date > daysInMonth) {
                cell.textContent = '';
                cell.classList.add('empty');
            } else {
                cell.textContent = date;
                const today = new Date();
                
                // Highlight hari ini
                if (date === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                    cell.classList.add('today');
                }
                
                // Format: "1 Sep", "2 Sep", etc.
                const eventDate = `${date} ${shortMonthNames[month]}`;
                const event = events.find(e => e.date === eventDate);
                
                if (event) { 
                    cell.classList.add('has-event'); 
                    cell.setAttribute('data-event-id', event.id); 
                }
                
                date++;
            }
            
            row.appendChild(cell);
        }
        
        calendarTable.appendChild(row);
    }
    
    // Update events list untuk bulan ini
    updateEventsListForMonth(month, year);
    
    // Trigger section animation
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => {
        if (isElementInViewport(section)) {
            section.classList.add('visible');
        }
    });
}

function updateEventsListForMonth(month, year) {
    const monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
    const currentMonthName = monthNames[month];
    
    // Filter events untuk bulan ini
    const monthEvents = events.filter(event => {
        return event.date.includes(currentMonthName);
    });
    
    const list = document.getElementById('events-list');
    const monthDisplay = document.getElementById('current-month-events');
    
    monthDisplay.textContent = monthNames[month];
    list.innerHTML = '';
    
    if (monthEvents.length === 0) {
        const li = document.createElement('li');
        li.innerHTML = `
            <div style="text-align: center; padding: 15px; color: #777;">
                <i class="fas fa-calendar-times"></i> Tidak ada kegiatan terjadwal untuk ${monthNames[month]} ${year}
            </div>
        `;
        list.appendChild(li);
        return;
    }
    
    monthEvents.forEach(event => {
        const li = document.createElement('li');
        li.innerHTML = `
            <div class="event-date">${event.date}</div>
            <div class="event-details">
                <h4>${event.title}</h4>
                <p>${event.location}, ${event.time}</p>
            </div>
        `;
        
        li.addEventListener('click', () => openModal(event));
        list.appendChild(li);
    });
}

// Fungsi inisialisasi yang akan dipanggil dari PHP
function initCalendar(eventsData) {
    events = formatEventsFromPHP(eventsData);
    generateCalendar(currentMonth, currentYear);
    renderEventsList();
}

// Fungsi render events list utama (semua events)
function renderEventsList() {
    // Fungsi ini sekarang hanya untuk inisialisasi
    // List events per bulan ditangani oleh updateEventsListForMonth
    updateEventsListForMonth(currentMonth, currentYear);
}

document.getElementById('prev-month').addEventListener('click', () => {
    currentMonth--;
    
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    
    generateCalendar(currentMonth, currentYear);
});

document.getElementById('next-month').addEventListener('click', () => {
    currentMonth++;
    
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    
    generateCalendar(currentMonth, currentYear);
});

function openModal(event) {
    document.getElementById('modal-title').textContent = event.title;
    document.getElementById('modal-date').textContent = `${event.date} ${currentYear}`;
    document.getElementById('modal-time').textContent = event.time;
    document.getElementById('modal-location').textContent = event.location;
    document.getElementById('modal-person').textContent = event.person;
    document.getElementById('modal-description').textContent = event.description;
    
    const list = document.getElementById('modal-preparations');
    list.innerHTML = '';
    
    event.preparations.forEach(prep => {
        const li = document.createElement('li');
        li.textContent = prep;
        list.appendChild(li);
    });
    
    document.getElementById('event-modal').style.display = 'flex';
}

document.querySelector('.close-modal').addEventListener('click', () => {
    document.getElementById('event-modal').style.display = 'none';
});

document.querySelector('.share-btn').addEventListener('click', () => {
    alert('Fitur berbagi akan membuka pilihan platform sosial media.');
});

document.querySelector('.reminder-btn').addEventListener('click', () => {
    alert('Pengingat telah ditambahkan ke kalender Anda!');
});

// Initialize calendar and events
// generateCalendar(currentMonth, currentYear); // Dipindahkan ke initCalendar
// renderEventsList(); // Dipindahkan ke initCalendar

// Event delegation for calendar cells
document.addEventListener('click', e => {
    if (e.target.classList.contains('has-event')) {
        const id = parseInt(e.target.getAttribute('data-event-id'));
        const event = events.find(ev => ev.id === id);
        
        if (event) openModal(event);
    }
});

// Mobile menu functionality
const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
const nav = document.querySelector('.nav');
const overlay = document.querySelector('.nav-overlay');
const body = document.body;

if (mobileMenuBtn && nav) {
    mobileMenuBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleMobileMenu();
    });
    
    if (overlay) {
        overlay.addEventListener('click', () => {
            closeMobileMenu();
        });
    }
    
    // Close menu when clicking on a link
    nav.addEventListener('click', (e) => {
        if (e.target.tagName === 'A') {
            closeMobileMenu();
        }
    });
    
    function toggleMobileMenu() {
        nav.classList.toggle('active');
        
        if (overlay) {
            overlay.classList.toggle('active');
        }
        
        mobileMenuBtn.innerHTML = nav.classList.contains('active') ? '✕' : '☰';
        
        // Prevent body scroll when menu is open
        if (nav.classList.contains('active')) {
            body.style.overflow = 'hidden';
        } else {
            body.style.overflow = '';
        }
    }
    
    function closeMobileMenu() {
        if (nav.classList.contains('active')) {
            nav.classList.remove('active');
            
            if (overlay) {
                overlay.classList.remove('active');
            }
            
            mobileMenuBtn.innerHTML = '☰';
            body.style.overflow = '';
        }
    }
}

// Function to check if element is in viewport for animations
function isElementInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
        rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.9 &&
        rect.bottom >= 0
    );
}

// Handle scroll animation for sections
function handleScrollAnimation() {
    const sections = document.querySelectorAll('.section');
    
    sections.forEach(section => {
        if (isElementInViewport(section)) {
            section.classList.add('visible');
        }
    });
}

window.addEventListener('scroll', handleScrollAnimation);
window.addEventListener('load', handleScrollAnimation);
handleScrollAnimation();

