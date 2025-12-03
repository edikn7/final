<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman | Digiperpus</title>
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
<body class="bg-gray-100">
    <!-- Sidebar -->
    <?php include_once __DIR__ . '/../views/partials/navbar_admin.php'; ?>

    <!-- Bagian Peminjaman Buku -->
    <main class="ml-64 mt-28 p-8">

    <h1 class="text-3xl font-bold text-blue-secondary mb-6 tracking-tight">
        Manajemen Peminjaman
    </h1>
    <!-- Card Tabel -->
    <div class="bg-white p-6 rounded-xl shadow-xl">
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="bg-teal-primary text-white">
                    <th class="py-3 px-4 text-left">ID Peminjaman</th>
                    <th class="py-3 px-4 text-left">Nama Anggota</th>
                    <th class="py-3 px-4 text-left">Judul Buku</th>
                    <th class="py-3 px-4 text-left">Tanggal Pinjam</th>
                    <th class="py-3 px-4 text-left">Tanggal Kembali</th>
                    <th class="py-3 px-4 text-left">Status</th>
                    <th class="py-3 px-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
include '../config.php';
$peminjaman = mysqli_query($config, "
    SELECT 
        p.id_peminjaman,
        u.nama AS nama,
        b.judul AS judul_buku,
        p.tanggal_pinjam,
        p.tanggal_kembali,
        p.status
    FROM peminjaman p
    JOIN user u ON p.id_user = u.id
    JOIN buku b ON p.id_buku = b.id_buku
    ORDER BY p.id_peminjaman DESC
");

while($p = mysqli_fetch_array($peminjaman)){
                ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4"><?= $p['id_peminjaman']; ?></td>
                    <td class="py-3 px-4"><?= $p['nama']; ?></td>
                    <td class="py-3 px-4"><?= $p['judul_buku']; ?></td>
                    <td class="py-3 px-4"><?= $p['tanggal_pinjam']; ?></td>
                    <td class="py-3 px-4"><?= $p['tanggal_kembali']; ?></td>
                    <td class="py-3 px-4"><?= $p['status']; ?></td>
                    <td class="py-3 px-4">
                        <a href="detail_peminjaman.php?id=<?= $p['id_peminjaman']; ?>" 
                           class="text-blue-secondary hover:underline">
                            Detail
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    
    
    </main>
   
</body>
<!--- Bagian Footer -->
        <footer class="ml-64 mt-6 mb-6 p-4 text-center text-sm text-gray-500">
            &copy; 2024 DigiPerpus. All rights reserved.
        </footer>
</html>