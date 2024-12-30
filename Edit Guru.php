<?php
include "koneksi.php"; // Pastikan Anda sudah menghubungkan file koneksi

// Pastikan data yang diperlukan ada
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $mata_pelajaran = mysqli_real_escape_string($conn, $_POST['mata_pelajaran']);

    // Query untuk memperbarui data guru
    $query = "UPDATE guru SET 
                username='$username', 
                email='$email', 
                telepon='$telepon', 
                alamat='$alamat', 
                mata_pelajaran='$mata_pelajaran' 
              WHERE id=$id";

    if (mysqli_query($conn, $query)) {
        // Jika berhasil, redirect ke halaman kelola guru
        header("Location: kelola-guru.php");
        exit;
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($conn);
    }
} else {
    echo "Data tidak ditemukan.";
}
?>
