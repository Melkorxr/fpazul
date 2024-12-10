<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Koneksi ke database
include('connect.php');

// Proses saat form disubmit
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $id_buku = $_POST['id_buku'];
    $tanggal_pengambilan = $_POST['tanggal_pengambilan'];
    $kontak = $_POST['kontak'];


    // Ambil username dari session
    $username = $_SESSION['username'];

    // Cari ID pengguna berdasarkan username
    $query_user = "SELECT id FROM users WHERE username = '$username'";
    $result_user = mysqli_query($conn, $query_user);

    if ($result_user && mysqli_num_rows($result_user) > 0) {
        $row_user = mysqli_fetch_assoc($result_user);
        $user_id = $row_user['id']; // ID pengguna

        // Query untuk memasukkan data ke dalam tabel pinjam
        $query_insert = "INSERT INTO reservasi (nama, id_buku, tanggal_pengambilan, kontak, user) 
                         VALUES ('$nama', '$id_buku', '$tanggal_pengambilan', '$kontak', '$user_id')";

        // Eksekusi query
        if (mysqli_query($conn, $query_insert)) {
            echo "<script>alert('Peminjaman berhasil ditambahkan'); window.location.href='tambahreservasi_user.php';</script>";
        } else {
            echo "Error: " . $query_insert . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Pengguna tidak ditemukan.'); window.location.href='tambahreservasi_user.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>The Great Azul</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/pmg/jpg" href="LogoAzul.png">
    <style>
        .slider {
            background: #67bef991;
        }
        section.slider {
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
        .footer h6 {
            margin: 0px;
        }
    </style>
</head>
<body>
<?php 
include 'navbar.php';
include 'sidebar_user.php';
?>
<section class="slider">    
    <div class="container" style="padding:20px">
        <h2 style="color: #ffffff">Reservasi</h2>
        <hr>
        <!-- Formulir Input -->
        <form action="" method="post">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" style="color: #ffffff">Atas Nama</label>
                <div class="col-sm-10">
                    <input type="text" name="nama" class="form-control" required placeholder="Masukkan Nama">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" style="color: #ffffff">ID Buku</label>
                <div class="col-sm-10">
                    <input type="text" name="id_buku" placeholder="Masukkan ID Buku" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" style="color: #ffffff">Tanggal Pengambilan</label>
                <div class="col-sm-10">
                    <input type="datetime-local" name="tanggal_pengambilan" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" style="color: #ffffff">Kontak</label>
                <div class="col-sm-10">
                    <input type="text" name="kontak" class="form-control" required placeholder="Masukkan Nomor Kontak yang bisa dihubungi">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">&nbsp;</label>
                <div class="col-sm-10">
                    <br>
                    <input type="submit" name="submit" class="btn btn-primary" value="SIMPAN">
                    <input type="reset" name="reset" class="btn btn-warning" value="RESET">
                </div>
            </div>
        </form>
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

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
