<?php
include "../../fungsi.php";
session_start();

if (empty($_SESSION["username"]) || empty($_SESSION["password"])) {
    header("Location: ../../otentikasi/login.php");
    exit();
} else if ($_SESSION["role"] != 'admin') {
    header("Location: ../../produk.php");
    exit();
}
$username = $_SESSION["username"];

$slug = $_GET["slug"];
$produk = show("SELECT * FROM produk WHERE slug = '$slug'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../asset/css/bootstrap.css">
    <link rel="stylesheet" href="../../asset/css/style.css">
    <!-- Bs Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Produk - Dokter Komputer</title>
</head>

<body class="bg-white">
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="">
            <div class="side-header">
                <h4>Dokter Komputer</h4>
            </div>
            <hr class="text-secondary">
            <ul class="side-nav list-unstyled">
                <li class="side-item">
                    <a href="../" class="side-link"><i class="bi bi-speedometer me-1"></i> Dashboard</a>
                </li>
                <li class="side-item">
                    <a href="../kategori/" class="side-link"><i class="bi bi-grid me-1"></i> Kategori</a>
                </li>
                <li class="side-item">
                    <a href="../produk/" class="side-link on"><i class="bi bi-box me-1"></i> Produk</a>
                </li>
                <li class="side-item">
                    <a href="#" class="side-link"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
                </li>
            </ul>

        </nav>

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar content-header">
                <?php include "../layout/navbarContent.php" ?>
            </nav>

            <div class="content-body">
                <div class="container-fluid">
                    <?php foreach ($produk as $item) : ?>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="../../fileUpload/<?= $item["gambar"] ?>" alt="Gambar Produk" class="img-fluid">
                            </div>
                            <div class="col-md-8">
                                <dl class="row">
                                    <dt class="col-sm-3">Nama Produk</dt>
                                    <dd class="col-sm-9"><?= $item["nama_produk"] ?></dd>

                                    <dt class="col-sm-3">Kategori</dt>
                                    <dd class="col-sm-9"><?= $item["kategori"] ?></dd>

                                    <dt class="col-sm-3">Harga</dt>
                                    <dd class="col-sm-9">Rp. <?= formatKeRupiah($item["harga"]) ?></dd>

                                    <dt class="col-sm-3">Kondisi</dt>
                                    <dd class="col-sm-9"><?= $item["kondisi"] ?></dd>

                                    <dt class="col-sm-3">Berat</dt>
                                    <dd class="col-sm-9"><?= $item["berat"] ?></dd>
                                </dl>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <h4>Deskripsi</h4>
                                <p><?= $item["deskripsi"] ?></p>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>



    <script src="../../asset/js/bootstrap.js"></script>
    <script src="../../asset/js/script.js"></script>

</body>

</html>