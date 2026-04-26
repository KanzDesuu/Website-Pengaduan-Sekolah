<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

require_once '../config/database.php';
require_once '../models/Aspirasi.php';

$db = new Database();
$conn = $db->connect();

$asp = new Aspirasi($conn);

$kategori = $_GET['kategori'] ?? '';
$tanggal = $_GET['tanggal'] ?? '';

$data = $asp->getAll($kategori, $tanggal);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="/ujikom_pengaduan_deva/assets/css/app.css">
</head>
<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <h2>Dashboard Admin</h2>
        <button class="btn btn-danger"
            onclick="if(confirm('Logout?')) window.location.href='../controllers/AuthController.php?action=logout'">
            Logout
        </button>
    </div>

    <!-- FILTER -->
    <form method="GET" class="filter-box">
        <select name="kategori">
            <option value="">-- Semua Kategori --</option>

            <?php 
            $kategoriList = $asp->getKategori();
            foreach ($kategoriList as $k): 
            ?>
                <option value="<?= $k['nama_kategori'] ?>"
                    <?= ($kategori == $k['nama_kategori']) ? 'selected' : '' ?>>
                    <?= $k['nama_kategori'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="date" name="tanggal" value="<?= $tanggal ?>">
        <button class="btn btn-primary">Cari</button>
    </form>

    <!-- TOMBOL KATEGORI -->
    <div style="margin-bottom:10px; display:flex; justify-content:flex-end;">
        <button class="btn btn-primary"
            onclick="window.location.href='kategori.php'">
            Kategori
        </button>
    </div>

    <div class="table-wrapper">

        <!-- OVERLAY -->
        <div id="overlay" class="modal-overlay" style="display:none;"></div>

        <!-- MODAL INPUT -->
        <div class="modal-box" id="feedbackModal" style="display:none;">
            <div class="modal-inner">
                <h3>Kirim Umpan Balik</h3>

                <form method="POST" action="../controllers/AspirasiController.php?action=kirim_feedback">
                    <input type="hidden" name="id_pengaduan" id="aspirasi_id">

                    <textarea name="isi" placeholder="Tulis umpan balik..." required></textarea>

                    <select name="status">
        <option value="pending">Pending</option>
        <option value="proses">Proses</option>
        <option value="selesai">Selesai</option>
    </select>

                    <button class="btn btn-primary btn-block">Kirim</button>
                    <button type="button" class="btn btn-danger btn-block" onclick="closeModal()">Batal</button>
                </form>
            </div>
        </div>

        <!-- MODAL VIEW + EDIT -->
        <div class="modal-box" id="viewModal" style="display:none;">
            <div class="modal-inner">
                <h3>Umpan Balik Admin</h3>

                <div id="viewMode">
                    <div id="isiView" class="box-view"></div>
                    <button class="btn btn-primary btn-block" onclick="showEdit()">Edit</button>
                </div>

                <div id="editMode" style="display:none;">
    <form method="POST" action="../controllers/AspirasiController.php?action=edit_feedback">

        <input type="hidden" name="id" id="edit_id">
        <input type="hidden" name="id_pengaduan" id="edit_pengaduan_id">

        <textarea name="isi" id="edit_isi" required></textarea>

        <select name="status" id="edit_status">
            <option value="pending">Pending</option>
            <option value="proses">Proses</option>
            <option value="selesai">Selesai</option>
        </select>

        <button type="button" class="btn btn-primary btn-block" onclick="confirmEdit()">
            Simpan
        </button>
    </form>
</div>

                <button class="btn btn-danger btn-block" onclick="closeViewModal()">Tutup</button>
            </div>
        </div>

        <!-- TABLE -->
        <table class="table">
            <tr>
                <th>Nama</th>
                <th>Judul</th>
                <th>Isi</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

            <?php foreach ($data as $d): ?>
            <?php $fb = $asp->getUmpanBalik($d['id']); ?>

            <tr>
                <td><?= $d['nama'] ?></td>
                <td><?= $d['judul'] ?></td>
                <td><?= $d['isi'] ?></td>
                <td><?= $d['created_at'] ?></td>
                <td>
                    <span class="badge 
                        <?= $d['status']=='pending' ? 'badge-pending' : 
                           ($d['status']=='proses' ? 'badge-proses' : 'badge-selesai') ?>">
                        <?= $d['status'] ?>
                    </span>
                </td>

                <td>
                    <?php if (!$fb): ?>
                        <button class="btn btn-primary"
                            onclick="openInputModal(<?= $d['id'] ?>)">
                            Balas
                        </button>
                    <?php else: ?>
                        <button class="btn btn-success viewBtn"
    data-isi="<?= htmlspecialchars($fb['isi'], ENT_QUOTES, 'UTF-8') ?>"
    data-id="<?= $fb['id_umpan_balik'] ?>"
    data-pengaduan="<?= $d['id'] ?>"
    data-status="<?= $d['status'] ?>">
    Lihat
</button>
                    <?php endif; ?>

                    <button class="btn btn-dark"
                        onclick="window.open('cetak.php?id=<?= $d['id'] ?>', '_blank')">
                        🖨 Cetak
                    </button>
                </td>
            </tr>

            <?php endforeach; ?>
        </table>

    </div>

</div>

<script src="../assets/js/app.js"></script>

</body>
</html>