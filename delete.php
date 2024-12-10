<?php
//include file config.php
include('connect.php');
 
//jika benar mendapatkan GET id dari URL
if(isset($_GET['nomor_kunjungan'])){
	//membuat variabel $id yang menyimpan nilai dari $_GET['id']
	$nomor_kunjungan = $_GET['nomor_kunjungan'];
	
	//melakukan query ke database, dengan cara SELECT data yang memiliki id yang sama dengan variabel $id
	$cek = mysqli_query($conn, "SELECT * FROM pengunjung WHERE nomor_kunjungan='$nomor_kunjungan'") or die(mysqli_error($conn));
	
	//jika query menghasilkan nilai > 0 maka eksekusi script di bawah
	if(mysqli_num_rows($cek) > 0){
		//query ke database DELETE untuk menghapus data dengan kondisi id=$id
		$del = mysqli_query($conn, "DELETE FROM pengunjung WHERE nomor_kunjungan='$nomor_kunjungan'") or die(mysqli_error($conn));
		if($del){
			echo '<script>alert("Berhasil menghapus data."); document.location="home.php";</script>';
		}else{
			echo '<script>alert("Gagal menghapus data."); document.location="home.php";</script>';
		}
	}else{
		echo '<script>alert("Nomor kunjungan tidak ditemukan di database."); document.location="home.php";</script>';
	}
}else{
	echo '<script>alert("Nomor Kunjungan tidak ditemukan di database."); document.location="home.php";</script>';
}
 
?>