<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location:./../login.php');
}
?>
<?php
include "./../koneksi.php";
$tanggal = date("Y-m-d");
$jmlh_belanja = $_POST['jumlah_belanja'];
$total = $_POST['total'];
$id_pegawai = 1;

$sql = "INSERT INTO penjualan (tanggal, total, id_pegawai) VALUES ('$tanggal', '$total', '$id_pegawai')";
$query = mysqli_query($conn, $sql);

if ($query) {
    $auto = mysqli_query($conn, "SELECT * FROM penjualan ORDER BY nonota DESC LIMIT 1");
    $no = mysqli_fetch_array($auto);
    $angka = $no['nonota'];
    $panjang = count($_POST['jml_beli']);

    for ($i = 0; $i < $panjang; $i++) {
        $kode = $_POST['kode'];
        $harga = $_POST['harga'];
        $jml_beli = $_POST['jml_beli'];
        $subtotal = $_POST['subtotal'];

        $sqldetail = "INSERT INTO detailpenjualan (nonota, kode, harga, jumlah, subtotal) VALUES ('$angka', '$kode[$i]', '$harga[$i]', '$jml_beli[$i]', '$subtotal[$i]')";
        $query1 = mysqli_query($conn, $sqldetail);

        $sisa = $_POST['sisa'];
        $sqlupdate = "UPDATE tabel_barang SET stok = '$sisa[$i]' WHERE kode = '$kode[$i]'";
        $queryupdate = mysqli_query($conn, $sqlupdate);
    }
    echo "Pembelian $angka berhasil disimpan";
?>
    <a href="../dashboard.html">[+] Menu Utama</a>
<?php
} else {
    echo "Pembelian $angka Gagal disimpan";
}
?>