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

$asp = new Aspirasi($conn); // ✅ BENAR
$data = $asp->getBySiswa($_SESSION['user']['id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pengaduan</title>
    <link rel="stylesheet" href="/ujikom_pengaduan_deva/assets/css/app.css">
</head>
<body>

<div class="center-box">
    <div class="card">
        <h2>Riwayat Pengaduan</h2>

        <?php if(empty($data)): ?>
            <p>Tidak ada data</p>
        <?php endif; ?>

    <?php foreach($data as $d): ?>
    <?php $fb = $asp->getUmpanBalik($d['id']); ?>
<div class="card riwayat-item">
    <div class="riwayat-left">
        <b><?= $d['judul'] ?></b>
        <p><?= $d['isi'] ?></p>

        <span class="badge 
            <?= $d['status']=='pending' ? 'badge-pending' : 
               ($d['status']=='proses' ? 'badge-proses' : 'badge-selesai') ?>">
            <?= $d['status'] ?>
        </span>
    </div>

    <div class="riwayat-right">
   <?php if ($fb): ?>
    <button class="btn btn-success"
        data-balasan="<?= htmlspecialchars($fb['isi'], ENT_QUOTES, 'UTF-8') ?>"
        onclick="openModalFromBtn(this)">
        Lihat balasan
    </button>
<?php else: ?>
    <span class="badge badge-pending">Belum dibalas</span>
<?php endif; ?>
</div>
</div>

<?php endforeach; ?>

         <div> 

        </div>
        <div> 

        </div>

        <a href="siswa.php" class="btn btn-primary btn-block" style="margin-top:10px;">
            Kembali
        </a>
    </div>
</div>
<div id="overlay" class="modal-overlay" style="display:none;"></div>

<div id="balasModal" class="modal-box" style="display:none;">
    <div class="modal-inner">
        <h3>Balasan</h3>

        <p id="isiBalasan"></p>

        <button type="button" class="btn btn-danger btn-block" onclick="closeModal()">
            Tutup
        </button>
    </div>
</div>
<script src="/ujikom_pengaduan_deva/assets/js/app.js"></script>
</body>
</html>