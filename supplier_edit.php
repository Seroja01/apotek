<?php 
include 'header.php';
if (!isset($_SESSION['user'])) header("Location: login.php");
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM supplier WHERE id='$id'"));

if (isset($_POST['update'])) {
    $nama = $_POST['nama_supplier'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    mysqli_query($conn, "UPDATE supplier SET nama_supplier='$nama', telepon='$telepon', alamat='$alamat' WHERE id='$id'");
    header("Location: supplier_index.php");
}
?>
<h3>Edit Supplier</h3>
<form method="POST" class="col-md-6">
    <div class="mb-3"><label>Nama Supplier</label><input type="text" name="nama_supplier" value="<?= $data['nama_supplier']; ?>" class="form-control" required></div>
    <div class="mb-3"><label>Telepon</label><input type="text" name="telepon" value="<?= $data['telepon']; ?>" class="form-control" required></div>
    <div class="mb-3"><label>Alamat</label><textarea name="alamat" class="form-control" required><?= $data['alamat']; ?></textarea></div>
    <button type="submit" name="update" class="btn btn-primary">Update</button>
    <a href="supplier_index.php" class="btn btn-secondary">Batal</a>
</form>
<?php include 'footer.php'; ?>