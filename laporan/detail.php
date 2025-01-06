<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location:./../login.php');
}

include("./../koneksi.php");

// cek apakah 'id' ada di URL
if (!isset($_GET['id'])) {
    header('Location: laporan.php');
}

// ambil ID dari URL
$id = $_GET['id'];
// query untuk mengambil detail penjualan berdasarkan no nota
$sql = "SELECT a.kode, a.nama, b.jumlah, b.subtotal 
        FROM tabel_barang a, detailpenjualan b 
        WHERE a.kode = b.kode AND nonota = '$id' 
        ORDER BY a.kode";
$query = mysqli_query($conn, $sql);

// ambil data barang dari hasil query
$barang = mysqli_fetch_assoc($query);

// cek apakah data ditemukan
if (mysqli_num_rows($query) < 1) {
    die("Data tidak ditemukan..."); // tampilkan pesan jika tidak ada data
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Detail Penjualan</title>
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

        h2, h3 {
            margin: 0;
        }

        nav {
            padding: 10px;
            background-color: #f9f9f9;
            text-align: center;
        }

        nav a {
            font-size: 16px;
            color: #007bff;
            text-decoration: none;
            margin: 0 10px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .table-container {
            text-align: center;
            padding: 20px;
        }
    </style>
</head>

<body>
    <header>
        <h2>Detail Laporan Penjualan</h2>
    </header>
    <nav>
        <a href="../penjualan/form_penjualan.php">[+] Tambah Penjualan Baru</a> ----
        <a href="./../dashboard.html">[+] Menu Utama</a>
    </nav>

    <header>
        <?php
        $id = $_GET['id'];
        $tanggal = $_GET['tanggal'];
        ?>
        <h3>No. Nota: <?php echo $id; ?> || Tanggal: <?php echo $tanggal; ?></h3> <!-- tampilkan no nota dan tanggal -->
    </header>
    <br>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1; // inisialisasi nomor urut
                // query untuk mengambil detail penjualan berdasarkan no nota
                $sql = "SELECT a.kode, a.nama, b.jumlah, b.subtotal 
                        FROM tabel_barang a, detailpenjualan b 
                        WHERE a.kode = b.kode AND nonota = '$id' 
                        ORDER BY a.kode";
                $query = mysqli_query($conn, $sql);
                // loop untuk menampilkan setiap barang
                while ($barang = mysqli_fetch_array($query)) {
                    echo "<tr>";
                    echo "<td>" . $no . "</td>";
                    echo "<td>" . $barang['kode'] . "</td>";
                    echo "<td>" . $barang['nama'] . "</td>";
                    echo "<td>" . $barang['jumlah'] . "</td>";
                    echo "<td>" . $barang['subtotal'] . "</td>";
                    echo "</tr>";
                    $no++; // increment nomor urut
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
