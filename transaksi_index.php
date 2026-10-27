<?php
require_once 'koneksi.php';
cek_login();
$judul = 'Transaksi';

// Inisialisasi keranjang
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

$error = $_SESSION['flash_error'] ?? '';
unset($_SESSION['flash_error']);

$obat = mysqli_query($conn, "SELECT * FROM obat WHERE stok > 0 ORDER BY nama_obat");
$daftar_obat = [];
while ($o = mysqli_fetch_assoc($obat)) {
    $daftar_obat[$o['id']] = $o;
}

// Hitung total keranjang
$total_keranjang = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $total_keranjang += $item['harga'] * $item['jumlah'];
}

$riwayat = mysqli_query($conn, "
    SELECT id_nota, MIN(tgl_transaksi) AS tgl, SUM(total_harga) AS total,
           GROUP_CONCAT(CONCAT(o.nama_obat, ' (x', t.jumlah, ')') SEPARATOR ', ') AS isi
    FROM transaksi t
    JOIN obat o ON t.id_obat = o.id
    GROUP BY id_nota
    ORDER BY id_nota DESC
");

include 'header.php';
?>
<div class="mb-4">
    <h3 class="fw-bold mb-1">Transaksi Penjualan</h3>
    <p class="text-muted mb-0">Pilih beberapa obat ke keranjang, lalu proses sekaligus</p>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= e($error) ?></div>
<?php endif; ?>

<div class="row g-4">
    <!-- Tambah ke keranjang -->
    <div class="col-lg-5">
        <div class="card card-app mb-4">
            <div class="card-header fw-bold"><i class="bi bi-plus-circle text-primary me-2"></i>Tambah ke Keranjang</div>
            <div class="card-body p-4">
                <form action="keranjang_aksi.php" method="POST">
                    <input type="hidden" name="aksi" value="tambah">
                    <div class="mb-3">
                        <label class="form-label">Pilih Obat</label>
                        <select name="id_obat" class="form-select" required>
                            <option value="" disabled selected>-- Pilih obat --</option>
                            <?php foreach ($daftar_obat as $o): ?>
                                <option value="<?= (int)$o['id'] ?>">
                                    <?= e($o['nama_obat']) ?> (Stok: <?= (int)$o['stok'] ?>) - <?= rupiah($o['harga']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" min="1" value="1" required>
                    </div>
                    <button type="submit" class="btn btn-outline-primary w-100 rounded-pill py-2 fw-semibold">
                        <i class="bi bi-cart-plus me-1"></i> Masukkan ke Keranjang
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Keranjang -->
    <div class="col-lg-7">
        <div class="card card-app mb-4">
            <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                <span><i class="bi bi-cart3 text-primary me-2"></i>Keranjang</span>
                <?php if ($_SESSION['keranjang']): ?>
                <a href="keranjang_aksi.php?aksi=kosongkan" class="btn btn-sm btn-outline-secondary rounded-pill">Kosongkan</a>
                <?php endif; ?>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead><tr><th>Obat</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th><th></th></tr></thead>
                    <tbody>
                    <?php if (empty($_SESSION['keranjang'])): ?>
                        <tr><td colspan="5" class="empty-state text-center">Keranjang masih kosong.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($_SESSION['keranjang'] as $id => $item): ?>
                        <tr>
                            <td class="fw-semibold"><?= e($item['nama']) ?></td>
                            <td><?= rupiah($item['harga']) ?></td>
                            <td><?= (int)$item['jumlah'] ?></td>
                            <td class="fw-bold text-success"><?= rupiah($item['harga'] * $item['jumlah']) ?></td>
                            <td class="text-end">
                                <a href="keranjang_aksi.php?aksi=hapus&id=<?= (int)$id ?>" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-lg"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <?php if (!empty($_SESSION['keranjang'])): ?>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total</td>
                            <td class="fw-bold text-success fs-5"><?= rupiah($total_keranjang) ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                    <?php endif; ?>
                </table>
            </div>
            <?php if (!empty($_SESSION['keranjang'])): ?>
            <div class="card-body border-top">
                <form action="transaksi_proses.php" method="POST">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold">
                        <i class="bi bi-check2-circle me-1"></i> Proses Transaksi
                    </button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Riwayat -->
<div class="card card-app">
    <div class="card-header fw-bold"><i class="bi bi-clock-history text-primary me-2"></i>Riwayat Transaksi</div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr><th>Nota</th><th>Tanggal</th><th>Isi</th><th>Total</th><th class="text-end">Cetak</th></tr>
            </thead>
            <tbody>
            <?php if (mysqli_num_rows($riwayat) === 0): ?>
                <tr><td colspan="5" class="empty-state text-center">Belum ada transaksi.</td></tr>
            <?php endif; ?>
            <?php while ($r = mysqli_fetch_assoc($riwayat)): ?>
                <tr>
                    <td><span class="badge bg-light text-dark border">NOTA-<?= (int)$r['id_nota'] ?></span></td>
                    <td class="small text-muted"><?= date('d M Y, H:i', strtotime($r['tgl'])) ?></td>
                    <td class="small"><?= e($r['isi']) ?></td>
                    <td class="fw-bold text-success"><?= rupiah($r['total']) ?></td>
                    <td class="text-end">
                        <a href="transaksi_nota.php?id=<?= (int)$r['id_nota'] ?>" class="btn btn-sm btn-info text-white" target="_blank">
                            <i class="bi bi-printer"></i> Cetak
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'footer.php'; ?>