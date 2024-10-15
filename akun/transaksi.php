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

// $alamat = show("SELECT * FROM alamat WHERE id_user = '$user'");

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
    <title>Daftar Transaksi - Macro Store Computer</title>
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
                        <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
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
                    <div class="card py-3 px-4 border-0 shadow-1 rounded-16" style="margin-bottom: 140px;">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-6">
                                <h4>Daftar Transaksi</h4>
                            </div>
                            <!-- <div class="col-6 text-end ">
                                <a href="#.php" class="btn btn-green">Tambah Alamat</a>
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card rounded-16 border-0 mb-4">
                                    <?php if (!empty($pesanan_user)) : ?>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="table-success fw-500">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Kode Pesanan</th>
                                                        <th scope="col">Tanggal</th>
                                                        <th scope="col">Jumlah</th>
                                                        <th scope="col">Pembayaran</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($pesanan_user as $key => $item) : ?>
                                                        <tr>
                                                            <th scope="row"><?= $key + 1 ?></th>
                                                            <td>
                                                                <a href="detail_pesanan?kode_pesanan=<?= $item['kode_pesanan'] ?>"><?= $item["kode_pesanan"] ?></a>
                                                            </td>
                                                            <td><?= $item["tgl_pesanan"] ?></td>
                                                            <td><?= $item["jumlah_item"] ?></td>
                                                            <td><?= $item["metode_pembayaran"] ?></td>
                                                            <td>
                                                                <span class="badge bg-danger"><?= $item["status"] ?></span>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else : ?>
                                        <div class="text-center">
                                            <img src="../asset/img/emty_trans.svg" alt="icon" width="">
                                            <h5 class=" fw-500 mt-3">Belum ada transaksi</h5>
                                            <p class="fs-14">Yuk, mulai belanja dan penuhi berbagai <br> kebutuhanmu di Macro Store Computer.</p>
                                            <a href="../produk.php" class="btn btn-green fs-500">Mulai Belanja</a>
                                        </div>
                                    <?php endif ?>
                                </div>
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