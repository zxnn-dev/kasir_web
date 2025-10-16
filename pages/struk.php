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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        

        /* Mode Cetak */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white;
                box-shadow: none;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar seperti halaman lain -->
    <div class="navbar">
        <h1>Aplikasi Kasir</h1>
    </div>

    <div class="container">
        <h2>🧾 Struk Pembelian</h2>

        <div class="card">
            <p><strong>No Transaksi:</strong> <?= $penjualan['penjualan_id']; ?></p>
            <p><strong>Tanggal:</strong> <?= $penjualan['tanggal']; ?></p>
            <p><strong>Kasir:</strong> <?= $penjualan['username']; ?></p>

            <?php if ($member_id): ?>
                <p><strong>Poin didapat:</strong> <?= $poin_didapat; ?></p>
                <p><strong>Total poin sekarang:</strong> <?= $poin_sekarang; ?></p>
            <?php endif; ?>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $detail->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['nama_produk']; ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td><?= $row['jumlah']; ?></td>
                    <td>Rp <?= number_format($row['subtotal'], 0, ',', '.'); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Total: Rp <?= number_format($penjualan['total_harga'], 0, ',', '.'); ?></h3>

        <div class="actions no-print">
    <button onclick="window.print()">🖨 Cetak Struk</button>
    <br>
    <br>
    <a href="penjualan.php" class="btn primary">🔄 Transaksi Baru</a>
    <br>
    <br>
    <a href="dashboard.php" class="btn secondary">⬅️ Kembali ke Dashboard</a>
</div>

    </div>

</body>
</html>
