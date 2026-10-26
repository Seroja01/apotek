<?php 
include 'header.php';
if (!isset($_SESSION['user'])) header("Location: login.php");

$obat = mysqli_query($conn, "SELECT * FROM obat WHERE stok > 0");
$transaksi = mysqli_query($conn, "SELECT t.*, o.nama_obat FROM transaksi t JOIN obat o ON t.id_obat = o.id ORDER BY t.id DESC");
?>
<h3>Transaksi Penjualan Kasir</h3>
<div class="row mb-5">
    <div class="col-md-5">
        <form action="transaksi_proses.php" method="POST" class="card p-3 shadow-sm">
            <div class="mb-3">
                <label>Pilih Obat</label>
                <select name="id_obat" class="form-select" required>
                    <?php while($o = mysqli_fetch_assoc($obat)): ?>
                        <option value="<?= $o['id']; ?>"><?= $o['nama_obat']; ?> (Stok: <?= $o['stok']; ?>) - Rp <?= $o['harga']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Jumlah Beli</label>
                <input type="number" name="jumlah" class="form-control" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary">Proses Transaksi</button>
        </form>
    </div>
</div>

<h4>Riwayat Transaksi</h4>
<table class="table table-bordered bg-white">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Nama Obat</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Nota</th>
        </tr>
    </thead>
    <tbody>
        <?php while($t = mysqli_fetch_assoc($transaksi)): ?>
        <tr>
            <td>TRX-<?= $t['id']; ?></td>
            <td><?= $t['tgl_transaksi']; ?></td>
            <td><?= $t['nama_obat']; ?></td>
            <td><?= $t['jumlah']; ?></td>
            <td>Rp <?= number_format($t['total_harga']); ?></td>
            <td><a href="transaksi_nota.php?id=<?= $t['id']; ?>" class="btn btn-sm btn-info text-white" target="_blank">Cetak Nota</a></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include 'footer.php'; ?>