<?php
session_start();
include '../config.php';

// Pastikan user sudah login & level Anggota
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'Anggota') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id_buku'])) {
    echo "Error: id_buku tidak ditemukan!";
    exit;
}

$id_buku = $_GET['id_buku'];

// Ambil data buku
$queryBuku = mysqli_query($config, "SELECT * FROM buku WHERE id_buku = '$id_buku'");
$buku = mysqli_fetch_assoc($queryBuku);

if (!$buku) {
    echo "Error: Buku tidak ditemukan!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Peminjaman Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body, html {
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
        }
    </style>
</head>
<body class="bg-blue-50 min-h-screen">

<?php include_once __DIR__ .'/../views/partials/navbar_anggota.php'; ?>

<main class="p-6 pt-24">
    <div class="max-w-3xl mx-auto p-6 bg-white shadow-lg rounded-xl mt-6">

        <h2 class="text-2xl font-semibold text-center text-blue-600 mb-4">
            Form Peminjaman Buku
        </h2>

        <!-- FORM PEMINJAMAN -->
        <form action="../aksi/aksi_peminjaman_buku.php" method="POST" class="space-y-4">

            <!-- ID tersembunyi -->
            <input type="hidden" name="id_buku" value="<?= $buku['id_buku']; ?>">
            <input type="hidden" name="id_user" value="<?= $_SESSION['user_id']; ?>">

            <div class="flex">
                <!--Cover Buku-->
                <div class="flex items-start mb-4">
                    <img src="../assets/img/<?= $buku['cover']; ?>" 
                         alt="<?= $buku['judul']; ?>" 
                         class="w-40 h-56 object-cover bg-white border-2 border-gray-200 rounded-md p-2 shadow-lg">
                </div>
                
                <div class="ml-6 space-y-3 flex-1">
                    <div class="flex items-center gap-4">
                        <label class="text-gray-700 font-medium w-24">Judul Buku</label>
                        <input type="text" value="<?= $buku['judul']; ?>" disabled 
                               class="flex-1 px-3 py-1 bg-gray-100 border border-gray-200 rounded text-sm">
                    </div>

                    <div class="flex items-center gap-4">
                        <label class="text-gray-700 font-medium w-24">Pengarang</label>
                        <input type="text" value="<?= $buku['pengarang']; ?>" disabled 
                               class="flex-1 px-3 py-1 bg-gray-100 border border-gray-200 rounded text-sm">
                    </div>

                    <div class="flex items-center gap-4">
                        <label class="text-gray-700 font-medium w-24">Penerbit</label>
                        <input type="text" value="<?= $buku['penerbit']; ?>" disabled 
                               class="flex-1 px-3 py-1 bg-gray-100 border border-gray-200 rounded text-sm">
                    </div>

                    <div class="flex items-center gap-4">
                        <label class="text-gray-700 font-medium w-24">ISBN</label>
                        <input type="text" value="<?= $buku['isbn']; ?>" disabled 
                               class="flex-1 px-3 py-1 bg-gray-100 border border-gray-200 rounded text-sm">
                    </div>

                    <div class="flex items-center gap-4">
                        <label class="text-gray-700 font-medium w-24">Kategori</label>
                        <input type="text" value="<?= $buku['kategori']; ?>" disabled 
                               class="flex-1 px-3 py-1 bg-gray-100 border border-gray-200 rounded text-sm">
                    </div>

                    <div class="flex items-center gap-4">
                        <label class="text-gray-700 font-medium w-24">Tersedia</label>
                        <input type="text" value="<?= $buku['jumlah_buku']; ?>" disabled 
                               class="flex-1 px-3 py-1 bg-gray-100 border border-gray-200 rounded text-sm">
                    </div>
                    <!--tanggal peminjaman dan Pengembalian-->
                    <div class="flex items-center gap-4">
                        <label class="text-gray-700 font-medium w-24">Tgl Pinjam</label>
                        <input type="date" name="tanggal_pinjam" required
                               class="flex-1 px-3 py-1 bg-white border border-gray-300 rounded text-sm">
                    </div>
                    <div class="flex items-center gap-4">
                        <label class="text-gray-700 font-medium w-24">Tgl kembali</label>
                        <input type="date" name="tanggal_kembali" required
                               class="flex-1 px-3 py-1 bg-white border border-gray-300 rounded text-sm">
                    </div>
                    <div class="text-sm text-gray-600">
                        <em>Catatan: Pastikan untuk mengembalikan buku tepat waktu agar dapat meminjam buku lainnya.</em>
                    </div>
                </div>
            </div>

            <!-- BUTTON -->
            <div class="flex justify-between items-center mt-6 gap-4">

                <a href="dashboard_anggota.php"
                    class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    Kembali
                </a>

                <!-- BUTTON SUBMIT (BUKAN LINK LAGI) -->
                <button type="submit"
                    class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Pinjam Buku
                </button>

            </div>

        </form>

    </div>
</main>

</body>
</html>
