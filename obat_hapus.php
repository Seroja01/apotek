<?php
require_once 'koneksi.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM obat WHERE id='$id'");
header("Location: obat_index.php");
?>