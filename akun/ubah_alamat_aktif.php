<?php

include "../fungsi.php";

$id_alamat = $_GET["id_alamat"];
$id_user = $_GET["id_user"];

// Menonaktifkan alamat sebelumnya
$nonaktifkan = mysqli_query($koneksi, "UPDATE alamat SET is_aktif = 0 WHERE id_user = '$id_user'");
// Mengaktifkan alamat yang dipilih
$aktifkan = mysqli_query($koneksi, "UPDATE alamat SET is_aktif = 1 WHERE id_alamat = '$id_alamat' AND id_user = '$id_user'");

header("Location: alamat.php");
