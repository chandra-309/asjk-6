<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location:./../login.php');
}
?>

<!DOCTYPE html>
<html>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f9f9f9;
    }

    h1, h2, h3, p {
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    table th, table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    table th {
        background-color: #f2f2f2;
        color: #333;
    }

    table td input {
        width: 100%;
        border: none;
        text-align: center;
        background-color: transparent;
    }

    table td input:focus {
        outline: none;
        border: 1px solid #007bff;
    }

    #tambah_tabel, #beli {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        font-size: 14px;
        border-radius: 5px;
    }

    #tambah_tabel:hover, #beli:hover {
        background-color: #0056b3;
    }

    select, input[type="text"], input[type="submit"], button {
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    select:focus, input:focus {
        border-color: #007bff;
        outline: none;
    }

    .form-actions {
        margin-top: 20px;
        text-align: center;
    }

    .form-actions input {
        font-size: 16px;
        width: auto;
        margin: 0 5px;
    }

    .btn {
        margin: 10px 0;
    }

    #jumlah_belanja, #tot {
        font-weight: bold;
        text-align: right;
        border: none;
        background-color: transparent;
        color: #333;
    }

    #template tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #template tr:hover {
        background-color: #ddd;
    }
</style>

<head>
    <title>Transaksi Penjualan</title>

    <script src="./../js/jquery-3.7.1.min.js"></script>
    <?php
    include "./../koneksi.php";
    $tgl = date('Y-m-d');
    $auto = mysqli_query($conn, "select * from penjualan order by nonota desc limit 1");
    $no = mysqli_fetch_array($auto);
    if ($no == null) {
        $angka = 1;
    } else {
        $angka = $no['nonota'] + 1;
    }
    echo "No. Nota : <input type='text' id='nota' value='$angka' readonly> 
          <input type='text' id='tanggal' value='$tgl' readonly>";
    ?>
</head>

<body>
    <br>
    <p>
        Transaksi Penjualan
        <br>
        <label>Nama Barang</label>
        <select id="kode">
            <?php
            include("./../koneksi.php");
            $sql = "SELECT * FROM tabel_barang";
            $query = mysqli_query($conn, $sql);
            while ($barang = mysqli_fetch_assoc($query)) {
                echo "<option value='" . $barang['kode'] . "'>" . $barang['nama'] . "</option>";
            }
            ?>
        </select>
        <input type="text" id="nama" value="" readonly>
        <input type="text" id="kode1" value="" readonly>
        <input type="text" id="harga" placeholder="Harga" class="span2" readonly>
        <input type="text" id="stok" name="stok" placeholder="Stok" class="span1" readonly>
        <input type="text" id="ukuran" placeholder="Ukuran" class="span2" readonly>
        <input type="text" id="jumlah" name="jumlah" onblur="cekstok()" placeholder="Jumlah Beli" class="span1">
        <button id="tambah_tabel" class="btn">Tambah</button>
    <table id="barang" class="table table-bordered"></table>
    <form method="post" action="proses_simpan_penjualan.php">
        <table id="tabelPinjam" name="tabelPinjam" border="1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Kode</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Ukuran</th>
                    <th>Beli</th>
                    <th>Sisa</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="template"></tbody>
        </table>
        <input type="text" id="jumlah_belanja" name="jumlah_belanja" value="" readonly>Jumlah Belanja
        <div class="form-actions">
            <input type="text" id="tot" name="total" value="0" readonly>
            <input type="submit" id="beli" value="Submit">
        </div>
        </p>
        <br>
    </form>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#kode").change(function() {
                let kode = $("#kode").val();
                //lakukan pengiriman data
                $.ajax({
                    url: "proses_ok.php",
                    data: "op=ambildata&kode=" + kode,
                    cache: false,
                    success: function(msg) {
                        data = msg.split("|");
                        //masukan isi data ke masing-masing field
                        $("#nama").val(data[0]);
                        $("#harga").val(data[1]);
                        $("#stok").val(data[2]);
                        $("#ukuran").val(data[4]); // Pastikan ini sesuai dengan urutan data
                        $("#kode1").val(data[3]);
                        $("#jumlah").focus();
                    }
                });
            });
        });

        function cekstok() {
            var stok = $("#stok").val();
            var jumlah = $("#jumlah").val();

            if (jumlah === "") {
                alert("Jumlah beli tidak boleh kosong.");
                return; // Hentikan eksekusi jika jumlah beli kosong
            }

            var hasil = stok - jumlah;
            if (hasil < 0) {
                alert("Stok Kurang, rubah jumlah pembelian !!!");
                document.getElementById("tambah_tabel").disabled = true;
                document.getElementById("beli").disabled = true;
            } else {
                document.getElementById("tambah_tabel").disabled = false;
                document.getElementById("beli").disabled = false;
            }
        }

        function findTotal() {
            var total = 0;
            $('.subtotal').each(function() {
                total += parseFloat($(this).val()) || 0;
            });
            $('#tot').val(total);
        }

        function deleteRow(button) {
            $(button).closest('tr').remove();
            const table = document.getElementById("tabelPinjam");
            // Mengambil semua baris (row) dalam tabel
            const rows = table.rows;
            document.getElementById('jumlah_belanja').value = rows.length - 1;
            findTotal();
        }

        function updatesubtotal(input) {
            var row = $(input).closest('tr');
            var jml_beli = row.find('.jml_beli').val();
            var stok = row.find('.stok').val();
            var harga = row.find('.harga').val();

            if (!isNaN(jml_beli) && !isNaN(stok) && !isNaN(harga)) {
                var stok_baru = stok - jml_beli;
                var harga_update = jml_beli * harga;
                if (stok_baru < 0) {
                    alert("Stok Habis, rubah pembelian !!!");
                    document.getElementById("tambah_tabel").disabled = true;
                    document.getElementById("beli").disabled = true;
                } else {
                    row.find('.subtotal').val(harga_update);
                    row.find('.sisa').val(stok_baru);
                    findTotal();
                    document.getElementById("tambah_tabel").disabled = false;
                    document.getElementById("beli").disabled = false;
                }
            } else {
                alert("Nilai input bukan angka.");
            }
        }

        var row = 1;
        $('#tambah_tabel').click(function() {
            let nama = $("#nama").val();
            let kode = $("#kode1").val();
            let harga = $("#harga").val();
            let stok = $("#stok").val();
            let ukuran = $("#ukuran").val();
            let jumlah = $("#jumlah").val();
            let sisa = $("#stok").val() - $("#jumlah").val();
            let subtotal = $("#jumlah").val() * $("#harga").val();

            $('#template').append(
                '<tr>' +
                '<td><input type="text" name="row[]" value="' + row + '" readonly></td>' +
                '<td><input type="text" name="nama[]" value="' + nama + '" readonly></td>' +
                '<td><input type="text" name="kode[]" value="' + kode + '" readonly></td>' +
                '<td><input type="text" name="harga[]" class="harga" value="' + harga + '" readonly></td>' +
                '<td><input type="text" name="stok[]" class="stok" value="' + stok + '" readonly></td>' +
                '<td><input type="text" name="ukuran[]" value="' + ukuran + '" readonly></td>' +
                '<td><input type="text" name="jml_beli[]" class="jml_beli" onblur="updatesubtotal(this)" value="' + jumlah + '"></td>' +
                '<td><input type="text" name="sisa[]" class="sisa" value="' + sisa + '" readonly></td>' +
                '<td><input type="text" class="subtotal" name="subtotal[]" value="' + subtotal + '" readonly></td>' +
                '<td><button type="button" onclick="deleteRow(this)">Hapus</button></td>' +
                '</tr>'
            );

            document.getElementById('jumlah_belanja').value = row;

            row++;

            findTotal();
        });
    </script>
</body>

</html>