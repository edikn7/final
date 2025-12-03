<!--Riwayat Peminjaman Buku-->
<?php
    session_start();

    // cek apakah yang mengakses halaman ini sudah login
    if($_SESSION['level']==""){
        header("location:../index.php?pesan=gagal");
    }   

    include '../config.php';

    // ID user dari session login
    $id_user = $_SESSION['user_id'];

    // Ambil riwayat peminjaman user
   $query = mysqli_query($config, "
        SELECT 
            peminjaman.*,
            buku.judul,
            buku.pengarang AS penulis
        FROM peminjaman
        LEFT JOIN buku ON buku.id_buku = peminjaman.id_buku
        WHERE peminjaman.id_user = '$id_user'
        ORDER BY peminjaman.tanggal_pinjam DESC
");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body, html {
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
        }
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
                        'cyan-accent': '#06b6d4',
                        'emerald-accent': '#10b981'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-blue-50 min-h-screen">

    <!-- Navbar -->
    <?php include_once __DIR__ .'/../views/partials/navbar_anggota.php'; ?>

    <main class="p-8 pt-32 bg-blue-50 min-h-screen">
        
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-8">
            Riwayat Peminjaman Buku
        </h1>

        <div class="bg-white p-6 rounded-lg shadow-lg max-w-5xl mx-auto">

            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-teal-primary text-white">
                        <th class="py-3 px-4 text-left">Judul Buku</th>
                        <th class="py-3 px-4 text-left">Tanggal Pinjam</th>
                        <th class="py-3 px-4 text-left">Tanggal Kembali</th>
                        <th class="py-3 px-4 text-left">Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($data = mysqli_fetch_assoc($query)) : ?>
                        <tr class="border-b hover:bg-blue-50">
                            
                            <td class="py-3 px-4">
                                <?= $data['judul']; ?>
                                <br>
                                <span class="text-xs text-gray-500">
                                    <?= $data['penulis']; ?>
                                </span>
                            </td>

                            <td class="py-3 px-4">
                                <?= $data['tanggal_pinjam']; ?>
                            </td>

                            <td class="py-3 px-4">
                                <?= $data['tanggal_kembali']; ?>
                            </td>

                            <td class="py-3 px-4">
                                <?php if ($data['status'] == "Dipinjam") : ?>
                                    <span class="bg-yellow-400 text-white px-3 py-1 rounded text-sm">
                                        Dipinjam
                                    </span>
                                <?php else : ?>
                                    <span class="bg-green-500 text-white px-3 py-1 rounded text-sm">
                                        Dikembalikan
                                    </span>
                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </main>

</body>
</html>
