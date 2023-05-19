<?php

require_once "../koneksi.php";
// menangkap data yang dikirim dari form

$username = $_POST['username'];
$password = $_POST['password'];


// mengaktifkan session php
// menyeleksi data admin dengan username dan password yang sesuai


if((ctype_alpha($username))&&($username!=NULL)&&($password!=NULL)){

    $password = MD5($password);

	$data = mysqli_query($koneksi, "select * from users where username='$username' and password='$password'");
	
	// menghitung jumlah data yang ditemukan
	$cek = mysqli_num_rows($data);
	
	if ($cek>0) {
		$fetch = mysqli_fetch_assoc($data);
		// cek jika user login sebagai admin
		if (($fetch['level'] == "admin")) {
			// buat session login dan username
			$_SESSION['username'] = $username;
			$_SESSION['status'] = "login";
			$_SESSION['level'] = "admin";
			header("location:../");
		} 
		else {
			$_SESSION['username'] = $username;
			$_SESSION['status'] = "login";
			$_SESSION['level'] = $fetch['level'];
			header("location: ../");
		}
	}
	else{
		header("location:../HTML CSS/login.php?pesan=gagal");
	}
}
else{
	header("location:../HTML CSS/login.php?pesan=gagal2");
}
?>

