<?php
include "koneksi.php";
$foto = $_FILES['foto']['name'];
$lokasi = $_FILES['foto']['tmp_name'];
$tipefile = $_FILES['foto']['type'];
$ukuranfile = $_FILES['foto']['size'];
$error = "";
if($foto == ""){
    $query = mysqli_query($conn, "INSERT INTO makanan SET
    nama_makanan = '$_POST[nama_makanan]',
    deskripsi = '$_POST[deskripsi]'
    ");
    } else{
    if($tipefile != "image/jpeg" and $tipefile != "image/jpg" and
    $tipefile != "image/png"){
    $error = "Tipe file tidak didukung";
    }elseif($ukuranfile >= 1000000){
    $error = "Ukuran file lebih dari 1 MB";
    }else{
    $ext = strrchr($foto, '.');
    $foto = basename($foto, $ext).time().$ext;
    move_uploaded_file($lokasi, "assets/".$foto);
    $query = mysqli_query($conn, "INSERT INTO makanan SET
    foto = '$foto',
    nama_makanan = '$_POST[nama_makanan]',
    deskripsi = '$_POST[deskripsi]'
    ");
    }
    }
    if($error != ""){
    echo "<script>alert('$error')</script>";
    echo "<meta http-equiv='refresh' content='0; url=tabel-makanan.php'>";
    }elseif($query){
    echo "<script>alert('Data berhasil disimpan')</script>";
    echo "<meta http-equiv='refresh' content='0; url=tabel-makanan.php'>";
    }else{
    echo "<script>alert('Tidak dapat menyimpan data')</script>";
    echo mysqli_error($conn);
    }
    ?>