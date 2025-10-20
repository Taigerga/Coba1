<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}
?>

<html>


<head>
	<title>Buku Tamu</title>
</head>

<center>

	<body>
	<form action=simpan_berita.php method=post enctype="multipart/form-data">
		<h1>FORM TAMBAH BERITA</h1>
		<h2>UNIKOM NEWS</h2>
		<hr>
		

		<table>
			<tr>
				<td> Judul Berita Bahasa Indonesia</td>
				<td> <input type=text name=judul_berita_indonesia size=50></td>
			</tr>
			<tr>
				<td> Judul Berita Bahasa Inggris</td>
				<td> <input type=text name=judul_berita_inggris size=50></td>
			</tr>
			<tr>
				<td> Isi Berita Bahasa Indonesia 	</td>
				<td> <textarea rows="10" cols="50" name=isi_berita_indonesia maxlength=1000 ></textarea></td>
			</tr>
			<tr>
				<td> Isi Berita Bahasa Inggris	</td>
				<td> <textarea rows="10" cols="50" name=isi_berita_inggris maxlength=1000></textarea></td>
			</tr>
			<tr>
				<td> File Pendukung			</td>
				<td> <input type="file" name="file"></td>
			</tr>

		</table>
		<br><br>
		<div>
			<input type=submit value=simpan name=simpan> <input type=reset value=Reset>
		</div>
		
		


	</form>
		<!-- Tombol Logout dan Kembali -->
        <div class="button-container">
            <p>Login sebagai: <b><?php echo $_SESSION['username']; ?></b></p>

            <form action="index.php" method="get">
                <button type="submit">🏠 Kembali ke Beranda</button>
            </form>

            <form action="logout.php" method="post" onsubmit="return confirm('Yakin ingin logout?')">
                <button type="submit">🚪 Logout</button>
            </form>
        </div>
	</body>
</center>
</html>

