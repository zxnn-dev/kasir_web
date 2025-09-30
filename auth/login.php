<?php
session_start();
include("../config/db.php"); // pastikan $conn ada

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.html");
    exit;
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($username === '' || $password === '') {
    header("Location: ../index.html?error=Username atau password kosong");
    exit;
}

// Prepared statement untuk ambil user berdasarkan username
$sql = "SELECT user_id, username, password, role FROM users WHERE username = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    header("Location: ../index.html?error=Terjadi kesalahan pada query");
    exit;
}

mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) !== 1) {
    // user tidak ditemukan
    header("Location: ../index.html?error=Username atau password salah");
    exit;
}

$row = mysqli_fetch_assoc($result);
$hashFromDb = $row['password'];
$login_ok = false;

// Cek MD5 legacy
if (strlen($hashFromDb) === 32 && ctype_xdigit($hashFromDb)) {
    if (md5($password) === $hashFromDb) {
        $login_ok = true;
        // upgrade ke password_hash (bcrypt)
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $updateSql = "UPDATE users SET password = ? WHERE user_id = ?";
        $updStmt = mysqli_prepare($conn, $updateSql);
        if ($updStmt) {
            mysqli_stmt_bind_param($updStmt, "si", $newHash, $row['user_id']);
            mysqli_stmt_execute($updStmt);
            mysqli_stmt_close($updStmt);
        }
    }
} else {
    // modern hash
    if (password_verify($password, $hashFromDb)) {
        $login_ok = true;
        // rehash jika perlu
        if (password_needs_rehash($hashFromDb, PASSWORD_DEFAULT)) {
            $rehash = password_hash($password, PASSWORD_DEFAULT);
            $updateSql = "UPDATE users SET password = ? WHERE user_id = ?";
            $updStmt = mysqli_prepare($conn, $updateSql);
            if ($updStmt) {
                mysqli_stmt_bind_param($updStmt, "si", $rehash, $row['user_id']);
                mysqli_stmt_execute($updStmt);
                mysqli_stmt_close($updStmt);
            }
        }
    }
}

mysqli_stmt_close($stmt);

if ($login_ok) {
    // set session
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['role'] = $row['role'];
    session_regenerate_id(true);

    header("Location: ../pages/dashboard.php");
    exit;
} else {
    header("Location: ../index.html?error=Username atau password salah");
    exit;
}
?>
