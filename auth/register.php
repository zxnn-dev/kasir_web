<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit;
}
include("../config/db.php");

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email = trim($_POST['email']);
    $nik = trim($_POST['nik']);
    $role = $_POST['role'];

    // cek field kosong
    if ($username === '' || $password === '' || $email === '' || $nik === '' || $role === '') {
        $error = "Semua field wajib diisi!";
    } else {
        // cek duplicate
        $checkSql = "SELECT * FROM users WHERE username=? OR email=? OR nik=? LIMIT 1";
        $stmt = mysqli_prepare($conn, $checkSql);
        mysqli_stmt_bind_param($stmt, "ssi", $username, $email, $nik);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $error = "Username, Email, atau NIK sudah terdaftar!";
        } else {
            // insert user
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // hash aman
            $insertSql = "INSERT INTO users (username, password, email, nik, role) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insertSql);
            mysqli_stmt_bind_param($stmt, "sssis", $username, $hashedPassword, $email, $nik, $role);

            if (mysqli_stmt_execute($stmt)) {
                $success = "User berhasil diregister!";
            } else {
                $error = "Gagal register user: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register User</title>
</head>
<body>
    <h2>Register User Baru</h2>

    <?php if (!empty($error)) : ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)) : ?>
        <p style="color:green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="text" name="nik" placeholder="NIK" required><br>
        <select name="role" required>
            <option value="kasir">Kasir</option>
            <option value="admin">Admin</option>
        </select><br><br>
        <button type="submit">Register</button>
    </form>
    <a href="../pages/dashboard.php" class="no-print">⬅️ Kembali ke Dashboard</a>
</body>
</html>
