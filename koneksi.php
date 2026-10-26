<?php
$conn = mysqli_connect("localhost", "root", "", "db_apotek");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
session_start();
?>