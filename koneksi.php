<?php
session_start();
//Membuat koneksi database
$koneksi = mysqli_connect("localhost", "root", "", "sql_task");
$koneksi2 = mysqli_connect("localhost", "root", "", "task_gojek");

// Check connection
if (mysqli_connect_errno()) {
	echo "Koneksi database gagal : " . mysqli_connect_error();
}
?>