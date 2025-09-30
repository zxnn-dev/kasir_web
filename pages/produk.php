<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}


if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $sql = "INSERT INTO produk (nama_produk, harga, stok) VALUES ('$nama','$harga','$stok')";
    $conn->query($sql);
}
?>

<h2>Data Produk</h2>


<table border="1" cellpadding="5">
    <tr>
        <th>ID</th><th>Nama</th><th>Harga</th><th>Stok</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM produk");
    while($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>".$row['produk_id']."</td>
            <td>".$row['nama_produk']."</td>
            <td>".$row['harga']."</td>
            <td>".$row['stok']."</td>
        </tr>";
    }
    ?>
</table>
<br>
<a href="dashboard.php">⬅️ Kembali ke Dashboard</a>
