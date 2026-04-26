<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once '../config/database.php';
require_once '../models/Aspirasi.php';

$db = new Database();
$conn = $db->connect();

$asp = new Aspirasi($conn);
$data = $asp->getKategori();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Kategori</title>
    <link rel="stylesheet" href="/ujikom_pengaduan_deva/assets/css/app.css">
</head>
<body>

<div class="container">
    <h2>Data Kategori</h2>

    <!-- FORM TAMBAH -->
    <form method="POST" action="../controllers/AspirasiController.php?action=tambah_kategori">
        <input type="text" name="nama" placeholder="Nama kategori" required>
        <button class="btn btn-primary">Tambah</button>
    </form>

    <br>

    <!-- TABLE -->
    <table class="table">
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>

        <?php $no=1; foreach($data as $d): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $d['nama_kategori'] ?></td>
            <td>
                <form method="POST" action="../controllers/AspirasiController.php?action=edit_kategori">
                    <input type="hidden" name="id" value="<?= $d['id_kategori'] ?>">
                    <input type="text" name="nama" value="<?= $d['nama_kategori'] ?>">
                    <button class="btn btn-warning">Edit</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div>
        
    </div>

    <a href="admin.php" class="btn btn-primary">Kembali</a>
</div>

</body>
</html>