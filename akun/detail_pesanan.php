<?php
session_start();
include "../db/koneksi.php";
include "../fungsi.php";

if (empty($_SESSION["username"]) || empty($_SESSION["email"]) || empty($_SESSION["password"])) {
    header("Location: ../index.php");
}
// untuk keranjang dinavbar
$user = !empty($_SESSION["id_user"]) ? $_SESSION["id_user"] : "";
$data_user = show("SELECT * FROM user WHERE id_user = '$user'");
$username = !empty($_SESSION["username"]) ? $_SESSION["username"] : "";

// Buat navbar
if ($data_user[0]["picture"]) {
    $picture = "../userPicture/" . $data_user[0]["picture"];
} else {
    $picture = "../asset/img/profile_default.png";
}
$kode_pesanan = $_GET["kode_pesanan"];
$get_id_produk = show("SELECT id_produk FROM pesanan 
WHERE kode_pesanan = '$kode_pesanan'");
$id_produk = $get_id_produk[0]['id_produk'];

// $pesanan_user = mysqli_query($koneksi, "SELECT 
//     pesanan.*, 
//     user.*, 
//     alamat.*, 
//     produk.*,
//     GROUP_CONCAT(produk.id_produk) AS id_produk FROM pesanan
//     LEFT JOIN user ON pesanan.id_user = user.id_user
//     LEFT JOIN alamat ON pesanan.id_alamat = alamat.id_alamat
//     LEFT JOIN produk ON pesanan.id_produk = produk.id_produk
//     WHERE pesanan.id_user = '$user' AND pesanan.kode_pesanan = '$kode_pesanan'
//     GROUP BY pesanan.id_produk");
$pesanan_user = mysqli_query($koneksi, "SELECT * FROM pesanan 
LEFT JOIN user ON pesanan.id_user = user.id_user
LEFT JOIN alamat ON pesanan.id_alamat = alamat.id_alamat
-- LEFT JOIN produk ON pesanan.id_produk = produk.id_produk
WHERE pesanan.id_user = '$user' AND pesanan.kode_pesanan = '$kode_pesanan'");
$pesanan = mysqli_fetch_assoc($pesanan_user);
$get_prod = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk IN ($id_produk)");
// $produk = mysqli_fetch_assoc($get_prod);
// $pesanan_user = show("SELECT * FROM pesanan 
// LEFT JOIN user ON pesanan.id_user = user.id_user
// LEFT JOIN alamat ON pesanan.id_alamat = alamat.id_alamat
// LEFT JOIN (
//     SELECT * FROM produk WHERE id_produk IN ($id_produk)
// ) AS allproduk ON pesanan.id_produk = allproduk.id_produk
// WHERE pesanan.id_user = '$user' AND pesanan.kode_pesanan = '$kode_pesanan'");
// $pesanan_user = show("SELECT * FROM pesanan 
// LEFT JOIN user ON pesanan.id_user = user.id_user
// LEFT JOIN alamat ON pesanan.id_alamat = alamat.id_alamat
// LEFT JOIN produk ON pesanan.id_produk = produk.id_produk
// WHERE pesanan.id_user = '$user' AND pesanan.kode_pesanan = '$kode_pesanan'
// AND produk.id_produk IN (
//     SELECT DISTINCT id_produk FROM pesanan
//     WHERE pesanan.id_produk IN ($id_produk) 
// )");
// var_dump($pesanan);
// var_dump();
// die;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../asset/css/bootstrap.css">
    <link rel="stylesheet" href="../asset/css/style.css">
    <!-- Bs Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Detail Pesanan - Macro Store Computer</title>
</head>

<body>

    <?php include "navbar.php" ?>

    <section id="hero">
        <div class="container mb-3">
            <div class="row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item">Akun</li>
                        <li class="breadcrumb-item">Pesanan</li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Pesanan</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <?php include "sidebar.php"; ?>
                </div>
                <div class="col-md-8">
                    <div class="card py-3 px-4 border-0 shadow-1 rounded-16">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-6">
                                <h4>Detail Pesanan</h4>
                            </div>
                            <div class="col-6 text-end ">
                                <a href="pesanan.php" class="btn btn-gray fw-500">Kembali</a>
                            </div>
                        </div>
                    </div>
                    <!-- DATA PESANAN -->
                    <div class="card pt-3 px-4 border-0 shadow-1 rounded-16 mt-2">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-6">
                                <h5 class="text-muted fw-500">Data Pesanan</h5>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="card rounded-16 border-0">
                                    <dl class="row">
                                        <dt class="col-sm-3 fw-500">Kode Pesanan</dt>
                                        <dd class="col-sm-9"><?= $pesanan["kode_pesanan"] ?></dd>

                                        <dt class="col-sm-3 fw-500">Tanggal</dt>
                                        <dd class="col-sm-9"><?= $pesanan["tgl_pesanan"] ?></dd>

                                        <dt class="col-sm-3 fw-500">Harga</dt>
                                        <dd class="col-sm-9">Rp<?= formatKeRupiah($pesanan["total_harga_belanja"]) ?></dd>

                                        <dt class="col-sm-3 fw-500">Metode Pembayaran</dt>
                                        <dd class="col-sm-9"><?= $pesanan["metode_pembayaran"] ?></dd>

                                        <dt class="col-sm-3 fw-500">Transfer Ke</dt>
                                        <dd class="col-sm-9">Moch. Ayi Pratama (1380564781) BCA</dd>

                                        <dt class="col-sm-3 fw-500">Status</dt>
                                        <dd class="col-sm-9">
                                            <span class="badge fw-500 fs-15 p-2 
                                                <?php
                                                if ($pesanan['status'] == 'Menunggu Pembayaran') {
                                                    echo 'bg-danger';
                                                } else if ($pesanan['status'] == 'Menunggu Konfirmasi') {
                                                    echo 'bg-info';
                                                } else if ($pesanan['status'] == 'Konfirmasi') {
                                                    echo 'bg-secondary';
                                                } else if ($pesanan['status'] == 'Dikemas') {
                                                    echo 'bg-warning';
                                                } else if ($pesanan['status'] == 'Dalam Pengiriman') {
                                                    echo 'bg-primary';
                                                } else if ($pesanan['status'] == 'Selesai') {
                                                    echo 'bg-success';
                                                }
                                                ?>
                                            ">
                                                <?= $pesanan["status"] ?>
                                            </span>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- DATA PENERIMA -->
                    <div class="card pt-3 px-4 border-0 shadow-1 rounded-16 mt-2">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-6">
                                <h5 class="text-muted fw-500">Data Penerima</h5>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="card rounded-16 border-0">
                                    <dl class="row">
                                        <dt class="col-sm-3 fw-500">Penerima</dt>
                                        <dd class="col-sm-9"><?= $pesanan["penerima"] ?></dd>

                                        <dt class="col-sm-3 fw-500">No.HP</dt>
                                        <dd class="col-sm-9"><?= $pesanan["nohp_penerima"] ?></dd>

                                        <dt class="col-sm-3 fw-500">Alamat</dt>
                                        <dd class="col-sm-9"><?= $pesanan["alamat_lengkap"] ?></dd>

                                        <dt class="col-sm-3 fw-500">Catatan</dt>
                                        <dd class="col-sm-9"><?= $pesanan["catatan"] ?></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- DATA PRODUK -->
                    <div class="card pt-3 px-4 border-0 shadow-1 rounded-16 mt-2">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-6">
                                <h5 class="text-muted fw-500">Data Produk</h5>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <?php foreach ($get_prod as $item) : ?>
                                    <div class="card rounded-16 border-0">
                                        <dl class="row">
                                            <dt class="col-sm-3 fw-500">Gambar</dt>
                                            <dd class="col-sm-9 p-0"><img src="../fileUpload/<?= $item["gambar"] ?>" alt="foto" class=""></dd>

                                            <dt class="col-sm-3 fw-500">Produk</dt>
                                            <dd class="col-sm-9"><?= $item["nama_produk"] ?></dd>

                                            <dt class="col-sm-3 fw-500">Jumlah</dt>
                                            <dd class="col-sm-9">
                                                <?php if ($pesanan["jumlah_item"] > 1) : ?>
                                                    <?= $pesanan["jumlah_item"] - 1 ?>
                                                <?php else : ?>
                                                    <?= $pesanan["jumlah_item"] ?>
                                                <?php endif ?>
                                            </dd>

                                            <dt class="col-sm-3 fw-500">Total</dt>
                                            <dd class="col-sm-9">Rp<?= formatKeRupiah($item["harga"]) ?></dd>
                                        </dl>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include "../footer.php" ?>


    <script src="../asset/js/bootstrap.js"></script>
    <script src="../asset/js/script.js"></script>
</body>

</html>