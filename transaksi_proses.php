<?php
require_once 'koneksi.php';
cek_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['keranjang'])) {
    header("Location: transaksi_index.php");
    exit;
}

// Mulai transaksi database agar semua item tersimpan atau tidak sama sekali
mysqli_begin_transaction($conn);

try {
    // Cek ulang stok semua item sebelum menyimpan apa pun
    foreach ($_SESSION['keranjang'] as $id => $item) {
        $id = (int)$id;
        $res = mysqli_query($conn, "SELECT stok FROM obat WHERE id=$id FOR UPDATE");
        $obat = mysqli_fetch_assoc($res);

        if (!$obat || $obat['stok'] < $item['jumlah']) {
            throw new Exception('Stok ' . $item['nama'] . ' tidak mencukupi. Perbarui keranjang.');
        }
    }

    // Nomor nota baru
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(MAX(id_nota), 0) + 1 AS nota FROM transaksi"));
    $id_nota = (int)$r['nota'];

    foreach ($_SESSION['keranjang'] as $id => $item) {
        $id     = (int)$id;
        $jumlah = (int)$item['jumlah'];
        $total  = (int)$item['harga'] * $jumlah;

        mysqli_query($conn, "INSERT INTO transaksi (id_nota, tgl_transaksi, id_obat, jumlah, total_harga)
                             VALUES ($id_nota, NOW(), $id, $jumlah, $total)");
        mysqli_query($conn, "UPDATE obat SET stok = stok - $jumlah WHERE id=$id");
    }

    mysqli_commit($conn);
    $_SESSION['keranjang'] = [];
    header("Location: transaksi_index.php");
    exit;
} catch (Exception $ex) {
    mysqli_rollback($conn);
    $_SESSION['flash_error'] = $ex->getMessage();
    header("Location: transaksi_index.php");
    exit;
}