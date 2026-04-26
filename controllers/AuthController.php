<?php
session_start();

require_once '../config/database.php';
require_once '../models/User.php';

$db = new Database();
$conn = $db->connect();

$user = new User($conn);

// ambil action
$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action == 'login') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // 🔥 ambil user dari DB
    $data = $user->login($email);

    // 🔥 cek password
    if ($data && password_verify($password, $data['password'])) {

        $_SESSION['user'] = $data;

        // redirect sesuai role
        if ($data['role'] == 'admin') {
            header("Location: ../views/admin.php");
        } else {
            header("Location: ../views/siswa.php");
        }
        exit;

    } else {
        header("Location: ../views/login.php?error=1");
        exit;
    }
}

// ================= REGISTER =================
if ($action == 'register') {

    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    if (!$user->register($nama, $email, $password, $role)) {
        header("Location: ../views/register.php?error=1");
        exit;
    }

    header("Location: ../views/register.php?success=1");
    exit;
}

// ================= LOGOUT =================
if ($action == 'logout') {
    session_destroy();
    header("Location: ../views/login.php");
    exit;
}