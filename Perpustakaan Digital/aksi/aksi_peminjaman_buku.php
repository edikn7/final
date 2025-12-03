<?php
session_start();
include '../config.php';

// Pastikan hanya anggota
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'Anggota') {
    header("Location: ../login.php");
    exit;
}

$id_buku = $_POST['id_buku'] ?? null;
$id_user = $_SESSION['user_id']; // FIX: ambil dari session

if (!$id_buku) {
    echo "<script>alert('Data tidak lengkap!'); window.location='../public/dashboard.php';</script>";
    exit;
}

// Cek apakah sudah pernah pinjam buku ini & belum dikembalikan
$cek = mysqli_query($config, "
    SELECT * FROM peminjaman 
    WHERE id_user='$id_user' 
    AND id_buku='$id_buku'
    AND status='Dipinjam'
");

if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Kamu sudah meminjam buku ini dan belum mengembalikannya!'); window.location='../public/dashboard.php';</script>";
    exit;
}

// Cek maksimal 2 buku dipinjam
$cek_total = mysqli_query($config, "
    SELECT COUNT(*) as total FROM peminjaman 
    WHERE id_user='$id_user' 
    AND status='Dipinjam'
");

$result = mysqli_fetch_assoc($cek_total);
if ($result['total'] >= 5) {
    echo "<script>alert('Anda sudah meminjam 3 buku!'); window.location='../public/dashboard_anggota.php';</script>";
    exit;
}

// Ambil tanggal kembali dari form
$tanggal_kembali = $_POST['tanggal_kembali'] ?? null;
if (!$tanggal_kembali) {
    echo "<script>alert('Tanggal pengembalian harus diisi!'); window.location='../public/dashboard_anggota.php';</script>";
    exit;
}


// Data peminjaman
$tanggal_pinjam = date('Y-m-d');
$tanggal_kembali_input = strtotime($_POST['tanggal_kembali']);
$tanggal_pinjam_timestamp = strtotime($tanggal_pinjam);
$max_kembali = strtotime('+1 month', $tanggal_pinjam_timestamp);

if ($tanggal_kembali_input > $max_kembali) {
    echo "<script>alert('Tanggal pengembalian maksimal 1 bulan dari tanggal peminjaman!'); window.location='../public/dashboard_anggota.php';</script>";
    exit;
}
$status = "Dipinjam";

// Insert
$insert = mysqli_query($config, "
    INSERT INTO peminjaman (id_user, id_buku, tanggal_pinjam, tanggal_kembali, status)
    VALUES ('$id_user', '$id_buku', '$tanggal_pinjam', '$tanggal_kembali', '$status')
");

if ($insert) {
    echo "<script>alert('Peminjaman berhasil!'); window.location='../public/riwayat_peminjaman.php';</script>";
} else {
    echo "<script>alert('Peminjaman gagal!'); window.location='../public/dashboard.php';</script>";
}
?>
