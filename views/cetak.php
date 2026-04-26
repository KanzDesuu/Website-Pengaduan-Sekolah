<?php
require_once '../config/database.php';
require_once '../models/Aspirasi.php';

$db = new Database();
$conn = $db->connect();

$asp = new Aspirasi($conn);

$id = $_GET['id'];

$data = $conn->prepare("
    SELECT aspirasi.*, users.nama 
    FROM aspirasi
    JOIN users ON aspirasi.siswa_id = users.id
    WHERE aspirasi.id = ?
");
$data->execute([$id]);
$d = $data->fetch(PDO::FETCH_ASSOC);

// ambil umpan balik
$fb = $asp->getUmpanBalik($id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan</title>
    <style>
        body {
            font-family: Arial;
            padding: 30px;
        }
        h2 {
            text-align: center;
        }
        .box {
            margin-top: 20px;
        }
        .label {
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>LAPORAN PENGADUAN</h2>

<div class="box">
    <p><span class="label">Nama:</span> <?= $d['nama'] ?></p>
    <p><span class="label">Judul:</span> <?= $d['judul'] ?></p>
    <p><span class="label">Isi:</span><br><?= $d['isi'] ?></p>
    <p><span class="label">Kategori:</span> <?= $d['kategori'] ?></p>
    <p><span class="label">Tanggal:</span> <?= $d['created_at'] ?></p>
    <p><span class="label">Status:</span> <?= $d['status'] ?></p>
</div>

<hr>

<div class="box">
    <h3>Umpan Balik Admin</h3>

    <?php if ($fb): ?>
        <p><?= $fb['isi'] ?></p>
    <?php else: ?>
        <p><i>Belum ada umpan balik</i></p>
    <?php endif; ?>
</div>
<script>
window.onload = function() {
    window.print();
}

window.onafterprint = function() {
    window.location.href = "admin.php";
}
</script>
</body>
</html>