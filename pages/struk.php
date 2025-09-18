<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$penjualan_id = $_GET['id'];
$sql = "SELECT p.penjualan_id, p.tanggal, p.total_harga, u.username 
        FROM penjualan p
        JOIN users u ON p.user_id = u.user_id
        WHERE p.penjualan_id = '$penjualan_id'";
$q = $conn->query($sql);
$penjualan = $q->fetch_assoc();

$detail = $conn->query("SELECT dp.*, pr.nama_produk, pr.harga 
                        FROM detail_penjualan dp
                        JOIN produk pr ON dp.produk_id = pr.produk_id
                        WHERE dp.penjualan_id='$penjualan_id'");
?>

<h2>Struk Pembelian</h2>
<p>No Transaksi: <?= $penjualan['penjualan_id']; ?></p>
<p>Tanggal: <?= $penjualan['tanggal']; ?></p>
<p>Kasir: <?= $penjualan['username']; ?></p>
<hr>
<table border="1" cellpadding="5">
    <tr>
        <th>Produk</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
    </tr>
    <?php while ($row = $detail->fetch_assoc()): ?>
    <tr>
        <td><?= $row['nama_produk']; ?></td>
        <td><?= $row['harga']; ?></td>
        <td><?= $row['jumlah']; ?></td>
        <td><?= $row['subtotal']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>
<hr>
<h3>Total: Rp <?= number_format($penjualan['total_harga'], 0, ',', '.'); ?></h3>

<br>
<button onclick="window.print()">🖨 Cetak Struk</button>
<a href="penjualan.php">🔙 Transaksi Baru</a>
<br>
<a href="dashboard.php">⬅️ Kembali ke Dashboard</a>
