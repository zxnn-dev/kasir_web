<?php
session_start();
include("../config/db.php");
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/style.css">
    <title>Laporan Transaksi</title>
    <style>
        /* Aturan print */
        @media print {
            body * {
                visibility: hidden; /* sembunyikan semua */
            }
            .print-area, .print-area * {
                visibility: visible; /* tampilkan print-area saja */
            }
            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print {
                display: none !important; /* sembunyikan elemen non-print */
            }
        }
        .btn.print {
    background-color: #28a745; /* hijau */
    color: white;
    padding: 10px 16px;
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: 0.2s;
}

.btn.print:hover {
    background-color: #1e7e34;
}

    </style>
</head>
<body>
<!-- Navbar seperti halaman lain -->
  <div class="navbar">
    <h1>Aplikasi Kasir</h1>
  </div>
<h2>Laporan Transaksi</h2>
<p>Halo, <?= $_SESSION['username']; ?> (<?= $_SESSION['role']; ?>)</p>


<br><br>

<form method="GET" class="no-print">
    <label>Cari Detail Transaksi (Masukkan ID Penjualan atau Pembelian):</label><br>
    <input type="number" name="detail_id">
    <select name="tipe">
        <option value="penjualan">Penjualan</option>
        <option value="pembelian">Pembelian</option>
    </select>
    <button type="submit">Cari</button>
</form>
<br>

<?php
// Tampilkan detail pencarian hanya jika ada input
if (!empty($_GET['detail_id']) && isset($_GET['tipe'])) {
    $id = $_GET['detail_id'];
    $tipe = $_GET['tipe'];

    echo "<div class='no-print'>"; // detail pencarian hanya tampil di halaman web
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
    echo "</div>"; // end no-print
} else {
    // Tampilkan tabel penjualan & pembelian yang akan dicetak
    echo "<div class='print-area'>"; // area yang dicetak

    echo "<h3>📦 Transaksi Penjualan (Barang Keluar)</h3>";
    echo "<p>Kasir: " . $_SESSION['username'] . "</p>";
    echo "<table border='1' cellpadding='5'>
            <tr>
                <th>ID Penjualan</th>
                <th>Tanggal</th>
                <th>Total Harga</th>
            </tr>";
    $sql = "SELECT p.penjualan_id, p.tanggal, p.total_harga 
            FROM penjualan p 
            ORDER BY p.tanggal DESC";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row['penjualan_id']."</td>
                <td>".$row['tanggal']."</td>
                <td>Rp ".number_format($row['total_harga'],0,',','.')."</td>
              </tr>";
    }
    echo "</table>";

    echo "<h3>📥 Transaksi Pembelian (Barang Masuk)</h3>";
    echo "<p>kasir: " . $_SESSION['username'] . "</p>";
    echo "<table border='1' cellpadding='5'>
            <tr>
                <th>ID Pembelian</th>
                <th>Tanggal</th>
                <th>Total Harga</th>
            </tr>";
    $sql = "SELECT b.pembelian_id, b.tanggal, b.total_harga 
            FROM pembelian b 
            ORDER BY b.tanggal DESC";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row['pembelian_id']."</td>
                <td>".$row['tanggal']."</td>
                <td>Rp ".number_format($row['total_harga'],0,',','.')."</td>
              </tr>";
    }
    echo "</table>";

    echo "</div>"; // end print-area
}
?>

<br>
<div class="button-group">
        <a href="dashboard.php" class="btn secondary">⬅️ Kembali ke Dashboard</a>
       <a onclick="window.print()" class="btn print no-print">🖨 Cetak Laporan</a>

    </div>
