<!-- Bagian Navbar Anggota -->
<nav class="bg-white/80 backdrop-blur-md shadow-xl border-b border-white/20 fixed w-full top-0 z-50 transition-all duration-500" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex items-center">
                <img src="../assets/img/logo_digiperpus1.png" href="index.php" alt="Logo DigiPerpus" class="h-20 w-50 rounded-3xl object-cover">
            </div>

            <!-- Navigation Menu - Center -->
            <div class="hidden md:flex flex-1 justify-center">
                <div class="flex items-center space-x-1">
                    <a href="dashboard_anggota.php" class="text-gray-800 font-semibold nav-link relative px-4 py-2 text-sm transition-all duration-300 group">
                        <span class="relative z-10">Beranda</span>
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-blue-500 group-hover:w-12 transition-all duration-300"></div>
                    </a>
                    <a href="riwayat_peminjaman.php" class="text-gray-800 font-semibold nav-link relative px-4 py-2 text-sm transition-all duration-300 group">
                        <span class="relative z-10">Peminjaman</span>
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-blue-500 group-hover:w-12 transition-all duration-300"></div>
                    </a>
                    <a href="katalog_digital.php" class="text-gray-800 font-semibold nav-link relative px-4 py-2 text-sm transition-all duration-300 group">
                        <span class="relative z-10">Katalog Digital</span>
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-blue-500 group-hover:w-16 transition-all duration-300"></div>
                    </a>
                </div>
            </div>
            <!--Dropdown Menu Kategori-->
            

            <!-- Search Bar - Right -->
            <div class="hidden md:flex items-center">
                <form action="" method="get" class="flex items-center bg-gray-50 rounded-full px-3 py-1.5 border border-gray-200 hover:border-blue-400 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input name="q" type="text" placeholder="Cari..." class="bg-transparent px-2 py-0 outline-none text-xs text-gray-700 placeholder-gray-400" />
                </form>
            </div>

            <!-- Profile Menu - Far Right -->
            <div class="relative ml-4">
                <button id="profileToggle" class="flex items-center gap-2 bg-white rounded-lg px-2 py-1 hover:shadow">
                    <img src="../assets/img/profil.png" alt="Avatar" class="h-8 w-8 rounded-full object-cover">
                    <span class="hidden md:inline text-sm"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="profileMenu" class="hidden absolute right-0 mt-2 w-44 bg-white rounded shadow py-1 z-20">
                    <a href="profil.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">Profil</a>
                    <a href="seting.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">Pengaturan</a>
                    <div class="border-t my-1"></div>
                    <a href="../logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</a>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    document.getElementById('profileToggle').addEventListener('click', function() {
        const profileMenu = document.getElementById('profileMenu');
        profileMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', function(event) {
        const profileToggle = document.getElementById('profileToggle');
        const profileMenu = document.getElementById('profileMenu');
        
        if (!profileToggle.contains(event.target) && !profileMenu.contains(event.target)) {
            profileMenu.classList.add('hidden');
        }
    });
</script>