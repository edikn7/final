<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Digiperpus</title>
    <script src ="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body, html {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'grey': '#c0c0c0ff',
                        'blue-primary': '#1e40af',
                        'blue-secondary': '#3b82f6',
                        'teal-primary': '#0d9488',
                        'teal-secondary': '#14b8a6',
                        'cyan-accent': '#06b6d4',
                        'emerald-accent': '#10b981'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-blue-50">

    <?php 
	session_start();
 
	// cek apakah yang mengakses halaman ini sudah login
	if($_SESSION['level']==""){
		header("location:../admin/login.php?pesan=gagal");
	}
 
	?>
    <!-- Bagian Sidebar -->
    <?php include_once __DIR__ .'/../views/partials/navbar_admin.php'; ?>
    
        <main class="ml-64 p-6 pt-24 min-h-screen">

           

            <!-- Konten Dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

            <!-- Card Total Buku -->
            <div class="relative bg-white rounded-lg shadow p-6 overflow-hidden group hover:shadow-lg transition-shadow duration-200">
                <span class="absolute left-0 top-0 h-full w-1 bg-gradient-to-b from-blue-secondary to-teal-500 rounded-r-md transform-gpu group-hover:scale-y-105 transition-transform duration-300"></span>
                <h2 class="text-xl font-semibold mb-4 text-blue-primary pl-4">Total Buku</h2>
                <p class="text-3xl font-bold text-teal-primary pl-4">
                    <?php
                    include '../config.php';
                    $result = mysqli_query($config, "SELECT COUNT(*) AS total_buku FROM buku");
                    $data = mysqli_fetch_assoc($result);
                    echo $data['total_buku'];
                    ?>
                </p>
            </div>

            <!-- Card Total Anggota -->
        
            <div class="relative bg-white rounded-lg shadow p-6 overflow-hidden group hover:shadow-lg transition-shadow duration-200">
                <span class="absolute left-0 top-0 h-full w-1 bg-gradient-to-b from-blue-secondary to-teal-500 rounded-r-md transform-gpu group-hover:scale-y-105 transition-transform duration-300"></span>
                <h2 class="text-xl font-semibold mb-4 text-blue-primary pl-4">Total Anggota</h2>
                <p class="text-3xl font-bold text-teal-primary pl-4">
                    <?php
                    include '../config.php';
                    $result = mysqli_query($config, "SELECT COUNT(*) AS total_anggota FROM user WHERE level='anggota'");
                    $data = mysqli_fetch_assoc($result);
                    echo $data['total_anggota'];
                    ?>

                </p>
            </div>

            <!-- Card Total Peminjaman -->
            <div class="relative bg-white rounded-lg shadow p-6 overflow-hidden group hover:shadow-lg transition-shadow duration-200">
                <span class="absolute left-0 top-0 h-full w-1 bg-gradient-to-b from-blue-secondary to-teal-500 rounded-r-md transform-gpu group-hover:scale-y-105 transition-transform duration-300"></span>
                <h2 class="text-xl font-semibold mb-4 text-blue-primary pl-4">Total Peminjaman</h2>
                <p class="text-3xl font-bold text-teal-primary pl-4">
                    <?php
                    include '../config.php';
                    $result = mysqli_query($config, "SELECT COUNT(*) AS total_peminjaman FROM peminjaman");
                    $data = mysqli_fetch_assoc($result);
                    echo $data['total_peminjaman'];
                    ?>
                </p>
            </div>

            </div>

            <!--- Bagian Statistik Peminjaman Buku -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-blue-primary mb-4">Statistik Peminjaman</h3>

            <?php
            require_once __DIR__ . '/../config.php';

            // Hitung 12 bulan terakhir (label dan default 0)
            $months = [];
            for ($i = 11; $i >= 0; $i--) {
                $ym = date('Y-m', strtotime("-$i month"));
                $label = date('M Y', strtotime("-$i month"));
                $months[$ym] = ['label' => $label, 'count' => 0];
            }

            // Ambil data peminjaman grouped by bulan (format YYYY-MM)
            $sql = "SELECT DATE_FORMAT(tanggal_pinjam, '%Y-%m') AS ym, COUNT(*) AS jumlah 
                    FROM peminjaman 
                    WHERE tanggal_pinjam >= DATE_SUB(CURDATE(), INTERVAL 11 MONTH)
                    GROUP BY ym
                    ORDER BY ym";
            $res = mysqli_query($config, $sql);
            if ($res) {
                while ($r = mysqli_fetch_assoc($res)) {
                    if (isset($months[$r['ym']])) {
                        $months[$r['ym']]['count'] = (int) $r['jumlah'];
                    }
                }
            }

            // Siapkan array untuk Chart.js
            $labels = array_map(fn($m) => $m['label'], array_values($months));
            $data = array_map(fn($m) => $m['count'], array_values($months));
            ?>

            <div class="w-full">
                <canvas id="peminjamanChart" class="w-full h-64"></canvas>
            </div>
        </div>

        <!-- Chart.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            (function(){
                const ctx = document.getElementById('peminjamanChart').getContext('2d');
                const labels = <?php echo json_encode($labels); ?>;
                const data = <?php echo json_encode($data); ?>;

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Peminjaman',
                            data: data,
                            backgroundColor: 'rgba(14,165,233,0.85)', // cyan-ish
                            borderColor: 'rgba(14,165,233,1)',
                            borderWidth: 1,
                            borderRadius: 6,
                            maxBarThickness: 40
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.parsed.y + ' peminjaman';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { color: '#374151' }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1, color: '#374151' },
                                grid: { color: 'rgba(2,6,23,0.04)' }
                            }
                        }
                    }
                });
            })();
        </script>

        <!--Buku-->

        </main>
        <!--- Bagian Footer -->
        <footer class="ml-64 mt-6 mb-6 p-4 text-center text-sm text-gray-500">
            &copy; 2024 DigiPerpus. All rights reserved.
        </footer>
    
</body>
</html>