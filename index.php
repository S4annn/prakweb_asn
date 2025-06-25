<?php require 'koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Inventaris Barang</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">

  <h1 class="mb-4">Inventaris Barang</h1>

  <a href="tambah.php" class="btn btn-primary mb-3">+ Tambah Barang</a>

  <?php
    // pencarian sederhana
    $keyword = $_GET['q'] ?? '';
    if ($keyword) {
        $kw = "%" . $conn->real_escape_string($keyword) . "%";
        $stmt = $conn->prepare("SELECT * FROM barang WHERE kode_barang LIKE ? OR nama_barang LIKE ? ORDER BY nama_barang");
        $stmt->bind_param("ss", $kw, $kw);
    } else {
        $stmt = $conn->prepare("SELECT * FROM barang ORDER BY nama_barang");
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
  ?>

  <form class="mb-3 d-flex" method="get">
    <input class="form-control me-2" type="search" name="q" value="<?= htmlspecialchars($keyword) ?>"
           placeholder="Cari kode / nama …">
    <button class="btn btn-outline-secondary" type="submit">Cari</button>
  </form>

  <table class="table table-bordered table-striped">
    <thead class="table-light">
      <tr>
        <th>Kode</th><th>Nama Barang</th><th>Kategori</th>
        <th class="text-end">Jumlah</th><th class="text-end">Harga (Rp)</th><th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!$rows): ?>
        <tr><td colspan="6" class="text-center">Belum ada data.</td></tr>
      <?php else: foreach ($rows as $r): ?>
        <tr>
          <td><?= $r['kode_barang'] ?></td>
          <td><?= $r['nama_barang'] ?></td>
          <td><?= $r['kategori'] ?></td>
          <td class="text-end"><?= number_format($r['jumlah']) ?></td>
          <td class="text-end"><?= number_format($r['harga'], 2, ',', '.') ?></td>
          <td>
            <a href="edit.php?kode=<?= $r['kode_barang'] ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="hapus.php?kode=<?= $r['kode_barang'] ?>"
               onclick="return confirm('Hapus barang ini?')"
               class="btn btn-sm btn-danger">Hapus</a>
          </td>
        </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>

</body>
</html>
