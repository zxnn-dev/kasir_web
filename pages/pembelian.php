<?php
session_start();
include("../config/db.php");


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $is_new = isset($_POST['is_new']) ? true : false;
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

    echo "<p style='color:green'>Pembelian berhasil dicatat!</p>";
}
?>

<h2>Input Pembelian Barang (Stok Masuk)</h2>
<form method="POST">
    <label><input type="checkbox" name="is_new" id="is_new" onclick="toggleNew()"> Barang Baru?</label>
    <br><br>

    <div id="old_product">
        <label>Pilih Produk Lama:</label><br>
        <select name="produk_id">
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

    <button type="submit">Simpan</button>
</form>

<br>
<a href="dashboard.php">⬅️ Kembali ke Dashboard</a>

<script>
function toggleNew() {
    var check = document.getElementById('is_new').checked;
    document.getElementById('old_product').style.display = check ? 'none' : 'block';
    document.getElementById('new_product').style.display = check ? 'block' : 'none';
}
</script>
