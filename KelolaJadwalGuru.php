<?php
session_start();

// Pastikan pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_sekolahtub";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tambah Jadwal Mengajar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_jadwal'])) {
    $nama_guru = $conn->real_escape_string($_POST['nama_guru']);
    $mata_pelajaran = $conn->real_escape_string($_POST['mata_pelajaran']);
    $hari = $conn->real_escape_string($_POST['hari']);
    $jam = $conn->real_escape_string($_POST['jam']);
    $ruang = $conn->real_escape_string($_POST['ruang']);
    
    $conn->query("INSERT INTO jadwal_guru (nama_guru, mata_pelajaran, hari, jam, ruang) VALUES ('$nama_guru', '$mata_pelajaran', '$hari', '$jam', '$ruang')");
}

// Edit Jadwal Mengajar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_jadwal'])) {
    $id = (int)$_POST['id'];
    $nama_guru = $conn->real_escape_string($_POST['nama_guru']);
    $mata_pelajaran = $conn->real_escape_string($_POST['mata_pelajaran']);
    $hari = $conn->real_escape_string($_POST['hari']);
    $jam = $conn->real_escape_string($_POST['jam']);
    $ruang = $conn->real_escape_string($_POST['ruang']);
    
    $conn->query("UPDATE jadwal_guru SET nama_guru='$nama_guru', mata_pelajaran='$mata_pelajaran', hari='$hari', jam='$jam', ruang='$ruang' WHERE id=$id");
}

// Hapus Jadwal Mengajar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_jadwal'])) {
    $id = (int)$_POST['id'];
    $conn->query("DELETE FROM jadwal_guru WHERE id=$id");
}

// Ambil Data Jadwal
$result = $conn->query("SELECT * FROM jadwal_guru");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jadwal Mengajar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #1B5E20;
            color: #fff;
            text-align: center;
            padding: 15px;
        }
        .container {
            display: flex;
        }
        .sidebar {
            background-color: #2E7D32;
            color: white;
            width: 250px;
            height: 100vh;
            padding: 20px;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 0;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background-color: #66BB6A;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        table th {
            background-color: #388E3C;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        button {
            padding: 8px 12px;
            border: none;
            background-color: #388E3C;
            color: white;
            cursor: pointer;
            margin: 5px;
        }
        button.edit {
            background-color: #FFA726;
        }
        button.delete {
            background-color: #E53935;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25);
        }
        .modal-content input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
        }
        .modal-content button {
            width: 100%;
            background: #388E3C;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<header>
    Kelola Jadwal Mengajar
</header>

<div class="container">
    <div class="sidebar">
        <h3>Menu</h3>
        <a href="dashboard.php">Dashboard</a> <!-- Dashboard Link -->
        <a href="keloladataguru.php">Kelola Data Guru</a>
        <a href="kelola_berita.php">Kelola Berita</a>
        <a href="login.php">Logout</a>
    </div>

    <div class="content">
        <h2>Daftar Jadwal Mengajar</h2>

        <form method="POST">
            <h3>Tambah Jadwal Mengajar</h3>
            <input type="text" name="nama_guru" placeholder="Nama Guru" required>
            <input type="text" name="mata_pelajaran" placeholder="Mata Pelajaran" required>
            <input type="text" name="hari" placeholder="Hari" required>
            <input type="text" name="jam" placeholder="Jam" required>
            <input type="text" name="ruang" placeholder="Ruang" required>
            <button type="submit" name="tambah_jadwal">Tambah Jadwal</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Guru</th>
                    <th>Mata Pelajaran</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Ruang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['nama_guru'] ?></td>
                    <td><?= $row['mata_pelajaran'] ?></td>
                    <td><?= $row['hari'] ?></td>
                    <td><?= $row['jam'] ?></td>
                    <td><?= $row['ruang'] ?></td>
                    <td>
                        <button class="edit" onclick="openModal(<?= $row['id'] ?>, '<?= $row['nama_guru'] ?>', '<?= $row['mata_pelajaran'] ?>', '<?= $row['hari'] ?>', '<?= $row['jam'] ?>', '<?= $row['ruang'] ?>')">Edit</button>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" class="delete" name="hapus_jadwal" onclick="return confirm('Hapus jadwal ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <a href="DashboardAdmin.php">
            <button>Kembali ke Dashboard</button>
        </a>
    </div>
</div>

<div class="modal" id="editModal">
    <div class="modal-content">
        <h3>Edit Jadwal Mengajar</h3>
        <form method="POST">
            <input type="hidden" name="id" id="edit_id">
            <input type="text" name="nama_guru" id="edit_nama_guru" placeholder="Nama Guru" required>
            <input type="text" name="mata_pelajaran" id="edit_mata_pelajaran" placeholder="Mata Pelajaran" required>
            <input type="text" name="hari" id="edit_hari" placeholder="Hari" required>
            <input type="text" name="jam" id="edit_jam" placeholder="Jam" required>
            <input type="text" name="ruang" id="edit_ruang" placeholder="Ruang" required>
            <button type="submit" name="edit_jadwal">Simpan Perubahan</button>
        </form>
        <button onclick="closeModal()">Tutup</button>
    </div>
</div>

<script>
    function openModal(id, nama_guru, mata_pelajaran, hari, jam, ruang) {
        document.getElementById("edit_id").value = id;
        document.getElementById("edit_nama_guru").value = nama_guru;
        document.getElementById("edit_mata_pelajaran").value = mata_pelajaran;
        document.getElementById("edit_hari").value = hari;
        document.getElementById("edit_jam").value = jam;
        document.getElementById("edit_ruang").value = ruang;
        document.getElementById("editModal").style.display = "flex";
    }

    function closeModal() {
        document.getElementById("editModal").style.display = "none";
    }
</script>

</body>
</html>
