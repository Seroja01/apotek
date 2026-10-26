<?php
require_once 'koneksi.php';
$id = $_GET['id'];
$q = mysqli_query($conn, "SELECT t.*, o.nama_obat, o.harga FROM transaksi t JOIN obat o ON t.id_obat = o.id WHERE t.id='$id'");
$data = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nota Transaksi TRX-<?= $data['id']; ?></title>
    <style>
        body { font-family: sans-serif; width: 300px; padding: 10px; border: 1px solid #ccc; }
        .text-center { text-align: center; }
        .flex { display: flex; justify-content: space-between; }
    </style>
</head>
<body onload="window.print()">
    <h3 class="text-center">APOTEK UTS</h3>
    <hr>
    <p>ID Transaksi: TRX-<?= $data['id']; ?><br>Tanggal: <?= $data['tgl_transaksi']; ?></p>
    <hr>
    <div class="flex">
        <span><?= $data['nama_obat']; ?> (x<?= $data['jumlah']; ?>)</span>
        <span>Rp <?= number_format($data['total_harga']); ?></span>
    </div>
    <hr>
    <div class="flex">
        <b>TOTAL:</b>
        <b>Rp <?= number_format($data['total_harga']); ?></b>
    </div>
    <br>
    <p class="text-center">-- Terima Kasih --</p>
</body>
</html>