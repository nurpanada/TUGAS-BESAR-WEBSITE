<?php
// Mulai sesi untuk menyimpan data pengguna
session_start();

// Menghubungkan ke database
$host = 'localhost';
$dbname = 'db_sekolahtub';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi ke database gagal: " . $e->getMessage());
}

// Membuat tabel 'users' jika belum ada
$tableQuery = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(20) NOT NULL DEFAULT 'siswa',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
";
$pdo->exec($tableQuery);

// Inisialisasi pesan error
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['form_type'] === 'signup') {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];
    $inputRole = $_POST['role'];

    try {
        // Tidak menggunakan hashing, simpan password dalam bentuk plaintext
        $insertStmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        $insertStmt->execute([
            'username' => $inputUsername,
            'password' => $inputPassword, // Simpan password dalam bentuk plaintext
            'role' => $inputRole, // Simpan role yang dipilih
        ]);

        // Redirect ke halaman login dengan pesan sukses
        header("Location: login.php?signup_success=1");
        exit;
    } catch (PDOException $e) {
        $message = "Gagal membuat akun: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-Up - SMKN 7 Bulukumba</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #E3F2FD;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .container h2 {
            text-align: center;
            color: #1B5E20;
        }
        .container form {
            display: flex;
            flex-direction: column;
        }
        .container label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        .container input,
        .container select {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .container button {
            padding: 10px;
            background-color: #1B5E20;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .container button:hover {
            background-color: #388E3C;
        }
        .message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        .toggle-link {
            text-align: center;
            margin-top: 10px;
        }
        .toggle-link a {
            color: #1B5E20;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sign-Up</h2>
        <?php if ($message): ?>
            <p class="message"> <?= htmlspecialchars($message) ?> </p>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="hidden" name="form_type" value="signup">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="guru">Guru</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">Sign-Up</button>
        </form>
        <p class="toggle-link">Sudah punya akun? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
