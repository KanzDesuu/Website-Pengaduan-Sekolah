<?php

class User {
    private $conn;
    private $table = "users";

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // ================= LOGIN =================
public function login($email) {
    $query = "SELECT * FROM users WHERE email = :email LIMIT 1";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    // ================= REGISTER =================
   public function register($nama, $email, $password, $role) {

    // cek email
    $cek = $this->conn->prepare("SELECT id FROM users WHERE email = :email");
    $cek->bindParam(':email', $email);
    $cek->execute();

    if ($cek->rowCount() > 0) {
        return false;
    }

    // insert
    $query = "INSERT INTO users (nama, email, password, role) 
              VALUES (:nama, :email, :password, :role)";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);

    return $stmt->execute();
}

    // ================= GET ALL USER (OPSIONAL ADMIN) =================
    public function getAll() {
        $query = "SELECT id, nama, email, role FROM {$this->table}";
        $result = $this->conn->query($query);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ================= GET USER BY ID =================
    public function getById($id) {
        $query = "SELECT id, nama, email, role FROM {$this->table} WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // ================= DELETE USER (OPSIONAL) =================
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}