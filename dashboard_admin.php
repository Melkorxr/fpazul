
<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<?php
include 'connect.php';

// Tentukan jumlah data per halaman
$limit = 5;

// Ambil halaman saat ini dari parameter URL, jika tidak ada maka halaman default adalah 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Pastikan halaman minimal adalah 1

// Hitung offset
$offset = ($page - 1) * $limit;

// Hitung total data
$totalQuery = "SELECT COUNT(*) as total FROM pinjam WHERE status IN ('belum dikembalikan', 'diperpanjang')";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalData = $totalRow['total'];

// Hitung total halaman
$totalPages = ceil($totalData / $limit);

// Query untuk mengambil data dengan limit dan offset
$query = "SELECT no_pinjam, nomor_kunjungan, id_buku, tanggal_pinjam, tanggal_pengembalian, kontak, status 
          FROM pinjam 
          WHERE status IN ('belum dikembalikan', 'diperpanjang') 
          ORDER BY tanggal_pinjam DESC 
          LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $query);

// Hitung total data resrvasi
$totalQuery = "SELECT COUNT(*) as total FROM reservasi WHERE status IN ('process', 'bisa diambil')";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalData = $totalRow['total'];

// Hitung total halaman
$totalPages = ceil($totalData / $limit);

// Query untuk mengambil data dengan limit dan offset
$query = "SELECT no_rsvs, nama, id_buku, tanggal_pengambilan, kontak, status 
          FROM reservasi 
          WHERE status IN ('process', 'bisa diambil') 
          ORDER BY tanggal_pengambilan DESC 
          LIMIT $limit OFFSET $offset";

$resultRsvs = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html>
<head>
	<title>The Great Azul</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
	<link rel="shortcut icon" type="image/png/jpg" href="LogoAzul.png">
	<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
	<script src="https://cdn.rawgit.com/mikeerickson/CountUp.js/master/dist/countUp.min.js"></script>
</head>

<style type="text/css">
	@import url('https://fonts.googleapis.com/css?family=Poppins:400,600,700,700i');
	@import url('https://fonts.googleapis.com/css?family=Roboto+Slab:300,400');

	body{
		font-family: 'Poppins', sans-serif;
		margin: 0px;
	}

	.slider{
		background: #67bef991;
	}

	section.slider {
    background: linear-gradient(rgba(0,0,0,.7), rgba(0,0,0,.7)), url("PerpusAzul.jpg") fixed;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    min-height: 90vh; /* Tinggi minimum */
    padding: 50px 0; /* Menambahkan padding untuk memberi ruang */
	}

	.font-slider{
		margin-top: 10%;
		text-align: center;
	}
	.judulsejarah{

		color: #3498db;
		font-weight: bold;
		margin-bottom: 20px;
	}

	.paragraph{
		text-align: justify;
		border-left: 7px solid #3498db;
		padding-left: 30px;
	}
	.paragraph2{
		margin-top: 30%;
		text-align: justify;
		border-right: 7px solid #3498db;
		padding-right: 30px;
	}
	.komentest{
	    padding: 10px 0px;
	    border-top: 1px solid #ccc;
	    border-bottom: 1px solid #ccc;
	    font-family: poppins;
	    font-size: 11pt;
	    text-align: justify;
	}
	.mark{
		background: linear-gradient(to bottom right, #eaeaeab0, whitesmoke);
	    text-align: center;
	    padding: 20px;
	    box-shadow: 0px 4px #ccc;
	    border-radius: 11px;
	    margin: 50px 0px 0px 0px;
	    margin-bottom: 15px;
	}
	.sejarah{
		padding-top: 6%;
	}

	.informasi{
		background: #f9f9f9;
		padding-bottom: 15px;
	}
	.visi{
		padding: 20px;
	    background: #dcdcd8;
	    border-radius: 6px;
	    line-height: 1.5em;
	    box-shadow: 0 1px 10px 0 rgba(0,0,0,.12);
	}
	.misi{
		padding: 20px;
	    background: #fdf3e5;
	    border-radius: 6px;
	    line-height: 1.5em;
	    box-shadow: 0 1px 10px 0 rgba(0,0,0,.12);
	}

	.kontak-informasi{
		padding: 20px;
	    background: #d6e4fc;
	    border-radius: 6px;
	    line-height: 1.5em;
	    box-shadow: 0 1px 10px 0 rgba(0,0,0,.12);
	}
	.top{
		margin-top: 5px;
		padding: 10px;
		background: #eee1b9;
	}
	.link{
		background: #4ca2e1;
		text-decoration: none;
		color: #ffffff;
	}
	.link2{
		background: #DDB538;
		text-decoration: none;
		color: white;
	}
	.link3{
		background: #e3875f;
		text-decoration: none;
		color: white;
	}
	.link4{
		background: #91d97b;
		text-decoration: none;
		color: white;
	}
	.link5{
		background: #06D8D3;
		text-decoration: none;
		color: white;
	}
	.link6{
		background: #CE95BD;
		text-decoration: none;
		color: white;
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

.footer h6 {
	margin: 0px;
}


	.indicator-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        margin-top: 30px;
    }

    .indicator {
        width: 150px;
        height: 150px;
        background-color: #3498db;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 40px;
        font-weight: bold;
    }

    #jumlahPengunjung {
        font-size: 50px;
        font-weight: bold;
        color: #3498db;
        margin-top: 20px;
        text-align: left;
    }

	.ds-container {
	justify-content: center;
    max-width: 1200px; /* Batas lebar maksimal 1200px */
    margin: 0 auto; /* Memusatkan kontainer */
    padding: 20px;
	color: #ffffff;
	}

	.container {
    width: 20px;
    margin: 0 auto; /* Memusatkan kontainer */
    padding: 1px;
	}

	.circle-indicator {
    width: 150px;
    height: 150px;
    position: relative;
    background-color: #e0e0e0;
    border-radius: 50%;
    overflow: hidden;
    display: inline-block;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
	}

	.circle-fill {
		width: 100%;
		height: 0;
		position: absolute;
		bottom: 0;
		left: 0;
		background: linear-gradient(180deg, #0000ff, #2980b9);
		transition: height 1.0s linear;
	}

	.circle-text {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		font-size: 32px;
		font-weight: bold;
		color: #ffffff;
		z-index: 10;
		text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
	}

</style>
<body>

<?php 
include 'navbar.php';
?>

<?php 
include 'sidebar.php';
?>

<section id="informasi" class="slider">
    <div class="ds-container">
        <div class="row-6" style="display: flex; justify-content: center; gap: 20px;">
            <div class="col-3" style="flex: 1; text-align: center;">
                <h5 style="font-weight: bold; margin: 30px 0px;">JUMLAH PENGUNJUNG</h5>
                <!-- Tempat untuk indikator bulat -->
                <div class="circle-indicator">
                    <div class="circle-fill" id="circleFill"></div>
                    <div class="circle-text" id="circleText">0</div>
                </div>
            </div>
			<div class="col-3" style="flex: 1; text-align: center;">
				<h5 style="font-weight: bold; margin: 30px 0px;">JUMLAH BUKU</h5>
				<!-- Tempat untuk indikator bulat jumlah buku -->
				<div class="circle-indicator">
					<div class="circle-fill" id="circleFillBuku"></div>
					<div class="circle-text" id="circleTextBuku">0</div>
				</div>
			</div>
			<div class="col-3" style="flex: 1; text-align: center;">
				<h5 style="font-weight: bold; margin: 30px 0px;">JUMLAH RESERVASI</h5>
				<!-- Tempat untuk indikator bulat jumlah buku -->
				<div class="circle-indicator">
					<div class="circle-fill" id="circleFillRsvs"></div>
					<div class="circle-text" id="circleTextRsvs">0</div>
				</div>
			</div>
			<div class="col-3" style="flex: 1; text-align: center;">
				<h5 style="font-weight: bold; margin: 30px 0px;">JUMLAH PEMINJAMAN</h5>
				<!-- Tempat untuk indikator bulat jumlah buku -->
				<div class="circle-indicator">
					<div class="circle-fill" id="circleFillpinjam"></div>
					<div class="circle-text" id="circleTextpinjam">0</div>
				</div>
			</div>
        </div>
    </div>

	<div class="card" style="max-width: 1000px; margin: 50px auto;">
		<div class="container">
			<h2 style="text-align: center; margin: 20px 0;">Reservasi</h2>
			<table class="table table-bordered table-striped">
				<thead class="thead-dark">
					<tr>
						<th>No Reservasi</th>
						<th>Atas Nama</th>
						<th>ID Buku</th>
						<th>Waktu Pengambilan</th>
						<th>Kontak</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = $offset + 1;

					if (mysqli_num_rows($resultRsvs) > 0) {
						while ($row = mysqli_fetch_assoc($resultRsvs)) {
							echo "<tr>";
							echo "<td>" . $row['no_rsvs'] . "</td>";
							echo "<td>" . $row['nama'] . "</td>";
							echo "<td>" . $row['id_buku'] . "</td>";
							echo "<td>" . $row['tanggal_pengambilan'] . "</td>";
							echo "<td>" . $row['kontak'] . "</td>";
							echo "<td>" . ucfirst($row['status']) . "</td>";
							echo "</tr>";
						}
					} else {
						echo "<tr><td colspan='7' style='text-align:center;'>Tidak ada data Reservasi.</td></tr>";
					}
					?>
				</tbody>
			</table>

			<!-- Navigasi Pagination -->
			<nav aria-label="Page navigation">
				<ul class="pagination justify-content-center">
					<?php if ($page > 1): ?>
						<li class="page-item">
							<a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
					<?php endif; ?>

					<?php for ($i = 1; $i <= $totalPages; $i++): ?>
						<li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
							<a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
						</li>
					<?php endfor; ?>

					<?php if ($page < $totalPages): ?>
						<li class="page-item">
							<a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</nav>
		</div>
	</div>

	<div class="card" style="max-width: 1000px; margin: 50px auto;">
		<div class="container">
			<h2 style="text-align: center; margin: 20px 0;">Peminjaman</h2>
			<table class="table table-bordered table-striped">
				<thead class="thead-dark">
					<tr>
						<th>No</th>
						<th>Nomor Peminjaman</th>
						<th>Nomor Kunjungan</th>
						<th>ID Buku</th>
						<th>Tanggal Peminjaman</th>
						<th>Tanggal Pengembalian</th>
						<th>Kontak</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = $offset + 1;

					if (mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<tr>";
							echo "<td>" . $no++ . "</td>";
							echo "<td>" . $row['no_pinjam'] . "</td>";
							echo "<td>" . $row['nomor_kunjungan'] . "</td>";
							echo "<td>" . $row['id_buku'] . "</td>";
							echo "<td>" . $row['tanggal_pinjam'] . "</td>";
							echo "<td>" . $row['tanggal_pengembalian'] . "</td>";
							echo "<td>" . $row['kontak'] . "</td>";
							echo "<td>" . ucfirst($row['status']) . "</td>";
							echo "</tr>";
						}
					} else {
						echo "<tr><td colspan='7' style='text-align:center;'>Tidak ada data peminjaman.</td></tr>";
					}
					?>
				</tbody>
			</table>

			<!-- Navigasi Pagination -->
			<nav aria-label="Page navigation">
				<ul class="pagination justify-content-center">
					<?php if ($page > 1): ?>
						<li class="page-item">
							<a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
					<?php endif; ?>

					<?php for ($i = 1; $i <= $totalPages; $i++): ?>
						<li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
							<a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
						</li>
					<?php endfor; ?>

					<?php if ($page < $totalPages): ?>
						<li class="page-item">
							<a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</nav>
		</div>
	</div>

    <script>
        // Mengambil data jumlah pengunjung dari data_pengunjung.php
        fetch('data_pengunjung.php')
            .then(response => response.json())
            .then(data => {
                let jumlahPengunjung = data.jumlah_pengunjung;
                
                // Variabel untuk animasi
                let currentCount = 0;
                let targetCount = jumlahPengunjung;
                let animationSpeed = 300;
				let step = Math.ceil(targetCount / 300);
                let percentage = 0;

                const circleFill = document.getElementById('circleFill');
                const circleText = document.getElementById('circleText');

                // Fungsi animasi
                let interval = setInterval(function () {
                    if (currentCount < targetCount) {
                        currentCount += Math.ceil(targetCount / 100); // Tingkat kenaikan angka
                        percentage = Math.min((currentCount / targetCount) * 100, 100); // Hitung persentase
                        circleText.textContent = Math.min(currentCount, targetCount); // Update angka
                        circleFill.style.height = `${percentage}%`; // Update tinggi air
                    } else {
                        clearInterval(interval);
                    }
                }, animationSpeed);
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Terjadi kesalahan saat memuat data.");
            });

			// Mengambil data jumlah buku dari data_buku.php
		fetch('data_buku.php')
			.then(response => response.json())
			.then(data => {
				let jumlahBuku = data.jumlah_buku;

				// Variabel untuk animasi
				let currentCountBuku = 0;
				let targetCountBuku = jumlahBuku;
				let animationSpeedBuku = 300;

				const circleFillBuku = document.getElementById('circleFillBuku');
				const circleTextBuku = document.getElementById('circleTextBuku');

				// Fungsi animasi
				let intervalBuku = setInterval(function () {
					if (currentCountBuku < targetCountBuku) {
						currentCountBuku += Math.ceil(targetCountBuku / 100); // Tingkat kenaikan angka
						let percentageBuku = Math.min((currentCountBuku / targetCountBuku) * 100, 100); // Hitung persentase
						circleTextBuku.textContent = Math.min(currentCountBuku, targetCountBuku); // Update angka
						circleFillBuku.style.height = `${percentageBuku}%`; // Update tinggi air
					} else {
						clearInterval(intervalBuku);
					}
				}, animationSpeedBuku);
			})
			.catch(error => {
				console.error('Error:', error);
				alert("Terjadi kesalahan saat memuat data buku.");
			});

			// Mengambil data jumlah reservasi dari data_reservasi.php
		fetch('data_reservasi.php')
			.then(response => response.json())
			.then(data => {
				let jumlahRsvs = data.jumlah_Rsvs;

				// Variabel untuk animasi
				let currentCountRsvs = 0;
				let targetCountRsvs = jumlahRsvs;
				let animationSpeedRsvs = 300;

				const circleFillRsvs = document.getElementById('circleFillRsvs');
				const circleTextRsvs = document.getElementById('circleTextRsvs');

				// Fungsi animasi
				let intervalRsvs = setInterval(function () {
					if (currentCountRsvs < targetCountRsvs) {
						currentCountRsvs += Math.ceil(targetCountRsvs / 100); // Tingkat kenaikan angka
						let percentageRsvs = Math.min((currentCountRsvs / targetCountRsvs) * 100, 100); // Hitung persentase
						circleTextRsvs.textContent = Math.min(currentCountRsvs, targetCountRsvs); // Update angka
						circleFillRsvs.style.height = `${percentageRsvs}%`; // Update tinggi air
					} else {
						clearInterval(intervalRsvs);
					}
				}, animationSpeedRsvs);
			})
			.catch(error => {
				console.error('Error:', error);
				alert("Terjadi kesalahan saat memuat data reservasi.");
			});

						// Mengambil data jumlah reservasi dari data_reservasi.php
		fetch('data_peminjaman.php')
			.then(response => response.json())
			.then(data => {
				let jumlahpinjam = data.jumlah_pinjam;

				// Variabel untuk animasi
				let currentCountpinjam = 0;
				let targetCountpinjam = jumlahpinjam;
				let animationSpeedpinjam = 300;

				const circleFillpinjam = document.getElementById('circleFillpinjam');
				const circleTextpinjam = document.getElementById('circleTextpinjam');

				// Fungsi animasi
				let intervalpinjam = setInterval(function () {
					if (currentCountpinjam < targetCountpinjam) {
						currentCountpinjam += Math.ceil(targetCountpinjam / 100); // Tingkat kenaikan angka
						let percentagepinjam = Math.min((currentCountpinjam / targetCountpinjam) * 100, 100); // Hitung persentase
						circleTextpinjam.textContent = Math.min(currentCountpinjam, targetCountpinjam); // Update angka
						circleFillpinjam.style.height = `${percentagepinjam}%`; // Update tinggi air
					} else {
						clearInterval(intervalpinjam);
					}
				}, animationSpeedpinjam);
			})
			.catch(error => {
				console.error('Error:', error);
				alert("Terjadi kesalahan saat memuat data reservasi.");
			});

    </script>
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

	<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	
</body>
</html>