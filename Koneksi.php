<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'db_sekolahtub';

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
