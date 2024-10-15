<?php
session_start();
include "db/koneksi.php";
include "fungsi.php";

header("Location: produk.php");
$user = !empty($_SESSION["username"]) ? $_SESSION["username"] : "";
// gambar untuk navbar
if ($user) {
    $data_user = show("SELECT * FROM user WHERE id_user = '$user'");
    if ($data_user[0]["picture"]) {
        $picture = "userPicture/" . $data_user[0]["picture"];
    } else {
        $picture = "asset/img/profile_default.png";
    }
}

$kategori = show("SELECT * FROM kategori");
// $rekomendasi_produk = show("SELECT * FROM produk LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori LIMIT 8");
// $aksesoris_headset = show("SELECT * FROM produk WHERE id_kategori = 4 LIMIT 3");
// $aksesoris_speaker = show("SELECT * FROM produk WHERE id_kategori = 5 LIMIT 3");
// $aksesoris_flashdisk = show("SELECT * FROM produk WHERE id_kategori = 6 LIMIT 3");
// var_dump($aksesoris_headset);
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
    <title>Macro Store Computer</title>
</head>

<body>

    <?php include "navbar.php" ?>
    <!-- Hero -->
    <section id="hero">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="asset/img/banner1.png" class="d-block w-100 rounded" alt="Hero Img">
                            </div>
                            <div class="carousel-item">
                                <img src="asset/img/banner2.jpg" class="d-block w-100 rounded" alt="Hero Img">
                            </div>
                            <div class="carousel-item">
                                <img src="asset/img/banner3.png" class="d-block w-100 rounded" alt="Hero Img">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- Kategori -->
    <section id="kategori">
        <div class="container">
            <div class="text-start">
                <h3 class="mb-4">Kategori</h3>
            </div>
            <div class="row row-cols-1 row-cols-md-4 g-2 g-md-3 mt-0">
                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                    <a href="produkberdasarkan.php?katakunci=Komputer" class="kat-link">
                        <div class="card h-100">
                            <img src="fileUpload/pc-acer-c22-1650-i3-ssd.png" alt="Gambar Produk" class="w-50 mx-auto mt-2">
                            <div class="card-body">
                                <h6 class="text-center">Komputer</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                    <a href="produkberdasarkan.php?katakunci=Laptop" class="kat-link">
                        <div class="card h-100">
                            <img src="fileUpload/headset-hp-gaming-h220s.png" alt="Gambar Produk" class="w-50 mx-auto mt-2">
                            <div class="card-body">
                                <h6 class="text-center">Laptop</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                    <a href="produkberdasarkan.php?katakunci=Prosesor" class="kat-link">
                        <div class="card h-100">
                            <img src="fileUpload/intel-core-i910900k.jpg" alt="Gambar Produk" class="w-50 mx-auto mt-2">
                            <div class="card-body">
                                <h6 class="text-center">Prosesor</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                    <a href="produkberdasarkan.php?katakunci=Headset" class="kat-link">
                        <div class="card h-100">
                            <img src="fileUpload/headset-logitech-gaming-g335-white.png" alt="Gambar Produk" class="w-50 mx-auto mt-2">
                            <div class="card-body">
                                <h6 class="text-center">Headset</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                    <a href="produkberdasarkan.php?katakunci=Flashdisk" class="kat-link">
                        <div class="card h-100">
                            <img src="fileUpload/sandisk32gbotg.png" alt="Gambar Produk" class="w-50 mx-auto mt-2">
                            <div class="card-body">
                                <h6 class="text-center">Flashdisk</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                    <a href="produkberdasarkan.php?katakunci=Speaker" class="kat-link">
                        <div class="card h-100">
                            <img src="fileUpload/speaker-logitech-z120.png" alt="Gambar Produk" class="w-50 mx-auto mt-2">
                            <div class="card-body">
                                <h6 class="text-center">Speaker</h6>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- Rekomendasi Produk -->
    <section id="rekomendasi" class="my-4 my-md-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h3>Rekomendasi Produk</h3>
                <div class="d-none d-md-block text-xl-end">
                    <a href="produk.php" class="btn btn-green">Lihat semua produk <i class="fa-solid fa-right-long"></i>
                    </a>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-4 g-2 g-md-3 mt-0">
                <?php foreach ($rekomendasi_produk as $item) : ?>
                    <div class="col-6 col-md-4 col-xl-3">
                        <div class="card card-produk h-100">
                            <a href="detailproduk.php?slug=<?= $item['slug'] ?>" class="mx-auto mt-3">
                                <img src="fileUpload/<?= $item['gambar'] ?>" alt="Gambar Produk">
                            </a>
                            <div class="card-body h-100 mt-auto">
                                <a href="#" class="text-secondary text-decoration-none  fs-14">
                                    <?= $item["nama_kategori"] ?>
                                </a>
                                <h5 class="card-title fs-15 mt-2">
                                    <a href="detailproduk.php?slug=<?= $item['slug'] ?>" class="card-link">
                                        <?php if (strlen($item["nama_produk"]) >= 45) : ?>
                                            <?= substr_replace($item["nama_produk"], '...', 45) ?>
                                        <?php else : ?>
                                            <?= $item["nama_produk"] ?>
                                        <?php endif ?>
                                    </a>
                                </h5>
                                <div class="d-md-flex justify-content-between">
                                    <?php if ($item["harga_diskon"]) : ?>
                                        <div class="card-text fw-500 fs-15">
                                            Rp<?= formatKeRupiah($item["harga_diskon"]) ?>
                                        </div>
                                        <small><s class="text-muted">Rp<?= formatKeRupiah($item["harga_normal"]) ?></s></small>
                                    <?php else : ?>
                                        <div class="card-text fw-500 fs-15">
                                            Rp<?= formatKeRupiah($item["harga_normal"]) ?>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                            <a href="" class="btn btn-green m-3 d-none d-md-block">
                                Tambah ke Keranjang
                            </a>
                            <a href="" class="btn btn-green m-3 d-block d-md-none">
                                + Keranjang
                            </a>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="py-4 text-center text-xl-end d-block d-md-none">
                        <a href="produk.php" class="btn btn-green fs-15">Lihat semua produk <i class="fa-solid fa-right-long"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Aksesoris -->
    <section id="aksesoris" class="my-4 my-md-5">
        <div class="container">
            <h3 class="mb-4">Aksesoris</h3>
            <div class="row">
                <!-- headset -->
                <div class="col-md-6 col-lg-4">
                    <div class="text-center" style="box-shadow: 0 10px 13px -7px var(--bg-color-save);">
                        <p class="fw-500 rounded-3 bg-save text-white py-2 mb-md-5 mb-3">HEADSET</p>
                    </div>
                    <?php foreach ($aksesoris_headset as $item) : ?>
                        <div class="d-flex mt-2">
                            <div class="flex-shrink-0 w-25">
                                <a href="detailproduk.php?slug=<?= $item['slug'] ?>">
                                    <img src="fileUpload/<?= $item['gambar'] ?>" class="" alt="Gambar Produk" />
                                </a>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <a href="detailproduk.php?slug=<?= $item['slug'] ?>" class="text-decoration-none card-link fw-500">
                                    <?= $item["nama_produk"] ?>
                                    <br />
                                    <span class="fw-500" style="color: #4e54c8">Rp. <?= formatKeRupiah($item["harga_normal"]) ?></span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
                <!-- speaker -->
                <div class="col-md-6 col-lg-4">
                    <div class="text-center" style="box-shadow: 0 10px 13px -7px var(--bg-color-cansel);">
                        <p class="fw-500 rounded-3 bg-cansel text-white py-2 mb-md-5 mb-3 mt-md-0 mt-3">SPEAKER</p>
                    </div>
                    <?php foreach ($aksesoris_speaker as $item) : ?>
                        <div class="d-flex mt-2">
                            <div class="flex-shrink-0 w-25">
                                <a href="detailproduk.php?slug=<?= $item['slug'] ?>">
                                    <img src="fileUpload/<?= $item['gambar'] ?>" alt="Gambar Produk" />
                                </a>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <a href="detailproduk.php?slug=<?= $item['slug'] ?>" class="text-decoration-none card-link fw-500">
                                    <?= $item["nama_produk"] ?>
                                    <br />
                                    <span class="fw-500" style="color: #4e54c8">Rp. <?= formatKeRupiah($item["harga_normal"]) ?></span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
                <!-- flashdisk -->
                <div class="col-md-6 col-lg-4 mt-md-4 mt-lg-0">
                    <div class="text-center" style="box-shadow: 0 10px 13px -7px var(--bg-color-setting);">
                        <p class="fw-500 rounded-3 bg-setting text-white py-2 mb-md-5 mb-3 mt-lg-0 mt-3">FLASHDISK</p>
                    </div>

                    <?php foreach ($aksesoris_flashdisk as $item) : ?>
                        <div class="d-flex mt-2">
                            <div class="flex-shrink-0 w-25">
                                <a href="detailproduk.php?slug=<?= $item['slug'] ?>">
                                    <img src="fileUpload/<?= $item['gambar'] ?>" alt="Gambar Produk" />
                                </a>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <a href="detailproduk.php?slug=<?= $item['slug'] ?>" class="text-decoration-none card-link fw-500">
                                    <?= $item["nama_produk"] ?>
                                    <br />
                                    <span class="fw-500" style="color: #4e54c8">Rp. <?= formatKeRupiah($item["harga_normal"]) ?></span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Manfaat Belanja -->
    <section id="manfaat" class="pb-5 mt-5">
        <div class="container">
            <div class="row">
                <h3 class="mb-4 text-center text-lg-start">Manfaat belanja di Macro Store Computer</h3>
                <div class="col-lg-4 mt-3 mt-lg-2">
                    <div class="box px-3 py-4 text-center">
                        <i class="bi bi-truck fs-1 my-3 text-primary"></i>
                        <h6 class="fw-500">PENGIRIMAN AMAN DAN CEPAT</h6>
                        <span class="text-muted fs-14">Kami menjamin barang sampai dengan cepat dan tepat waktu</span>
                    </div>
                </div>
                <div class="col-lg-4 mt-3 mt-lg-2">
                    <div class="box px-3 py-4 text-center">
                        <i class="bi bi-headset fs-1 my-3 text-primary"></i>
                        <h6 class="fw-500">CUSTOMER SERVICE</h6>
                        <span class="text-muted fs-14">Hubungi tim profesional kami untuk info mengenai barang dan pesanan</span>
                    </div>
                </div>
                <div class="col-lg-4 mt-3 mt-lg-2">
                    <div class="box px-3 py-4 text-center">
                        <i class="bi bi-recycle fs-1 my-3 text-primary"></i>
                        <h6 class="fw-500">7 HARI PENGEMBALIAN</h6>
                        <span class="text-muted fs-14">Barang akan kami tukar dengan yang baru apabila terdapat cacat dan malfungsi</span>
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