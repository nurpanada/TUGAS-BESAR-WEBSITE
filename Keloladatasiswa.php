<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$conn = new mysqli("localhost", "root", "", "db_sekolahtub");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// Query untuk mengambil semua data siswa
$result = $conn->query("SELECT * FROM siswa");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Menangani input POST untuk menambahkan siswa
    if (isset($_POST['add_siswa'])) {
        $nama = $conn->real_escape_string($_POST['nama']);
        $kelas = $conn->real_escape_string($_POST['kelas']);
        $status = $conn->real_escape_string($_POST['status']);
        
        // Menyimpan data siswa baru
        $conn->query("INSERT INTO siswa (nama, kelas, status) VALUES ('$nama', '$kelas', '$status')");
        $result = $conn->query("SELECT * FROM siswa");
    }

    // Menangani input POST untuk menghapus siswa berdasarkan ID
    if (isset($_POST['delete_siswa']) && isset($_POST['id'])) {
        $id = (int)$_POST['id'];
        $conn->query("DELETE FROM siswa WHERE id=$id");
        $result = $conn->query("SELECT * FROM siswa");
    }

    // Menangani input POST untuk mengedit siswa berdasarkan ID
    if (isset($_POST['edit_siswa']) && isset($_POST['id'])) {
        $id = (int)$_POST['id'];
        $nama = $conn->real_escape_string($_POST['nama']);
        $kelas = $conn->real_escape_string($_POST['kelas']);
        $status = $conn->real_escape_string($_POST['status']);
        
        // Update data siswa
        $conn->query("UPDATE siswa SET nama='$nama', kelas='$kelas', status='$status' WHERE id=$id");
        $result = $conn->query("SELECT * FROM siswa");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kelola Data Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #1B5E20;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
        }
        .container {
            margin: 20px auto;
            width: 80%;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="text"], button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #1B5E20;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #4CAF50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .action-buttons form {
            display: inline;
        }
        .edit-btn {
            background-color: #FF9800;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .edit-btn:hover {
            background-color: #FFB74D;
        }
        .delete-btn {
            background-color: #F44336;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #E57373;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .dashboard-btn {
            background-color: #2196F3;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-align: center;
        }
        .dashboard-btn:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>
<header>
    Kelola Data Siswa - SMKN 7 Bulukumba
</header>

<div class="container">
    <div class="form-container">
        <h3>Tambah Siswa</h3>
        <form method="POST">
            <input type="text" name="nama" placeholder="Nama" required>
            <input type="text" name="kelas" placeholder="Kelas" required>
            <input type="text" name="status" placeholder="Status" required>
            <button type="submit" name="add_siswa">Tambah Siswa</button>
        </form>
    </div>
</div>

<div class="container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['kelas']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td class="action-buttons">
                <!-- Tombol Edit -->
                <button class="edit-btn" onclick="openModal(<?= $row['id'] ?>, '<?= $row['nama'] ?>', '<?= $row['kelas'] ?>', '<?= $row['status'] ?>')">Edit</button>
                <!-- Tombol Hapus -->
                <form method="POST" style="display: inline;" onsubmit="return confirmDelete()">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit" name="delete_siswa" class="delete-btn">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal Edit Siswa -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <h3>Edit Siswa</h3>
        <form method="POST">
            <input type="hidden" name="id" id="edit_id">
            <input type="text" name="nama" id="edit_nama" placeholder="Nama" required>
            <input type="text" name="kelas" id="edit_kelas" placeholder="Kelas" required>
            <input type="text" name="status" id="edit_status" placeholder="Status" required>
            <button type="submit" name="edit_siswa">Simpan Perubahan</button>
            <button type="button" onclick="closeModal()">Tutup</button>
        </form>
    </div>
</div>

<!-- Button Dashboard -->
<div class="container">
    <form action="DashboardAdmin.php" method="get">
        <button type="submit" class="dashboard-btn">Kembali ke Dashboard</button>
    </form>
</div>

<script>
    function openModal(id, nama, kelas, status) {
        document.getElementById("edit_id").value = id;
        document.getElementById("edit_nama").value = nama;
        document.getElementById("edit_kelas").value = kelas;
        document.getElementById("edit_status").value = status;
        document.getElementById("editModal").style.display = "flex";
    }

    function closeModal() {
        document.getElementById("editModal").style.display = "none";
    }

    function confirmDelete() {
        return confirm("Apakah Anda yakin ingin menghapus data siswa ini?");
    }
</script>
</body>
</html>
