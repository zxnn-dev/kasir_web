
<?php
session_start();
include("../config/db.php");

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
     <link rel="stylesheet" href="../assets/style.css">
    <title>Daftar Member</title>
    <style>
       
    </style>
</head>
<body>
    
<div class="navbar">
  <h1>Aplikasi Kasir</h1>
</div>

<h2>📋 Daftar Member</h2>
<table>
    <tr>
        <th>ID Member</th>
        <th>Nama</th>
        <th>No HP</th>
        <th>Email</th>
        <th>NIK</th>
        <th>Alamat</th>
        <th>Poin</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM members ORDER BY member_id DESC");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>".$row['member_id']."</td>
            <td>".$row['nama']."</td>
            <td>".$row['no_hp']."</td>
            <td>".$row['email']."</td>
            <td>".$row['nik']."</td>
            <td>".$row['alamat']."</td>
            <td>".$row['poin']."</td>
        </tr>";
    }
    ?>
</table>

<br>
 <div class="button-group">
      <a href="dashboard.php" class="btn secondary">⬅️ Kembali ke Dashboard</a>
  </div>

</body>
</html>

