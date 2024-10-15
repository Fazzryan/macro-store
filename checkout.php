<?php
session_start();
include "db/koneksi.php";
include "fungsi.php";

$user = !empty($_SESSION["id_user"]) ? $_SESSION["id_user"] : "";
$tgl_pesanan = tgl_indo(date("Y-m-d"));
$kode_pesanan = generateRandomString();
// var_dump($kode_pesanan);
// die;
// ====================================================================================================
if (isset($_GET['selected_products'])) {
    $selectedProducts = $_GET['selected_products'];
    $produk = mysqli_query($koneksi, "SELECT * FROM keranjang 
    LEFT JOIN produk 
    ON keranjang.id_produk = produk.id_produk
    LEFT JOIN user
    ON keranjang.id_user = user.id_user
    WHERE keranjang.id_user = '$user'
    AND keranjang.id_produk IN ($selectedProducts)
    ");
    // foreach ($produk as $jumlah_produk) {
    //     echo $jumlah_produk['jumlah_produk'];
    // }
    // die;
} else {
    echo "
    <script>
        alert('Tidak ada produk yang dipilih');
        window.location.href='keranjang.php';
    </script>
    ";
}

// ====================================================================================================
$selectedProducts = $_GET['selected_products'];
$ongkir = 12000;
$total_produk = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM keranjang WHERE id_user = '$user' AND id_produk = '$selectedProducts'");
$jumlah_produk = mysqli_fetch_row($total_produk);
foreach ($jumlah_produk as $x) {
    $harga = mysqli_query($koneksi, "SELECT SUM(total_harga_produk) FROM keranjang WHERE id_user = '$user' AND id_produk IN ($selectedProducts)");
    $total_harga = mysqli_fetch_row($harga);
    $total_harga_all = $total_harga[0] + $ongkir;
    $qty = show("SELECT SUM(jumlah_produk) AS total FROM keranjang WHERE id_user = '$user' AND id_produk IN ($selectedProducts)");
}

// ====================================================================================================
$alamat = show("SELECT * FROM alamat LEFT JOIN user ON alamat.id_user = user.id_user WHERE alamat.id_user = '$user' AND alamat.is_aktif = 1");

$pilih_alamat = show("SELECT * FROM alamat LEFT JOIN user ON alamat.id_user = user.id_user WHERE alamat.id_user = '$user'");
// GANTI ALAMAT ==========================================================================================
if (isset($_POST["ganti_alamat"])) {
    // var_dump($_POST);
    // die;
    $id_alamat = $_POST["id_alamat"];
    $id_user = $_POST["id_user"];

    // Menonaktifkan alamat sebelumnya
    $nonaktifkan = mysqli_query($koneksi, "UPDATE alamat SET is_aktif = 0 WHERE id_user = '$id_user'");
    // Mengaktifkan alamat yang dipilih
    $aktifkan = mysqli_query($koneksi, "UPDATE alamat SET is_aktif = 1 WHERE id_alamat = '$id_alamat' AND id_user = '$id_user'");

    if ($alamat) {
        echo "
        <script>
            alert('Alamat berhasil diubah');
            location.replace(location.href);
        </script>
    ";
    }
}


// TOMBOL CHEKOUT============================================================================================
if (isset($_POST["proses_pembayaran"])) {
    // var_dump($_POST);
    // die;
    if (prosesPembayaran($_POST) > 0) {
        echo "
        <script>
            alert('Pesanan berhasil dibuat!');
            // window.location.href='checkout_sukses.php';
            // window.location.href='akun/pesanan.php';
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
    <title>Checkout - Macro Store Computer</title>
</head>

<body style="background-color:#F0F3F7;">
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
    <section class="checkout">
        <div class="container">
            <div class="row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="keranjang.php">Kerajang</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </nav>
            </div>
            <form action="" method="post">
                <div class="row justify-content-center mt-3">
                    <div class="col-12 col-lg-8">
                        <!-- ALAMAT PENGIRIMAN -->
                        <div class="row align-items-center">
                            <div class="col-12">
                                <div class="border rounded-8 mt-1 p-3 p-lg-4 shadow-1 bg-white">
                                    <h6 class="text-muted mb-3">ALAMAT PENGIRIMAN</h6>
                                    <?php if (!empty($alamat)) : ?>
                                        <?php foreach ($alamat as $item) : ?>
                                            <input type="hidden" name="id_alamat_penerima" value="<?= $item['id_alamat'] ?>">
                                            <input type="hidden" name="kode_pesanan" value="<?= $kode_pesanan . $item['nohp_penerima'] ?>">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="card-subtitle">
                                                    <i class="bi bi-geo-alt-fill text-green"></i>
                                                    <?= $item["label_alamat"] ?> / <?= $item["penerima"] ?>
                                                </h6>
                                            </div>
                                            <div class="fs-16 mt-2">
                                                <span class="card-subtitle"><?= $item["nohp_penerima"] ?></span>
                                                <p class=""><?= $item["alamat_lengkap"] ?> (<?= $item["catatan"] ?>)</p>
                                            </div>
                                        <?php endforeach ?>
                                    <?php else : ?>
                                        <p>Anda belum menambahkan alamat pengiriman. <a href="akun/tambahalamat.php" class="text-green">Tambah alamat </a> terlebih dahulu agar bisa melanjutkan proses pembayaran.</p>
                                    <?php endif ?>

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-green fs-14" data-bs-toggle="modal" data-bs-target="#alamatModal">
                                        Ganti Alamat
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="alamatModal" tabindex="-1" aria-labelledby="alamatModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="alamatModalLabel">Daftar Alamat</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php foreach ($pilih_alamat as $item) : ?>
                                                        <div class="border rounded-8 my-2 p-3 p-lg-4 shadow-1 bg-white">
                                                            <div class="d-flex justify-content-between">
                                                                <h6 class="card-subtitle">
                                                                    <i class="bi bi-geo-alt-fill text-green"></i>
                                                                    <?= $item["label_alamat"] ?> / <?= $item["penerima"] ?>
                                                                </h6>
                                                            </div>
                                                            <div class="fs-16 mt-2">
                                                                <span class="card-subtitle"><?= $item["nohp_penerima"] ?></span>
                                                                <p class=""><?= $item["alamat_lengkap"] ?> (<?= $item["catatan"] ?>)</p>
                                                                <form action="" method="post">
                                                                    <input type="hidden" name="id_alamat" value="<?= $item['id_alamat'] ?>">
                                                                    <input type="hidden" name="id_user" value="<?= $user ?>">
                                                                    <button type="submit" name="ganti_alamat" class="btn btn-green fs-14">Pilih</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    <?php endforeach ?>
                                                </div>
                                                <div class="modal-footer fs-14">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- JASA PENGIRIMAN & TRANSFER BANK -->
                        <div class="row">
                            <div class="col-12">
                                <div class="border rounded-8 mt-1 p-3 p-lg-4 shadow-1 bg-white">
                                    <h6 class="text-muted mb-3">JASA PENGIRIMAN</h6>
                                    <input class="form-control mb-2" type="text" name="jasa_pengiriman" id="jasa_pengiriman" readonly value="JNE">
                                    <span class="fs-14">JNE Reguler 1-3 hari - <span class="fw-500">Rp12.000,00</span></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="border rounded-8 mt-1 p-3 p-lg-4 shadow-1 bg-white">
                                    <h6 class="text-muted mb-3">METODE PEMBAYARAN</h6>
                                    <input class="form-control mb-2" type="text" name="metode_pembayaran" id="metode_pembayaran" readonly value="Bank Transfer">
                                    <span class="fs-14"><i>(Pembayaran lewat ATM atau internet Banking)</i></span>
                                </div>
                            </div>
                        </div>
                        <!-- PRODUK -->
                        <div class="row">
                            <div class="col-12">
                                <?php foreach ($produk as $key => $item) : ?>
                                    <input type="hidden" name="id_produk[]" value="<?= $selectedProducts ?>">
                                    <input type="hidden" name="tgl_pesanan" value="<?= $tgl_pesanan ?>">
                                    <input type="text" name="jumlah_produk[]" value="<?= $item['jumlah_produk'] ?>">
                                    <div class="border rounded-8 mt-2 p-3 p-lg-4 shadow-1 bg-white">
                                        <h6 class="text-muted mb-3">PESANAN <?= $key + 1 ?></h6>
                                        <div class="row">
                                            <div class="col-3">
                                                <img src="fileUpload/<?= $item['gambar'] ?>" class="keranjang_img rounded-8 w-50" alt="produk">
                                            </div>
                                            <div class="col-9">
                                                <h5 class="fw-400"><?= $item["nama_produk"] ?></h5>
                                                <div>Jumlah : <h6 class="d-inline"><?= $item["jumlah_produk"] ?> x Rp<?= formatKeRupiah($item["harga"]) ?></h6>
                                                </div>
                                                <div>Total : <h6 class="d-inline">Rp<?= formatKeRupiah($item["total_harga_produk"]) ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 mt-3 mt-lg-0">
                        <div class="border rounded-8 mt-1 p-3 p-lg-4 shadow-1 bg-white">
                            <div class="fs-16 fw-500">Ringkasan Belanja</div>
                            <div class="d-flex justify-content-between fs-14 my-3">
                                <span>Total Harga (<?= $qty[0]["total"] ?> barang)</span>
                                <input type="hidden" name="jumlah_item" value="<?= $qty[0]["total"] ?>">
                                <span>Rp<?= formatKeRupiah($total_harga[0]) ?></span>
                            </div>
                            <div class="d-flex justify-content-between fs-14 my-3">
                                <span>Total Ongkos Kirim</span>
                                <span>Rp12.000,00</span>
                            </div>
                            <div class="d-flex justify-content-between border-top">
                                <input type="hidden" name="ongkir" value="<?= $ongkir ?>">
                                <input type="hidden" name="total_harga_belanja" value="<?= $total_harga_all ?>">
                                <span class="fw-500 mt-3">Total Harga</span>
                                <span class="fw-500 mt-3">Rp<?= formatKeRupiah($total_harga_all) ?></span>
                            </div>
                            <div class="mt-3">
                                <button type="submit" name="proses_pembayaran" class="btn btn-green w-100 fw-500">Proses Pembayaran</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <?php include "footer.php" ?>

    <script src="asset/js/bootstrap.js"></script>
    <script src="asset/js/script.js"></script>

</body>

</html>