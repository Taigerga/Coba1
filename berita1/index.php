<?php
// Mulai session
session_start();
$default_lang = 'bahasa_indonesia';

// ✅ Gunakan isset agar tidak muncul warning
if (!isset($_SESSION['lang'])) {
  $_SESSION['lang'] = $default_lang;
}

if (isset($_GET['lang'])) {
  $_SESSION['lang'] = $_GET['lang'];
  header("Location: index.php");
  exit;
}

// masukan file bahasa yang sedang aktif
include $_SESSION['lang'] . '.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang_judul; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#"><?php echo $lang_judul; ?></a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
              <!-- Di dalam navbar index.php -->
              <ul class="navbar-nav me-auto">
                  <li class="nav-item">
                      <a class="nav-link" href="#"><?php echo $lang_menu_home; ?></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#"><?php echo $lang_menu_profile; ?></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#"><?php echo $lang_menu_contact; ?></a>
                  </li>
                  
                  <!-- Tombol Tambah Berita - SELALU TAMPIL -->
                  <li class="nav-item">
                      <?php if (isset($_SESSION['logged_in'])): ?>
                          <!-- Jika sudah login, langsung ke halaman tambah berita -->
                          <a class="nav-link" href="tambah_berita.php"><?php echo $lang_menu_add; ?></a>
                      <?php else: ?>
                          <!-- Jika belum login, arahkan ke login dulu dengan redirect -->
                          <a class="nav-link" href="login.php?redirect=tambah_berita.php"><?php echo $lang_menu_add; ?></a>
                      <?php endif; ?>
                  </li>
              </ul>

              <!-- Bagian kanan navbar untuk Login/Register -->
              <ul class="navbar-nav">
                  <?php if (isset($_SESSION['logged_in'])): ?>
                      <!-- Jika sudah login -->
                      <li class="nav-item">
                          <span class="nav-link">Selamat datang, <?php echo $_SESSION['username']; ?></span>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="logout.php">Logout</a>
                      </li>
                  <?php else: ?>
                      <!-- Jika belum login -->
                      <li class="nav-item">
                          <a class="nav-link" href="login.php">Login</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="register.php">Daftar</a>
                      </li>
                  <?php endif; ?>
              </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Welcome Message -->
        <div class="welcome-message">
            <?php echo $lang_selamat_datang; ?>
        </div>

        <!-- News Table -->
        <div class="news-table">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <?php if ($_SESSION['lang'] == "bahasa_indonesia"): ?>
                            <th scope="col">ID</th>
                            <th scope="col">Waktu</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Isi</th>
                            <th scope="col">Nama File</th>
                        <?php elseif ($_SESSION['lang'] == "bahasa_inggris"): ?>
                            <th scope="col">ID</th>
                            <th scope="col">Time</th>
                            <th scope="col">Title</th>
                            <th scope="col">Content</th>
                            <th scope="col">File Name</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "db.php";

                    $sql = "SELECT * FROM berita ORDER BY id_berita ASC";
                    $hasil = mysqli_query($mysqli, $sql);
                    
                    if ($hasil && mysqli_num_rows($hasil) > 0) {
                        while ($row = mysqli_fetch_assoc($hasil)) {
                            // Gunakan null coalescing operator untuk menghindari warning
                            $id_berita = $row['id_berita'] ?? '';
                            $waktu_berita = $row['waktu_berita'] ?? '';
                            $judul_id = $row['judul_id'] ?? '';
                            $judul_en = $row['judul_en'] ?? '';
                            $isi_id = $row['isi_id'] ?? '';
                            $isi_en = $row['isi_en'] ?? '';
                            $nama_file = $row['nama_file'] ?? '';
                            
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($id_berita) . "</td>";
                            echo "<td>" . htmlspecialchars($waktu_berita) . "</td>";
                            
                            if ($_SESSION['lang'] == "bahasa_inggris") {
                                echo "<td>" . htmlspecialchars($judul_en) . "</td>";
                                echo "<td>" . htmlspecialchars(substr($isi_en, 0, 100)) . "...</td>";
                            } else {
                                echo "<td>" . htmlspecialchars($judul_id) . "</td>";
                                echo "<td>" . htmlspecialchars(substr($isi_id, 0, 100)) . "...</td>";
                            }
                            
                            echo "<td><a href='berkas/$nama_file' class='file-link'>" . htmlspecialchars($nama_file) . "</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        $colspan = ($_SESSION['lang'] == "bahasa_indonesia") ? "Tidak ada data berita" : "No news data";
                        echo "<tr><td colspan='5' class='text-center'>$colspan</td></tr>";
                    }
                    
                    // Tutup koneksi database
                    mysqli_close($mysqli);
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>