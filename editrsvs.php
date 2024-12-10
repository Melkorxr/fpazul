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
    <h2>Edit Reservasi</h2>
    
    <hr>
    
    <?php
    // Cek apakah ada parameter no_rsvs di URL
    if (isset($_GET['no_rsvs'])) {
        // Menyimpan no_rsvs dari URL
        $no_rsvs = $_GET['no_rsvs'];
        
        // Query untuk mengambil data berdasarkan no_rsvs
        $select = mysqli_query($conn, "SELECT * FROM reservasi WHERE no_rsvs='$no_rsvs'");
        
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
        // Jika no_rsvs tidak ada di URL, tampilkan pesan kesalahan
        echo '<div class="alert alert-danger">No peminjaman tidak ditemukan di URL.</div>';
        exit();
    }
    ?>
    
    <?php
    // Cek jika tombol simpan ditekan
    if (isset($_POST['submit'])) {
        // Ambil data dari form
        $no_rsvs = $_POST['no_rsvs'];
        $nama = $_POST['nama'];
        $id_buku = $_POST['id_buku'];
        $tanggal_pengambilan = $_POST['tanggal_pengambilan'];
        $kontak = $_POST['kontak'];
        $status = $_POST['status'];
        
        // Query untuk memperbarui data
        $sql = mysqli_query($conn, "UPDATE reservasi SET tanggal_pengambilan='$tanggal_pengambilan', kontak='$kontak', id_buku='$id_buku', nama='$nama', status='$status' WHERE no_rsvs='$no_rsvs'");
        
        // Cek jika query berhasil
        if ($sql) {
            echo '<script>alert("Berhasil menyimpan data."); document.location="editrsvs.php?no_rsvs='.$no_rsvs.'";</script>';
        } else {
            echo '<div class="alert alert-warning">Gagal melakukan proses edit data.</div>';
        }
    }
    ?>
    
    <!-- Form untuk mengedit peminjaman -->
    <form action="editrsvs.php?no_rsvs=<?php echo $no_rsvs; ?>" method="post">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Atas Nama</label>
            <div class="col-sm-10">
                <input type="hidden" name="no_rsvs" value="<?php echo $no_rsvs; ?>">
                <input type="text" name="nama" class="form-control" value="<?php echo isset($data['nama']) ? $data['nama'] : ''; ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">ID Buku</label>
            <div class="col-sm-10">
                <input type="text" name="id_buku" class="form-control" value="<?php echo isset($data['id_buku']) ? $data['id_buku'] : ''; ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Tanggal Pengambilan</label>
            <div class="col-sm-10">
                <input type="datetime-local" name="tanggal_pengambilan" class="form-control" value="<?php echo isset($data['tanggal_pengambilan']) ? $data['tanggal_pengambilan'] : ''; ?>" required>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Kontak</label>
            <div class="col-sm-10">
                <input type="number" name="kontak" class="form-control" value="<?php echo isset($data['kontak']) ? $data['kontak'] : ''; ?>" required>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">status</label>
            <div class="col-sm-10">
                <input type="text" name="status" class="form-control" value="<?php echo isset($data['status']) ? $data['status'] : ''; ?>" required>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">&nbsp;</label>
            <div class="col-sm-10">
                <input type="submit" name="submit" class="btn btn-primary" value="SIMPAN">
                <a href="reservasi.php" class="btn btn-warning">KEMBALI</a>
            </div>
        </div>
    </form>
    
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>
