<?php 
include 'header.php';
if (!isset($_SESSION['user'])) header("Location: login.php");

$total_obat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM obat"))['total'];
$total_supplier = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM supplier"))['total'];
$total_transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi"))['total'];
?>
<h2>Dashboard</h2>
<p>Selamat datang, <b><?= $_SESSION['user']['nama']; ?></b>!</p>
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card bg-info text-white p-3">
            <h4>Total Obat</h4>
            <h2><?= $total_obat; ?></h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white p-3">
            <h4>Total Supplier</h4>
            <h2><?= $total_supplier; ?></h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-white p-3">
            <h4>Total Transaksi</h4>
            <h2><?= $total_transaksi; ?></h2>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>