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
<body>
	
<?php 
include 'navbar.php';
?>

<?php 
include 'sidebar.php';
?>
<section class="slider">	
	<div class="container">
		<h2 style="color: #ffffff; padding: 20px">Pengunjung</h2>
		
		<hr>
		
		<?php
        if (isset($_POST['submit'])) {
        
            // Tangkap data dari form
            $nim = $_POST['nim'];
            $nama_pengunjung = mysqli_real_escape_string($conn, $_POST['nama_pengunjung']);
            $fakultas = mysqli_real_escape_string($conn, $_POST['fakultas']);
            $prodi = mysqli_real_escape_string($conn, $_POST['prodi']);
        
            // Validasi bahwa NIM adalah angka
            if (!ctype_digit($nim)) {
                echo '<div class="alert alert-warning">NIM harus berupa angka!</div>';
                exit();
            }
        
            // Tambahkan data ke database
            $sql = mysqli_query($conn, "INSERT INTO pengunjung (nim, nama_pengunjung, fakultas, prodi) 
                                        VALUES ('$nim', '$nama_pengunjung', '$fakultas', '$prodi')") 
                   or die(mysqli_error($conn));
        
            if ($sql) {
                echo '<script>alert("Data berhasil ditambahkan."); window.location="pengunjung.php";</script>';
            } else {
                echo '<div class="alert alert-warning">Gagal menambahkan data.</div>';
            }
        }
        
		?>
		
		<form action="" method="post">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" style="color: #ffffff;">NIM</label>
				<div class="col-sm-10">
					<input type="text" name="nim" class="form-control" size="4" required placeholder="Masukkan NIM">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" style="color: #ffffff;">Nama</label>
				<div class="col-sm-10">
					<input type="text" name="nama_pengunjung" class="form-control" size="4" required placeholder="Masukkan Nama">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" style="color: #ffffff;">Fakultas</label>
				<div class="col-sm-10">
					<input type="text" name="fakultas" class="form-control" size="4" required placeholder="Masukkan Fakultas">
				</div>
			</div>
            <div class="form-group row">
				<label class="col-sm-2 col-form-label" style="color: #ffffff;">Prodi</label>
				<div class="col-sm-10">
					<input type="text" name="prodi" class="form-control" size="4" required placeholder="Masukkan Program Studi">
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