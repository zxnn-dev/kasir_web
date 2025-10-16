<?php
session_start();
include("../config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $is_new = isset($_POST['barang_baru']) ? true : false;
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];

    if ($is_new) {
        $nama_produk = $_POST['nama_produk'];
        $harga_jual = $_POST['harga_jual'];

        $conn->query("INSERT INTO produk (nama_produk, harga, stok) VALUES ('$nama_produk', '$harga_jual', 0)");
        $produk_id = $conn->insert_id;
    } else {
        $produk_id = $_POST['produk_id'];
    }

    $total = $jumlah * $harga;

    $conn->query("INSERT INTO pembelian (user_id, total_harga) VALUES ('".$_SESSION['user_id']."', '$total')");
    $pembelian_id = $conn->insert_id;

    $conn->query("INSERT INTO detail_pembelian (pembelian_id, produk_id, jumlah, harga) 
                  VALUES ('$pembelian_id','$produk_id','$jumlah','$harga')");

    $conn->query("UPDATE produk SET stok = stok + $jumlah WHERE produk_id = '$produk_id'");

    echo "<p class='success-msg'>Pembelian berhasil dicatat!</p>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembelian Barang</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="navbar">
  <h1>Aplikasi Kasir</h1>
</div>

<div class="content">
  <h2>Input Pembelian Barang (Stok Masuk)</h2>
  
  <form method="POST" class="form-box">
      <div class="form-group checkbox-group">
          <label>
            barang baru?
              <input type="checkbox" name="barang_baru" id="barang_baru" onclick="toggleNew()">
              
          </label>
      </div>

      <div id="old_product">
          <label>Pilih Produk Lama:</label><br>
          <select name="produk_id" required>
              <?php
              $result = $conn->query("SELECT * FROM produk");
              while ($row = $result->fetch_assoc()) {
                  echo "<option value='".$row['produk_id']."'>".$row['nama_produk']."</option>";
              }
              ?>
          </select>
      </div>

      <div id="new_product" style="display:none;">
          <label>Nama Produk Baru:</label><br>
          <input type="text" name="nama_produk"><br><br>

          <label>Harga Jual:</label><br>
          <input type="number" name="harga_jual"><br><br>
      </div>

      <label>Jumlah Masuk:</label><br>
      <input type="number" name="jumlah" required><br><br>

      <label>Harga Beli per Unit:</label><br>
      <input type="number" name="harga" required><br><br>

      <button type="submit" class="btn-primary">Simpan</button>
  </form>

  <br>
  <div class="button-group">
      <a href="dashboard.php" class="btn secondary">⬅️ Kembali ke Dashboard</a>
  </div>
</div>

<script>
function toggleNew() {
    const check = document.getElementById('barang_baru').checked;
    document.getElementById('old_product').style.display = check ? 'none' : 'block';
    document.getElementById('new_product').style.display = check ? 'block' : 'none';
}
</script>

</body>
</html>
