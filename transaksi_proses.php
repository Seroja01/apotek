<?php
require_once 'koneksi.php';

$id_obat = $_POST['id_obat'];
$jumlah = $_POST['jumlah'];

$data_obat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM obat WHERE id='$id_obat'"));

if ($data_obat['stok'] < $jumlah) {
    echo "<script>alert('Stok obat tidak mencukupi!'); window.location='transaksi_index.php';</script>";
} else {
    $total_harga = $data_obat['harga'] * $jumlah;
    
    // Simpan Transaksi
    mysqli_query($conn, "INSERT INTO transaksi VALUES(NULL, NOW(), '$id_obat', '$jumlah', '$total_harga')");
    
    // Potong Stok Obat
    $stok_baru = $data_obat['stok'] - $jumlah;
    mysqli_query($conn, "UPDATE obat SET stok='$stok_baru' WHERE id='$id_obat'");
    
    header("Location: transaksi_index.php");
}
?>