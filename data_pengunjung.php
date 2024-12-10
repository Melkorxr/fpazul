<?php
include('connect.php');

// Mengatur zona waktu ke Waktu Indonesia Barat (WIB)
date_default_timezone_set('Asia/Jakarta');

// Mendapatkan tanggal hari ini (WIB)
$tanggal_hari_ini = date('Y-m-d');

// Query untuk menghitung jumlah pengunjung berdasarkan tanggal hari ini
$query = "SELECT COUNT(*) AS total_pengunjung FROM pengunjung WHERE DATE(waktu_berkunjung) = '$tanggal_hari_ini'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Ambil jumlah pengunjung
$total_pengunjung = $data['total_pengunjung'];

// Menutup koneksi database
mysqli_close($conn);

// Mengirim data ke JavaScript
echo json_encode(['jumlah_pengunjung' => $total_pengunjung]);
?>
