<?php include('connect.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>The Great Azul</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="shortcut icon" type="image/pmg/jpg" href="icon.png">

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
<body>
	<?php
	include 'navbar.php';
	?>
<section class="slider">	
	<div class="container" style="padding:20px;">
		<h2 style="color: #ffffff;">Edit Pengunjung</h2>
		
		<hr>
		
		<?php
		//jika sudah mendapatkan parameter GET id dari URL
		if(isset($_GET['nomor_kunjungan'])){
			//membuat variabel $id untuk menyimpan id dari GET id di URL
			$nomor_kunjungan = $_GET['nomor_kunjungan'];
			
			//query ke database SELECT tabel mahasiswa berdasarkan id = $id
			$select = mysqli_query($conn, "SELECT * FROM pengunjung WHERE nomor_kunjungan='$nomor_kunjungan'") or die(mysqli_error($conn));
			
			//jika hasil query = 0 maka muncul pesan error
			if(mysqli_num_rows($select) == 0){
				echo '<div class="alert alert-warning">Nomor Kunjungan tidak ada dalam database.</div>';
				exit();
			//jika hasil query > 0
			}else{
				//membuat variabel $data dan menyimpan data row dari query
				$data = mysqli_fetch_assoc($select);
			}
		}
		?>
		
		<?php
		//jika tombol simpan di tekan/klik
		if(isset($_POST['submit'])){
			$nomor_kunjungan = $_POST['nomor_kunjungan'];
			$nim = $_POST['nim'];
			$nama_pengunjung	= $_POST['nama_pengunjung'];
			$prodi				= $_POST['prodi'];
			$fakultas			= $_POST['fakultas'];
			
			$sql = mysqli_query($conn, "UPDATE pengunjung SET nama_pengunjung='$nama_pengunjung', prodi = '$prodi', nim = '$nim', fakultas='$fakultas' WHERE nomor_kunjungan ='$nomor_kunjungan' ") or die(mysqli_error($conn));
			
			if($sql){
				echo '<script>alert("Berhasil menyimpan data."); document.location="home.php?nomor_kunjungan='.$nomor_kunjungan.'";</script>';
			}else{
				echo '<div class="alert alert-warning">Gagal melakukan proses edit data.</div>';
			}
		}
		?>
		
		<form action="edit.php?nomor_kunjungan=<?php echo $nomor_kunjungan; ?>" method="post">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" style="color: #ffffff;">NAMA PENGUNJUNG</label>
				<div class="col-sm-10">
					<td><input type="hidden" name="nomor_kunjungan" value=<?php echo $_GET['nomor_kunjungan'];?>></td>
					<input type="text" name="nama_pengunjung" class="form-control" value="<?php echo $data['nama_pengunjung']; ?>" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" style="color: #ffffff;">NIM</label>
				<div class="col-sm-10">
				<input type="number" name="nim" class="form-control" value="<?php echo $data['nim']; ?>" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" style="color: #ffffff;">PRODI</label>
				<div class="col-sm-10">
				<input type="text" name="prodi" class="form-control" value="<?php echo $data['prodi']; ?>" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" style="color: #ffffff;">FAKULTAS</label>
				<div class="col-sm-10">
				<input type="text" name="fakultas" class="form-control" value="<?php echo $data['fakultas']; ?>" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">&nbsp;</label>
				<div class="col-sm-10">
					<input type="submit" name="submit" class="btn btn-primary" value="SIMPAN">
					<a href="home.php" class="btn btn-warning">KEMBALI</a>
				</div>
			</div>
		</form>
	</div>
</section>

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