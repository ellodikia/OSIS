// Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileNav = document.getElementById('mobileNav');
        const closeMobileMenu = document.getElementById('closeMobileMenu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileNav.classList.add('active');
        });

        closeMobileMenu.addEventListener('click', () => {
            mobileNav.classList.remove('active');
        });

        // Modal Functionality
        function showMemberDetail(memberId) {
            const modal = document.getElementById('memberModal');
            const modalName = document.getElementById('modalName');
            const modalPosition = document.getElementById('modalPosition');
            const modalPhoto = document.getElementById('modalPhoto');
            
            // Sample data - in a real app, this would come from a database
            const members = {
                'pembina': {
                    name: 'Dr. Ahmad Fauzi, M.Pd',
                    position: 'Pembina OSIS',
                    photo: 'https://randomuser.me/api/portraits/men/60.jpg',
                    class: '-',
                    nis: '-',
                    visi: 'Membimbing OSIS menjadi organisasi yang berintegritas dan berprestasi',
                    misi: [
                        'Memberikan bimbingan dan arahan kepada pengurus OSIS',
                        'Memastikan program kerja OSIS sejalan dengan visi sekolah',
                        'Menjadi penghubung antara OSIS dengan pihak sekolah'
                    ],
                    program: [
                        'Pembinaan rutin mingguan',
                        'Evaluasi program kerja bulanan',
                        'Pelatihan kepemimpinan untuk pengurus OSIS'
                    ]
                },
                'ketua': {
                    name: 'Andi Wijaya',
                    position: 'Ketua OSIS',
                    photo: 'https://randomuser.me/api/portraits/men/32.jpg',
                    class: 'XII IPA 1',
                    nis: '12345678',
                    visi: 'Mewujudkan OSIS yang aktif, kreatif, dan berprestasi',
                    misi: [
                        'Memimpin rapat rutin OSIS',
                        'Mengkoordinasikan seluruh kegiatan OSIS',
                        'Menjadi perwakilan siswa dalam hubungan dengan pihak sekolah'
                    ],
                    program: [
                        'Program mentoring adik kelas',
                        'Kegiatan bulan bahasa',
                        'Lomba antar kelas'
                    ]
                },
                'wakil': {
                    name: 'Budi Santoso',
                    position: 'Wakil Ketua OSIS',
                    photo: 'https://randomuser.me/api/portraits/women/44.jpg',
                    class: 'XII IPS 2',
                    nis: '12345679',
                    visi: 'Mendukung ketua dalam menciptakan OSIS yang solid',
                    misi: [
                        'Menggantikan ketua saat berhalangan',
                        'Mengkoordinasikan kegiatan departemen',
                        'Memantau pelaksanaan program kerja'
                    ],
                    program: [
                        'Program pengembangan karakter siswa',
                        'Kegiatan team building pengurus OSIS',
                        'Monitoring evaluasi kegiatan'
                    ]
                },
                // Add data for other members similarly
                'sekretaris': {
                    name: 'Citra Dewi',
                    position: 'Sekretaris Umum',
                    photo: 'https://randomuser.me/api/portraits/women/65.jpg',
                    class: 'XI IPA 3',
                    nis: '12345680',
                    visi: 'Menciptakan administrasi OSIS yang tertib dan teratur',
                    misi: [
                        'Membuat notulensi rapat',
                        'Mengarsipkan dokumen OSIS',
                        'Mengelola surat-menyurat'
                    ],
                    program: [
                        'Digitalisasi arsip OSIS',
                        'Pelatihan administrasi untuk pengurus',
                        'Pembuatan laporan kegiatan'
                    ]
                }
            };

            const member = members[memberId] || {
                name: 'Nama Anggota',
                position: 'Jabatan',
                photo: '',
                class: 'Kelas',
                nis: 'NIS',
                visi: 'Visi akan ditampilkan di sini',
                misi: ['Misi 1', 'Misi 2', 'Misi 3'],
                program: ['Program 1', 'Program 2']
            };

            modalName.textContent = member.name;
            modalPosition.textContent = member.position;
            modalPhoto.src = member.photo;
            document.getElementById('modalClass').textContent = `Kelas: ${member.class}`;
            document.getElementById('modalNis').textContent = `NIS: ${member.nis}`;
            document.getElementById('modalVisi').textContent = member.visi;
            
            const misiList = document.getElementById('modalMisi');
            misiList.innerHTML = '';
            member.misi.forEach(misi => {
                const li = document.createElement('li');
                li.textContent = misi;
                misiList.appendChild(li);
            });
            
            const programList = document.getElementById('modalProgram');
            programList.innerHTML = '';
            member.program.forEach(program => {
                const li = document.createElement('li');
                li.textContent = program;
                programList.appendChild(li);
            });

            modal.classList.add('active');
        }

        function closeModal() {
            document.getElementById('memberModal').classList.remove('active');
        }

        // Close modal when clicking outside
        window.addEventListener('click', (e) => {
            const modal = document.getElementById('memberModal');
            if (e.target === modal) {
                closeModal();
            }
        });