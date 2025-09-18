<?php
session_start();
include("../config/db.php");

if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (nik, email, username, password, role) 
            VALUES ('$nik', '$email', '$username','$password','$role')";
    if ($conn->query($sql)) {
        echo "<p style='color:green'>User berhasil ditambahkan!</p>";
    } else {
        echo "<p style='color:red'>Error: " . $conn->error . "</p>";
    }
}
?>

<h2>Tambah User Baru</h2>
<form method="POST">
    <label>NIK:</label><br>
    <input type="text" name="nik" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Role:</label><br>
    <select name="role">
        <option value="kasir">Kasir</option>
        <option value="admin">Admin</option>
    </select><br><br>

    <button type="submit">Simpan</button>
</form>

<br>
<a href="../pages/dashboard.php">⬅️ Kembali ke Dashboard</a>
