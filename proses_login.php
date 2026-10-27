<?php
require_once 'koneksi.php';
$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
if (mysqli_num_rows($query) > 0) {
    $_SESSION['user'] = mysqli_fetch_assoc($query);
    header("Location: dashboard.php");
} else {
    echo "<script>alert('Username atau password salah'); window.location='login.php';</script>";
}
?>