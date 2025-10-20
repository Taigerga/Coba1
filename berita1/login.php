<?php
session_start();
include "db.php";

// Cek jika sudah login, redirect ke halaman yang diminta
if (isset($_SESSION['logged_in'])) {
    $redirect = $_GET['redirect'] ?? 'tambah_berita.php';
    header("Location: $redirect");
    exit;
}

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']); // tanpa hash

    $query = "SELECT * FROM login WHERE username='$username' AND password='$password'";
    $result = mysqli_query($mysqli, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        
        // Redirect ke halaman yang diminta atau tambah_berita.php
        $redirect = $_GET['redirect'] ?? 'tambah_berita.php';
        header("Location: $redirect");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<html>
<head>
    <title>Login</title>
    <!-- Tambahkan sedikit styling -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 400px;
            margin: 50px auto;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2 style="text-align: center;">Login untuk Tambah Berita</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post" action="">
            <label>Username:</label><br>
            <input type="text" name="username" required><br><br>
            <label>Password:</label><br>
            <input type="password" name="password" required><br><br>
            <button type="submit" name="submit">Login</button>
        </form>
        
        <p style="text-align: center; margin-top: 15px;">
            Belum punya akun? <a href="register.php">Daftar di sini</a>
        </p>
    </div>
</body>
</html>