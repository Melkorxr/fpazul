<?php include('connect.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>The Great Azul</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/png" href="LogoAzul.png">
</head>
<body>
<?php 
include 'navbar.php';
?>

<div class="container" style="margin-top:20px">
    <h2>Edit Peminjaman</h2>
    
    <hr>
    
    <?php
    // Cek apakah ada parameter no_pinjam di URL
    if (isset($_GET['no_pinjam'])) {
        // Menyimpan no_pinjam dari URL
        $no_pinjam = $_GET['no_pinjam'];
        
        // Query untuk mengambil data berdasarkan no_pinjam
        $select = mysqli_query($conn, "SELECT * FROM pinjam WHERE no_pinjam='$no_pinjam'");
        
        // Cek jika query gagal
        if (!$select) {
            die("Query gagal: " . mysqli_error($conn));  // Menampilkan pesan kesalahan jika query gagal
        }
        
        // Cek jika data ditemukan
        if (mysqli_num_rows($select) == 0) {
            echo '<div class="alert alert-warning">No peminjaman tidak ada dalam database.</div>';
            exit();
        } else {
            // Menyimpan data dari query ke variabel $data
            $data = mysqli_fetch_assoc($select);
        }
    } else {
        // Jika no_pinjam tidak ada di URL, tampilkan pesan kesalahan
        echo '<div class="alert alert-danger">No peminjaman tidak ditemukan di URL.</div>';
        exit();
    }
    ?>
    
    <?php
    // Cek jika tombol simpan ditekan
    if (isset($_POST['submit'])) {
        // Ambil data dari form
        $no_pinjam = $_POST['no_pinjam'];
        $id_buku = $_POST['id_buku'];
        $tanggal_pengembalian = $_POST['tanggal_pengembalian'];
        $kontak = $_POST['kontak'];
        $status = $_POST['status'];
        $user = $_POST['user'];
        
        // Query untuk memperbarui data
        $sql = mysqli_query($conn, "UPDATE pinjam SET tanggal_pengembalian='$tanggal_pengembalian', kontak='$kontak', id_buku='$id_buku', status='$status', user='$user' WHERE no_pinjam='$no_pinjam'");
        
        // Cek jika query berhasil
        if ($sql) {
            echo '<script>alert("Berhasil menyimpan data."); document.location="editpinjam.php?no_pinjam='.$no_pinjam.'";</script>';
        } else {
            echo '<div class="alert alert-warning">Gagal melakukan proses edit data.</div>';
        }
    }
    ?>
    
    <!-- Form untuk mengedit peminjaman -->
    <form action="editpinjam.php?no_pinjam=<?php echo $no_pinjam; ?>" method="post">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">ID BUKU</label>
            <div class="col-sm-10">
                <input type="hidden" name="no_pinjam" value="<?php echo $no_pinjam; ?>">
                <input type="text" name="id_buku" class="form-control" value="<?php echo isset($data['id_buku']) ? $data['id_buku'] : ''; ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">TANGGAL PENGEMBALIAN</label>
            <div class="col-sm-10">
                <input type="date" name="tanggal_pengembalian" class="form-control" value="<?php echo isset($data['tanggal_pengembalian']) ? $data['tanggal_pengembalian'] : ''; ?>" required>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">KONTAK</label>
            <div class="col-sm-10">
                <input type="number" name="kontak" class="form-control" value="<?php echo isset($data['kontak']) ? $data['kontak'] : ''; ?>" required>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                <input type="text" name="status" class="form-control" value="<?php echo isset($data['status']) ? $data['status'] : ''; ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">User</label>
            <div class="col-sm-10">
                <input type="text" name="user" class="form-control" value="<?php echo isset($data['user']) ? $data['user'] : ''; ?>" required>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">&nbsp;</label>
            <div class="col-sm-10">
                <input type="submit" name="submit" class="btn btn-primary" value="SIMPAN">
                <a href="pinjam.php" class="btn btn-warning">KEMBALI</a>
            </div>
        </div>
    </form>
    
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>
