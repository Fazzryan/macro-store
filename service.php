<?php
session_start();
include "db/koneksi.php";
include "fungsi.php";

$user = !empty($_SESSION["id_user"]) ? $_SESSION["id_user"] : "";
// gambar untuk navbar
if ($user) {
    $data_user = show("SELECT * FROM user WHERE id_user = '$user'");
    if ($data_user[0]["picture"]) {
        $picture = "userPicture/" . $data_user[0]["picture"];
    } else {
        $picture = "asset/img/profile_default.png";
    }
}
// Pagination
$batas_halaman = 16;
$halaman = isset($_GET["halaman"]) ? (int) $_GET["halaman"] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas_halaman) - $batas_halaman : 0;

$sebelumnya = $halaman - 1;
$selanjutnya = $halaman + 1;
$data_produk = mysqli_query($koneksi, "SELECT * FROM produk LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori");

$jumlah_data = mysqli_num_rows($data_produk);
$total_halaman = ceil($jumlah_data / $batas_halaman);
$nomor = $halaman_awal + 1;

$produk = show("SELECT * FROM produk LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori ORDER BY id_produk DESC LIMIT $halaman_awal, $batas_halaman");

$jumlah_produk = show("SELECT COUNT(*) AS jml_produk FROM produk");
// var_dump($jumlah_produk);
// die;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/css/bootstrap.css">
    <link rel="stylesheet" href="asset/css/style.css">
    <!-- Bs Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Service - Dokter Komputer</title>
</head>

<body>

    <?php include "navbar.php" ?>

    <section id="hero">
        <div class="container">
            <div class="row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Service</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-12 col-md-10 col-lg-6">
                    <h3>Service Kami</h3>
                    <p class="py-3">Butuh perbaikan komputer, laptop dan barang lainnya? Silahkan hubungi customer service kami di +62 852-2342-2415 atau bisa datang langsung ke toko Dokter Komputer untuk mengkonsultasikannya secara langsung.</p>
                </div>
            </div>

            <div class="row g-2 g-md-3 row-cols-1 row-cols-md-2 row-cols-lg-3 mb-5">
                <div class="col">
                    <div class="card py-3 rounded-16 shadow-1 text-center">
                        <img src="asset/img/komputer.svg" alt="Icon" class="mx-auto">
                        <div class="card-body">
                            <h5 class="card-title">Service Komputer</h5>
                            <a href="" class="btn btn-green mt-2">Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card py-3 rounded-16 shadow-1 text-center">
                        <img src="asset/img/laptop.svg" alt="Icon" class="mx-auto">
                        <div class="card-body">
                            <h5 class="card-title">Service Laptop</h5>
                            <a href="" class="btn btn-green mt-2">Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card py-3 rounded-16 shadow-1 text-center">
                        <img src="asset/img/printer.svg" alt="Icon" class="mx-auto">
                        <div class="card-body">
                            <h5 class="card-title">Service Printer</h5>
                            <a href="" class="btn btn-green mt-2">Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <?php include "footer.php" ?>

    <script src="asset/js/bootstrap.js"></script>
    <script src="asset/js/script.js"></script>
</body>

</html>