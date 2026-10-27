<?php
require_once 'koneksi.php';
cek_login();

if (isset($_POST['simpan'])) {
    $nama    = mysqli_real_escape_string($conn, $_POST['nama_supplier']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $alamat  = mysqli_real_escape_string($conn, $_POST['alamat']);
    mysqli_query($conn, "INSERT INTO supplier (nama_supplier, telepon, alamat) VALUES ('$nama', '$telepon', '$alamat')");
    header("Location: supplier_index.php");
    exit;
}

$judul = 'Tambah Supplier';
include 'header.php';
?>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="mb-4">
            <h3 class="fw-bold mb-1">Tambah Supplier</h3>
            <p class="text-muted mb-0">Tambahkan mitra pemasok baru</p>
        </div>
        <div class="card card-app">
            <div class="card-body p-4">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Supplier</label>
                        <input type="text" name="nama_supplier" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="telepon" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="supplier_index.php" class="btn btn-light rounded-pill px-4">Batal</a>
                        <button type="submit" name="simpan" class="btn btn-success rounded-pill px-4">
                            <i class="bi bi-check-lg me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>