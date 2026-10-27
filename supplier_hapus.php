<?php
require_once 'koneksi.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM supplier WHERE id='$id'");
header("Location: supplier_index.php");
?>