<?php
session_start();
include "db/koneksi.php";
include "fungsi.php";

$user = !empty($_SESSION["id_user"]) ? $_SESSION["id_user"] : "";

// ====================================================================================================

// ====================================================================================================
$pesanan_user = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_user = '$user' ORDER BY id_pesanan DESC LIMIT 1");
$pesanan = mysqli_fetch_assoc($pesanan_user);
// var_dump($pesanan_user);
// die;
// ====================================================================================================

// TOMBOL CHEKOUT============================================================================================
if (isset($_POST["proses_pembayaran"])) {
    // var_dump($_POST);
    // die;
    if (deleteKeranjang($_POST) > 0) {
        echo "
        <script>
            alert('Produk berhasil dihapus');
            window.location.href='keranjang.php';
        </script>
    ";
    }
}


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
    <title>Checkout Sukses - Macro Store Computer</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top border-bottom">
        <div class="container py-2 ">
            <a class="navbar-brand" href="index.php">
                <img src="asset/img/logo2.png" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav flex-row">
                    <li class="nav-item me-2 mt-2 mt-lg-0">
                        <a class="btn btn-gray fw-500" href="keranjang.php">
                            <!-- <i class="bi bi-cart-fill"></i> -->
                            Kembali
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Hero -->
    <section class="checkout" style="min-height:65vh;">
        <div class="container">
            <!-- <form action="" method="post"> -->
            <div class="row justify-content-center mt-3">
                <div class="col-12 col-lg-8">
                    <!-- ALAMAT PENGIRIMAN -->
                    <div class="row justify-content-center">
                        <div class="col-xl-8">
                            <div class="border rounded-8 mt-1 p-3 p-lg-4 shadow-1 bg-white">
                                <h5 class="text-center text-green mb-3">PESANAN BERHASIL DIBUAT</h5>
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <p class="text-center">Silakan lakukan pembayaran <br> dengan melakukan transfer ke rekening berikut.</p>
                                        <div class="card">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fw-500">Metode Pembayaran</span>
                                                        <span>Transfer Bank</span>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fw-500">Transfer Ke</span>
                                                        <span class="text-end">Moch. Ayi pratama <span class="fw-500">(1380564781) BCA</span></span>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fw-500">Kode Pesanan</span>
                                                        <span><?= $pesanan["kode_pesanan"] ?></span>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fw-500">Total Tagihan</span>
                                                        <span>Rp<?= formatKeRupiah($pesanan["total_harga_belanja"]) ?></span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="row g-2 mt-2">
                                            <div class="col-md-6">
                                                <a href="akun/pesanan.php" class="btn btn-gray w-100 fw-500 fs-15">Cek Pesanan Anda</a>
                                            </div>
                                            <div class="col-md-6">
                                                <a href="akun/pesanan.php" class="btn btn-green w-100 fw-500 fs-15">Belanja Lagi</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- </form> -->
        </div>
    </section>

    <!-- Footer -->
    <?php include "footer.php" ?>

    <script src="asset/js/bootstrap.js"></script>
    <script src="asset/js/script.js"></script>

</body>

</html>