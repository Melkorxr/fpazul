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
<body>
<?php 
include 'navbar.php';
?>

<?php 
include 'sidebar.php';
?>

<?php
//memasukkan file config.php
include('connect.php');
?>
<section class="slider">	
	<div class="container">
		<h2 style="color: #ffffff; padding: 20px;"><center>Data Pengunjung Perpustakaan</center></h2>
		
		<hr>
		
	<div class="card">
	<div class="container">
				<!-- Form pencarian dan filter -->
		<form method="GET" action="" class="mb-3">
			<div class="form-row">
				<div class="col-md-4">
					<input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama atau NIM" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
				</div>
				<div class="col-md-3">
					<select name="filter_prodi" class="form-control">
						<option value="">Semua Prodi</option>
						<option value="Fisika" <?= isset($_GET['filter_prodi']) && $_GET['filter_prodi'] === "Fisika" ? 'selected' : '' ?>>Fisika</option>
						<option value="Biologi" <?= isset($_GET['filter_prodi']) && $_GET['filter_prodi'] === "Biologi" ? 'selected' : '' ?>>Biologi</option>
						<option value="Matematika" <?= isset($_GET['filter_prodi']) && $_GET['filter_prodi'] === "Matematika" ? 'selected' : '' ?>>Matematika</option>
						<option value="Informatika" <?= isset($_GET['filter_prodi']) && $_GET['filter_prodi'] === "Informatika" ? 'selected' : '' ?>>Informatika</option>
						<option value="Teknik Elektro" <?= isset($_GET['filter_prodi']) && $_GET['filter_prodi'] === "Teknik Elektro" ? 'selected' : '' ?>>Teknik Elektro</option>
						<!-- Tambahkan opsi lainnya sesuai kebutuhan -->
					</select>
				</div>
				<div class="col-md-3">
					<select name="filter_fakultas" class="form-control">
						<option value="">Semua Fakultas</option>
						<option value="Fakultas Sains" <?= isset($_GET['filter_fakultas']) && $_GET['filter_fakultas'] === "Fakultas Sains" ? 'selected' : '' ?>>Fakultas Sains</option>
						<option value="Fakultas Teknik" <?= isset($_GET['filter_fakultas']) && $_GET['filter_fakultas'] === "Fakultas Teknik" ? 'selected' : '' ?>>Fakultas Teknik</option>
						<!-- Tambahkan opsi lainnya sesuai kebutuhan -->
					</select>
				</div>
				<div class="col-md-2">
					<input type="date" name="start_date" class="form-control" value="<?= isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : '' ?>" placeholder="Dari Tanggal">
				</div>
				<div class="col-md-2">
					<input type="date" name="end_date" class="form-control" value="<?= isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : '' ?>" placeholder="Sampai Tanggal">
				</div>
				<div class="col-md-2">
					<button type="submit" class="btn btn-primary btn-block">Cari</button>
				</div>
			</div>
		</form>
		<table class="table table-striped table-hover table-sm table-bordered">
			<thead class="thead-danger">
				<tr class="table-primary" style="text-align:center">
					<th>NO.</th>
					<th>NIM</th>
					<th>NAMA PENGUNJUNG</th>
					<th>PRODI</th>
					<th>FAKULTAS</th>
					<th>WAKTU BERKUNJUNG</th>
					<th>AKSI</th>
				</tr>
			</thead>
			<tbody>
				<?php
				// Pagination setup
				$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
				$limit = 12;
				$offset = ($page - 1) * $limit;

				// Ambil input dari formulir
				$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
				$filter_prodi = isset($_GET['filter_prodi']) ? mysqli_real_escape_string($conn, $_GET['filter_prodi']) : '';
				$filter_fakultas = isset($_GET['filter_fakultas']) ? mysqli_real_escape_string($conn, $_GET['filter_fakultas']) : '';
				$start_date = isset($_GET['start_date']) ? mysqli_real_escape_string($conn, $_GET['start_date']) : '';
				$end_date = isset($_GET['end_date']) ? mysqli_real_escape_string($conn, $_GET['end_date']) : '';

				// Query untuk pencarian dan filter
				$query = "SELECT * FROM pengunjung WHERE 1=1";

				if (!empty($search)) {
					$query .= " AND (nim LIKE '%$search%' OR nama_pengunjung LIKE '%$search%' nomor_kunjungan LIKE '%$search%')";
				}
				if (!empty($filter_prodi)) {
					$query .= " AND prodi = '$filter_prodi'";
				}
				if (!empty($filter_fakultas)) {
					$query .= " AND fakultas = '$filter_fakultas'";
				}
				if (!empty($start_date)) {
					$query .= " AND waktu_berkunjung >= '$start_date'";
				}
				if (!empty($end_date)) {
					$query .= " AND waktu_berkunjung <= '$end_date'";
				}

				$query .= " ORDER BY nomor_kunjungan DESC LIMIT $limit OFFSET $offset";

				$sql = mysqli_query($conn, $query) or die(mysqli_error($conn));

				// Menampilkan data
				if (mysqli_num_rows($sql) > 0) {
					while ($data = mysqli_fetch_assoc($sql)) {
						echo '
						<tr style="text-align:center">
							<td>' . htmlspecialchars($data['nomor_kunjungan']) . '</td>
							<td>' . htmlspecialchars($data['nim']) . '</td>
							<td>' . htmlspecialchars($data['nama_pengunjung']) . '</td>
							<td>' . htmlspecialchars($data['prodi']) . '</td>
							<td>' . htmlspecialchars($data['fakultas']) . '</td>
							<td>' . htmlspecialchars($data['waktu_berkunjung']) . '</td>
							<td>
								<a href="edit.php?nomor_kunjungan=' . urlencode($data['nomor_kunjungan']) . '" class="badge badge-warning">Edit</a>
								<a href="delete.php?nomor_kunjungan=' . urlencode($data['nomor_kunjungan']) . '" class="badge badge-danger" onclick="return confirm(\'Yakin ingin menghapus data ini?\')">Delete</a>
							</td>
						</tr>';
					}
				} else {
					echo '<tr><td colspan="6">Tidak ada data.</td></tr>';
				}

				// Query total data
				$total_query = "SELECT COUNT(*) AS total FROM pengunjung WHERE 1=1";
				if (!empty($search)) $total_query .= " AND (nim LIKE '%$search%' OR nama_pengunjung LIKE '%$search%' nomor_kunjungan LIKE '%$search%')";
				if (!empty($filter_prodi)) $total_query .= " AND prodi = '$filter_prodi'";
				if (!empty($filter_fakultas)) $total_query .= " AND fakultas = '$filter_fakultas'";
				if (!empty($start_date)) $total_query .= " AND waktu_berkunjung >= '$start_date'";
				if (!empty($end_date)) $total_query .= " AND waktu_berkunjung <= '$end_date'";
				$total_result = mysqli_query($conn, $total_query);
				$total_data = mysqli_fetch_assoc($total_result)['total'];
				$total_pages = ceil($total_data / $limit);
				?>
			<tbody>
		</table>
		<!-- Pagination -->
		<nav aria-label="Page navigation">
			<ul class="pagination justify-content-center">
				<?php if ($page > 1): ?>
					<li class="page-item">
						<a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
							<span aria-hidden="true">&laquo;</span>
						</a>
					</li>
				<?php endif; ?>

				<?php for ($i = 1; $i <= $total_pages; $i++): ?>
					<li class="page-item <?= $i == $page ? 'active' : '' ?>">
						<a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
					</li>
				<?php endfor; ?>

				<?php if ($page < $total_pages): ?>
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