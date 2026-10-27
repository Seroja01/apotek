<?php
require_once 'koneksi.php';
cek_login();
$judul = 'Transaksi';

$obat      = mysqli_query($conn, "SELECT * FROM obat WHERE stok > 0 ORDER BY nama_obat");
$transaksi = mysqli_query($conn, "SELECT t.*, o.nama_obat FROM transaksi t JOIN obat o ON t.id_obat = o.id ORDER BY t.id DESC");

include 'header.php';
?>
<div class="mb-4">
    <h3 class="fw-bold mb-1">Transaksi Penjualan</h3>
    <p class="text-muted mb-0">Proses penjualan obat dan cetak nota</p>
</div>

<div class="row g-4">
    <!-- Form kasir -->
    <div class="col-lg-4">
        <div class="card card-app">
            <div class="card-header fw-bold"><i class="bi bi-cart-plus text-primary me-2"></i>Kasir Baru</div>
            <div class="card-body p-4">
                <form action="transaksi_proses.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Pilih Obat</label>
                        <select name="id_obat" class="form-select" required>
                            <option value="" disabled selected>-- Pilih obat --</option>
                            <?php while ($o = mysqli_fetch_assoc($obat)): ?>
                                <option value="<?= $o['id'] ?>">
                                    <?= e($o['nama_obat']) ?> (Stok: <?= (int)$o['stok'] ?>) - <?= rupiah($o['harga']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Jumlah Beli</label>
                        <input type="number" name="jumlah" class="form-control" min="1" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold">
                        <i class="bi bi-check2-circle me-1"></i> Proses Transaksi
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Riwayat -->
    <div class="col-lg-8">
        <div class="card card-app">
            <div class="card-header fw-bold"><i class="bi bi-clock-history text-primary me-2"></i>Riwayat Transaksi</div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Nama Obat</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th class="text-end">Nota</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (mysqli_num_rows($transaksi) === 0): ?>
                        <tr><td colspan="6" class="empty-state text-center">Belum ada transaksi.</td></tr>
                    <?php endif; ?>
                    <?php while ($t = mysqli_fetch_assoc($transaksi)): ?>
                        <tr>
                            <td><span class="badge bg-light text-dark border">TRX-<?= $t['id'] ?></span></td>
                            <td class="small text-muted"><?= date('d M Y, H:i', strtotime($t['tgl_transaksi'])) ?></td>
                            <td class="fw-semibold"><?= e($t['nama_obat']) ?></td>
                            <td><?= (int)$t['jumlah'] ?></td>
                            <td class="fw-bold text-success"><?= rupiah($t['total_harga']) ?></td>
                            <td class="text-end">
                                <a href="transaksi_nota.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-info text-white" target="_blank">
                                    <i class="bi bi-printer"></i> Cetak
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>