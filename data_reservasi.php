<?php
include('connect.php');

// Query untuk menghitung jumlah seluruh pengunjung
$query = "SELECT COUNT(*) AS total_Rsvs FROM reservasi WHERE status IN ('process', 'bisa diambil')";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Ambil jumlah pengunjung
$total_Rsvs = $data['total_Rsvs'];

// Menutup koneksi database
mysqli_close($conn);

// Mengirim data ke JavaScript
echo json_encode(['jumlah_Rsvs' => $total_Rsvs]);
?>
