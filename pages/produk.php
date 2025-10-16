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

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk</title>
    <!-- Hubungkan ke CSS -->
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <!-- Navbar seperti halaman lain -->
  <div class="navbar">
    <h1>Aplikasi Kasir</h1>
  </div>

    <h2>Data Produk</h2>

    <form method="POST">
        <label>Nama Produk</label>
        <input type="text" name="nama" required>

        <label>Harga</label>
        <input type="number" name="harga" required>

        <label>Stok</label>
        <input type="number" name="stok" required>

        <button type="submit" name="tambah">Tambah Produk</button>
    </form>

    <br>

    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Stok</th>
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
  <div class="button-group">
       
        <a href="dashboard.php" class="btn secondary">⬅️ Kembali ke Dashboard</a>
    </div>
  </div>
</body>
</html>
