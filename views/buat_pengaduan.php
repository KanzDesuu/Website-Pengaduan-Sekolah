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

$asp = new Aspirasi($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buat Pengaduan</title>
    <link rel="stylesheet" href="/ujikom_pengaduan_deva/assets/css/app.css">
</head>
<body>

<div class="center-box">
    <div class="card">
        <h2>Buat Pengaduan</h2>

        <form method="POST" action="../controllers/AspirasiController.php?action=insert">
    
    <input type="text" name="judul" placeholder="Judul" required>

    <textarea name="isi" placeholder="Isi Pengaduan" required></textarea>

    <select name="kategori" required>
        <option value="">-- Pilih Kategori --</option>

        <?php 
        $kategoriList = $asp->getKategori();
        foreach($kategoriList as $k): 
        ?>
            <option value="<?= $k['nama_kategori'] ?>">
                <?= $k['nama_kategori'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button class="btn btn-primary btn-block">Kirim</button>
</form>

<button class="btn btn-success btn-block" style="margin-top:10px;"
    onclick="window.location.href='siswa.php'">
    Kembali
</button>
    </div>
</div>
<script src="/ujikom_pengaduan_deva/assets/js/app.js"></script>
</body>
</html>