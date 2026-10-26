<?php 
include 'header.php';
if (!isset($_SESSION['user'])) header("Location: login.php");

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_supplier'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    mysqli_query($conn, "INSERT INTO supplier VALUES(NULL, '$nama', '$telepon', '$alamat')");
    header("Location: supplier_index.php");
}
?>
<h3>Tambah Supplier</h3>
<form method="POST" class="col-md-6">
    <div class="mb-3"><label>Nama Supplier</label><input type="text" name="nama_supplier" class="form-control" required></div>
    <div class="mb-3"><label>Telepon</label><input type="text" name="telepon" class="form-control" required></div>
    <div class="mb-3"><label>Alamat</label><textarea name="alamat" class="form-control" required></textarea></div>
    <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
    <a href="supplier_index.php" class="btn btn-secondary">Batal</a>
</form>
<?php include 'footer.php'; ?>