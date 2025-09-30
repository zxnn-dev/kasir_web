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

$member_id = isset($_GET['member_id']) ? $_GET['member_id'] : null;
$poin_didapat = 0;
$poin_sekarang = 0;

if ($member_id) {
    $poin_didapat = floor($penjualan['total_harga'] / 10000);
    $qMember = $conn->query("SELECT poin FROM members WHERE member_id='$member_id'");
    $memberData = $qMember->fetch_assoc();
    $poin_sekarang = $memberData['poin'] + $poin_didapat;
    $conn->query("UPDATE members SET poin='$poin_sekarang' WHERE member_id='$member_id'");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Struk Pembelian</title>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<h2>Struk Pembelian</h2>
<p>No Transaksi: <?= $penjualan['penjualan_id']; ?></p>
<p>Tanggal: <?= $penjualan['tanggal']; ?></p>
<p>Kasir: <?= $penjualan['username']; ?></p>

<?php if ($member_id): ?>
<p>Poin didapat: <?= $poin_didapat; ?></p>
<p>Total poin sekarang: <?= $poin_sekarang; ?></p>
<?php endif; ?>

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
<button onclick="window.print()" class="no-print">🖨 Cetak Struk</button>
<a href="penjualan.php" class="no-print">🔙 Transaksi Baru</a>
<br>
<a href="dashboard.php" class="no-print">⬅️ Kembali ke Dashboard</a>

</body>
</html>
