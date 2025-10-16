<?php
session_start();
include("../config/db.php");

if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}

// Hapus user jika ada request ?delete_id=...
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); 
    if ($delete_id != $_SESSION['user_id']) {
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id=?");
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            $message = "User berhasil dihapus!";
        } else {
            $message = "Gagal menghapus user: " . $conn->error;
        }
    } else {
        $message = "Anda tidak bisa menghapus akun sendiri!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
 <div class="navbar">
  <h1>Aplikasi Kasir</h1>
    </div>
<div class="container">
    <h2>👥 Manajemen User</h2>

   

    <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>

    <div class="card">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role (debug)</th>
                    <th>Role (trim)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM users");
                while ($row = $result->fetch_assoc()) {
                    $role_raw = $row['role'];
                    $role_trim = trim($role_raw);
                    echo "
                    <tr>
                        <td>{$row['user_id']}</td>
                        <td>{$row['username']}</td>
                        <td>[{$role_raw}]</td>
                        <td>[{$role_trim}]</td>
                        <td><a href='?delete_id={$row['user_id']}' class='btn danger' onclick=\"return confirm('Yakin ingin menghapus user ini?');\">Hapus</a></td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<br>
 <div class="button-group">
        <a href="../auth/register.php" class="btn primary">+ Tambah User Baru</a>
        <a href="dashboard.php" class="btn secondary">⬅️ Kembali ke Dashboard</a>
    </div>
</body>
</html>
