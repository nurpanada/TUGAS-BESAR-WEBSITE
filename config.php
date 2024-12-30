<?php
// Konfigurasi database
$host = 'localhost';       // Host database (default: localhost)
$dbname = 'db_sekolahtub'; // Ganti dengan nama database Anda
$username = 'root';        // Username database (default: root untuk XAMPP/Laragon)
$password = '';            // Password database (kosong untuk XAMPP/Laragon)

try {
    // Buat koneksi menggunakan PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Aktifkan mode exception
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage()); // Tampilkan pesan error jika gagal
}
?>
