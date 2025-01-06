<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ./../login.php');
}

include("./../koneksi.php");


if (isset($_POST['simpan'])) {
    // mengambil data dari form input
    $kodeBarang = $_POST['kodeBarang'];
    $nama = $_POST['nama'];
    $hargaBeli = $_POST['hargaBeli'];
    $hargaJual = $_POST['hargaJual'];
    $stok = $_POST['stok'];
    $ukuran = $_POST['ukuran'];
    $wadah = $_POST['wadah'];
    $keterangan = $_POST['keterangan'];


    $sql = "UPDATE tabel_barang SET 
        nama='$nama', 
        hrg_beli='$hargaBeli', 
        hrg_jual='$hargaJual', 
        stok='$stok', 
        ukuran='$ukuran',
        wadah='$wadah', 
        keterangan='$keterangan' 
        WHERE kode='$kodeBarang'";

    $query = mysqli_query($conn, $sql); // eksekusi query

    if ($query) {
        header('Location: list_barang.php?status=sukses'); //  ke halaman list_barang dengan status sukses
        exit();
    } else {
        die("Gagal menyimpan perubahan..."); // menampilkan pesan error jika query gagal
    }
} else {
    die("Akses dilarang..."); // menampilkan pesan error jika form tidak di-submit
}
