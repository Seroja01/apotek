<?php 
include 'header.php';
if (!isset($_SESSION['user'])) header("Location: login.php");
$data = mysqli_query($conn, "SELECT * FROM obat");
?>
<div class="d-flex justify-content-between mb-3">
    <h3>Data Obat</h3>
    <a href="obat_tambah.php" class="btn btn-primary">Tambah Obat</a>
</div>
<table class="table table-bordered bg-white">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Obat</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['nama_obat']; ?></td>
            <td><?= $row['kategori']; ?></td>
            <td>Rp <?= number_format($row['harga']); ?></td>
            <td><?= $row['stok']; ?></td>
            <td>
                <a href="obat_edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="obat_hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include 'footer.php'; ?>