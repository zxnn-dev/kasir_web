<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Buat ID member otomatis
$q = $conn->query("SELECT MAX(member_id) as max_id FROM members");
$data = $q->fetch_assoc();
$max_id = $data['max_id'];

if ($max_id) {
    $urutan = (int) substr($max_id, 3, 4);
    $urutan++;
    $member_id = "MBR" . str_pad($urutan, 4, "0", STR_PAD_LEFT);
} else {
    $member_id = "MBR0001";
}

// Jika form disubmit
if (isset($_POST['simpan'])) {
    $id = $_POST['member_id'];
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];

    $sql = "INSERT INTO members (member_id, nama, nik, no_hp, email, alamat, poin) 
            VALUES ('$id', '$nama', '$nik', '$no_hp', '$email', '$alamat', 0)";
    if ($conn->query($sql)) {
        echo "<script>alert('Member baru berhasil dibuat!'); window.location='list_member.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buat ID Member</title>
  <link rel="stylesheet" href="../assets/style.css">  
  <style>
  </style>
</head>
<body>

  <!-- Navbar seperti halaman lain -->
  <div class="navbar">
    <h1>Aplikasi Kasir</h1>
  </div>

  <div class="content">
    <h2>Buat ID Member Baru</h2>
    <form method="post">
        <label>ID Member</label>
        <input type="text" name="member_id" value="<?= $member_id; ?>" readonly>

        <label>Nama Lengkap</label>
        <input type="text" name="nama" required>

        <label>NIK</label>
        <input type="text" name="nik" required>

        <label>No HP</label>
        <input type="text" name="no_hp" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Alamat</label>
        <input name="alamat" required></input>

        <button type="submit" name="simpan">Simpan</button>
    </form>

    <div class="button-group">
    
        <a href="dashboard.php" class="btn secondary">⬅️ Kembali ke Dashboard</a>
    </div>
  </div>

</body>
</html>
