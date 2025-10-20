<?php
session_start();
include "db.php";

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']); // tanpa hash

    $query = "SELECT * FROM login WHERE username='$username' AND password='$password'";
    $result = mysqli_query($mysqli, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header("Location: tambah_berita.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>


<html>
<head>
    <title>Login</title>
</head>

<body>
    <center>
    <h2>Login untuk Tambah Berita</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post" action="">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit" name="submit">Login</button>
    </form>
    </center>
</body>

</html>
