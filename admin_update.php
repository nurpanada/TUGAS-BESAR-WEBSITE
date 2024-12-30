<?php
include "koneksi.php";

$foto = $_FILES['foto']['name'];
$lokasi = $_FILES['foto']['tmp_name'];
$tipefile = $_FILES['foto']['type'];
$ukuranfile = $_FILES['foto']['size'];

$error = "";
$id_makanan = intval($_POST['id_makanan']); // Mengambil ID makanan dengan validasi

if (empty($foto)) { // Update jika foto tidak diubah
    $query = mysqli_query($conn, "UPDATE makanan SET
        nama_makanan = '$_POST[nama_makanan]',
        deskripsi = '$_POST[deskripsi]'
        WHERE id_makanan='$id_makanan'");
} else {
    if ($tipefile != "image/jpeg" && $tipefile != "image/jpg" && $tipefile != "image/png") {
        $error = "Tipe file tidak didukung";
    } elseif ($ukuranfile >= 1000000) {
        $error = "Ukuran file lebih dari 1 MB";
    } else { // Update jika foto diubah
        $query = mysqli_query($conn, "SELECT * FROM makanan WHERE id_makanan='$id_makanan'");
        $data = mysqli_fetch_array($query);

        if (file_exists("assets/$data[foto]")) {
            unlink("assets/$data[foto]"); // Hapus foto lama
        }

        $ext = strrchr($foto, '.');
        $foto = basename($foto, $ext) . time() . $ext;

        // Pindahkan file ke direktori tujuan
        if (move_uploaded_file($lokasi, "assets/" . $foto)) {
            $query = mysqli_query($conn, "UPDATE makanan SET
                foto = '$foto',
                nama_makanan = '$_POST[nama_makanan]',
                deskripsi = '$_POST[deskripsi]'
                WHERE id_makanan='$id_makanan'");
        } else {
            $error = "Gagal mengunggah file.";
        }
    }
}

if (!empty($error)) {
    echo "<script>alert('$error')</script>";
    echo "<meta http-equiv='refresh' content='0; url=tabel-makanan.php'>";
} elseif ($query) {
    echo "<script>alert('Data berhasil diubah')</script>";
    echo "<meta http-equiv='refresh' content='0; url=tabel-makanan.php'>";
} else {
    echo "<script>alert('Tidak dapat menyimpan data')</script>";
    echo mysqli_error($conn);
}
?>