<?php
include('connect.php');

// Query untuk menghitung jumlah seluruh pengunjung
$query = "SELECT COUNT(*) AS total_buku FROM buku";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Ambil jumlah pengunjung
$total_buku = $data['total_buku'];

// Menutup koneksi database
mysqli_close($conn);

// Mengirim data ke JavaScript
echo json_encode(['jumlah_buku' => $total_buku]);
?>
