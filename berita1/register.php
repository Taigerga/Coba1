<?php
session_start();
include "db.php";

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    $confirm = mysqli_real_escape_string($mysqli, $_POST['confirm']);

    if ($password !== $confirm) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        // Cek apakah username sudah ada
        $check = mysqli_query($mysqli, "SELECT * FROM login WHERE username='$username'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Username sudah digunakan!";
        } else {
            // Simpan akun baru (tanpa hash)
            $query = "INSERT INTO login (username, password) VALUES ('$username', '$password')";
            if (mysqli_query($mysqli, $query)) {
                $success = "Registrasi berhasil! Silakan login.";
            } else {
                $error = "Terjadi kesalahan saat menyimpan data.";
            }
        }
    }
}
?>

<html>
<head>
    <title>Daftar Akun Baru</title>
</head>
<body>
    <h2>Daftar Akun Baru</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

    <form method="post" action="">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Konfirmasi Password:</label><br>
        <input type="password" name="confirm" required><br><br>

        <button type="submit" name="submit">Daftar</button>
        <button type="button" onclick="window.location.href='login.php'">Kembali ke Login</button>
    </form>
</body>
</html>
