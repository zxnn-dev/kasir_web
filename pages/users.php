<?php
session_start();
include("../config/db.php");

if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}
?>
<h2>Manajemen User</h2>
<a href="../auth/register.php">+ Tambah User Baru</a>
<br>

<table border="1" cellpadding="5">
    <tr><th>ID</th><th>Username</th><th>Role</th></tr>
    <?php
    $result = $conn->query("SELECT * FROM users");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>".$row['user_id']."</td>
            <td>".$row['username']."</td>
            <td>".$row['role']."</td>
        </tr>";
    }
    ?>
</table>
<a href="dashboard.php">⬅️ Kembali ke Dashboard</a>
