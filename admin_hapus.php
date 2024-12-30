<?php
include "koneksiphp";
if(file_exists("assets/$_GET[foto]")) unlink("assets/$_GET[foto]");
$query = mysqli_query($conn, "DELETE FROM makanan
WHERE id_makanan='$_GET[id]'");
if($query){
echo "<script>alert('Data berhasil dihapus')</script>";
echo "<meta http-equiv='refresh' content='0; url=tabel-makanan.php'>";
} else{
echo "<script>alert('Tidak dapat menghapus data')</script>";
echo mysqli_error($conn);
}
?>