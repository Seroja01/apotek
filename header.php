<?php require_once 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Apotek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php if (isset($_SESSION['user'])): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container">
    <a class="navbar-brand font-weight-bold" href="dashboard.php">Apotek</a>
    <div class="navbar-nav">
      <a class="nav-link" href="dashboard.php">Dashboard</a>
      <a class="nav-link" href="obat_index.php">Data Obat</a>
      <a class="nav-link" href="supplier_index.php">Data Supplier</a>
      <a class="nav-link" href="transaksi_index.php">Transaksi</a>
      <a class="nav-link text-warning" href="logout.php">Logout</a>
    </div>
  </div>
</nav>
<?php endif; ?>
<div class="container">