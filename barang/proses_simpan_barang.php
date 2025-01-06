<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location:./../login.php');
}

include("./../koneksi.php");


if (isset($_POST['simpan'])) {
    // mengambil data dari form input
    $kodeBarang = $_POST['kodeBarang'];
    $nama = $_POST['nama'];
    $hargaBeli = $_POST['hrg_beli'];
    $hargaJual = $_POST['hrg_jual'];
    $stok = $_POST['stok'];
    $ukuran = $_POST['ukuran'];
    $wadah = $_POST['wadah'];
    $keterangan = $_POST['keterangan'];

    try {
        // qery untuk menambahkan data barang baru ke dalam tabel_barang
        $sql = "INSERT INTO tabel_barang (kode, nama, hrg_beli, hrg_jual, stok, ukuran, wadah, keterangan) 
                VALUES ('$kodeBarang', '$nama', '$hargaBeli', '$hargaJual', '$stok', '$ukuran', '$wadah', '$keterangan')";

        $query = mysqli_query($conn, $sql); // eksekusi query

        // cek apakah query berhasil dijalankan
        if ($query) {
            header('Location: ./list_barang.php?status=sukses');
        } else {
            header('Location: ./list_barang.php?status=gagal');
        }
    } catch (mysqli_sql_exception $e) {
        header('Location: ./list_barang.php?status=gagal');
    }
} else {
    die("Akses dilarang...");
}
