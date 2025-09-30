<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_POST['checkout'])) {
    $user_id = $_SESSION['user_id'];
    $tanggal = date("Y-m-d H:i:s");

    $conn->query("INSERT INTO penjualan (user_id, tanggal, total_harga) VALUES ('$user_id','$tanggal',0)");
    $penjualan_id = $conn->insert_id;

    $total = 0;

    foreach ($_POST['produk_id'] as $key => $produk_id) {
        $jumlah = $_POST['jumlah'][$key];
        if ($jumlah > 0) {
            $qProduk = $conn->query("SELECT * FROM produk WHERE produk_id='$produk_id'");
            $produk = $qProduk->fetch_assoc();

            $subtotal = $produk['harga'] * $jumlah;
            $total += $subtotal;

            $conn->query("INSERT INTO detail_penjualan (penjualan_id, produk_id, jumlah, subtotal) 
                          VALUES ('$penjualan_id','$produk_id','$jumlah','$subtotal')");

            $conn->query("UPDATE produk SET stok = stok - $jumlah WHERE produk_id='$produk_id'");
        }
    }

    $conn->query("UPDATE penjualan SET total_harga='$total' WHERE penjualan_id='$penjualan_id'");

    if (!empty($_POST['member_id'])) {
        $member_id = $_POST['member_id'];
        $poin = floor($total / 10000);
        if ($poin > 0) {
            $conn->query("UPDATE users SET poin = poin + $poin WHERE user_id='$member_id'");
        }
        header("Location: struk.php?id=$penjualan_id&member_id=$member_id");
    } else {
        header("Location: struk.php?id=$penjualan_id");
    }
    exit;
}
?>

<h2>Transaksi Penjualan</h2>
<form method="POST">
    <label for="member_id">ID Member (opsional):</label>
    
    <input type="text" name="member_id" id="member_id" placeholder="Masukkan ID Member">
    <br><br>
   <a href="tambah_member.php">belum punya member?</a>
    <br><br>
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
