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
    <h2>Edit Buku</h2>
    
    <hr>
    
    <?php
    // Cek apakah ada parameter id_buku di URL
    if (isset($_GET['id_buku'])) {
        // Menyimpan id_buku dari URL
        $id_buku = $_GET['id_buku'];
        
        // Query untuk mengambil data berdasarkan id_buku
        $select = mysqli_query($conn, "SELECT * FROM buku WHERE id_buku='$id_buku'");
        
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
        // Jika id_buku tidak ada di URL, tampilkan pesan kesalahan
        echo '<div class="alert alert-danger">No peminjaman tidak ditemukan di URL.</div>';
        exit();
    }
    ?>
    
    <?php
    // Cek jika tombol simpan ditekan
    if (isset($_POST['submit'])) {
        // Ambil data dari form
        $id_buku = $_POST['id_buku'];
        $judul_buku = $_POST['judul_buku'];
        $penulis = $_POST['penulis'];
        $tahun_terbit = $_POST['tahun_terbit'];
        $jenis_buku = $_POST['jenis_buku'];
        $bahasa = $_POST['bahasa'];
        $ketersedian = $_POST['ketersedian'];
        
        // Query untuk memperbarui data
        $sql = mysqli_query($conn, "UPDATE buku SET penulis='$penulis', tahun_terbit='$tahun_terbit', id_buku='$id_buku', jenis_buku='$jenis_buku', bahasa='$bahasa', ketersedian='$ketersedian' WHERE id_buku='$id_buku'");
        
        // Cek jika query berhasil
        if ($sql) {
            echo '<script>alert("Berhasil menyimpan data."); document.location="editbuku.php?id_buku='.$id_buku.'";</script>';
        } else {
            echo '<div class="alert alert-warning">Gagal melakukan proses edit data.</div>';
        }
    }
    ?>
    
    <!-- Form untuk mengedit peminjaman -->
    <form action="editbuku.php?id_buku=<?php echo $id_buku; ?>" method="post">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">ID Buku</label>
            <div class="col-sm-10">
                <input type="hidden" name="id_buku" value="<?php echo $id_buku; ?>">
                <input type="text" name="judul_buku" class="form-control" value="<?php echo isset($data['judul_buku']) ? $data['judul_buku'] : ''; ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Penulis</label>
            <div class="col-sm-10">
                <input type="text" name="penulis" class="form-control" value="<?php echo isset($data['penulis']) ? $data['penulis'] : ''; ?>" required>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Tahun Terbit</label>
            <div class="col-sm-10">
                <input type="number" name="tahun_terbit" class="form-control" value="<?php echo isset($data['tahun_terbit']) ? $data['tahun_terbit'] : ''; ?>" required>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Jenis Buku</label>
            <div class="col-sm-10">
                <input type="text" name="jenis_buku" class="form-control" value="<?php echo isset($data['jenis_buku']) ? $data['jenis_buku'] : ''; ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Bahasa</label>
            <div class="col-sm-10">
                <input type="text" name="bahasa" class="form-control" value="<?php echo isset($data['bahasa']) ? $data['bahasa'] : ''; ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">ketersedian</label>
            <div class="col-sm-10">
                <input type="text" name="ketersedian" class="form-control" value="<?php echo isset($data['ketersedian']) ? $data['ketersedian'] : ''; ?>" required>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">&nbsp;</label>
            <div class="col-sm-10">
                <input type="submit" name="submit" class="btn btn-primary" value="SIMPAN">
                <a href="buku.php" class="btn btn-warning">KEMBALI</a>
            </div>
        </div>
    </form>
    
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>
