<?php
require_once 'koneksi.php';
cek_login();
$judul = 'Data Supplier';
$data = mysqli_query($conn, "SELECT * FROM supplier");
include 'header.php';
?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1">Data Supplier</h3>
        <p class="text-muted mb-0">Daftar mitra pemasok obat</p>
    </div>
    <a href="supplier_tambah.php" class="btn btn-primary rounded-pill px-4 shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Supplier
    </a>
</div>

<div class="card card-app">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Supplier</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (mysqli_num_rows($data) === 0): ?>
                <tr><td colspan="5" class="empty-state text-center"><i class="bi bi-inbox fs-1 d-block mb-2"></i>Belum ada data supplier.</td></tr>
            <?php endif; ?>
            <?php while ($row = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td class="text-muted">#<?= $row['id'] ?></td>
                    <td class="fw-semibold"><?= e($row['nama_supplier']) ?></td>
                    <td><i class="bi bi-telephone text-muted me-1"></i><?= e($row['telepon']) ?></td>
                    <td class="text-muted small"><?= e($row['alamat']) ?></td>
                    <td class="text-end">
                        <a href="supplier_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil-square"></i> Edit</a>
                        <a href="supplier_hapus.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus supplier ini?')"><i class="bi bi-trash"></i> Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'footer.php'; ?>