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
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    if ($username === '' || $password === '' || $email === '' || $nik === '' || $role === '') {
        $error = "Semua field wajib diisi!";
    } else {
        $checkSql = "SELECT * FROM users WHERE username=? OR email=? OR nik=? LIMIT 1";
        $stmt = mysqli_prepare($conn, $checkSql);
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $nik);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row['username'] == $username) {
                $error = "Username sudah terdaftar!";
            } elseif ($row['email'] == $email) {
                $error = "Email sudah terdaftar!";
            } elseif ($row['nik'] == $nik) {
                $error = "NIK sudah terdaftar!";
            }
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertSql = "INSERT INTO users (username, password, email, nik, role) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insertSql);
            mysqli_stmt_bind_param($stmt, "sssss", $username, $hashedPassword, $email, $nik, $role);

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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register User</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <h1>Aplikasi Kasir</h1>
    </div>

    <div class="content">
        <h2>Register User Baru</h2>

        <?php if (!empty($error)) : ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($success)) : ?>
            <p style="color:green;"><?php echo $success; ?></p>
        <?php endif; ?>

        <form method="POST" class="form-box">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="text" name="nik" placeholder="NIK" required><br>
            <select name="role" required>
                <option value="">-- Pilih Role --</option>
                <option value="kasir">Kasir</option>
                <option value="admin">Admin</option>
            </select><br><br>

            <button type="submit" class="btn primary">Register</button>
        </form>

        <div class="button-group">
            <a href="../pages/dashboard.php" class="btn secondary">⬅️ Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
