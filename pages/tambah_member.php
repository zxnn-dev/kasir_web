
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
<html>
<head>
    <title>Buat ID Member</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        form { width: 400px; margin: auto; }
        label { display: block; margin-top: 10px; }
        input, textarea { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 15px; padding: 10px 15px; }
    </style>
</head>
<body>
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
        <textarea name="alamat" required></textarea>

        <button type="submit" name="simpan">Simpan</button>
    </form>
    <br>
     <a href="list_member.php">list member</a>
    <br><br>
    <a href="dashboard.php">⬅️ Kembali ke Dashboard</a>
</body>
</html>
