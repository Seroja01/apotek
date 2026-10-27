<?php require_once 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($judul) ? e($judul) . ' | ' : '' ?>Sistem Apotek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<?php
$halaman = basename($_SERVER['PHP_SELF']);
$grup = explode('_', pathinfo($halaman, PATHINFO_FILENAME))[0];
$menu = fn($g) => $grup === $g ? ' active' : '';
?>
<?php if (isset($_SESSION['user'])): ?>
<nav class="navbar navbar-expand-lg navbar-apotek sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="dashboard.php">
            <span class="brand-icon"><i class="bi bi-capsule-pill"></i></span> Apotek
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuUtama">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuUtama">
            <div class="navbar-nav ms-auto gap-1 align-items-lg-center">
                <a class="nav-link<?= $menu('dashboard') ?>" href="dashboard.php"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
                <a class="nav-link<?= $menu('obat') ?>" href="obat_index.php"><i class="bi bi-capsule me-1"></i>Data Obat</a>
                <a class="nav-link<?= $menu('supplier') ?>" href="supplier_index.php"><i class="bi bi-truck me-1"></i>Supplier</a>
                <a class="nav-link<?= $menu('transaksi') ?>" href="transaksi_index.php"><i class="bi bi-receipt me-1"></i>Transaksi</a>
                <a class="btn btn-sm btn-outline-light rounded-pill px-3 ms-lg-2" href="logout.php">
                    <i class="bi bi-box-arrow-right me-1"></i>Logout
                </a>
            </div>
        </div>
    </div>
</nav>
<?php endif; ?>
<main class="container py-4">