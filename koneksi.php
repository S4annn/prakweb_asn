<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'inventaris_db';

$conn = new mysqli($host, $user, $pass, $db);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
