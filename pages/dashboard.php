<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<link rel="stylesheet" href="../assets/style.css">

</head>
<body>

<div class="navbar">
  <h1>Aplikasi Kasir</h1>
  <div>
    <a href="transaksi.php">Laporan</a>
    <a href="produk.php">Produk</a>
    <a href="penjualan.php">Pembelian</a>
    <a href="pembelian.php">Stok Barang Masuk</a>
    <a href="tambah_member.php">Buat Member</a>
    <?php if ($_SESSION['role'] == 'admin'): ?>
        <a href="users.php">Manajemen User</a>
    <?php endif; ?>
    <a href="../auth/logout.php" class="logout">Logout</a>
  </div>
</div>

<div class="content">
  <h2>Selamat datang, <?= $_SESSION['username']; ?> (<?= $_SESSION['role']; ?>)</h2>
</div>

</body>
</html>
