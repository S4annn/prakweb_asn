<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $kode_barang = $_POST['kode_barang'] ?? '';
  $nama_barang = $_POST['nama_barang'] ?? '';
  $kategori    = $_POST['kategori'] ?? '';
  $jumlah      = (int) ($_POST['jumlah'] ?? 0);
  $harga       = (float) ($_POST['harga'] ?? 0);

  $sql = "INSERT INTO barang (kode_barang, nama_barang, kategori, jumlah, harga)
          VALUES (?, ?, ?, ?, ?)";

  $stmt = $conn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param("sssii", $kode_barang, $nama_barang, $kategori, $jumlah, $harga);
    if ($stmt->execute()) {
      header('Location: index.php');
      exit;
    } else {
      $error = "Gagal menyimpan: " . $stmt->error;
    }
  } else {
    $error = "Gagal mempersiapkan query: " . $conn->error;
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Barang</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
  <h1 class="mb-4">Tambah Barang</h1>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="post" class="row g-3">
    <div class="col-md-4">
      <label class="form-label">Kode Barang</label>
      <input type="text" name="kode_barang" class="form-control" required>
    </div>
    <div class="col-md-8">
      <label class="form-label">Nama Barang</label>
      <input type="text" name="nama_barang" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Kategori</label>
      <input type="text" name="kategori" class="form-control" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Jumlah</label>
      <input type="number" name="jumlah" class="form-control" min="0" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Harga (Rp)</label>
      <input type="number" step="0.01" name="harga" class="form-control" min="0" required>
    </div>
    <div class="col-12">
      <button class="btn btn-success">Simpan</button>
      <a href="index.php" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</body>
</html>
