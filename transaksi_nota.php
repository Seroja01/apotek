<?php
require_once 'koneksi.php';
cek_login();
$id = (int)($_GET['id'] ?? 0);
$q = mysqli_query($conn, "SELECT t.*, o.nama_obat, o.harga FROM transaksi t JOIN obat o ON t.id_obat = o.id WHERE t.id=$id");
$data = mysqli_fetch_assoc($q);
if (!$data) {
    die("Transaksi tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota TRX-<?= $data['id'] ?></title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            width: 300px;
            margin: 20px auto;
            padding: 16px;
            border: 1px dashed #94a3b8;
            color: #1e293b;
            font-size: 13px;
        }
        h3 { text-align: center; margin: 0 0 4px; letter-spacing: 2px; }
        .sub { text-align: center; color: #64748b; font-size: 11px; margin-bottom: 8px; }
        hr { border: 0; border-top: 1px dashed #94a3b8; margin: 10px 0; }
        .row { display: flex; justify-content: space-between; gap: 8px; margin: 4px 0; }
        .total { font-weight: bold; font-size: 15px; }
        .footer { text-align: center; margin-top: 14px; color: #64748b; }
    </style>
</head>
<body onload="window.print()">
    <h3>APOTEK UTS</h3>
    <div class="sub">Nota Penjualan</div>
    <hr>
    <div class="row"><span>ID</span><span>TRX-<?= $data['id'] ?></span></div>
    <div class="row"><span>Tanggal</span><span><?= date('d/m/Y H:i', strtotime($data['tgl_transaksi'])) ?></span></div>
    <hr>
    <div class="row">
        <span><?= e($data['nama_obat']) ?> (x<?= (int)$data['jumlah'] ?>)</span>
        <span><?= rupiah($data['total_harga']) ?></span>
    </div>
    <hr>
    <div class="row total"><span>TOTAL</span><span><?= rupiah($data['total_harga']) ?></span></div>
    <div class="footer">-- Terima Kasih --</div>
</body>
</html>