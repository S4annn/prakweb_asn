<?php
require 'koneksi.php';

$kode = $_GET['kode'] ?? '';

if ($kode) {
  $stmt = $conn->prepare("DELETE FROM barang WHERE kode_barang = ?");
  if ($stmt) {
    $stmt->bind_param("s", $kode);
    $stmt->execute();
  }
}

header('Location: index.php');
exit;
