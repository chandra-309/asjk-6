<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location:./../login.php');
}
?>

<?php
include("./../koneksi.php");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM tabel_barang WHERE kode='$id'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header('Location: list_barang.php');
    } else {
        die("Gagal menghapus...");
    }
} else {
    die("Akses dilarang...");
}
?>
