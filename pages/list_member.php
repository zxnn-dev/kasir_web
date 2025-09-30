
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
    <title>Daftar Member</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background: #eee;
        }
    </style>
</head>
<body>

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
<a href="dashboard.php">⬅️ Kembali ke Dashboard</a>

</body>
</html>

