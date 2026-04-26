<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body>

<div class="center-box">
    <form class="card" method="POST" action="../controllers/AuthController.php">

        <h2 class="auth-title">Register</h2>

        <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success">Berhasil daftar! Silakan login</div>
        <?php endif; ?>

        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-error">Email sudah digunakan!</div>
        <?php endif; ?>

        <input type="hidden" name="action" value="register">

        <input type="text" name="nama" placeholder="Nama" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <input type="hidden" name="role" value="siswa">

        <button class="btn btn-primary btn-block">Register</button>

        <div class="auth-link">
            Sudah punya akun? <a href="login.php">Login</a>
        </div>

    </form>
</div>

<script src="../assets/js/app.js"></script>
</body>
</html>