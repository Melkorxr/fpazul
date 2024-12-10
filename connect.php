<?php
// Konfigurasi koneksi
$servername = "localhost";
$username = "adminperpus";  // Ganti dengan username yang dibuat
$password = "thegreatazul";        // Ganti dengan password yang dibuat
$dbname = "perpustakaan";         // Nama database yang dibuat

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
#if ($conn->connect_error) {
#    die("Koneksi gagal: " . $conn->connect_error);
#}
#echo "Koneksi berhasil!";
?>
