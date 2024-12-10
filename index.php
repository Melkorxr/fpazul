<?php
session_start();
include 'connect.php';
require_once 'vendor/autoload.php'; // Pastikan autoload Composer sudah ada

// Login dengan Google
$client = new Google_Client();
$client->setClientId('941940160450-0tta5m6lstmornu27890653cso4sj9vt.apps.googleusercontent.com'); // Ganti dengan Client ID
$client->setClientSecret('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'); // Ganti dengan Client Secret
$client->setRedirectUri('http://localhost/google-callback.php'); // Ganti dengan URL redirect yang benar
$client->addScope("email");

$google_oauthV2 = new Google_Service_Oauth2($client);

// Proses login dengan Google
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $token;
    $client->setAccessToken($token);

    $user = $google_oauthV2->userinfo->get();
    $username = $user['email'];
    $name = $user['name'];
    
    // Cek apakah pengguna sudah terdaftar
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 0) {
        // Jika tidak terdaftar, daftarkan pengguna
        $query = "INSERT INTO users (username, password, role) VALUES ('$username', 'google', 'user')";
        mysqli_query($conn, $query);
    }

    // Simpan info user ke session
    $_SESSION['username'] = $username;
    $_SESSION['role'] = 'user'; // Role default, bisa disesuaikan

    header("Location: dashboard_user.php");
    exit();
}

// Proses login biasa dengan username dan password
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Cek username di database
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        // Pengguna ditemukan, ambil data dari database
        $row = mysqli_fetch_assoc($result);

        // Verifikasi password yang dimasukkan
        $db_password = $row['password'];

        if (password_verify($password, $db_password)) {
            // Password cocok dengan hash terenkripsi
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role']; // Role dari database (user atau admin)

            // Arahkan ke dashboard sesuai role
            if ($_SESSION['role'] === 'admin') {
                header("Location: dashboard_admin.php");
            } else {
                header("Location: dashboard_user.php");
            }
            exit();
        } elseif ($password === $db_password) {
            // Password cocok dengan password tidak terenkripsi
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role']; // Role dari database (user atau admin)

            // Arahkan ke dashboard sesuai role
            if ($_SESSION['role'] === 'admin') {
                header("Location: dashboard_admin.php");
            } else {
                header("Location: dashboard_user.php");
            }
            exit();
        } else {
            // Jika password salah
            $error_message = "Username atau password salah!";
        }
    } else {
        // Jika username tidak ditemukan
        $error_message = "Username atau password salah!";
    }
}

$loginUrl = $client->createAuthUrl();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>LOGIN</title>
</head>
<style>
    body, html {
    font-family: 'Poppins', sans-serif;
    margin: 0px;
}

/* Container for login */
.login-container {
    position: absolute; /* Posisi container relatif terhadap slider */
    top: 50%;           /* Tengah vertikal */
    left: 50%;          /* Tengah horizontal */
    transform: translate(-50%, -50%); /* Geser agar benar-benar di tengah */
    text-align: center; /* Pusatkan teks */
    background: rgba(240, 255, 255, 1); /* Tambahkan latar belakang transparan */
    color: white;       /* Warna teks putih */
    padding: 20px;
    border-radius: 10px; /* Opsional: sudut melengkung */
}

/* Login box styling */
.login-box h2 {
    margin-bottom: 20px;
    color: #333333;
    font-size: 24px;
    font-weight: bold;
    justify-content: center;
}

/* Input fields styling */
.input-group {
    margin-bottom: 15px;
    position: relative;
}

.input-group input {
    width: 300px;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    outline: none;
    font-size: 16px;
    transition: border-color 0.3s;
}

.input-group input:focus {
    border-color: #3f51b5;
}

/* Button styling */
.btn {
    width: 100px;
    padding: 10px;
    background-color: #3498db;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Menambahkan bayangan pada tombol */
}

.btn:hover {
    background-color: #0000ff;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Menambah bayangan lebih gelap saat hover */
}

.btn-google {
    width: 200px;
    margin-top: 20px;
    padding: 10px;
    background-color: #ffffff;
    color: #000000;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
    text-decoration: none; /* Menghilangkan garis bawah pada tautan */
    display: inline-flex; /* Menggunakan inline-flex untuk menyusun ikon dan teks */
    align-items: center; /* Mengatur ikon dan teks sejajar secara vertikal */
    justify-content: center; /* Mengatur konten agar berada di tengah */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Menambahkan bayangan pada tombol */
}

.google-icon {
    width: 20px; /* Ukuran gambar ikon */
    height: 20px; /* Ukuran gambar ikon */
    margin-right: 10px; /* Memberikan jarak antara ikon dan teks */
}

.btn-google:hover {
    background-color: #3498db;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Menambah bayangan lebih gelap saat hover */
}

/* Forgot link styling */
.forgot-link {
    display: inline-block;
    margin-top: 10px;
    font-size: 14px;
    color: #666666;
    text-decoration: none;
    transition: color 0.3s;
}

.forgot-link:hover {
    color: #3f51b5;
}

.slider{
	background: #67bef991;
}

section.slider{
    background: linear-gradient(rgba(0,0,0,.7), rgba(0,0,0,.7)), url("PerpusAzul.jpg") fixed;
	background-position: center;
	background-size: 100%;
	height: 100vh;
	background-repeat: no-repeat;
}

.font-slider{
	margin-top: 0px;
    padding: 100px;
	text-align: center;
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
<section class="slider">
    <div class="login-container">
        <div class="login-box">
            <h2>LOGIN</h2>
            <form method="POST" action="">
                <div class="input-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                    <input type="submit" name="login" value="Login" class="btn">
                <?php
                if (isset($error_message)) {
                    echo "<p style='color:red;'>$error_message</p>";
                }
                ?>
                <div style="margin-top: 20px;">
                    <a href="<?= $loginUrl ?>" class="btn-google">
                        <img src="google-icon.png" alt="Google Icon" class="google-icon"> Login with Google
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
</body>
</html>
