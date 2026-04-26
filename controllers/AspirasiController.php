<?php
session_start();

require_once '../config/database.php';
require_once '../models/Aspirasi.php';

$db = new Database();
$conn = $db->connect();

$asp = new Aspirasi($conn);

// INSERT PENGADUAN
if ($_GET['action'] == 'insert') {
    $judul = $_POST['judul'] ?? '';
    $isi = $_POST['isi'] ?? '';
    $kategori = $_POST['kategori'] ?? '';

    if ($judul == '' || $isi == '' || $kategori == '') {
        die("Data tidak boleh kosong");
    }

    $asp->insert($_SESSION['user']['id'], $judul, $isi, $kategori);
    header("Location: ../views/siswa.php");
    exit;
}

// UPDATE STATUS (ADMIN)
if ($_GET['action'] == 'update') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $asp->updateStatus($id, $status);
    header("Location: ../views/admin.php");
    exit;
}

// ✅ ADMIN KIRIM UMPAN BALIK
if ($_GET['action'] == 'kirim_feedback') {

    if ($_SESSION['user']['role'] != 'admin') {
        die("Akses ditolak!");
    }

    $id_pengaduan = $_POST['id_pengaduan'];
    $isi = $_POST['isi'];
    $status = $_POST['status']; // ✅ TAMBAH INI

    $asp->tambahUmpanBalik($id_pengaduan, $isi);
    $asp->updateStatus($id_pengaduan, $status); // ✅ TAMBAH INI

    header("Location: ../views/admin.php");
    exit;
}

if ($_GET['action'] == 'edit_feedback') {

    $id = $_POST['id'];
    $isi = $_POST['isi'];
    $id_pengaduan = $_POST['id_pengaduan']; // ✅ TAMBAH
    $status = $_POST['status']; // ✅ TAMBAH

    $asp->editUmpanBalik($id, $isi);
    $asp->updateStatus($id_pengaduan, $status); // ✅ TAMBAH

    header("Location: ../views/admin.php");
    exit;
}

// tambah kategori
if (isset($_GET['action']) && $_GET['action'] == 'tambah_kategori') {
    $asp->tambahKategori($_POST['nama']);
    header("Location: ../views/kategori.php");
    exit;
}


// edit kategori
if ($_GET['action'] == 'edit_kategori') {
    $asp->editKategori($_POST['id'], $_POST['nama']);
    header("Location: ../views/kategori.php");
    exit;
}