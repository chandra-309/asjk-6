<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location:./../login.php');
}
?>
<?php
include "./../koneksi.php";
$data = mysqli_query($conn, "SELECT * FROM tabel_barang");
$op = isset($_GET['op']) ? $_GET['op'] : null;

if ($op == 'ambildata') {
    $kode = $_GET['kode'];
    $dt = mysqli_query($conn, "SELECT * FROM tabel_barang WHERE kode='$kode'");
    $d = mysqli_fetch_array($dt);

    echo $d['nama'] . "|" . $d['hrg_jual'] . "|" . $d['stok'] . "|" . $d['kode'] . "|" . $d['ukuran'];
}
?>
