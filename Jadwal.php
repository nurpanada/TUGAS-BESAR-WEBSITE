<?php
// Mulai sesi untuk memeriksa login pengguna
session_start();

// Cek jika pengguna belum login, arahkan ke halaman login
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'guru') {
    header('Location: login.php');
    exit;
}

// Contoh data jadwal mengajar
$jadwal = [
    ['hari' => 'Senin', 'jam' => '08:00 - 10:00', 'mata_pelajaran' => 'Matematika'],
    ['hari' => 'Rabu', 'jam' => '10:00 - 12:00', 'mata_pelajaran' => 'Bahasa Indonesia'],
    ['hari' => 'Jumat', 'jam' => '08:00 - 10:00', 'mata_pelajaran' => 'Fisika']
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Mengajar - SMKN 7 Bulukumba</title>
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
        <h1>Jadwal Mengajar Anda</h1>
        <table>
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Mata Pelajaran</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jadwal as $item): ?>
                    <tr>
                        <td><?= $item['hari'] ?></td>
                        <td><?= $item['jam'] ?></td>
                        <td><?= $item['mata_pelajaran'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="DashboardGuru.php" class="back-btn">Kembali ke Dashboard</a>
    </div>
</body>
</html>
