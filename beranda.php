<?php
session_start();

// Pastikan pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Redirect ke halaman login jika tidak memiliki akses
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

// Tangani operasi CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tambah Pengguna
    if (isset($_POST['add_user'])) {
        if (isset($_POST['username'], $_POST['password'], $_POST['role'])) {
            $username = $conn->real_escape_string($_POST['username']);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password
            $role = $conn->real_escape_string($_POST['role']);

            $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
            $conn->query($sql);
        }
    }

    // Edit Pengguna
    if (isset($_POST['edit_user'])) {
        if (isset($_POST['id'], $_POST['username'], $_POST['role'])) {
            $id = (int) $_POST['id'];
            $username = $conn->real_escape_string($_POST['username']);
            $role = $conn->real_escape_string($_POST['role']);
            $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

            if ($password) {
                $sql = "UPDATE users SET username='$username', password='$password', role='$role' WHERE id=$id";
            } else {
                $sql = "UPDATE users SET username='$username', role='$role' WHERE id=$id";
            }

            $conn->query($sql);
        }
    }

    // Hapus Pengguna
    if (isset($_POST['delete_user'])) {
        if (isset($_POST['id'])) {
            $id = (int) $_POST['id'];
            $sql = "DELETE FROM users WHERE id=$id";
            $conn->query($sql);
        }
    }
}

// Query untuk mengambil data pengguna
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            background-color: #333;
            color: #fff;
            padding: 20px 10px;
            box-sizing: border-box;
        }

        .sidebar h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            color: #ddd;
            text-decoration: none;
            padding: 10px 0;
            margin: 10px 0;
            text-align: center;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        /* Main Content */
        .main {
            margin-left: 270px;
            padding: 20px;
            box-sizing: border-box;
        }

        .main h1 {
            color: #333;
        }

        .main h2 {
            color: #444;
            margin-top: 20px;
        }

        .main p {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
        }

        /* Tabel Pengguna */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        td a {
            color: #4CAF50;
            text-decoration: none;
            cursor: pointer;
        }

        td a:hover {
            text-decoration: underline;
        }

        /* Footer */
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .footer a {
            color: #fff;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* Edit Form */
        #edit-form {
            margin-top: 20px;
            display: none;
        }

        .btn-delete {
            color: red;
            cursor: pointer;
            border: none;
            background: none;
            font-size: 14px;
        }

    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="beranda.php">Beranda</a>
        <a href="DashboardAdmin.php">Kelola Pengguna</a>
        <a href="Login.php">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, Admin! Kelola konten website Anda di sini.</p>
    </div>

</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>