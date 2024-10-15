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

$pesanan_user = show("SELECT * FROM pesanan WHERE id_user = '$user' ORDER BY id_pesanan DESC");
if (isset($_POST["batalkan_pesanan"])) {
    // var_dump($_POST);
    // die;
    $id_user = $_POST["id_user"];
    $kode_pesanan = $_POST["kode_pesanan"];
    $batalkan_pesanan = mysqli_query($koneksi, "DELETE FROM pesanan WHERE kode_pesanan = '$kode_pesanan' AND id_user = '$id_user'");
    if ($batalkan_pesanan) {
        echo "
        <script>
            alert('Pesanan berhasil dibatalkan!');
            location.replace(location.href);
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
    <link rel="stylesheet" href="../asset/css/bootstrap.css">
    <link rel="stylesheet" href="../asset/css/style.css">
    <!-- Bs Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Pesanan - Macro Store Computer</title>
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
                        <li class="breadcrumb-item active" aria-current="page">Pesanan</li>
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
                            <div class="col-6">
                                <h4>Pesanan</h4>
                            </div>
                            <!-- <div class="col-6 text-end ">
                                <a href="#.php" class="btn btn-green">Tambah Alamat</a>
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <?php if (!empty($pesanan_user)) : ?>
                                    <?php foreach ($pesanan_user as $item) : ?>
                                        <div class="card rounded-8 border-1 shadow-1 my-2">
                                            <div class="p-3">
                                                <!-- <div class="d-flex justify-content-between align-items-center mb-2"> -->
                                                <div class="mb-2">
                                                    <i class="bi bi-bag-fill"></i>
                                                    <span class="fw-500">Belanja</span>
                                                    <span class="text-muted fw-400 fs-14"><?= $item["tgl_pesanan"] ?></span>
                                                </div>
                                                <!-- <span class="badge bg-danger"><?= $item["status"] ?></span> -->
                                                <!-- </div> -->
                                                <div class="row justify-content-between align-items-center">
                                                    <div class="col-lg-3">
                                                        <span class="text-muted fs-14">Metode Pembayaran</span>
                                                        <h6><?= $item["metode_pembayaran"] ?></h6>
                                                    </div>
                                                    <div class="col-lg-3 border-start">
                                                        <span class="text-muted fs-14">Kode Pesanan</span>
                                                        <h6><?= $item["kode_pesanan"] ?></h6>
                                                    </div>
                                                    <div class="col-lg-3 border-start">
                                                        <span class="text-muted fs-14">Total Pembayaran</span>
                                                        <h6>Rp<?= formatKeRupiah($item["total_harga_belanja"]) ?></h6>
                                                    </div>
                                                    <div class="col-lg-3 border-start">
                                                        <span class="text-muted fs-14">Status</span>
                                                        <h6>
                                                            <?= $item["status"] ?>
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="text-start mt-2">
                                                    <a href="detail_pesanan.php?kode_pesanan=<?= $item['kode_pesanan'] ?>" class="btn btn-green fs-14 fw-500">Lihat Detail</a>
                                                    <?php if ($item["status"] == "Selesai" || $item["status"] == "Dalam Pengiriman") : ?>
                                                        <a href="../invoice.php?id_user=<?= $item['id_user'] ?>&kode_pesanan=<?= $item['kode_pesanan'] ?>" class="btn btn-outline-success rounded-8 fw-500 fs-14" target="_blank">Lihat Invoice</a>
                                                    <?php else : ?>
                                                        <form action="" method="post" class="d-inline">
                                                            <input type="hidden" name="id_user" value="<?= $item["id_user"] ?>">
                                                            <input type="hidden" name="kode_pesanan" value="<?= $item["kode_pesanan"] ?>">
                                                            <button type="submit" name="batalkan_pesanan" class="btn btn-gray fs-14 fw-500 border ms-1" onclick="return confirm('Yakin batalkan pesanan?')">Batalkan</button>
                                                        </form>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <div class="row row-cols-1 g-2 g-lg-3 justify-content-center mt-3">
                                        <div class="col text-center address">
                                            <img src="../asset/img/empty_pesanan.svg" alt="icon">
                                            <h5 class="mt-4">Pesanan anda masih kosong!</h5>
                                            <p>Tambahkan barang ke keranjang belanja Anda untuk melanjutkan proses pemesanan.</p>
                                            <a href="../produk.php" class="btn btn-green fs-15 fw-500">Mulai Belanja</a>
                                        </div>
                                    </div>
                                <?php endif ?>
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