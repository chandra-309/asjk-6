<?php
session_start();

// cek login
if (!isset($_SESSION['username'])) {
    header('Location:./../login.php'); // Jika belum login, alihkan ke halaman login
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Shop - Daftar Barang</title>
    <style>
        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        header {
            background-color: #6b4f4f;
            color: #fff;
            padding: 15px 20px;
            text-align: center;
        }

        header h3 {
            margin: 0;
        }

        nav {
            margin: 20px;
            text-align: center;
        }

        nav a {
            text-decoration: none;
            color: #fff;
            background-color: #6b4f4f;
            padding: 10px 15px;
            border-radius: 5px;
            margin-right: 10px;
        }

        nav a:hover {
            background-color: #8d6e63;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #6b4f4f;
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .total-barang {
            margin: 20px auto;
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
        }

        p.status {
            text-align: center;
            font-size: 1rem;
            color: green;
        }

        p.status.error {
            color: red;
        }
    </style>
</head>

<body>
    <header>
        <h3>Daftar Barang</h3>
    </header>

    <nav>
        <!-- link untuk menambah barang baru atau kembali ke menu utama -->
        <a href="tambah_barang.php">[+] Tambah Baru</a>
        <a href="./../dashboard.html">[+] Menu Utama</a>
    </nav>

    <?php if (isset($_GET['status'])) { ?>
        <p class="status <?php echo $_GET['status'] == 'sukses' ? '' : 'error'; ?>">
            <?php
            // menampilkan status setelah simpan data
            echo $_GET['status'] == 'sukses' ? "Simpan Data Berhasil!" : "Simpan Data Gagal!";
            ?>
        </p>
    <?php } ?>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Ukuran</th>
                <th>Wadah</th>
                <th>Keterangan</th>
                <th>Tindakan</th>
                <th>Barcode</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include("./../koneksi.php");
            $no = 1;
            $sql = "SELECT * FROM tabel_barang";
            $query = mysqli_query($conn, $sql);

            // looping untuk menampilkan data barang
            while ($barang = mysqli_fetch_array($query)) {
                echo "<tr>";
                echo "<td>" . $no . "</td>";
                echo "<td>" . $barang['kode'] . "</td>";
                echo "<td>" . $barang['nama'] . "</td>";
                echo "<td>" . $barang['hrg_beli'] . "</td>";
                echo "<td>" . $barang['hrg_jual'] . "</td>";
                echo "<td>" . $barang['stok'] . "</td>";
                echo "<td>" . $barang['ukuran'] . "</td>";
                echo "<td>" . $barang['wadah'] . "</td>";
                echo "<td>" . $barang['keterangan'] . "</td>";
                echo "<td>";
                echo "<a href='edit_barang.php?id=" . $barang['kode'] . "'>Edit</a>  ";
                echo "<a href='hapus_barang.php?id=" . $barang['kode'] . "'>Hapus</a>";
                echo "</td>";
                echo "<td>";
                echo "<a href='./../js/barcode.php?text=" . $barang['kode'] . "&codetype=code128&print=true&size=55' target='_blank'>Barcode</a>";
                echo "</td>";
                echo "</tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>

    <p class="total-barang">Total Barang: <?php echo mysqli_num_rows($query); ?></p>
</body>

</html>
