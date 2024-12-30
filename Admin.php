<?php
// Nama file: admin_dashboard.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SMKN 7 Bulukumba</title>
    <style>
        /* Gaya Umum */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #E3F2FD;
            color: #333;
        }

        /* Header */
        header {
            background-color: #1B5E20;
            color: #FFFFFF;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        /* Sidebar */
        .sidebar {
            width: 20%;
            background-color: #1B5E20;
            color: #FFFFFF;
            position: fixed;
            height: 100%;
            padding: 20px 0;
            overflow-y: auto;
        }

        .sidebar a {
            display: block;
            color: #A5D6A7;
            text-decoration: none;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #81C784;
        }

        /* Konten */
        .main-content {
            margin-left: 20%;
            padding: 20px;
        }

        .main-content h2 {
            color: #1B5E20;
            margin-bottom: 20px;
        }

        .card {
            background-color: #FFFFFF;
            border: 1px solid #DDD;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            margin: 0 0 10px;
        }

        .card p {
            margin: 0;
        }

        /* Footer */
        footer {
            background-color: #1B5E20;
            color: #FFFFFF;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Dashboard Admin - SMKN 7 Bulukumba</h1>
    </header>

    <div class="sidebar">
        <h3>Menu</h3>
        <a href="#" onclick="return false;">Dashboard</a>
        <a href="#">Kelola Data Siswa</a>
        <a href="#">Kelola Data Guru</a>
        <a href="#">Kelola Jadwal</a>
        <a href="#">Kelola Berita</a>
        <a href="#">Logout</a>
    </div>

    <div class="main-content">
        <h2>Selamat Datang, Admin</h2>
        <div class="card">
            <h3>Jumlah Siswa</h3>
            <p>250 Siswa</p>
        </div>
        <div class="card">
            <h3>Jumlah Guru</h3>
            <p>30 Guru</p>
        </div>
        <div class="card">
            <h3>Berita Terbaru</h3>
            <p>Workshop Teknologi akan diadakan pada 20 Desember 2024.</p>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> SMKN 7 Bulukumba. All rights reserved.</p>
    </footer>
</body>
</html>
