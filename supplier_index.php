<?php 
include 'header.php';
if (!isset($_SESSION['user'])) header("Location: login.php");
$data = mysqli_query($conn, "SELECT * FROM supplier");
?>
<div class="d-flex justify-content-between mb-3">
    <h3>Data Supplier</h3>
    <a href="supplier_tambah.php" class="btn btn-primary">Tambah Supplier</a>
</div>
<table class="table table-bordered bg-white">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Supplier</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['nama_supplier']; ?></td>
            <td><?= $row['telepon']; ?></td>
            <td><?= $row['alamat']; ?></td>
            <td>
                <a href="supplier_edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="supplier_hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus supplier?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include 'footer.php'; ?>