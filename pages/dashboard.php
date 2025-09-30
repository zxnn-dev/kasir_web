<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>
<h2>Selamat datang, <?= $_SESSION['username']; ?> (<?= $_SESSION['role']; ?>)</h2>
<nav>
     <a href="transaksi.php">laporan</a> |
    <a href="produk.php">Produk</a> |
    <a href="penjualan.php">pembelian</a> |
    <a href="pembelian.php">stok barang masuk</a> |
     <a href="tambah_member.php">buat Member</a>
    <?php if ($_SESSION['role'] == 'admin'): ?>
        | <a href="users.php">Manajemen User</a>
       
    <?php endif; ?>
    | <a href="../auth/logout.php">Logout</a>
</nav>
