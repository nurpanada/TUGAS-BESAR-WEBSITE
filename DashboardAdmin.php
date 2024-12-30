<?php
session_start();

// Pastikan pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Arahkan ke halaman login jika belum login atau role tidak sesuai
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

// CRUD handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Edit data user
    if (isset($_POST['edit_user']) && isset($_POST['id'], $_POST['username'], $_POST['role'])) {
        $id = (int)$_POST['id'];
        $username = $conn->real_escape_string($_POST['username']);
        $role = $conn->real_escape_string($_POST['role']);
        $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

        $sql = $password
            ? "UPDATE users SET username='$username', password='$password', role='$role' WHERE id=$id"
            : "UPDATE users SET username='$username', role='$role' WHERE id=$id";

        $conn->query($sql);
    }

    // Hapus data user
    if (isset($_POST['delete_user']) && isset($_POST['id'])) {
        $id = (int)$_POST['id'];
        $conn->query("DELETE FROM users WHERE id=$id");
    }
}

$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
        }
        header {
            background-color: #1B5E20;
            color: #fff;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
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
            border-radius: 5px;
        }
        .content {
            flex: 1;
            padding: 20px;
            background-color: #fff;
            margin: 10px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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
        table tr:hover {
            background-color: #c8e6c9;
        }
        button, .btn {
            padding: 8px 12px;
            border: none;
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
        button:hover {
            opacity: 0.8;
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
            border-radius: 4px;
        }
        .modal-content button {
            width: 100%;
            background: #388E3C;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .modal-content button:hover {
            background: #66BB6A;
        }
    </style>
</head>
<body>
<header>
    Dashboard Admin - SMKN 7 Bulukumba
</header>

<div class="container">
    <div class="sidebar">
        <h3>Menu</h3>
        <a href="">Dashboard</a>
        <a href="Keloladatasiswa.php">Kelola Data Siswa</a>
        <a href="keloladataguru.php">Kelola Data Guru</a>
        <a href="KelolaJadwalGuru.php">Kelola Jadwal</a>
        <a href="login.php">Logout</a>
    </div>

    <div class="content">
        <h2>Kelola Pengguna</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= $row['role'] ?></td>
                    <td>
                        <button class="btn edit" onclick="openModal(<?= $row['id'] ?>, '<?= $row['username'] ?>', '<?= $row['role'] ?>')">Edit</button>
                        <button class="btn delete" onclick="deleteUser(<?= $row['id'] ?>)">Hapus</button>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal" id="editModal">
    <div class="modal-content">
        <h3>Edit Pengguna</h3>
        <form method="POST" id="editForm" onsubmit="submitEditForm(event)">
            <input type="hidden" name="id" id="edit_id">
            <input type="text" name="username" id="edit_username" placeholder="Username" required>
            <input type="text" name="role" id="edit_role" placeholder="Role" required>
            <input type="password" name="password" placeholder="Password (Kosongkan jika tidak diubah)">
            <button type="submit" name="edit_user">Simpan Perubahan</button>
        </form>
    </div>
</div>

<script>
    function openModal(id, username, role) {
        document.getElementById('editModal').style.display = 'flex';
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_username').value = username;
        document.getElementById('edit_role').value = role;
    }

    function submitEditForm(event) {
        event.preventDefault(); // Mencegah halaman refresh
        const formData = new FormData(document.querySelector('#editForm'));

        fetch('dashboard.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert("Data berhasil disimpan");
            location.reload();  // Reload halaman setelah berhasil
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function deleteUser(id) {
        if (confirm('Hapus pengguna ini?')) {
            const formData = new FormData();
            formData.append('delete_user', true);
            formData.append('id', id);

            fetch('dashboard.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert("Pengguna berhasil dihapus");
                location.reload();  // Reload halaman setelah berhasil
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }

    window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };
</script>
</body>
</html>

<?php
$conn->close();
?>
