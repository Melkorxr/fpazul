<?php include('connect.php'); ?>
<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>The Great Azul</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
	<link rel="shortcut icon" type="image/pmg/jpg" href="LogoAzul.png">
</head>
<style>
	.slider{
		background: #67bef991;
	}
	section.slider{
		background: linear-gradient(rgba(0,0,0,.7), rgba(0,0,0,.7)), url("PerpusAzul.jpg") fixed;
		background-position: center;
		background-size: 100%;
		height: 90vh;
		background-repeat: no-repeat;
	}

	.footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 10px 0;
    z-index: 1000;
	}

	.footer h6{
		margin: 0px;
	}
</style>
<?php 
include 'navbar.php';
?>

<?php 
include 'sidebar.php';
?>

<body>
<section class="slider">	
	<div class="container" style="padding: 20px;">
		<h2 style="color: #ffffff;">Buku</h2>
		
		<hr>
		
		<?php
		if(isset($_POST['submit'])){
			$id_buku			= $_POST['id_buku'];
			$judul_buku			= $_POST['judul_buku'];
			$penulis			= $_POST['penulis'];
			$tahun_terbit		= $_POST['tahun_terbit'];
			$jenis_buku			= $_POST['jenis_buku'];
			$bahasa				= $_POST['bahasa'];

			
			$cek = mysqli_query($conn, "SELECT * FROM buku WHERE id_buku='$id_buku'") or die(mysqli_error($conn));
			
			if(mysqli_num_rows($cek) == 0){
				
					$sql = mysqli_query($conn, "INSERT INTO buku(id_buku, judul_buku, penulis, tahun_terbit, jenis_buku, bahasa) VALUES('$id_buku', '$judul_buku', '$penulis', '$tahun_terbit', '$jenis_buku', '$bahasa')") or die(mysqli_error($conn));
					
						if($sql){
							echo '<script>alert("Berhasil menambahkan data."); document.location="tambahbuku.php";</script>';
						}else{
							echo '<div class="alert alert-warning">Gagal melakukan proses tambah data.</div>';
						}
				{
				echo '<div class="alert alert-warning">Gagal, id_buku sudah terdaftar.</div>';
			}

		}}
		?>
		
		
		<form action="tambahbuku.php" method="post" class="tes" enctype="multipart/form-data">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" style="color: #ffffff;">ID BUKU</label>
				<div class="col-sm-10">
					<input type="text" name="id_buku" class="form-control" size="4" required placeholder="Masukkan ID untuk Buku">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" style="color: #ffffff;">JUDUL BUKU</label>
				<div class="col-sm-10">
					<input type="text" name="judul_buku" class="form-control" size="4" required placeholder="Masukkan Judul Buku">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" style="color: #ffffff;">PENULIS</label>
				<div class="col-sm-10">
					
						<input type="text" name="penulis" class="form-control" size="4" required placeholder="Masukkan Penulis Buku">
					
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" style="color: #ffffff;">Tahun Terbit</label>
				<div class="col-sm-10">
					
						<input type="text" name="tahun_terbit" class="form-control" size="4"  required placeholder="Masukkan Tahun Terbit Buku">	
					</div> 
			</div> 
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" style="color: #ffffff;">Jenis Buku</label>
				<div class="col-sm-10">
					<input type="text" name="jenis_buku" class="form-control" size="4" required placeholder="Masukkan Jenis Buku">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" style="color: #ffffff;">BAHASA</label>
				<div class="col-sm-10">
					<input type="text" name="bahasa" class="form-control" size="4" required placeholder="Masukkan Bahasa yang digunakan Buku">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">&nbsp;</label>
				<div class="col-sm-10">
					<br>
					<input type="submit" name="submit" class="btn btn-primary" value="SIMPAN">
				</div>
			</div>
		</form>
			</div>

<footer class="footer">
	<div class="container">
		<div class="row">
			<div class="col">
				<h6 style="font-size: 12px;">Copyright &copy LIBRARY of AZUL</h6>
			</div>
		</div>
	</div>
</footer>
		
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	
</body>
</html> 