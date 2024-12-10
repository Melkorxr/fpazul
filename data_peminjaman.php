<?php
include('connect.php');

// Query untuk menghitung jumlah seluruh pengunjung
$query = "SELECT COUNT(*) AS total_pinjam FROM pinjam WHERE status IN ('Belum dikembalikan', 'Diperpanjang')";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Ambil jumlah pengunjung
$total_pinjam = $data['total_pinjam'];

// Menutup koneksi database
mysqli_close($conn);

// Mengirim data ke JavaScript
echo json_encode(['jumlah_pinjam' => $total_pinjam]);
?>
