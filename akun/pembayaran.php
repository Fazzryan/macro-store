<?php
session_start();
include "../db/koneksi.php";
include "../fungsi.php";

if (empty($_SESSION["username"]) || empty($_SESSION["email"]) || empty($_SESSION["password"])) {
    header("Location: ../index.php");
}
// untuk keranjang dinavbar
$user = !empty($_SESSION["id_user"]) ? $_SESSION["id_user"] : "";
$username = !empty($_SESSION["username"]) ? $_SESSION["username"] : "";

$data_user = show("SELECT * FROM user WHERE id_user = '$user'");
$tgl_transfer = tgl_indo(date("Y-m-d"));
// Buat navbar
if ($data_user[0]["picture"]) {
    $picture = "../userPicture/" . $data_user[0]["picture"];
} else {
    $picture = "../asset/img/profile_default.png";
}

$pesanan_user = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_user = '$user'");
$pembayaran_user = mysqli_query($koneksi, "SELECT * FROM pembayaran WHERE id_user = '$user'");
// $pesanan = mysqli_fetch_assoc($pembayaran_user);
// var_dump($pembayaran_user);
// die;

// TOMBOL CHEKOUT============================================================================================
if (isset($_POST["konfirmasi"])) {
    // var_dump($_POST);
    // die;
    if (konfirmasiPembayaran($_POST) > 0) {
        echo "
        <script>
            alert('Konfirmasi berhasil dilakukan');
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
    <title>Pembayaran - Macro Store Computer</title>
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
                        <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
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
                                <h4>Pembayaran</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id_user" value="<?= $user ?>">
                                    <input type="hidden" name="tgl_transfer" value="<?= $tgl_transfer ?>">
                                    <div class="card rounded-8 border-1 shadow-1 my-2">
                                        <div class="p-3">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="kondisi" class="form-label fw-500">Kode Pesanan</label>
                                                        <select name="kode_pesanan" class="form-select" required>
                                                            <option value="" disabled selected>Pilih Kode Pesanan</option>
                                                            <?php foreach ($pesanan_user as $item) : ?>
                                                                <?php if ($item["status"] == "Menunggu Pembayaran") : ?>
                                                                    <option value="<?= $item['kode_pesanan'] ?>"><?= $item['kode_pesanan'] ?> (Rp<?= formatKeRupiah($item['total_harga_belanja']) ?>)</option>
                                                                <?php endif ?>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="NamaBank" class="form-label fw-500">Nama Bank</label>
                                                        <input type="text" class="form-control" id="NamaBank" name="nama_bank" required autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="norek" class="form-label fw-500">No. Rekening</label>
                                                        <input type="number" class="form-control" id="norek" name="norek" required autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="jml_transfer" class="form-label fw-500">Jumlah Transfer</label>
                                                        <input type="number" class="form-control" id="jml_transfer" name="jml_transfer" required autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="atas_nama" class="form-label fw-500">Atas nama</label>
                                                        <input type="text" class="form-control" id="atas_nama" name="atas_nama" required autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="rekening_tujuan" class="form-label fw-500">Transfer Ke Rekening </label>
                                                        <input type="text" name="rekening_tujuan" class="form-control" value="Moch. Ayi Pratama (1380564781) BCA" readonly required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="bukti_pembayaran" class="form-label fw-500">Bukti Transfer</label>
                                                        <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran" required autocomplete="off">
                                                    </div>
                                                    <button class="btn btn-green fw-500 fs-15" name="konfirmasi">Konfirmasi</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-12 mt-3">
                                <h4>Pembayaran Saya</h4>
                                <span class="fs-15 fst-italic">Pembayaran Anda akan diverifikasi oleh Admin dalam waktu 1x24 jam.</span>
                                <div class="card rounded-8 border-1 shadow-1 mt-3">
                                    <div class="p-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <table class="table ">
                                                        <tr>
                                                            <td class="fw-500">#</td>
                                                            <td class="fw-500">Kode Pesanan</td>
                                                            <td class="fw-500">Status</td>
                                                        </tr>
                                                        <?php if (!empty($pembayaran_user)) : ?>
                                                            <?php foreach ($pembayaran_user as $key => $item) : ?>
                                                                <tr>
                                                                    <td><?= $key + 1 ?></td>
                                                                    <td><?= $item["kode_pesanan"] ?></td>
                                                                    <td>
                                                                        <span class="badge fs-15 fw-500
                                                                        <?php
                                                                        if ($item['status_pem'] == 'Menunggu Konfirmasi') {
                                                                            echo 'bg-warning';
                                                                        } else if ($item['status_pem'] == 'Konfirmasi') {
                                                                            echo 'bg-success';
                                                                        } else {
                                                                            echo 'bg-secondary';
                                                                        }
                                                                        ?>
                                                                        "><?= $item["status_pem"] ?></span>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                        <?php endif ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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