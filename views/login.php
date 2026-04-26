<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="/ujikom_pengaduan_deva/assets/css/app.css">
</head>
<body>

<div class="center-box">
    <form class="card" method="POST" action="../controllers/AuthController.php">

        <h2 class="auth-title">Login</h2>

        <input type="hidden" name="action" value="login">

        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button class="btn btn-primary btn-block">Login</button>

        <div class="auth-link">
            Belum punya akun? <a href="register.php">Register</a>
        </div>

    </form>
</div>

</body>
</html>