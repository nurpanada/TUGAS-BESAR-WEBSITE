<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMKN 7 Bulukumba</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f4f9;
            color: #333;
            line-height: 1.6;
        }

        header {
            background: linear-gradient(to right, #1B5E20, #4CAF50);
            color: #fff;
            text-align: center;
            padding: 30px 0;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
        }

        nav {
            display: flex;
            justify-content: center;
            background: #388E3C;
            padding: 10px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 20px;
            font-weight: bold;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        nav a:hover {
            color: #C8E6C9;
            transform: scale(1.1);
        }

        section {
            padding: 40px 20px;
            text-align: center;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.5s ease;
        }

        section.active {
            opacity: 1;
            transform: translateY(0);
        }

        h2 {
            margin-bottom: 20px;
            font-size: 2em;
            color: #1B5E20;
        }

        p {
            font-size: 1.1em;
            color: #555;
        }

        .organization {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }

        .organization-item {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }

        .organization-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .organization-item img {
            width: 100%;
            height: auto;
            object-fit: contain;
            object-position: center;
        }

        .organization-item h3 {
            margin: 15px 0;
            color: #388E3C;
            font-size: 1.5em;
            text-align: center;
        }

        .organization-item p {
            padding: 20px;
            font-size: 1em;
            line-height: 1.5;
            text-align: justify;
            background-color: #f9f9f9;
        }

        #kontak {
            padding: 40px 20px;
            background: #fff;
            color: #333;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 20px;
        }

        #kontak h2 {
            font-size: 2em;
            color: #388E3C;
            margin-bottom: 20px;
        }

        #kontak p {
            font-size: 1.1em;
            margin-bottom: 15px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        form label {
            font-size: 1.1em;
            text-align: left;
            width: 100%;
        }

        form input, form textarea {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        form textarea {
            resize: vertical;
        }

        form button {
            padding: 10px 20px;
            background-color: #388E3C;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #1B5E20;
        }

        footer {
            background: #1B5E20;
            color: #fff;
            text-align: center;
            padding: 15px;
            margin-top: 20px;
            font-size: 0.9em;
        }

        /* Button for returning to the landing page */
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #1B5E20;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .back-button:hover {
            background-color: #388E3C;
        }
    </style>
</head>
<body>
    <header>
        <h1>Selamat Datang di SMKN 7 Bulukumba</h1>
        <p>Sekolah Berkualitas untuk Masa Depan Gemilang</p>
    </header>

    <nav>
        <a href="#profil">Profil</a>
        <a href="#organisasi">Organisasi</a>
        <a href="#kontak">Kontak</a>
    </nav>

    <section id="profil">
        <h2>Profil Sekolah</h2>
        <p>
            SMKN 7 Bulukumba adalah sekolah menengah kejuruan unggulan yang berkomitmen untuk menghasilkan lulusan yang kompeten dan siap bersaing di dunia kerja. 
            Dengan berbagai program keahlian yang relevan dengan kebutuhan industri, sekolah ini terus berupaya mencetak generasi muda yang memiliki kemampuan teknis, keterampilan kerja, dan karakter yang tangguh. 
            Fasilitas modern, tenaga pendidik yang berpengalaman, dan kurikulum berbasis industri menjadi keunggulan utama dari SMKN 7 Bulukumba. 
            Selain itu, berbagai kegiatan ekstrakurikuler juga mendukung pengembangan potensi siswa di bidang akademik maupun non-akademik. 
            Sekolah ini juga memprioritaskan pengembangan soft skills siswa seperti kepemimpinan, kerjasama, dan etika kerja yang sangat dibutuhkan di dunia profesional. SMKN 7 Bulukumba siap mencetak tenaga kerja yang handal dan siap menghadapi tantangan masa depan.
        </p>
    </section>

    <section id="organisasi">
        <h2>Organisasi Sekolah</h2>
        <div class="organization">
            <div class="organization-item">
                <img src="PRAMUKA2.jpg" alt="Organisasi Pramuka">
                <h3>Pramuka</h3>
                <p>Pramuka adalah organisasi yang bertujuan untuk membentuk karakter dan kepemimpinan siswa. Kegiatan yang dilakukan mencakup berbagai latihan kepemimpinan, kegiatan alam terbuka, dan pengabdian kepada masyarakat.</p>
            </div>
            <div class="organization-item">
                <img src="OSIS.jpg" alt="Organisasi OSIS">
                <h3>OSIS</h3>
                <p>OSIS berperan dalam menyelenggarakan berbagai kegiatan yang melibatkan seluruh siswa di SMKN 7 Bulukumba. Organisasi ini bertujuan untuk mengembangkan kemampuan siswa dalam manajemen dan organisasi.</p>
            </div>
            <div class="organization-item">
                <img src="PMR.jpg" alt="Organisasi PMR">
                <h3>PMR</h3>
                <p>PMR adalah organisasi yang bergerak di bidang kesehatan, yang bertujuan untuk melatih siswa agar dapat memberikan pertolongan pertama pada kecelakaan serta memberikan edukasi tentang kesehatan kepada masyarakat.</p>
            </div>
        </div>
    </section>

    <section id="kontak">
        <h2>Kontak Kami</h2>
        <p>Jika Anda memiliki pertanyaan, silakan hubungi kami melalui form berikut:</p>
        <form action="#" method="post">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="pesan">Pesan:</label>
            <textarea id="pesan" name="pesan" rows="4" required></textarea>

            <button type="submit">Kirim Pesan</button>
        </form>

        <a href="LandingPage.php" class="back-button">Kembali ke Halaman Utama</a>
    </section>

    <footer>
        <p>&copy; 2024 SMKN 7 Bulukumba. Semua hak dilindungi.</p>
    </footer>

    <script>
        // Adding active class to section based on navigation clicks
        const navLinks = document.querySelectorAll("nav a");
        const sections = document.querySelectorAll("section");

        navLinks.forEach(link => {
            link.addEventListener("click", (e) => {
                e.preventDefault();
                const target = document.querySelector(link.getAttribute("href"));

                sections.forEach(section => {
                    section.classList.remove("active");
                });

                target.classList.add("active");
                window.scrollTo({
                    top: target.offsetTop - 20,
                    behavior: 'smooth'
                });
            });
        });

        // Activate first section by default
        document.querySelector("#profil").classList.add("active");
    </script>
</body>
</html>
