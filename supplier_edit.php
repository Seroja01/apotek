<?php
require_once 'koneksi.php';
cek_login();
$id = (int)($_GET['id'] ?? 0);

if (isset($_POST['update'])) {
    $nama    = mysqli_real_escape_string($conn, $_POST['nama_supplier']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $alamat  = mysqli_real_escape_string($conn, $_POST['alamat']);
    mysqli_query($conn, "UPDATE supplier SET nama_supplier='$nama', telepon='$telepon', alamat='$alamat' WHERE id=$id");
    header("Location: supplier_index.php");
    exit;
}

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM supplier WHERE id=$id"));
if (!$data) {
    header("Location: supplier_index.php");
    exit;
}

$judul = 'Edit Supplier';
include 'header.php';
?>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="mb-4">
            <h3 class="fw-bold mb-1">Edit Supplier</h3>
            <p class="text-muted mb-0">Perbarui data <strong><?= e($data['nama_supplier']) ?></strong></p>
        </div>
        <div class="card card-app">
            <div class="card-body p-4">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Supplier</label>
                        <input type="text" name="nama_supplier" value="<?= e($data['nama_supplier']) ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="telepon" value="<?= e($data['telepon']) ?>" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3" required><?= e($data['alamat']) ?></textarea>
                    </div>
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="supplier_index.php" class="btn btn-light rounded-pill px-4">Batal</a>
                        <button type="submit" name="update" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-save me-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>