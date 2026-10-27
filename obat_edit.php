<?php
require_once 'koneksi.php';
cek_login();
$id = (int)($_GET['id'] ?? 0);
$error = '';

if (isset($_POST['update'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama_obat']);
    $kategori = $_POST['kategori'] ?? '';
    $harga    = (int)$_POST['harga'];
    $stok     = (int)$_POST['stok'];

    if (in_array($kategori, $daftar_kategori, true)) {
        $kategori = mysqli_real_escape_string($conn, $kategori);
        mysqli_query($conn, "UPDATE obat SET nama_obat='$nama', kategori='$kategori', harga='$harga', stok='$stok' WHERE id=$id");
        header("Location: obat_index.php");
        exit;
    }
    $error = 'Kategori tidak valid. Pilih salah satu dari daftar.';
}

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM obat WHERE id=$id"));
if (!$data) {
    header("Location: obat_index.php");
    exit;
}

// Kalau kategori lama tidak ada di daftar baru, tetap tampilkan agar tidak hilang
$kategori_sekarang = $_POST['kategori'] ?? $data['kategori'];
$kategori_lama = !in_array($data['kategori'], $daftar_kategori, true);

$judul = 'Edit Obat';
include 'header.php';
?>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="mb-4">
            <h3 class="fw-bold mb-1">Edit Obat</h3>
            <p class="text-muted mb-0">Perbarui data untuk <strong><?= e($data['nama_obat']) ?></strong></p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endif; ?>
        <?php if ($kategori_lama): ?>
            <div class="alert alert-warning">
                Kategori lama "<?= e($data['kategori']) ?>" tidak ada dalam daftar. Silakan pilih kategori yang baru.
            </div>
        <?php endif; ?>

        <div class="card card-app">
            <div class="card-body p-4">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Obat</label>
                        <input type="text" name="nama_obat" value="<?= e($data['nama_obat']) ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <?php if ($kategori_lama): ?>
                                <option value="" disabled selected>-- Pilih kategori --</option>
                            <?php endif; ?>
                            <?php foreach ($daftar_kategori as $k): ?>
                                <option value="<?= e($k) ?>" <?= $k === $kategori_sekarang ? 'selected' : '' ?>><?= e($k) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="harga" value="<?= (int)$data['harga'] ?>" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" value="<?= (int)$data['stok'] ?>" class="form-control" min="0" required>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="obat_index.php" class="btn btn-light rounded-pill px-4">Batal</a>
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