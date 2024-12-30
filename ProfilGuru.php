<?php
session_start();

// Cek jika pengguna belum login, arahkan ke halaman login
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'guru') {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];
$id = $_SESSION['id']; // ID pengguna, pastikan ada dalam sesi

// Proses pengeditan data jika ada form yang disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    $new_username = $_POST['username'];
    $new_role = $_POST['role'];
    $password = $_POST['password'];
    
    // Validasi input (pastikan username tidak kosong)
    if (empty($new_username)) {
        $error = "Username tidak boleh kosong.";
    } else {
        require 'config.php'; // Menyertakan file konfigurasi database

        // Query untuk memperbarui username, role, dan password (jika diubah)
        if (!empty($password)) {
            $sql = "UPDATE users SET username = ?, role = ?, password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("sssi", $new_username, $new_role, $hashed_password, $id);
        } else {
            $sql = "UPDATE users SET username = ?, role = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $new_username, $new_role, $id);
        }

        // Eksekusi query
        if ($stmt->execute()) {
            // Update session dengan username baru
            $_SESSION['username'] = $new_username;

            // Redirect setelah berhasil
            header('Location: profil.php');
            exit;
        } else {
            $error = "Gagal memperbarui data.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Akun - SMKN 7 Bulukumba</title>
    <style>
        /* Gaya Umum untuk Halaman */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Container untuk Menampung Seluruh Konten */
        .container {
            display: flex;
            height: 100vh;
        }

        /* Sidebar Menu */
        .menu {
            width: 250px;
            background-color: #1B5E20;
            color: white;
            padding: 20px;
            box-sizing: border-box;
        }

        .menu h2 {
            margin-bottom: 20px;
            font-size: 20px;
        }

        .menu a {
            display: block;
            color: white;
            text-decoration: none;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .menu a:hover {
            background-color: #388E3C;
        }

        /* Konten Utama */
        .content {
            flex: 1;
            padding: 20px;
            background-color: white;
            box-sizing: border-box;
        }

        h1 {
            color: #1B5E20;
        }

        .profile {
            background-color: #e0f2f1;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .profile h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #1B5E20;
        }

        .profile p {
            font-size: 18px;
            line-height: 1.6;
        }

        .profile p strong {
            color: #388E3C;
        }

        /* Modal */
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
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-container input {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            box-sizing: border-box;
        }

        .form-container button {
            padding: 10px 20px;
            background-color: #388E3C;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #1B5E20;
        }

        .error {
            color: red;
            margin: 10px 0;
        }
    </style>
    <script>
        function openEditModal() {
            document.getElementById('editModal').style.display = 'flex';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="container">
        <!-- Menu Sidebar -->
        <div class="menu">
            <h2>Menu Guru</h2>
            <a href="jadwal.php">Lihat Jadwal Mengajar</a>
            <a href="DataSiswa.php">Lihat Data Siswa</a>
            <a href="profil.php">Profil Akun</a>
            <a href="LogOutguru.php">Logout</a>
        </div>

        <!-- Konten Utama -->
        <div class="content">
            <h1>Profil Akun Anda</h1>
            <div class="profile">
                <h2>Profil Akun</h2>
                <p><strong>Username:</strong> <?= htmlspecialchars($username) ?></p>
                <button onclick="openEditModal()">Edit Username</button>
            </div>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <h3>Edit Pengguna</h3>
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
            <form method="POST" id="editForm">
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="text" name="username" id="edit_username" value="<?= htmlspecialchars($username) ?>" placeholder="Username" required>
                <input type="text" name="role" id="edit_role" placeholder="Role" required>
                <input type="password" name="password" placeholder="Password (Kosongkan jika tidak diubah)">
                <button type="submit" name="edit_user">Simpan Perubahan</button>
            </form>
            <button onclick="closeEditModal()">Tutup</button>
        </div>
    </div>
</body>
</html>
