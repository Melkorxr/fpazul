<!DOCTYPE html>
<html lang="en">
<head>
	<title>The Great Azul</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<style>
    /* Styling Sidebar */
.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  width: 250px;
  height: 100%;
  background-color: #808080;
  color: white;
  transition: transform 0.3s ease-in-out;
  z-index: 1050;
}

.sidebar.closed {
  transform: translateX(0px); /* Geser keluar layar */
}

.sidebar a {
  color: white;
  padding: 10px 15px;
  display: block;
  text-decoration: none;
}

.sidebar a:hover {
  background-color: #575757;
}

.image-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 10%; /* Sesuaikan dengan tinggi yang diinginkan */
}

.sd-container {
  display: flex;
  justify-content: center; /* Memusatkan secara horizontal */
  align-items: center; /* Memusatkan secara vertikal */
  padding: 5px;
  margin-left: 0px;
  font-size: 14px;
  font-weight: bold;
  color: #000000;
}


.sd-container, .image-container {
  background-color: #808080;
}

</style>

<body>
	<!-- Sidebar -->
	<div class="sidebar closed" id="sidebar">
        <div class="image-container">
          <img src="iconadmin.png" height="80px" width="180px">
        </div>
        <div class="sd-container">
          <p><?php echo $_SESSION['username']; ?></p>
        </div>
		<a href="dashboard_admin.php" style="font-weight: bold;">Dashboard</a>
    <a href="pengunjung.php" style="font-weight: bold;">Pengunjung</a>
    <a href="tambahbuku.php" style="font-weight: bold;">Buku</a>
    <a href="tambahpinjam.php" style="font-weight: bold;">Peminjaman</a>
		<a href="home.php" style="font-weight: bold;">Data Pengunjung</a>
    <a href="buku.php" style="font-weight: bold;">Data Buku</a>
    <a href="reservasi.php" style="font-weight: bold;">Data Reservasi</a>
    <a href="pinjam.php" style="font-weight: bold;">Data Peminjaman</a>
		<a href="Manajemen_Akun.php" style="font-weight: bold;">Manajemen Akun</a>
    <a href="request_reset.php" style="font-weight: bold;">Reset Password</a>
	</div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
