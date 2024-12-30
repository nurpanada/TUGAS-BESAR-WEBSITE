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

// Inisialisasi pesan error
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['form_type'] === 'login') {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Tidak menggunakan hashing, langsung periksa password dalam bentuk plaintext
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $stmt->execute([
        'username' => $inputUsername,
        'password' => $inputPassword, // Bandingkan dengan password plaintext
    ]);

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $role = $user['role'];

        // Set session untuk menyimpan username dan role
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $role;

        // Buat cookie untuk menyimpan username dan role selama 60 detik
        setcookie('username', $user['username'], time() + 60, "/");
        setcookie('role', $role, time() + 60, "/");

        // Arahkan pengguna ke halaman yang sesuai dengan role
        if ($role === 'admin') {
            header('Location: DashboardAdmin.php');
        } elseif ($role === 'guru') {
            header('Location: DashboardGuru.php');
        } else {
            header('Location: DashboardSiswa.php');
        }
        exit;
    } else {
        $message = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMKN 7 Bulukumba</title>
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
        .container input {
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
        <h2>Login</h2>
        <?php if ($message): ?>
            <p class="message"> <?= htmlspecialchars($message) ?> </p>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="hidden" name="form_type" value="login">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <p class="toggle-link">Belum punya akun? <a href="signup.php">Sign-Up</a></p>
    </div>
</body>
</html>
