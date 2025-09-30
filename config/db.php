<?php
$host = "localhost";
$user = "root";    // default user XAMPP
$pass = "";        // default password XAMPP biasanya kosong
$db   = "kasir_db"; // sesuaikan dengan nama database kamu

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
