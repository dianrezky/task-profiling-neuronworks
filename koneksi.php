<?php
session_start();
//Membuat koneksi database
$koneksi = mysqli_connect("localhost", "root", "", "sql_task");

// Check connection
if (mysqli_connect_errno()) {
	echo "Koneksi database gagal : " . mysqli_connect_error();
}
?>