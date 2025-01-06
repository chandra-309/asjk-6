<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ./../login.php');
    exit();
}

include("./../koneksi.php");

// Cek apakah ID diberikan
if (!isset($_GET['id'])) {
    header('Location: list_barang.php');
    exit();
}

$id = $_GET['id'];

// Query untuk mendapatkan data barang berdasarkan ID
$hs = "SELECT * FROM tabel_barang WHERE kode='$id'";
$hb = mysqli_query($conn, $hs);

// Cek apakah query berhasil dieksekusi
if (!$hb) {
    die("Query gagal: " . mysqli_error($conn));
}

// Cek apakah data ditemukan
if (mysqli_num_rows($hb) < 1) {
    die("Data tidak ditemukan...");
}

// Ambil data barang
$barang = mysqli_fetch_assoc($hb);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang | Minimarket</title>
</head>

<body>
    <header>
        <h3>Formulir Edit Barang</h3>
    </header>
    <form action="proses_edit_barang.php" method="POST">
        <p>
            <label for="kode">Kode Barang: </label>
            <input type="text" name="kodeBarang" value="<?php echo htmlspecialchars($barang['kode']); ?>" readonly />
        </p>
        <p>
            <label for="nama">Nama: </label>
            <input type="text" name="nama" value="<?php echo htmlspecialchars($barang['nama']); ?>" />
        </p>
        <p>
            <label for="hargaBeli">Harga Beli/Kulakan: </label>
            <input type="number" name="hargaBeli" value="<?php echo htmlspecialchars($barang['hrg_beli']); ?>" />
        </p>
        <p>
            <label for="hargaJual">Harga Jual: </label>
            <input type="number" name="hargaJual" value="<?php echo htmlspecialchars($barang['hrg_jual']); ?>" />
        </p>
        <p>
            <label for="stok">Stok: </label>
            <input type="number" name="stok" value="<?php echo htmlspecialchars($barang['stok']); ?>" />
        </p>

        <p>
            <label for="ukuran">Ukuran: </label>
            <select name="ukuran" id="ukuran">
                <option value="<?php echo htmlspecialchars($barang['ukuran']); ?>"><?php echo htmlspecialchars($barang['ukuran']); ?></option>
                <option value="Small">Small</option>
                <option value="Medium">Medium</option>
                <option value="Large">Large</option>
            </select>
        </p>

        <p>
            <label for="wadah">Wadah: </label>
            <input type="text" name="wadah" value="<?php echo htmlspecialchars($barang['wadah']); ?>" />
        </p>
        <p>
            <label for="keterangan">Keterangan: </label>
            <input type="text" name="keterangan" value="<?php echo htmlspecialchars($barang['keterangan']); ?>" />
        </p>
        <p>
            <input type="submit" value="Update" name="simpan" />
        </p>
    </form>
</body>

</html>
