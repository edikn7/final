<!--Detail Peminjaman Buku-->
<?php
include '../config.php';
$id_peminjaman = $_GET['id'];
$query = mysqli_query($config, "
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
    WHERE p.id_peminjaman = '$id_peminjaman'
");
$peminjaman = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peminjaman Buku | Digiperpus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'blue-primary': '#1e40af',
                        'blue-secondary': '#3b82f6',
                        'teal-primary': '#0d9488',
                        'teal-secondary': '#14b8a6',
                    }
                }
            }
        }
    </script>
</head>
<body>
    <!-- Sidebar -->
    <?php include_once __DIR__ . '/../views/partials/navbar_admin.php'; ?>

    <main class="ml-64 mt-28 p-8">
        <h1 class="text-3xl font-bold text-blue-secondary mb-6 tracking-tight">
            Detail Peminjaman Buku
        </h1>

        <div class="bg-white items-center p-6 rounded-xl shadow-xl max-w-lg">
            <div class="mb-4 items-center">
                <label class="block text-gray-700 font-medium mb-2">ID Peminjaman:</label>
                <input type="text" value="<?= $peminjaman['id_peminjaman']; ?>" disabled 
                       class="w-full px-3 py-2 bg-gray-100 border border-gray-200 rounded">
            </div>
            <div class="mb-4 items-center">
                <label class="block text-gray-700 font-medium mb-2">Nama Anggota:</label>
                <input type="text" value="<?= $peminjaman['nama']; ?>" disabled 
                       class="w-full px-3 py-2 bg-gray-100 border border-gray-200 rounded">
            </div>
            <div class="mb-4 items-center">
                <label class="block text-gray-700 font-medium mb-2">Judul Buku:</label>
                <input type="text" value="<?= $peminjaman['judul_buku']; ?>" disabled 
                       class="w-full px-3 py-2 bg-gray-100 border border-gray-200 rounded">
            </div>
            <div class="mb-4 items-center">
                <label class="block text-gray-700 font-medium mb-2">Tanggal Pinjam:</label>
                <input type="text" value="<?= $peminjaman['tanggal_pinjam']; ?>" disabled 
                       class="w-full px-3 py-2 bg-gray-100 border border-gray-200 rounded">
            </div>
            <div class="mb-4 items-center">
                <label class="block text-gray-700 font-medium mb-2">Tanggal Kembali:</label>
                <input type="text" value="<?= $peminjaman['tanggal_kembali']; ?>"
                          class="w-full px-3 py-2 bg-gray-100 border border-gray-200 rounded" disabled>
            </div>
            <div class="mb-4 items-center">
                <label class="block text-gray-700 font-medium mb-2">Status:</label>
                <input type="text" value="<?= $peminjaman['status']; ?>" disabled 
                       class="w-full px-3 py-2 bg-gray-100 border border-gray-200 rounded">
            </div>

            <a href="kelola_peminjaman.php" 
               class="inline-block bg-blue-secondary text-white px-6 py-2 rounded-lg shadow hover:bg-blue-primary transition-colors duration-200">
                Kembali ke Daftar Peminjaman
            </a>
        </div>
    </main>
    <footer>
        <div class="ml-64 mt-6 mb-6 p-4 text-center text-sm text-gray-500">
            &copy; 2024 Digiperpus. All rights reserved.
        </div>
    </footer>
</body>
    
</html>