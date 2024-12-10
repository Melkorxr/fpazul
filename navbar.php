<?php include('connect.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Great Azul</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        /* Styling untuk navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
        }

        .navbar-brand {
            height: 50px;
            width: 80px;
        }

        .menu-btn {
            font-size: 30px;
            color: white;
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Navbar Collapse */
        .navbar-collapse {
            flex-grow: 1;
            justify-content: flex-end;
        }

        .nav-link {
            color: white !important;
        }

        /* Responsif untuk layar lebih kecil (mobile) */
        @media (max-width: 767px) {
            .navbar-collapse {
                text-align: center;
                width: 100%;
            }

            .menu-btn {
                display: block; /* Menampilkan tombol menu pada layar kecil */
            }

            .navbar-nav {
                flex-direction: column; /* Menyusun menu secara vertikal pada layar kecil */
                width: 100%;
            }

            .navbar-nav .nav-item {
                padding: 10px 0;
            }

            .navbar-brand {
                width: 60px; /* Menyesuaikan ukuran logo di layar kecil */
                height: 40px;
            }
        }

        /* Untuk elemen yang berada di dalam container */
        .container-1 {
            transform: translateX(225px); /* Geser sejauh lebar sidebar */
        }

        .left-bar, .right-bar {
            margin: 0 10px; /* Opsional: Memberi jarak antar elemen */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top navbar-azul" id="myHeader">
        <div class="container-fluid"> <!-- Gunakan container-fluid untuk fleksibilitas -->
            <!-- Tombol toggle sidebar (untuk layar besar dan kecil) -->
            <button class="menu-btn" onclick="toggleSidebar()">&#x22EE;</button>
            
            <!-- Logo -->
            <img src="LogoAzul.png" alt="Logo" class="navbar-brand">

            <!-- Navbar Collapse untuk menu di layar kecil -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ml-auto"> <!-- ml-auto mendorong elemen ke kanan -->
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php" style="color: #ffffff;">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIKb7ZKzI7G7tJm2Q/Jr1baKmlreCg7zi9p60uK6q4A1/J40y4n9P" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqduiT6nM4wqp5a8R6dV0gxkFmd28bgvvfFwq9eXk2eJ8" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqduiT6nM4wqp5a8R6dV0gxkFmd28bgvvfFwq9eXk2eJ8" crossorigin="anonymous"></script>

    <script>
        // Fungsi toggle sidebar (jika diperlukan)
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }
    </script>
</body>
</html>
