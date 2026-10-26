<?php 
include 'header.php';
if (!isset($_SESSION['user'])) header("Location: login.php");

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_obat'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    mysqli_query($conn, "INSERT INTO obat VALUES(NULL, '$nama', '$kategori', '$harga', '$stok')");
    header("Location: obat_index.php");
}
?>
<h3>Tambah Obat</h3>
<form method="POST" class="col-md-6">
    <div class="mb-3"><label>Nama Obat</label><input type="text" name="nama_obat" class="form-control" required></div>
    <div class="mb-3"><label>Kategori</label><input type="text" name="kategori" class="form-control" required></div>
    <div class="mb-3"><label>Harga</label><input type="number" name="harga" class="form-control" required></div>
    <div class="mb-3"><label>Stok</label><input type="number" name="stok" class="form-control" required></div>
    <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
    <a href="obat_index.php" class="btn btn-secondary">Batal</a>
</form>
<?php include 'footer.php'; ?>