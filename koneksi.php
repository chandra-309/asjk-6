<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kernel_coffee";

// Buat koneksi menggunakan mysqli_connect
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
