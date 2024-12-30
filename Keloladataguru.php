<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$conn = new mysqli("localhost", "root", "", "db_sekolahtub");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// Query untuk mengambil semua data guru
$result = $conn->query("SELECT * FROM guru");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Menangani input POST untuk menambahkan guru
    if (isset($_POST['add_guru'])) {
        $username = $conn->real_escape_string($_POST['username']);
        $email = $conn->real_escape_string($_POST['email']);
        $telepon = $conn->real_escape_string($_POST['telepon']);
        $alamat = $conn->real_escape_string($_POST['alamat']);
        $mata_pelajaran = $conn->real_escape_string($_POST['mata_pelajaran']);
        
        // Menyimpan data guru baru beserta mata pelajaran
        $conn->query("INSERT INTO guru (username, email, telepon, alamat, mata_pelajaran) 
                      VALUES ('$username', '$email', '$telepon', '$alamat', '$mata_pelajaran')");
        $result = $conn->query("SELECT * FROM guru");
    }

    // Menangani input POST untuk menghapus guru berdasarkan ID
    if (isset($_POST['delete_guru']) && isset($_POST['id'])) {
        $id = (int)$_POST['id'];
        $conn->query("DELETE FROM guru WHERE id=$id");
        $result = $conn->query("SELECT * FROM guru");
    }

    // Menangani input POST untuk mengedit guru berdasarkan ID
    if (isset($_POST['edit_guru']) && isset($_POST['id'])) {
        $id = (int)$_POST['id'];
        $username = $conn->real_escape_string($_POST['username']);
        $email = $conn->real_escape_string($_POST['email']);
        $telepon = $conn->real_escape_string($_POST['telepon']);
        $alamat = $conn->real_escape_string($_POST['alamat']);
        $mata_pelajaran = $conn->real_escape_string($_POST['mata_pelajaran']);
        
        // Update data guru
        $conn->query("UPDATE guru SET username='$username', email='$email', telepon='$telepon', alamat='$alamat', mata_pelajaran='$mata_pelajaran' WHERE id=$id");
        $result = $conn->query("SELECT * FROM guru");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kelola Data Guru</title>
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
        input[type="text"], input[type="email"], input[type="text"], button {
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

        /* Button Kembali ke Dashboard */
        .back-btn {
            background-color: #1976D2;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            margin: 20px auto;
        }

        .back-btn:hover {
            background-color: #1565C0;
        }
    </style>
</head>
<body>
<header>
    Kelola Data Guru - SMKN 7 Bulukumba
</header>

<div class="container">
    <div class="form-container">
        <h3>Tambah Guru</h3>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="telepon" placeholder="Telepon" required>
            <input type="text" name="alamat" placeholder="Alamat" required>
            <input type="text" name="mata_pelajaran" placeholder="Mata Pelajaran" required>
            <button type="submit" name="add_guru">Tambah Guru</button>
        </form>
    </div>
</div>

<div class="container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Mata Pelajaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['telepon']) ?></td>
            <td><?= htmlspecialchars($row['alamat']) ?></td>
            <td><?= htmlspecialchars($row['mata_pelajaran']) ?></td>
            <td class="action-buttons">
                <!-- Tombol Edit -->
                <button class="edit-btn" onclick="openModal(<?= $row['id'] ?>, '<?= $row['username'] ?>', '<?= $row['email'] ?>', '<?= $row['telepon'] ?>', '<?= $row['alamat'] ?>', '<?= $row['mata_pelajaran'] ?>')">Edit</button>
                <!-- Tombol Hapus -->
                <form method="POST" style="display: inline;" onsubmit="return confirmDelete()">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit" name="delete_guru" class="delete-btn">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Tombol Kembali ke Dashboard -->
<div class="container">
    <a href="DashboardAdmin.php">
        <button type="button" class="back-btn">Kembali ke Dashboard</button>
    </a>
</div>

<!-- Modal Edit Guru -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <h3>Edit Guru</h3>
        <form method="POST">
            <input type="hidden" name="id" id="edit_id">
            <input type="text" name="username" id="edit_username" placeholder="Username" required>
            <input type="email" name="email" id="edit_email" placeholder="Email" required>
            <input type="text" name="telepon" id="edit_telepon" placeholder="Telepon" required>
            <input type="text" name="alamat" id="edit_alamat" placeholder="Alamat" required>
            <input type="text" name="mata_pelajaran" id="edit_mata_pelajaran" placeholder="Mata Pelajaran" required>
            <button type="submit" name="edit_guru">Simpan Perubahan</button>
            <button type="button" onclick="closeModal()">Tutup</button>
        </form>
    </div>
</div>

<script>
    // Fungsi untuk membuka modal edit
    function openModal(id, username, email, telepon, alamat, mata_pelajaran) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_username').value = username;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_telepon').value = telepon;
        document.getElementById('edit_alamat').value = alamat;
        document.getElementById('edit_mata_pelajaran').value = mata_pelajaran;
        document.getElementById('editModal').style.display = 'flex';
    }

    // Fungsi untuk menutup modal
    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // Konfirmasi penghapusan
    function confirmDelete() {
        return confirm('Apakah Anda yakin ingin menghapus data guru ini?');
    }
</script>
</body>
</html>
