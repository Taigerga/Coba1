<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}
?>

<html>
<head>
	<title>Tambah Berita - UNIKOM NEWS</title>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom CSS -->
	<style>
		body {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			min-height: 100vh;
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		}
		
		.form-container {
			background: white;
			border-radius: 15px;
			box-shadow: 0 10px 30px rgba(0,0,0,0.3);
			padding: 30px;
			margin: 30px auto;
			max-width: 800px;
		}
		
		.header-title {
			color: #2c3e50;
			font-weight: bold;
			margin-bottom: 10px;
		}
		
		.header-subtitle {
			color: #7f8c8d;
			font-size: 1.2rem;
			margin-bottom: 20px;
		}
		
		.form-label {
			font-weight: 600;
			color: #2c3e50;
			margin-bottom: 5px;
		}
		
		.form-control, .form-select {
			border: 2px solid #e9ecef;
			border-radius: 8px;
			padding: 10px;
			transition: all 0.3s ease;
		}
		
		.form-control:focus, .form-select:focus {
			border-color: #667eea;
			box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
		}
		
		.btn-primary {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			border: none;
			border-radius: 8px;
			padding: 12px 30px;
			font-weight: 600;
			transition: all 0.3s ease;
		}
		
		.btn-primary:hover {
			transform: translateY(-2px);
			box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
		}
		
		.btn-outline-secondary {
			border: 2px solid #6c757d;
			border-radius: 8px;
			padding: 12px 30px;
			font-weight: 600;
			transition: all 0.3s ease;
		}
		
		.btn-outline-secondary:hover {
			background-color: #6c757d;
			color: white;
		}
		
		.user-info {
			background: #f8f9fa;
			border-radius: 10px;
			padding: 15px;
			margin-bottom: 20px;
			border-left: 4px solid #667eea;
		}
		
		.button-container {
			display: flex;
			gap: 10px;
			justify-content: center;
			margin-top: 20px;
			flex-wrap: wrap;
		}
		
		.button-container form {
			margin: 5px;
		}
		
		.divider {
			border-top: 2px solid #e9ecef;
			margin: 25px 0;
		}
		
		textarea {
			resize: vertical;
			min-height: 120px;
		}
		
		.file-upload {
			background: #f8f9fa;
			border: 2px dashed #dee2e6;
			border-radius: 8px;
			padding: 20px;
			text-align: center;
			transition: all 0.3s ease;
		}
		
		.file-upload:hover {
			border-color: #667eea;
			background: #f0f2ff;
		}
	</style>
</head>

<body>
	<div class="container py-5">
		<div class="form-container">
			<!-- Header -->
			<div class="text-center mb-4">
				<h1 class="header-title">FORM TAMBAH BERITA</h1>
				<h3 class="header-subtitle">UNIKOM NEWS</h3>
			</div>
			
			<hr class="divider">
			
			<!-- User Info -->
			<div class="user-info">
				<p class="mb-0">Login sebagai: <b><?php echo $_SESSION['username']; ?></b></p>
			</div>

			<!-- Form -->
			<form action="simpan_berita.php" method="post" enctype="multipart/form-data">
				<div class="row">
					<!-- Judul Berita Indonesia -->
					<div class="col-md-6 mb-3">
						<label class="form-label">Judul Berita Bahasa Indonesia</label>
						<input type="text" class="form-control" name="judul_berita_indonesia" placeholder="Masukkan judul berita dalam Bahasa Indonesia" required>
					</div>
					
					<!-- Judul Berita Inggris -->
					<div class="col-md-6 mb-3">
						<label class="form-label">Judul Berita Bahasa Inggris</label>
						<input type="text" class="form-control" name="judul_berita_inggris" placeholder="Enter news title in English" required>
					</div>
				</div>
				
				<!-- Isi Berita Indonesia -->
				<div class="mb-3">
					<label class="form-label">Isi Berita Bahasa Indonesia</label>
					<textarea class="form-control" name="isi_berita_indonesia" placeholder="Tulis isi berita dalam Bahasa Indonesia (maksimal 1000 karakter)" maxlength="1000" rows="6" required></textarea>
					<div class="form-text">Maksimal 1000 karakter</div>
				</div>
				
				<!-- Isi Berita Inggris -->
				<div class="mb-3">
					<label class="form-label">Isi Berita Bahasa Inggris</label>
					<textarea class="form-control" name="isi_berita_inggris" placeholder="Write news content in English (maximum 1000 characters)" maxlength="1000" rows="6" required></textarea>
					<div class="form-text">Maximum 1000 characters</div>
				</div>
				
				<!-- File Upload -->
				<div class="mb-4">
					<label class="form-label">File Pendukung</label>
					<div class="file-upload">
						<input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
						<small class="text-muted">Format yang didukung: PDF, DOC, DOCX, JPG, JPEG, PNG</small>
					</div>
				</div>
				
				<!-- Action Buttons -->
				<div class="text-center">
					<button type="submit" class="btn btn-primary me-2" name="simpan">
						💾 Simpan Berita
					</button>
					<button type="reset" class="btn btn-outline-secondary">
						🔄 Reset Form
					</button>
				</div>
			</form>
			
			<hr class="divider">
			
			<!-- Navigation Buttons -->
			<div class="button-container">
				<form action="index.php" method="get">
					<button type="submit" class="btn btn-outline-primary">
						🏠 Kembali ke Beranda
					</button>
				</form>
				
				<form action="logout.php" method="post" onsubmit="return confirm('Yakin ingin logout?')">
					<button type="submit" class="btn btn-outline-danger">
						🚪 Logout
					</button>
				</form>
			</div>
		</div>
	</div>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>