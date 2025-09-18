<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Jika transaksi disimpan
if (isset($_POST['checkout'])) {
    $user_id = $_SESSION['user_id'];
    $tanggal = date("Y-m-d H:i:s");

    // Insert ke tabel penjualan
    $conn->query("INSERT INTO penjualan (user_id, tanggal, total_harga) VALUES ('$user_id','$tanggal',0)");
    $penjualan_id = $conn->insert_id;

    $total = 0;

    // Loop item belanjaan
    foreach ($_POST['produk_id'] as $key => $produk_id) {
        $jumlah = $_POST['jumlah'][$key];
        if ($jumlah > 0) {
            $qProduk = $conn->query("SELECT * FROM produk WHERE produk_id='$produk_id'");
            $produk = $qProduk->fetch_assoc();

            $subtotal = $produk['harga'] * $jumlah;
            $total += $subtotal;

            // Simpan ke detail penjualan
            $conn->query("INSERT INTO detail_penjualan (penjualan_id, produk_id, jumlah, subtotal) 
                          VALUES ('$penjualan_id','$produk_id','$jumlah','$subtotal')");

            // Update stok
            $conn->query("UPDATE produk SET stok = stok - $jumlah WHERE produk_id='$produk_id'");
        }
    }

    // Update total transaksi
    $conn->query("UPDATE penjualan SET total_harga='$total' WHERE penjualan_id='$penjualan_id'");

    // Redirect ke halaman struk
    header("Location: struk.php?id=$penjualan_id");
    exit;
}
?>

<h2>Transaksi Penjualan</h2>
<form method="POST">
    <table border="1" cellpadding="5">
        <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Jumlah Beli</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM produk WHERE stok > 0");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>".$row['nama_produk']."</td>
                <td>".$row['harga']."</td>
                <td>".$row['stok']."</td>
                <td>
                    <input type='hidden' name='produk_id[]' value='".$row['produk_id']."'>
                    <input type='number' name='jumlah[]' min='0' max='".$row['stok']."' value='0'>
                </td>
            </tr>";
        }
        ?>
    </table>
    <br>
    <button type="submit" name="checkout">Checkout</button>
</form>
<br>
<a href="dashboard.php">⬅️ Kembali ke Dashboard</a>
