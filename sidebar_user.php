<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Great Azul</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style>
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: #808080;
            color: white;
            transform: translateX(-250px);
            transition: transform 0.3s ease-in-out;
            z-index: 1050;
        }
        .sidebar.open {
            transform: translateX(0);
        }
        .sidebar a {
            color: white;
            padding: 10px 15px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        
        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .menu-btn {
            color: white;
            font-size: 24px;
            cursor: pointer;
            border: none;
            background: none;
            outline: none;
            transition: transform 0.3s ease-in-out;
        }
        .navbar .navbar-brand {
            cursor: pointer;
            border: none;
            background: none;
            outline: none;
            transition: transform 0.3s ease-in-out;
        }

        .image-container {
          display: flex;
          justify-content: center;
          align-items: center;
          height: 10%; /* Sesuaikan dengan tinggi yang diinginkan */
        }

        .sd-container {
          display: flex;
          justify-content: center; /* Memusatkan secara horizontal */
          align-items: center; /* Memusatkan secara vertikal */
          padding: 5px;
          margin-left: 0px;
          font-size: 14px;
          font-weight: bold;
          color: #000000;
        }

        .sd-container, .image-container {
          background-color: #808080;
        }

        /* Responsif untuk layar lebih kecil (mobile) */
        @media (max-width: 767px) {
            .sidebar {
                width: 200px; /* Lebar sidebar lebih kecil pada perangkat mobile */
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .container-1 {
                transform: translateX(0); /* Menyesuaikan konten saat sidebar terbuka */
            }

            /* Tombol titik 3 di navbar bergerak ke kanan saat sidebar terbuka */
            .navbar .menu-btn {
                left: 220px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="image-container">
          <img src="iconuser.png" height="80px" width="80px">
        </div>
        <div class="sd-container">
          <p><?php echo $_SESSION['username']; ?></p>
        </div>
        <a href="dashboard_user.php" style="font-weight: bold;">Dashboard</a>
        <a href="buku_user.php" style="font-weight: bold;">Data Buku</a>
        <a href="tambahreservasi_user.php" style="font-weight: bold;">Reservasi</a>
        <a href="riwayat_pinjam.php" style="font-weight: bold;">Riwayat Peminjaman</a>
        <a href="request_resetuser.php" style="font-weight: bold;">Reset Password</a>
        <a href="about.php" style="font-weight: bold;">About Us</a>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const menuBtn = document.querySelector('.menu-btn');
            const navBrand = document.querySelector('.navbar-brand');

            if (sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
                menuBtn.style.transform = 'translateX(0)';
                navBrand.style.transform = 'translateX(0)';
            } else {
                sidebar.classList.add('open');
                menuBtn.style.transform = 'translateX(250px)';
                navBrand.style.transform = 'translateX(250px)';
            }
        }
    </script>
</body>
</html>
