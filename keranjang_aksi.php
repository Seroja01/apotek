<?php
require_once 'koneksi.php';
cek_login();

$aksi = $_REQUEST['aksi'] ?? '';

if ($aksi === 'tambah' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = (int)($_POST['id_obat'] ?? 0);
    $jumlah = (int)($_POST['jumlah'] ?? 0);

    $res  = mysqli_query($conn, "SELECT * FROM obat WHERE id=$id");
    $obat = mysqli_fetch_assoc($res);

    if (!$obat || $jumlah < 1) {
        $_SESSION['flash_error'] = 'Data obat atau jumlah tidak valid.';
    } else {
        // Jumlah yang sudah ada di keranjang untuk obat ini
        $sudah = $_SESSION['keranjang'][$id]['jumlah'] ?? 0;
        $total_minta = $sudah + $jumlah;

        if ($total_minta > $obat['stok']) {
            $_SESSION['flash_error'] = 'Stok ' . $obat['nama_obat'] . ' tidak mencukupi (sisa ' . $obat['stok'] . ').';
        } else {
            $_SESSION['keranjang'][$id] = [
                'nama'   => $obat['nama_obat'],
                'harga'  => (int)$obat['harga'],
                'jumlah' => $total_minta,
            ];
        }
    }
}

if ($aksi === 'hapus') {
    $id = (int)($_GET['id'] ?? 0);
    unset($_SESSION['keranjang'][$id]);
}

if ($aksi === 'kosongkan') {
    $_SESSION['keranjang'] = [];
}

header("Location: transaksi_index.php");
exit;