// Mobile menu and sidebar toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');
        const closeSidebar = document.getElementById('closeSidebar');
        
        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.add('active');
        });
        
        closeSidebar.addEventListener('click', () => {
            sidebar.classList.remove('active');
        });

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

        // Calendar functionality
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();

        // Sample events data
        const events = [
            {
                id: 1,
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
                id: 2,
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
                id: 3,
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
                id: 4,
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

        // Generate calendar
        function generateCalendar(month, year) {
            const calendarTable = document.getElementById('calendar-table');
            const monthYearDisplay = document.getElementById('current-month-year');
            
            // Clear existing table
            calendarTable.innerHTML = '';
            
            // Set month and year title
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", 
                               "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            monthYearDisplay.textContent = `${monthNames[month]} ${year}`;
            
            // Create day headers
            const dayNames = ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"];
            const headerRow = document.createElement('tr');
            
            dayNames.forEach(day => {
                const th = document.createElement('th');
                th.textContent = day;
                headerRow.appendChild(th);
            });
            
            calendarTable.appendChild(headerRow);
            
            // Calculate days in month and starting day
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const firstDay = new Date(year, month, 1).getDay();
            // Adjust for week starting on Monday (0 = Monday, 6 = Sunday)
            const adjustedFirstDay = firstDay === 0 ? 6 : firstDay - 1;
            
            let date = 1;
            for (let i = 0; i < 6; i++) {
                // Stop if we've exceeded the number of days in the month
                if (date > daysInMonth) break;
                
                const row = document.createElement('tr');
                
                for (let j = 0; j < 7; j++) {
                    const cell = document.createElement('td');
                    
                    if (i === 0 && j < adjustedFirstDay) {
                        // Empty cells before the first day of the month
                        cell.textContent = '';
                    } else if (date > daysInMonth) {
                        // Empty cells after the last day of the month
                        cell.textContent = '';
                    } else {
                        // Cells with dates
                        cell.textContent = date;
                        
                        // Highlight today
                        const today = new Date();
                        if (date === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                            cell.classList.add('today');
                        }
                        
                        // Add event marker if date has an event
                        const eventDate = `${date} ${monthNames[month].substring(0, 3)}`;
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
        }

        // Render events list
        function renderEventsList() {
            const eventsList = document.getElementById('events-list');
            eventsList.innerHTML = '';
            
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
        }

        // Month navigation
        document.getElementById('prev-month').addEventListener('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            generateCalendar(currentMonth, currentYear);
        });

        document.getElementById('next-month').addEventListener('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            generateCalendar(currentMonth, currentYear);
        });

        // Modal functions
        function openModal(event) {
            const modal = document.getElementById('event-modal');
            const modalTitle = document.getElementById('modal-title');
            const modalDate = document.getElementById('modal-date');
            const modalTime = document.getElementById('modal-time');
            const modalLocation = document.getElementById('modal-location');
            const modalPerson = document.getElementById('modal-person');
            const modalDescription = document.getElementById('modal-description');
            const modalPreparations = document.getElementById('modal-preparations');
            
            modalTitle.textContent = event.title;
            modalDate.textContent = event.date + ' 2023';
            modalTime.textContent = event.time;
            modalLocation.textContent = event.location;
            modalPerson.textContent = event.person;
            modalDescription.textContent = event.description;
            
            // Clear and populate preparations list
            modalPreparations.innerHTML = '';
            event.preparations.forEach(prep => {
                const li = document.createElement('li');
                li.textContent = prep;
                modalPreparations.appendChild(li);
            });
            
            modal.style.display = 'block';
            
            // Close modal when clicking outside
            window.onclick = function(e) {
                if (e.target == modal) {
                    modal.style.display = 'none';
                }
            }
        }

        // Close modal
        document.querySelector('.close-modal').addEventListener('click', function() {
            document.getElementById('event-modal').style.display = 'none';
        });

        // Share button
        document.querySelector('.share-btn').addEventListener('click', function() {
            alert('Fitur berbagi akan membuka pilihan platform sosial media.');
        });

        // Reminder button
        document.querySelector('.reminder-btn').addEventListener('click', function() {
            alert('Pengingat telah ditambahkan ke kalender Anda!');
        });

        // Initialize calendar and events
        generateCalendar(currentMonth, currentYear);
        renderEventsList();

        // Event delegation for calendar cells
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('has-event')) {
                const eventId = parseInt(e.target.getAttribute('data-event-id'));
                const event = events.find(e => e.id === eventId);
                if (event) openModal(event);
            }
        });