<?php
$current_page = basename($_SERVER['PHP_SELF']);

function is_menu_active($current_page, $main_file, $sub_patterns = []) {
    if ($current_page == $main_file) return true;
    
    foreach ($sub_patterns as $pattern) {
        if (strpos($current_page, $pattern) !== false) return true;
    }
    return false;
}
?>

<div id="sidebar-overlay" onclick="openSidebar()" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity duration-300 opacity-0"></div>

<aside id="main-sidebar" class="fixed inset-y-0 left-0 z-50 w-72 flex flex-col border-r border-slate-800 bg-slate-900 transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0 min-h-screen">
    
    <div class="flex h-16 items-center px-6 border-b border-slate-800/50 justify-between">
        <div class="flex items-center">
            <div class="h-8 w-8 rounded-lg bg-white flex items-center justify-center overflow-hidden shadow-sm">
                <img src="../foto/logo-osis.png" alt="Logo" class="h-6 w-6 object-contain">
            </div>
            <span class="ml-3 text-white font-bold tracking-tight text-lg">
                Raksana<span class="text-red-600">Medan</span>
            </span>
        </div>
        
        <button onclick="openSidebar()" class="lg:hidden p-2 text-slate-400 hover:text-white transition-colors">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    <div class="px-4 py-6 border-b border-slate-800/30 bg-slate-800/20">
        <div class="flex flex-col items-center text-center">
            <div class="relative group">
                <div class="h-20 w-20 rounded-2xl border-2 border-red-600 p-1 transition-transform group-hover:rotate-3 bg-slate-800 overflow-hidden shadow-xl">
                    <?php 
                        $foto_db = $_SESSION['admin_foto'] ?? '';
                        $foto_path = (!empty($foto_db) && file_exists('foto_admin/' . $foto_db)) 
                                     ? 'foto_admin/' . $foto_db 
                                     : 'foto_admin/default.png';
                    ?>
                    <img src="<?= $foto_path ?>" alt="Profile" class="h-full w-full rounded-xl object-cover">
                </div>
                <div class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full bg-green-500 border-2 border-slate-900 shadow-sm"></div>
            </div>

            <div class="mt-3 overflow-hidden w-full">
                <p class="text-sm font-bold text-white tracking-wide truncate px-2">
                    <?= $_SESSION['admin_nama'] ?? 'Administrator'; ?>
                </p>
                <p class="text-[10px] font-medium text-red-500 uppercase tracking-widest mt-1">
                    <?= $_SESSION['admin_level'] ?? 'Admin'; ?>
                </p>
            </div>
        </div>
    </div>
<div class="p-4 border-t border-slate-800 bg-slate-900/50">
        <a href="logout.php" class="flex items-center justify-center w-full py-3 rounded-xl bg-slate-800 text-slate-400 hover:bg-red-600 hover:text-white transition-all text-xs font-bold uppercase tracking-widest">
            <i class="fa-solid fa-right-from-bracket mr-2"></i> Keluar
        </a>
    </div>
    <nav class="flex-1 space-y-1 px-3 py-6 overflow-y-auto">
        <?php
        function nav_item($link, $icon, $label, $current_page, $sub_patterns = []) {
            $is_active = is_menu_active($current_page, $link, $sub_patterns);

            $class = $is_active 
                ? 'bg-red-600/10 text-red-500 border-l-4 border-red-600 font-semibold shadow-[inset_10px_0_15px_-10px_rgba(220,38,38,0.2)]' 
                : 'text-slate-400 hover:bg-slate-800/50 hover:text-white font-medium border-l-4 border-transparent';
            
            echo "<a href='$link' class='group flex items-center rounded-r-lg px-3 py-3 text-sm transition-all $class'>
                    <i class='fa-solid $icon mr-3 w-5 text-center text-lg'></i>
                    $label
                  </a>";
        }

        nav_item('dashboard.php', 'fa-house', 'Dashboard', $current_page);
        
        nav_item('berita.php', 'fa-newspaper', 'Kelola Berita', $current_page, ['berita.php', 'tambah_berita', 'edit_berita']);
        
        nav_item('pengurus.php', 'fa-user-group', 'Kelola Pengurus', $current_page, ['pengurus.php', 'tambah_pengurus', 'edit_pengurus']);
        
        nav_item('kalender.php', 'fa-calendar', 'Kelola Kalender', $current_page, ['kalender.php', 'tambah_kegiatan', 'edit_kegiatan', 'tambah_kalender']);
        
        nav_item('gallery.php', 'fa-image', 'Kelola Gallery', $current_page, ['gallery.php', 'tambah_gallery', 'edit_gallery']);

        nav_item('form.php', 'fa-file', 'Kelola Formulir', $current_page, ['form.php', 'tambah_form', 'edit_form']);
        ?>
    </nav>

</aside>

<script>
    function openSidebar() {
        const sidebar = document.getElementById('main-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        
        const isClosed = sidebar.classList.contains('-translate-x-full');

        if (isClosed) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.add('opacity-100');
            }, 10);
            document.body.style.overflow = 'hidden';
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.remove('opacity-100');
            setTimeout(() => {
                overlay.classList.add('hidden');
                document.body.style.overflow = 'auto'; 
            }, 300);
        }
    }
</script>