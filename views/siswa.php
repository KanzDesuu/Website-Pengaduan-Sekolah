<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
require_once '../config/database.php';
require_once '../models/Aspirasi.php';

$db = new Database();
$conn = $db->connect();

$asp = new Aspirasi($conn); // ✅ WAJIB PAKE INI

$data = $asp->getBySiswa($_SESSION['user']['id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Siswa</title>
    <link rel="stylesheet" href="/ujikom_pengaduan_deva/assets/css/app.css">
</head>
<body>

<div class="center-box">
    <div class="card">
        <h2>Halo, <?= $_SESSION['user']['nama'] ?></h2>
        <p>Selamat datang di dashboard siswa, ayo sampaikan aspirasi kamu!.</p>
       

        <!-- BUTTON -->
        <div class="btn-group">
    <button class="btn btn-primary" 
    onclick="window.location.href='buat_pengaduan.php'">
        Buat Pengaduan
    </button>

    <button class="btn btn-success" 
    onclick="window.location.href='riwayat.php'">
        Riwayat
    </button>
</div>

        <!-- LOGOUT -->
        <button class="btn btn-logout" onclick="logout()">
            Logout
        </button>
    </div>
</div>

<script src="/ujikom_pengaduan_deva/assets/js/app.js"></script>

</body>
</html>