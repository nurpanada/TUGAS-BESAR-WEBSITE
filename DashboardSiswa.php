<?php
session_start();

// Cek apakah pengguna sudah login dan memiliki role "siswa"
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'siswa') {
    header('Location: login.php');
    exit;
}

echo "<h1>Dashboard Siswa</h1>";
echo "<p>Selamat datang, Siswa! Berikut adalah informasi terkait kelas dan nilai Anda:</p>";
echo "<ul>";
echo "<li><a href='view_schedule.php'>Lihat Jadwal Pelajaran</a></li>";
echo "<li><a href='view_grades.php'>Lihat Nilai</a></li>";
echo "<li><a href='logout.php'>Logout</a></li>";
echo "</ul>";
?>
