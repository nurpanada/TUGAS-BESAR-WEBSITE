<?php
// Mulai sesi untuk memeriksa login pengguna
session_start();

// Cek jika pengguna belum login, arahkan ke halaman login
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'guru') {
    header('Location: login.php');
    exit;
}

// Ambil data profil pengguna (misalnya dari database)
$username = $_SESSION['username'];
// Misalkan kita sudah memiliki informasi lainnya seperti email, yang diambil dari sesi atau database
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'Tidak Diketahui';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - SMKN 7 Bulukumba</title>
    <style>
        /* Mengatur latar belakang halaman menggunakan gambar */
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background-image: url('images/kelas.jpg'); /* Gambar latar belakang */
            background-size: cover;  /* Agar gambar menutupi seluruh halaman */
            background-position: center; /* Menjaga gambar di tengah */
            background-attachment: fixed; /* Membuat gambar tetap saat scroll */
            height: 100vh; /* Mengatur tinggi halaman agar memenuhi layar */
        }

        /* Kontainer utama untuk layout */
        .container {
            display: flex; /* Menggunakan flexbox untuk membuat dua kolom */
            height: 100vh; /* Mengatur tinggi halaman */
        }

        /* Menu di sebelah kiri */
        .menu {
            width: 250px; /* Lebar menu tetap */
            background-color: rgba(255, 255, 255, 0.8); /* Latar belakang semi-transparan */
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* Efek bayangan di sisi kanan menu */
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .menu a {
            text-decoration: none;
            background-color: #1B5E20;
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .menu a:hover {
            background-color: #388E3C;
        }

        /* Konten utama di sebelah kanan */
        .content {
            flex-grow: 1; /* Konten utama mengambil sisa ruang */
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.8); /* Latar belakang semi-transparan untuk konten */
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1); /* Efek bayangan untuk konten */
            border-radius: 10px;
            margin-left: 20px; /* Jarak antara menu dan konten */
        }

        h1 {
            text-align: center;
            color: #1B5E20;
            margin-bottom: 20px;
        }

        .logout {
            margin-top: 40px;
            text-align: center;
        }

        .logout a {
            text-decoration: none;
            color: #FF4C4C;
            font-size: 16px;
        }

        .logout a:hover {
            text-decoration: underline;
        }

        /* Responsivitas: Agar tampilan lebih baik pada perangkat kecil */
        @media (max-width: 768px) {
            .container {
                flex-direction: column; /* Ubah menjadi kolom pada layar kecil */
            }

            .menu {
                width: 100%; /* Menu akan mengambil lebar penuh pada perangkat kecil */
                padding: 10px;
            }

            .content {
                margin-left: 0; /* Hilangkan margin pada konten */
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Menu Sidebar -->
        <div class="menu">
            <h2>Menu Guru</h2>
            <a href="jadwal.php">Lihat Jadwal Mengajar</a>
            <a href="DataSiswa.php">Lihat Data Siswa</a>
            <a href="Profilguru.php">Profil Akun</a>
            <a href="LogOutguru.php">Logout</a>
        </div>

        <!-- Konten Utama -->
        <div class="content">
            <h1>Selamat datang, Guru!</h1>
            <p>Berikut adalah informasi terkait kelas yang Anda ajar:</p>

            <!-- Bagian Profil Akun dihapus -->
        </div>
    </div>
</body>
</html>
