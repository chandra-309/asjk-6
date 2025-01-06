<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location:./../login.php');
    exit();
}

include("./../koneksi.php"); // Pastikan Anda sudah menghubungkan file koneksi.php

// Mengambil kode barang terakhir
$sql = "SELECT kode FROM tabel_barang ORDER BY kode DESC LIMIT 1";
$query = mysqli_query($conn, $sql);

// Mengecek apakah ada data kode barang sebelumnya
if ($query && mysqli_num_rows($query) > 0) {
    $result = mysqli_fetch_assoc($query);
    $lastKode = $result['kode']; // Ambil kode barang terakhir
    $nextKode = 'BRG' . str_pad((intval(substr($lastKode, 3)) + 1), 2, '0', STR_PAD_LEFT); // Menangani format BRG01, BRG02, dst.
} else {
    $nextKode = 'BRG01'; // Jika belum ada barang, mulai dari BRG01
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Coffee Shop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        h3 {
            margin: 0;
            font-size: 24px;
        }

        form {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form p {
            margin-bottom: 15px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            outline: none;
            border-color: #007bff;
            background-color: #ffffff;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .form-container {
            padding: 20px;
        }

        .form-container p {
            margin: 10px 0;
        }

        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container select {
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <header>
        <h3>Formulir Tambah Barang</h3>
    </header>

    <div class="form-container">
        <form action="proses_simpan_barang.php" method="POST">
            <p>
                <label for="kode">Kode Barang: </label>
                <input type="text" name="kodeBarang" value="<?php echo $nextKode; ?>" readonly />
            </p>
            <p>
                <label for="nama">Nama: </label>
                <input type="text" name="nama" placeholder="Nama barang..." required />
            </p>
            <p>
                <label for="hrg_beli">Harga Beli/Kulakan: </label>
                <input type="number" name="hrg_beli" placeholder="Harga beli..." required />
            </p>
            <p>
                <label for="hrg_jual">Harga Jual: </label>
                <input type="number" name="hrg_jual" placeholder="Harga jual..." required />
            </p>
            <p>
                <label for="stok">Stok: </label>
                <input type="number" name="stok" placeholder="Stok..." required />
            </p>
            <p>
                <label for="ukuran">Ukuran:</label>
                <select name="ukuran">
                    <option value="Small">Small</option>
                    <option value="Medium">Medium</option>
                    <option value="Large">Large</option>
                </select>
            </p>
            <p>
                <label for="wadah">Wadah: </label>
                <input type="text" name="wadah" placeholder="Wadah..." required />
            </p>
            <p>
                <label for="keterangan">Keterangan: </label>
                <input type="text" name="keterangan" placeholder="Keterangan..." required />
            </p>
            <p>
                <input type="submit" value="Simpan" name="simpan" />
            </p>
        </form>
    </div>
</body>

</html>


