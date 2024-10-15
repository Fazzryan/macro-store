<?php
session_start();
include "../../fungsi.php";

if (empty($_SESSION["username"]) || empty($_SESSION["password"])) {
    header("Location: ../../otentikasi/login.php");
    exit();
} else if ($_SESSION["role"] != 'admin') {
    header("Location: ../../produk.php");
    exit();
}
$username = $_SESSION["username"];

$kode_pesanan = $_GET["kode_pesanan"];
$pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan 
LEFT JOIN user ON pesanan.id_user = user.id_user 
LEFT JOIN alamat ON pesanan.id_alamat = alamat.id_alamat 
LEFT JOIN produk ON pesanan.id_produk = produk.id_produk
WHERE pesanan.kode_pesanan = '$kode_pesanan'");
$detail_pesanan = mysqli_fetch_assoc($pesanan);

$pembayaran = mysqli_query($koneksi, "SELECT * FROM pembayaran WHERE kode_pesanan = '$kode_pesanan'");
$detail_pembayaran = mysqli_fetch_assoc($pembayaran);
// var_dump($detail_pembayaran['id_user']);
// die;
$id_user = !empty($detail_pembayaran["id_user"]) ? $detail_pembayaran["id_user"] : "";

if (isset($_POST["konfirmasi_pesanan"])) {
    // var_dump($_POST);
    // die;
    $id_user = $_POST["id_user"];
    $kode_pesanan = $_POST["kode_pesanan"];
    $status = $_POST["status"];

    $update_status = mysqli_query($koneksi, "UPDATE pesanan SET status = '$status' WHERE id_user = '$id_user' AND kode_pesanan = '$kode_pesanan'");
    if ($update_status) {
        echo "
        <script>
            alert('Konfirmasi berhasil!');
            location.replace(location.href);
        </script>
    ";
    }
}
if (isset($_POST["konfirmasi_pembayaran"])) {
    // var_dump($_POST);
    // die;
    $id_user = $_POST["id_user"];
    $kode_pesanan = $_POST["kode_pesanan"];
    $status_pem = $_POST["status_pem"];

    $update_status_pem = mysqli_query($koneksi, "UPDATE pembayaran SET status_pem = '$status_pem' WHERE id_user = '$id_user' AND kode_pesanan = '$kode_pesanan'");
    if ($update_status_pem) {
        echo "
        <script>
            alert('Konfirmasi berhasil!');
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
    <link rel="stylesheet" href="../../asset/css/bootstrap.css">
    <link rel="stylesheet" href="../../asset/css/style.css">
    <!-- Bs Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Detail Pesanan - Macro Store Computer</title>
</head>

<body class="bg-white">
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <?php include "../layout/navbarNav.php" ?>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar content-header">
                <?php include "../layout/navbarContent.php" ?>
            </nav>

            <div class="content-body">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-12 col-md-6">
                            <h3>Detail Pesanan</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="Pesanan.php">Pesanan</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Detail Pesanan</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-12 col-md-6 text-end">
                            <a href="Pesanan.php" class="btn btn-gray fw-500 fs-15">Kembali ke Pesanan</a>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-lg-7">
                                    <!-- Data Pesanan -->
                                    <div class="card rounded-16 p-4 pb-2 shadow-1">
                                        <h5 class="text-muted fw-500">Data Pesanan</h5>
                                        <dl class="row">
                                            <dt class="col-sm-6 fw-500">Kode Pesanan</dt>
                                            <dd class="col-sm-6"><?= $detail_pesanan["kode_pesanan"] ?></dd>

                                            <dt class="col-sm-6 fw-500">Tanggal</dt>
                                            <dd class="col-sm-6"><?= $detail_pesanan["tgl_pesanan"] ?></dd>

                                            <dt class="col-sm-6 fw-500">Harga</dt>
                                            <dd class="col-sm-6">Rp<?= formatKeRupiah($detail_pesanan["total_harga_belanja"]) ?></dd>

                                            <dt class="col-sm-6 fw-500">Metode Pembayaran</dt>
                                            <dd class="col-sm-6"><?= $detail_pesanan["metode_pembayaran"] ?></dd>

                                            <dt class="col-sm-6 fw-500">Transfer Ke</dt>
                                            <dd class="col-sm-6">Moch. Ayi Pratama (1380564781) BCA</dd>

                                            <dt class="col-sm-6 fw-500">Status</dt>
                                            <dd class="col-sm-6">
                                                <span class="badge fw-500 fs-15 p-2 
                                                <?php
                                                if ($detail_pesanan['status'] == 'Menunggu Pembayaran') {
                                                    echo 'bg-danger';
                                                } else if ($detail_pesanan['status'] == 'Menunggu Konfirmasi') {
                                                    echo 'bg-info';
                                                } else if ($detail_pesanan['status'] == 'Konfirmasi') {
                                                    echo 'bg-secondary';
                                                } else if ($detail_pesanan['status'] == 'Dikemas') {
                                                    echo 'bg-warning';
                                                } else if ($detail_pesanan['status'] == 'Dalam Pengiriman') {
                                                    echo 'bg-primary';
                                                } else if ($detail_pesanan['status'] == 'Selesai') {
                                                    echo 'bg-success';
                                                }
                                                ?>
                                            ">
                                                    <?= $detail_pesanan["status"] ?>
                                                </span>
                                            </dd>
                                            <dt class="col-sm-12 fw-500">
                                                <form action="" method="post" class="mt-1 d-flex">
                                                    <input type="hidden" name="id_user" value="<?= $id_user ?>">
                                                    <input type="hidden" name="kode_pesanan" value="<?= $detail_pesanan["kode_pesanan"] ?>">
                                                    <select name="status" class="form-select w-75">
                                                        <option value="Konfirmasi">Konfirmasi</option>
                                                        <option value="Dikemas">Dikemas</option>
                                                        <option value="Dalam Pengiriman">Dalam Pengiriman</option>
                                                        <option value="Selesai">Selesai</option>
                                                        <option value="Batalkan">Batalkan</option>
                                                    </select>
                                                    <button type="submit" name="konfirmasi_pesanan" class="btn btn-green fw-500 fs-15 ms-2 w-25">OK</button>
                                                </form>
                                            </dt>
                                        </dl>
                                    </div>
                                    <!-- Data Produk -->
                                    <div class="card rounded-16 p-4 pb-2 shadow-1 mt-2">
                                        <h5 class="text-muted fw-500">Data Produk</h5>
                                        <dl class="row">
                                            <dt class="col-sm-3 fw-500">Gambar</dt>
                                            <dd class="col-sm-9"><img src="../../fileUpload/<?= $detail_pesanan["gambar"] ?>" alt="foto" class=""></dd>

                                            <dt class="col-sm-3 fw-500">Produk</dt>
                                            <dd class="col-sm-9"><?= $detail_pesanan["nama_produk"] ?></dd>

                                            <dt class="col-sm-3 fw-500">Jumlah</dt>
                                            <dd class="col-sm-9"><?= $detail_pesanan["jumlah_item"] ?></dd>

                                            <dt class="col-sm-3 fw-500">Total</dt>
                                            <dd class="col-sm-9">Rp<?= formatKeRupiah($detail_pesanan["total_harga_belanja"]) ?></dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-5 mt-2 mt-lg-0">
                                    <!-- Data Penerima -->
                                    <div class="card rounded-16 p-4 pb-2 shadow-1">
                                        <h5 class="text-muted fw-500">Data Penerima</h5>
                                        <dl class="row">
                                            <dt class="col-sm-5 fw-500">Penerima</dt>
                                            <dd class="col-sm-7"><?= $detail_pesanan["penerima"] ?></dd>

                                            <dt class="col-sm-5 fw-500">No.HP</dt>
                                            <dd class="col-sm-7"><?= $detail_pesanan["nohp_penerima"] ?></dd>

                                            <dt class="col-sm-5 fw-500">Alamat</dt>
                                            <dd class="col-sm-7"><?= $detail_pesanan["alamat_lengkap"] ?></dd>

                                            <dt class="col-sm-5 fw-500">Catatan</dt>
                                            <dd class="col-sm-7"><?= $detail_pesanan["catatan"] ?></dd>
                                        </dl>
                                    </div>
                                    <!-- Data Pembayaran -->
                                    <div id="fullscreen" onclick="closeFullscreen()">
                                        <img src="../../filePembayaran/<?= $detail_pembayaran["bukti_pembayaran"] ?>" alt="Gambar Fullscreen">
                                    </div>
                                    <div class="card rounded-16 p-4 pb-2 shadow-1 mt-2">
                                        <h5 class="text-muted fw-500">Pembayaran</h5>
                                        <?php if (!empty($detail_pembayaran)) : ?>
                                            <!-- <img src="../../filePembayaran/<?= $detail_pembayaran["bukti_pembayaran"] ?>" alt="foto" class="w-100"> -->

                                            <img src="../../filePembayaran/<?= $detail_pembayaran["bukti_pembayaran"] ?>" alt="Gambar" class="rounded-3 w-100" style="cursor:pointer;" onclick="openFullscreen()">
                                            <dl class="row">
                                                <dt class="col-sm-5 fw-500">Jumlah Transfer</dt>
                                                <dd class="col-sm-7">
                                                    Rp<?= formatKeRupiah($detail_pembayaran["jml_transfer"]) ?>
                                                </dd>

                                                <dt class="col-sm-5 fw-500">Tanggal</dt>
                                                <dd class="col-sm-7"><?= $detail_pembayaran["tgl_transfer"] ?></dd>

                                                <dt class="col-sm-5 fw-500">Status</dt>
                                                <dd class="col-sm-7">
                                                    <span class="badge fs-14 fw-500
                                                    <?php
                                                    if ($detail_pembayaran['status_pem'] == 'Menunggu Konfirmasi') {
                                                        echo 'bg-warning';
                                                    } else if ($detail_pembayaran['status_pem'] == 'Konfirmasi') {
                                                        echo 'bg-success';
                                                    } else {
                                                        echo 'bg-secondary';
                                                    }
                                                    ?>">
                                                        <?= $detail_pembayaran["status_pem"]
                                                        ?>
                                                    </span>
                                                </dd>

                                                <dt class="col-sm-5 fw-500">Transfer Ke</dt>
                                                <dd class="col-sm-7"><?= $detail_pembayaran["rekening_tujuan"] ?></dd>

                                                <dt class="col-sm-5 fw-500">Transfer Dari</dt>
                                                <dd class="col-sm-7"><?= $detail_pembayaran["atas_nama"] ?></dd>
                                                <dt class="col-sm-12 fw-500">
                                                    <form action="" method="post" class="mt-1 d-flex">
                                                        <input type="hidden" name="id_user" value="<?= $id_user ?>">
                                                        <input type="hidden" name="kode_pesanan" value="<?= $detail_pembayaran["kode_pesanan"] ?>">
                                                        <select name="status_pem" class="form-select w-75">
                                                            <option value="Konfirmasi">Konfirmasi Pembayaran</option>
                                                            <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                                                            <option value="Dibatalkan">Batalkan Pembayaran</option>
                                                        </select>
                                                        <button type="submit" name="konfirmasi_pembayaran" class="btn btn-green fw-500 fs-15 ms-2 w-25">OK</button>
                                                    </form>
                                                </dt>
                                            </dl>
                                        <?php else : ?>
                                            <span class="fw-500 fs-15">Belum ada pembayaran</span>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../asset/js/bootstrap.js"></script>
    <script src="../../asset/js/script.js"></script>
    <script>
        let tombol = document.getElementById('tombol-ar');
        tombol.addEventListener('click', () => {
            let content = document.getElementById('ar-code');
            if (content.style.display === 'inline-flex') {
                content.style.display = 'none';
            } else {
                content.style.display = 'inline-flex';
            }
        });
    </script>
</body>

</html>