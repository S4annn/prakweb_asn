<?php
require 'koneksi.php';

$kode = $_GET['kode'] ?? '';

// 1) mengambil data lama
$stmt = $conn->prepare("SELECT * FROM barang WHERE kode_barang = ?");
$stmt->bind_param("s", $kode);
$stmt->execute();
$result = $stmt->get_result();
$barang = $result->fetch_assoc();

if (!$barang) {
  die('Barang tidak ditemukan.');
}

// 2) Jika submit, simpan perubahan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama_barang = $_POST['nama_barang'] ?? '';
  $kategori    = $_POST['kategori'] ?? '';
  $jumlah      = (int) ($_POST['jumlah'] ?? 0);
  $harga       = (float) ($_POST['harga'] ?? 0);

  $stmt = $conn->prepare("UPDATE barang SET 
                            nama_barang = ?, 
                            kategori = ?, 
                            jumlah = ?, 
                            harga = ? 
                          WHERE kode_barang = ?");
  $stmt->bind_param("ssiis", $nama_barang, $kategori, $jumlah, $harga, $kode);
  $stmt->execute();

  header('Location: index.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Barang</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
  <h1 class="mb-4">Edit Barang</h1>

  <form method="post" class="row g-3">
    <div class="col-md-4">
      <label class="form-label">Kode Barang</label>
      <input type="text" class="form-control" value="<?= htmlspecialchars($barang['kode_barang']) ?>" disabled>
    </div>
    <div class="col-md-8">
      <label class="form-label">Nama Barang</label>
      <input type="text" name="nama_barang" class="form-control"
             value="<?= htmlspecialchars($barang['nama_barang']) ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Kategori</label>
      <input type="text" name="kategori" class="form-control"
             value="<?= htmlspecialchars($barang['kategori']) ?>" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Jumlah</label>
      <input type="number" name="jumlah" class="form-control"
             value="<?= $barang['jumlah'] ?>" min="0" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Harga (Rp)</label>
      <input type="number" step="0.01" name="harga" class="form-control"
             value="<?= $barang['harga'] ?>" min="0" required>
    </div>
    <div class="col-12">
      <button class="btn btn-primary">Update</button>
      <a href="index.php" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</body>
</html>
