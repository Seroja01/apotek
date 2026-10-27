<?php
require_once 'koneksi.php';
cek_login();
$judul = 'Dashboard';

$total_obat      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM obat"))['total'];
$total_supplier  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM supplier"))['total'];
$total_transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM transaksi"))['total'];
$stok_menipis    = mysqli_query($conn, "SELECT * FROM obat WHERE stok <= 10 ORDER BY stok ASC LIMIT 5");
$transaksi_terakhir = mysqli_query($conn, "SELECT t.*, o.nama_obat FROM transaksi t JOIN obat o ON t.id_obat = o.id ORDER BY t.id DESC LIMIT 5");

include 'header.php';
?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1">Dashboard Sistem Apotek</h2>
        <p class="text-muted mb-0">Selamat datang kembali, <strong><?= e($_SESSION['user']['nama']) ?></strong>!</p>
    </div>
    <a href="transaksi_index.php" class="btn btn-primary rounded-pill px-4 shadow-sm">
        <i class="bi bi-cart-plus me-1"></i> Transaksi Baru
    </a>
</div>

<!-- Kartu ringkasan -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card stat-teal d-flex justify-content-between align-items-center">
            <div>
                <div class="label">Total Jenis Obat</div>
                <div class="value"><?= $total_obat ?></div>
            </div>
            <i class="bi bi-capsule icon"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card stat-blue d-flex justify-content-between align-items-center">
            <div>
                <div class="label">Total Supplier</div>
                <div class="value"><?= $total_supplier ?></div>
            </div>
            <i class="bi bi-truck icon"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card stat-amber d-flex justify-content-between align-items-center">
            <div>
                <div class="label">Total Transaksi</div>
                <div class="value"><?= $total_transaksi ?></div>
            </div>
            <i class="bi bi-receipt icon"></i>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Stok menipis -->
    <div class="col-lg-6">
        <div class="card card-app h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>Stok Obat Menipis (&le; 10)</h6>
                <a href="obat_index.php" class="btn btn-sm btn-outline-secondary rounded-pill">Kelola Obat</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr><th>Nama Obat</th><th>Kategori</th><th class="text-end">Sisa Stok</th></tr>
                    </thead>
                    <tbody>
                    <?php if (mysqli_num_rows($stok_menipis) > 0): ?>
                        <?php while ($s = mysqli_fetch_assoc($stok_menipis)): ?>
                        <tr>
                            <td class="fw-semibold"><?= e($s['nama_obat']) ?></td>
                            <td><span class="badge rounded-pill bg-info-subtle text-info-emphasis"><?= e($s['kategori']) ?></span></td>
                            <td class="text-end"><span class="badge rounded-pill bg-danger fs-6"><?= (int)$s['stok'] ?></span></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="3" class="empty-state text-center"><i class="bi bi-check-circle fs-2 d-block text-success mb-2"></i>Semua stok obat masih aman.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Transaksi terbaru -->
    <div class="col-lg-6">
        <div class="card card-app h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary"><i class="bi bi-clock-history me-2"></i>Transaksi Terbaru</h6>
                <a href="transaksi_index.php" class="btn btn-sm btn-outline-secondary rounded-pill">Lihat Riwayat</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr><th>ID Transaksi</th><th>Obat &amp; Qty</th><th class="text-end">Total</th></tr>
                    </thead>
                    <tbody>
                    <?php if (mysqli_num_rows($transaksi_terakhir) > 0): ?>
                        <?php while ($t = mysqli_fetch_assoc($transaksi_terakhir)): ?>
                        <tr>
                            <td><span class="badge bg-light text-dark border">TRX-<?= $t['id'] ?></span></td>
                            <td><?= e($t['nama_obat']) ?> <span class="text-muted">(<?= (int)$t['jumlah'] ?>x)</span></td>
                            <td class="text-end fw-bold text-success"><?= rupiah($t['total_harga']) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="3" class="empty-state text-center">Belum ada transaksi tercatat.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>