<?php
session_start();
include 'connect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Pastikan PHPMailer diinstal dan autoload-nya benar

// Setel zona waktu ke Waktu Indonesia Bagian Barat (WIB)
date_default_timezone_set('Asia/Jakarta');

if (isset($_POST['request_reset'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Cek apakah email terdaftar
    $query = "SELECT * FROM users WHERE username='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $token = bin2hex(random_bytes(32)); // Token unik
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour")); // Token berlaku 1 jam sesuai WIB

        // Simpan token ke tabel users
        $query = "UPDATE users SET reset_token='$token', token_expires='$expires' WHERE username='$email'";
        mysqli_query($conn, $query);

        // Kirim email reset password menggunakan PHPMailer
        $reset_link = "http://localhost/reset_password.php?token=$token";
        $mail = new PHPMailer(true);
        
        try {
            // Pengaturan Server SMTP
            $mail->isSMTP();                                            // Set email menggunakan SMTP
            $mail->Host = 'smtp.gmail.com';                               // Ganti dengan server SMTP yang digunakan (misal Gmail)
            $mail->SMTPAuth = true;                                       // Aktifkan otentikasi SMTP
            $mail->Username = 'yayatipango@students.amikom.ac.id';                     // Ganti dengan email pengirim
            $mail->Password = '@pleasehelpme';                      // Ganti dengan password email pengirim
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           // Gunakan enkripsi TLS
            $mail->Port = 587;                                            // Port SMTP untuk TLS

            // Pengaturan pengirim dan penerima
            $mail->setFrom('your-email@gmail.com', 'Your Website');       // Ganti dengan alamat pengirim
            $mail->addAddress($email);                                    // Tambahkan email penerima
            $mail->isHTML(true);                                           // Kirim email dalam format HTML
            $mail->Subject = 'Reset Your Password';
            $mail->Body    = "Click this link to reset your password: <a href='$reset_link'>$reset_link</a>";
            
            // Kirim email
            $mail->send();
            #echo "Check your email for the password reset link.";
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        echo "Email is not registered.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/pmg/jpg" href="LogoAzul.png">
</head>
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
<body>
<?php 
include 'navbar.php';
include 'sidebar.php';
?>
<section class="slider">
    <div class="container" style="padding:20px">
        <h2 style="color: #ffffff">Reset Password</h2>
        <hr>
        <form method="POST" action="">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" style="color: #ffffff">Email</label>
                <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" required placeholder="Masukkan Alamat Email">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">&nbsp;</label>
                <div class="col-sm-10">
                    <br>
                    <input type="submit" name="request_reset" class="btn btn-primary" value="SIMPAN">
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

</body>
</html>
