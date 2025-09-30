<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<h2>Laporan Transaksi</h2>
<p>Halo, <?= $_SESSION['username']; ?> (<?= $_SESSION['role']; ?>)</p>

<button onclick="window.print()">🖨 Cetak Laporan</button>
<br><br>

<form method="GET">
    <label>Cari Detail Transaksi (Masukkan ID Penjualan atau Pembelian):</label><br>
    <input type="number" name="id" required>
    <select name="tipe">
        <option value="penjualan">Penjualan</option>
        <option value="pembelian">Pembelian</option>
    </select>
    <button type="submit">Cari</button>
</form>
<br>

<?php
if (isset($_GET['id']) && isset($_GET['tipe'])) {
    $id = $_GET['id'];
    $tipe = $_GET['tipe'];

    if ($tipe == "penjualan") {
        echo "<h3>Detail Penjualan #$id</h3>";
        $sql = "SELECT dp.jumlah, dp.subtotal, pr.nama_produk, pr.harga 
                FROM detail_penjualan dp 
                JOIN produk pr ON dp.produk_id = pr.produk_id
                WHERE dp.penjualan_id = '$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table border='1' cellpadding='5'>
                    <tr><th>Nama Produk</th><th>Jumlah</th><th>Harga Satuan</th><th>Subtotal</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row['nama_produk']."</td>
                        <td>".$row['jumlah']."</td>
                        <td>Rp ".number_format($row['harga'],0,',','.')."</td>
                        <td>Rp ".number_format($row['subtotal'],0,',','.')."</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color:red'>Data tidak ditemukan!</p>";
        }
    } else {
        echo "<h3>Detail Pembelian #$id</h3>";
        $sql = "SELECT dp.jumlah, dp.harga, pr.nama_produk 
                FROM detail_pembelian dp 
                JOIN produk pr ON dp.produk_id = pr.produk_id
                WHERE dp.pembelian_id = '$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table border='1' cellpadding='5'>
                    <tr><th>Nama Produk</th><th>Jumlah</th><th>Harga Beli</th><th>Subtotal</th></tr>";
            while ($row = $result->fetch_assoc()) {
                $subtotal = $row['jumlah'] * $row['harga'];
                echo "<tr>
                        <td>".$row['nama_produk']."</td>
                        <td>".$row['jumlah']."</td>
                        <td>Rp ".number_format($row['harga'],0,',','.')."</td>
                        <td>Rp ".number_format($subtotal,0,',','.')."</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color:red'>Data tidak ditemukan!</p>";
        }
    }
    echo "<br><a href='transaksi.php'>⬅️ Kembali ke Semua Transaksi</a><br><br>";
}
?>

<h3>📦 Transaksi Penjualan (Barang Keluar)</h3>
<table border="1" cellpadding="5">
    <tr>
        <th>ID Penjualan</th>
        <th>Tanggal</th>
        <th>Kasir</th>
        <th>Total Harga</th>
    </tr>
    <?php
    $sql = "SELECT p.penjualan_id, p.tanggal, u.username, p.total_harga 
            FROM penjualan p 
            JOIN users u ON p.user_id = u.user_id 
            ORDER BY p.tanggal DESC";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>".$row['penjualan_id']."</td>
            <td>".$row['tanggal']."</td>
            <td>".$row['username']."</td>
            <td>Rp ".number_format($row['total_harga'],0,',','.')."</td>
        </tr>";
    }
    ?>
</table>

<h3>📥 Transaksi Pembelian (Barang Masuk)</h3>
<table border="1" cellpadding="5">
    <tr>
        <th>ID Pembelian</th>
        <th>Tanggal</th>
        <th>Admin</th>
        <th>Total Harga</th>
    </tr>
    <?php
    $sql = "SELECT b.pembelian_id, b.tanggal, u.username, b.total_harga 
            FROM pembelian b 
            JOIN users u ON b.user_id = u.user_id 
            ORDER BY b.tanggal DESC";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>".$row['pembelian_id']."</td>
            <td>".$row['tanggal']."</td>
            <td>".$row['username']."</td>
            <td>Rp ".number_format($row['total_harga'],0,',','.')."</td>
        </tr>";
    }
    ?>
</table>

<br>
<a href="dashboard.php" class="no-print">⬅️ Kembali ke Dashboard</a>
