<?php
session_start();
include 'connect.php';
require_once 'vendor/autoload.php';

// Inisialisasi Google Client
$client = new Google_Client();
$client->setClientId('941940160450-0tta5m6lstmornu27890653cso4sj9vt.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/google-callback.php');

$google_oauthV2 = new Google_Service_Oauth2($client);

if (isset($_GET['code'])) {
    // Ambil token akses menggunakan kode otentikasi
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (isset($token['error'])) {
        die('Error fetching access token');
    }

    // Simpan token akses di session
    $_SESSION['access_token'] = $token['access_token'];
    $client->setAccessToken($token);

    // Ambil data pengguna dari Google
    $user = $google_oauthV2->userinfo->get();
    $username = mysqli_real_escape_string($conn, $user['email']); // Gunakan email sebagai username
    $name = mysqli_real_escape_string($conn, $user['name']); // Nama pengguna

    // Periksa apakah pengguna sudah ada di database
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        // Jika pengguna belum terdaftar, buat pengguna baru
        $encrypted_token = password_hash($token['access_token'], PASSWORD_BCRYPT); // Enkripsi token akses
        $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$encrypted_token', 'user')";
        if (!mysqli_query($conn, $query)) {
            die('Error: ' . mysqli_error($conn));
        }
    } else {
        // Pengguna sudah terdaftar, ambil role dari database
        $row = mysqli_fetch_assoc($result);
        $role = $row['role'];
    }

    // Simpan data pengguna di session
    $_SESSION['username'] = $username;
    $_SESSION['role'] = isset($role) ? $role : 'user'; // Role dari database atau default 'user'

    // Arahkan pengguna ke dashboard berdasarkan role
    if ($_SESSION['role'] === 'admin') {
        header("Location: dashboard_admin.php");
    } else {
        header("Location: dashboard_user.php");
    }
    exit();
} else {
    header("Location: index.php");
    exit();
}
