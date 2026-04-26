<?php
require_once '../config/database.php';

class Aspirasi {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insert($siswa_id, $judul, $isi, $kategori) {
        $stmt = $this->conn->prepare("INSERT INTO aspirasi (siswa_id, judul, isi, kategori) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$siswa_id, $judul, $isi, $kategori]);
    }

    // ✅ UMPAN BALIK
    public function tambahUmpanBalik($id_pengaduan, $isi) {
        $stmt = $this->conn->prepare("INSERT INTO umpan_balik (id_pengaduan, isi) VALUES (?, ?)");
        return $stmt->execute([$id_pengaduan, $isi]);
    }

    public function getUmpanBalik($id_pengaduan) {
        $stmt = $this->conn->prepare("SELECT * FROM umpan_balik WHERE id_pengaduan = ?");
        $stmt->execute([$id_pengaduan]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editUmpanBalik($id, $isi) {
        $stmt = $this->conn->prepare("UPDATE umpan_balik SET isi = ?, updated_at = NOW() WHERE id_umpan_balik = ?");
        return $stmt->execute([$isi, $id]);
    }
    // ambil semua kategori
public function getKategori() {
    $stmt = $this->conn->prepare("SELECT * FROM kategori");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// tambah kategori
public function tambahKategori($nama) {
    $stmt = $this->conn->prepare("INSERT INTO kategori (nama_kategori) VALUES (?)");
    return $stmt->execute([$nama]);
}

// edit kategori
public function editKategori($id, $nama) {
    $stmt = $this->conn->prepare("UPDATE kategori SET nama_kategori=? WHERE id_kategori=?");
    return $stmt->execute([$nama, $id]);
}

    public function getAll($kategori = '', $tanggal = '') {

        $query = "SELECT aspirasi.*, users.nama 
                  FROM aspirasi
                  JOIN users ON aspirasi.siswa_id = users.id
                  WHERE 1";

        if ($kategori != '') {
            $query .= " AND kategori = :kategori";
        }

        if ($tanggal != '') {
            $query .= " AND DATE(created_at) = :tanggal";
        }

        $query .= " ORDER BY aspirasi.id DESC";

        $stmt = $this->conn->prepare($query);

        if ($kategori != '') {
            $stmt->bindParam(':kategori', $kategori);
        }

        if ($tanggal != '') {
            $stmt->bindParam(':tanggal', $tanggal);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBySiswa($id) {
        $stmt = $this->conn->prepare("SELECT * FROM aspirasi WHERE siswa_id=?");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE aspirasi SET status=? WHERE id=?");
        return $stmt->execute([$status, $id]);
    }
}
?>