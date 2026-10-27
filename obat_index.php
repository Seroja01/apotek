<?php
require_once 'koneksi.php';
cek_login();
$judul = 'Data Obat';
$data = mysqli_query($conn, "SELECT * FROM obat");
include 'header.php';
?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1">Data Obat</h3>
        <p class="text-muted mb-0">Kelola daftar obat dan stoknya</p>
    </div>
    <a href="obat_tambah.php" class="btn btn-primary rounded-pill px-4 shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Obat
    </a>
</div>

<div class="card card-app">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Obat</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (mysqli_num_rows($data) === 0): ?>
                <tr><td colspan="6" class="empty-state text-center"><i class="bi bi-inbox fs-1 d-block mb-2"></i>Belum ada data obat.</td></tr>
            <?php endif; ?>
            <?php while ($row = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td class="text-muted">#<?= $row['id'] ?></td>
                    <td class="fw-semibold"><?= e($row['nama_obat']) ?></td>
                    <td><span class="badge rounded-pill bg-info-subtle text-info-emphasis"><?= e($row['kategori']) ?></span></td>
                    <td><?= rupiah($row['harga']) ?></td>
                    <td><span class="badge rounded-pill <?= $row['stok'] <= 10 ? 'bg-danger' : 'bg-success' ?>"><?= (int)$row['stok'] ?></span></td>
                    <td class="text-end">
                        <a href="obat_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil-square"></i> Edit</a>
                        <a href="obat_hapus.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data obat ini?')"><i class="bi bi-trash"></i> Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'footer.php'; ?>