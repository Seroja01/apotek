<?php 
include 'header.php';
if (!isset($_SESSION['user'])) header("Location: login.php");
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM obat WHERE id='$id'"));

if (isset($_POST['update'])) {
    $nama = $_POST['nama_obat'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    mysqli_query($conn, "UPDATE obat SET nama_obat='$nama', kategori='$kategori', harga='$harga', stok='$stok' WHERE id='$id'");
    header("Location: obat_index.php");
}
?>
<h3>Edit Obat</h3>
<form method="POST" class="col-md-6">
    <div class="mb-3"><label>Nama Obat</label><input type="text" name="nama_obat" value="<?= $data['nama_obat']; ?>" class="form-control" required></div>
    <div class="mb-3"><label>Kategori</label><input type="text" name="kategori" value="<?= $data['kategori']; ?>" class="form-control" required></div>
    <div class="mb-3"><label>Harga</label><input type="number" name="harga" value="<?= $data['harga']; ?>" class="form-control" required></div>
    <div class="mb-3"><label>Stok</label><input type="number" name="stok" value="<?= $data['stok']; ?>" class="form-control" required></div>
    <button type="submit" name="update" class="btn btn-primary">Update</button>
    <a href="obat_index.php" class="btn btn-secondary">Batal</a>
</form>
<?php include 'footer.php'; ?>