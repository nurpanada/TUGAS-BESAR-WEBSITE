<?php
// Mulai sesi untuk memeriksa login pengguna
session_start();

// Cek jika pengguna belum login, arahkan ke halaman login
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'guru') {
    header('Location: login.php');
    exit;
}

// Koneksi ke database
$servername = "localhost"; // Ganti dengan server database Anda
$username = "root";        // Ganti dengan username database Anda
$password = "";            // Ganti dengan password database Anda
$dbname = "db_sekolahtub"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data siswa
$sql = "SELECT nama, kelas, status FROM siswa";
$result = $conn->query($sql);

// Menutup koneksi setelah mengambil data
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - SMKN 7 Bulukumba</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #E3F2FD;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #1B5E20;
            color: white;
        }
        .back-btn {
            margin-top: 20px;
            display: block;
            text-align: center;
            background-color: #1B5E20;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-btn:hover {
            background-color: #388E3C;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Data Siswa</h1>

        <!-- Tabel Data Siswa -->
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Tampilkan data siswa jika ada
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['nama'] . "</td>
                                <td>" . $row['kelas'] . "</td>
                                <td>" . $row['status'] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Tidak ada data siswa.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="DashboardGuru.php" class="back-btn">Kembali ke Dashboard</a>
    </div>
</body>
</html>
