<?php
session_start();
include 'connect.php';

if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);

    // Verifikasi token
    $query = "SELECT * FROM users WHERE reset_token='$token' AND token_expires > NOW()";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        if (isset($_POST['reset_password'])) {
            $row = mysqli_fetch_assoc($result);
            $email = $row['username'];
            $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Perbarui password dan hapus token
            $query = "UPDATE users SET password='$hashed_password', reset_token=NULL, token_expires=NULL WHERE username='$email'";
            mysqli_query($conn, $query);

            echo "Password has been reset successfully!";
            exit();
        }
    } else {
        echo "Invalid or expired token.";
        exit();
    }
} else {
    echo "No token provided.";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <form method="POST" action="">
        <h2>Set New Password</h2>
        <label>New Password:</label>
        <input type="password" name="new_password" required>
        <button type="submit" name="reset_password">Reset Password</button>
    </form>
</body>
</html>
