<?php
//include file config.php
include('connect.php');
 
//jika benar mendapatkan GET id dari URL
if(isset($_GET['no_rsvs'])){
	//membuat variabel $id yang menyimpan nilai dari $_GET['id']
	$no_rsvs = $_GET['no_rsvs'];
	
	//melakukan query ke database, dengan cara SELECT data yang memiliki id yang sama dengan variabel $id
	$cek = mysqli_query($conn, "SELECT * FROM reservasi WHERE no_rsvs='$no_rsvs'") or die(mysqli_error($conn));
	
	//jika query menghasilkan nilai > 0 maka eksekusi script di bawah
	if(mysqli_num_rows($cek) > 0){
		//query ke database DELETE untuk menghapus data dengan kondisi id=$id
		$del = mysqli_query($conn, "DELETE FROM reservasi WHERE no_rsvs='$no_rsvs'") or die(mysqli_error($coneksi));
		if($del){
			echo '<script>alert("Berhasil menghapus data."); document.location="reservasi.php";</script>';
		}else{
			echo '<script>alert("Gagal menghapus data."); document.location="reservasi.php";</script>';
		}
	}else{
		echo '<script>alert("no_rsvs tidak ditemukan di database."); document.location="reservasi.php";</script>';
	}
}else{
	echo '<script>alert("no_rsvs tidak ditemukan di database."); document.location="reservasi.php";</script>';
}
 
?>