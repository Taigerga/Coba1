<?php
// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
// Pastikan user sudah login
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Simpan Berita - UNIKOM NEWS</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .result-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 600px;
            text-align: center;
        }
        .success {
            color: #28a745;
            font-size: 3rem;
            margin-bottom: 20px;
        }
        .error {
            color: #dc3545;
            font-size: 3rem;
            margin-bottom: 20px;
        }
        .btn-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
            font-weight: 600;
            color: white;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .btn-secondary {
            background: #6c757d;
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
            font-weight: 600;
            color: white;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="result-container">
        <?php
        include "db.php";

        // Debug: Cek apakah form ter-submit
        if(!isset($_POST['simpan'])) {
            echo '<div class="error">❌</div>';
            echo '<h3>Error: Form tidak terkirim dengan benar</h3>';
            echo '<p>Tombol simpan tidak dikenali</p>';
            echo '<a href="tambah_berita.php" class="btn-custom">Kembali ke Form</a>';
            echo '<a href="index.php" class="btn-secondary">Ke Beranda</a>';
            exit;
        }

        // Ambil data dari form
        $judul_id   = mysqli_real_escape_string($mysqli, $_POST['judul_berita_indonesia']);
        $judul_en   = mysqli_real_escape_string($mysqli, $_POST['judul_berita_inggris']);
        $isi_id     = mysqli_real_escape_string($mysqli, $_POST['isi_berita_indonesia']);
        $isi_en     = mysqli_real_escape_string($mysqli, $_POST['isi_berita_inggris']);
        
        $ekstensi_diperbolehkan = array('png','jpg','jpeg','pdf','zip','doc','docx');
        $nama = $_FILES['file']['name'];
        $x = explode('.', $nama);
        $ekstensi = strtolower(end($x));
        $ukuran = $_FILES['file']['size'];
        $file_tmp = $_FILES['file']['tmp_name'];

        // Validasi file
        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
            // upload file dilarang lebih dari 1 MB (1024x1024 = 1048576)
            if($ukuran < 1048576){
                // Buat direktori berkas jika belum ada
                if (!is_dir('berkas')) {
                    mkdir('berkas', 0777, true);
                }

                // Upload file
                if(move_uploaded_file($file_tmp, 'berkas/'.$nama)){
                    // Simpan ke database
                    $hasil = mysqli_query($mysqli, 
                        "INSERT INTO berita VALUES (NULL, NOW(), '$judul_id', '$judul_en', '$isi_id', '$isi_en', '$nama', 'T')");
                    
                    if($hasil){
                        echo '<div class="success">✅</div>';
                        echo '<h3>Proses Upload File: Berhasil!</h3>';
                        echo '<p>Berita telah berhasil disimpan ke database.</p>';
                        echo '<div class="mt-4">';
                        echo '<a href="index.php" class="btn-custom">Kembali Ke Halaman Berita</a>';
                        echo '<a href="tambah_berita.php" class="btn-secondary">Tambah Berita Lagi</a>';
                        echo '</div>';
                    }
                    else{
                        echo '<div class="error">❌</div>';
                        echo '<h3>Proses Upload File: Gagal!</h3>';
                        echo '<p>Error: ' . mysqli_error($mysqli) . '</p>';
                        echo '<div class="mt-4">';
                        echo '<a href="index.php" class="btn-secondary">Kembali Ke Halaman Berita</a>';
                        echo '<a href="tambah_berita.php" class="btn-custom">Kembali Ke Form Tambah Berita</a>';
                        echo '</div>';
                    }
                }
                else{
                    echo '<div class="error">❌</div>';
                    echo '<h3>Gagal Upload File!</h3>';
                    echo '<p>Terjadi kesalahan saat mengupload file.</p>';
                    echo '<a href="tambah_berita.php" class="btn-custom">Kembali Ke Form</a>';
                }
            }
            else{
                echo '<div class="error">❌</div>';
                echo '<h3>Ukuran File Terlalu Besar!</h3>';
                echo '<p>Maksimal ukuran file: 1 MB</p>';
                echo '<p>Ukuran file Anda: ' . round($ukuran/1024, 2) . ' KB</p>';
                echo '<a href="tambah_berita.php" class="btn-custom">Kembali Ke Form</a>';
            }
        }
        else{
            echo '<div class="error">❌</div>';
            echo '<h3>Format File Tidak Didukung!</h3>';
            echo '<p>Format yang diperbolehkan: ' . implode(', ', $ekstensi_diperbolehkan) . '</p>';
            echo '<p>Format file Anda: ' . $ekstensi . '</p>';
            echo '<a href="tambah_berita.php" class="btn-custom">Kembali Ke Form</a>';
        }

        // Tutup koneksi database
        mysqli_close($mysqli);
        ?>
    </div>
</body>
</html>