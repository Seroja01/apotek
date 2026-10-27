<?php
$conn = mysqli_connect("localhost", "root", "", "db_apotek");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");
session_start();

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function rupiah($angka) {
    return 'Rp ' . number_format((int)$angka, 0, ',', '.');
}

function cek_login() {
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit;
    }
}

$daftar_kategori = [
    'Obat Bebas',
    'Obat Bebas Terbatas',
    'Obat Keras',
    'Obat Golongan Narkotika',
    'Obat Fitofarmaka',
    'Obat Herbal Terstandar',
];

?>