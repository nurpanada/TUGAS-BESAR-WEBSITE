<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMKN 7 Bulukumba</title>
    <style>
        /* CSS Langsung di Sini */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #E3F2FD; /* Biru langit lembut */
            color: #333;
            line-height: 1.6;
        }

        header, footer {
            background-color: #1B5E20; /* Hijau tua, mencerminkan kesan formal dan alami */
            color: #FFFFFF; /* Teks putih untuk kontras */
            padding: 20px 0;
            text-align: center;
            opacity: 0;
            animation: fadeIn 2s forwards; /* Animasi Fade-in untuk header */
        }

        header h1, footer p {
            margin: 0;
        }

        nav {
            text-align: center;
            margin-top: 10px;
            opacity: 0;
            animation: slideIn 2s forwards 1s; /* Menu sliding-in effect */
        }

        nav a {
            color: #A5D6A7; /* Hijau lembut untuk teks */
            padding: 10px 15px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: #81C784; /* Hijau terang untuk efek hover */
            border-radius: 5px;
        }

        /* Animasi gambar zoom-in */
        .image-container {
            width: 100%;
            height: 100vh; /* Full screen height */
            overflow: hidden;
            animation: zoomIn 2s forwards;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Memastikan gambar memenuhi seluruh kontainer */
            transform: scale(1.1); /* Gambar lebih besar */
            opacity: 0;
            animation: fadeInImage 2s forwards;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            padding: 20px 0;
        }

        h2 {
            color: #1B5E20; /* Hijau tua untuk heading */
            margin-bottom: 20px;
            font-size: 24px;
            opacity: 0;
            animation: fadeIn 2s forwards 2s;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            background-color: #66BB6A; /* Hijau cerah untuk tombol */
            color: #FFFFFF; /* Teks putih untuk kontras */
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #388E3C; /* Hijau lebih gelap untuk efek hover */
        }

        p {
            margin: 10px 0;
            line-height: 1.6;
        }

        .section {
            margin-bottom: 30px;
        }

        ul {
            list-style-type: disc;
            padding-left: 20px;
        }

        /* Keyframes untuk animasi */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            0% {
                transform: translateX(-100%);
                opacity: 0;
            }
            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes zoomIn {
            0% {
                transform: scale(1.1);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes fadeInImage {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

    </style>
</head>
<body>
    <header>
        <h1>Selamat Datang di SMKN 7 Bulukumba</h1>
        <nav>
            <a href="Tentang.php">Tentang</a>
            <a href="login.php">Login</a>
        </nav>
    </header>

    <div class="image-container">
        <img src="Gambar sekolah.jpg" alt="Foto SMKN 7 Bulukumba">
    </div>

    <div class="container">
        <section class="intro section">
            <h2>Mengapa Memilih SMKN 7 Bulukumba?</h2>
            <p>SMKN 7 Bulukumba berkomitmen memberikan pendidikan terbaik dengan fasilitas dan lingkungan yang mendukung proses belajar mengajar.</p>
        </section>
        <section class="vision-mission section">
            <h2>Visi dan Misi</h2>
            <h3>Visi:</h3>
            <p>"Menjadi sekolah kejuruan unggulan yang menghasilkan lulusan berkompetensi tinggi, berkarakter, dan berdaya saing global."</p>
            <h3>Misi:</h3>
            <ul>
                <li>Memberikan pendidikan berbasis teknologi dan inovasi.</li>
                <li>Meningkatkan kompetensi siswa melalui pelatihan praktis dan kerja sama dengan industri.</li>
                <li>Menanamkan nilai-nilai moral dan etika dalam setiap aspek pembelajaran.</li>
                <li>Mendorong siswa untuk aktif berkreasi dan berprestasi di tingkat nasional maupun internasional.</li>
            </ul>
        </section>

        <section class="services section">
            <h2>Layanan Kami</h2>
            <ul>
                <li>Pendidikan berkualitas tinggi</li>
                <li>Fasilitas modern</li>
                <li>Guru yang berpengalaman</li>
            </ul>
        </section>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> SMKN 7 Bulukumba. All rights reserved.</p>
    </footer>
</body>
</html>
