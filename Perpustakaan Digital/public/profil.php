<!--Profil Anggota-->
<?php
session_start();
include '../config.php';
// Pastikan user sudah login & level Anggota
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'Anggota') {
    header("Location: ../login.php");
    exit;
}
// ID user dari session login
$id_user = $_SESSION['id'];
// Ambil data profil user
$queryProfil = mysqli_query($config, "SELECT * FROM user WHERE id = '$id_user'");
$profil = mysqli_fetch_assoc($queryProfil);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Anggota</title>
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
<?php include_once __DIR__ .'/../views/partials/navbar_anggota.php'; ?>
<main class="p-6 pt-24">
    <div class="max-w-3xl mx-auto p-6 bg-white shadow-lg rounded-xl mt-6">

        <h2 class="text-2xl font-semibold text-center text-blue-600 mb-4">
            Profil Anggota
        </h2>
        <!-- Foto Profil dan Informasi -->
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
            <!-- Foto Profil -->
            <div class="flex-shrink-0">
            <img src="../assets/img/<?= $profil['foto_profil'] ?: 'default_profile.png'; ?>" 
                 alt="Foto Profil" 
                 class="w-32 h-32 object-cover rounded-full border-4 border-blue-secondary">
            </div>
            
            <!-- Informasi Profil -->
            <div class="space-y-4 flex-1">
            <div class="flex items-center gap-4">
                <label class="text-gray-700 font-medium w-32">Nama Lengkap</label>
                <input type="text" value="<?= $profil['nama']; ?>" disabled 
                   class="flex-1 px-3 py-1 bg-gray-100 border border-gray-200 rounded text-sm">
            </div>
            <div class="flex items-center gap-4">
                <label class="text-gray-700 font-medium w-32">Email</label>
                <input type="text" value="<?= $profil['email']; ?>" disabled 
                   class="flex-1 px-3 py-1 bg-gray-100 border border-gray-200 rounded text-sm">
            </div>
            <div class="flex items-center gap-4">
                <label class="text-gray-700 font-medium w-32">No. Telepon</label>
                <input type="text" value="<?= $profil['no_telepon']; ?>" disabled 
                   class="flex-1 px-3 py-1 bg-gray-100 border border-gray-200 rounded text-sm">
            </div>
            <div class="flex items-center gap-4">
                <label class="text-gray-700 font-medium w-32">Alamat</label>
                <textarea disabled 
                   class="flex-1 px-3 py-1 bg-gray-100 border border-gray-200 rounded text-sm resize-none"><?= $profil['alamat']; ?></textarea>
            </div>
            <div class="flex items-center gap-4">
                <label class="text-gray-700 font-medium w-32">Bergabung</label>
                <input type="text" value="<?= date('d M Y', strtotime($profil['tanggal_bergabung'])); ?>" disabled 
                   class="flex-1 px-3 py-1 bg-gray-100 border border-gray-200 rounded text-sm">
            </div>


            
            
        </div>
        </main>
        <footer class="mt-6 mb-6 p-4 text-center text-sm text-gray-500">
            &copy; <?= date('Y'); ?> Digiperpus. All rights reserved.
        </footer>
</body>
</html>
