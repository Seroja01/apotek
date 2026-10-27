<?php
require_once 'koneksi.php';
cek_login();

if (isset($_POST['simpan'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama_obat']);
    $kategori = $_POST['kategori'] ?? '';
    $harga    = (int)$_POST['harga'];
    $stok     = (int)$_POST['stok'];

    // Tolak kategori yang tidak ada dalam daftar
    if (in_array($kategori, $daftar_kategori, true)) {
        $kategori = mysqli_real_escape_string($conn, $kategori);
        mysqli_query($conn, "INSERT INTO obat (nama_obat, kategori, harga, stok) VALUES ('$nama', '$kategori', '$harga', '$stok')");
        header("Location: obat_index.php");
        exit;
    }
    $error = 'Kategori tidak valid. Pilih salah satu dari daftar.';
}

$judul = 'Tambah Obat';
include 'header.php';
?>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="mb-4">
            <h3 class="fw-bold mb-1">Tambah Obat</h3>
            <p class="text-muted mb-0">Isi data obat baru dengan lengkap</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endif; ?>

        <div class="card card-app">
            <div class="card-body p-4">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Obat</label>
                        <input type="text" name="nama_obat" class="form-control" placeholder="Contoh: Paracetamol 500mg" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="" disabled selected>-- Pilih kategori --</option>
                            <?php foreach ($daftar_kategori as $k): ?>
                                <option value="<?= e($k) ?>"><?= e($k) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control" min="0" required>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="obat_index.php" class="btn btn-light rounded-pill px-4">Batal</a>
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