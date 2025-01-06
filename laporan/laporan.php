<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location:./../login.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }

        header {
            text-align: center;
            background-color: #007bff;
            color: white;
            padding: 15px 0;
            margin-bottom: 20px;
        }

        h3 {
            margin: 0;
            font-size: 28px;
        }

        nav {
            margin-bottom: 20px;
            text-align: center;
            font-size: 16px;
        }

        nav a {
            text-decoration: none;
            color: #007bff;
            padding: 10px 20px;
            margin: 0 10px;
            border-radius: 5px;
            background-color: #e9ecef;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #d6d8db;
            color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        td {
            color: #555;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        p {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }

        a {
            font-size: 14px;
            text-decoration: none;
            color: #28a745;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .total-barang {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-top: 20px;
            text-align: center;
        }

        .total-barang span {
            color: #007bff;
        }
    </style>
</head>

<body>
    <header>
        <h3>Laporan Penjualan</h3>
    </header>
    <nav>
        <a href="../penjualan/form_penjualan.php">[+] Tambah Penjualan Baru</a> ----
        <a href="./../dashboard.html">[+] Menu Utama</a>
    </nav>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Nota</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>ID Pegawai</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include("./../koneksi.php");
            $no = 1;
            $sql = "SELECT * FROM penjualan";
            $query = mysqli_query($conn, $sql);
            while ($barang = mysqli_fetch_array($query)) {
                echo "<tr>";
                echo "<td>" . $no . "</td>";
                echo "<td>" . $barang['nonota'] . "</td>";
                echo "<td>" . $barang['tanggal'] . "</td>";
                echo "<td>" . $barang['total'] . "</td>";
                echo "<td>" . $barang['id_pegawai'] . "</td>";
                echo "<td>";
                echo "<a href='detail.php?id=" . $barang['nonota'] . "&tanggal=" . $barang['tanggal'] . "'>Detail</a>";
                echo "</td>";
                echo "</tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>

    <div class="total-barang">
        <p>Total Barang: <span><?php echo mysqli_num_rows($query); ?></span></p>
    </div>
</body>

</html>
