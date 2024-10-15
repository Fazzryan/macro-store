<?php
session_start();
include "db/koneksi.php";
include "fungsi.php";

if (empty($_SESSION["username"]) || empty($_SESSION["email"]) || empty($_SESSION["password"])) {
    header("Location: index.php");
}
$user = !empty($_SESSION["id_user"]) ? $_SESSION["id_user"] : "";

$kode_pesanan = $_GET["kode_pesanan"];
$get_id_produk = show("SELECT id_produk FROM pesanan 
WHERE kode_pesanan = '$kode_pesanan'");
$id_produk = $get_id_produk[0]['id_produk'];
$get_prod = show("SELECT * FROM produk WHERE id_produk IN ($id_produk)");

$pesanan_user = mysqli_query($koneksi, "SELECT * FROM pesanan 
LEFT JOIN user ON pesanan.id_user = user.id_user
LEFT JOIN alamat ON pesanan.id_alamat = alamat.id_alamat
LEFT JOIN produk ON pesanan.id_produk = produk.id_produk
WHERE pesanan.id_user = '$user' AND pesanan.kode_pesanan = '$kode_pesanan'");

$pesanan = mysqli_fetch_assoc($pesanan_user);
$tott = show("SELECT SUM(harga) AS total FROM produk WHERE id_produk IN ($id_produk)");
var_dump($tott[0]['total']);
// die;
foreach ($pesanan_user as $hit) {
    $tot = $hit['jumlah_item'] * $get_prod[0]['harga'];
}

$ongkir = 12000;
$total_produk = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pesanan WHERE id_user = '$user' AND id_produk = '$id_produk'");
$jumlah_produk = mysqli_fetch_row($total_produk);
foreach ($jumlah_produk as $x) {
    $harga = mysqli_query($koneksi, "SELECT SUM(total_harga_belanja) FROM pesanan WHERE id_user = '$user' AND id_produk IN ($id_produk)");
    $total_harga = mysqli_fetch_row($harga);
    foreach ($harga as $a) {
        echo $a;
    }
    // die;
    $total_harga_all = $total_harga[0] + $ongkir;
    $qty = show("SELECT SUM(jumlah_item) AS total FROM pesanan WHERE id_user = '$user' AND id_produk IN ($id_produk)");
}
// var_dump($tot);
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
    <title>Invoice - Macro Store Computer</title>
</head>

<body style="margin-top: -80px; font-size:14px;">
    <section id="hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <!-- DATA PESANAN -->
                    <div class="card pt-3 px-4 pb-4 border-0 shadow-1 rounded-16 mt-2">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>LOGo Macro Store Computer</h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <h6>INVOICE</h6>
                                <span class="text-green fw-500"><?= $kode_pesanan ?></span>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <span class="fw-500 d-block">DITERBITKAN ATAS NAMA</span>
                                <span>Penjual : <span class="fw-500">Macro Store Computer</span></span>
                            </div>
                            <div class="col-md-6">
                                <span class="fw-500">UNTUK</span>
                                <dl class="row">
                                    <dt class="col-sm-5 fw-500">Pembeli</dt>
                                    <dd class="col-sm-7"><?= $pesanan["penerima"] ?></dd>

                                    <dt class="col-sm-5 fw-500">Tanggal Pembelian</dt>
                                    <dd class="col-sm-7"><?= $pesanan["tgl_pesanan"] ?></dd>

                                    <dt class="col-sm-5 fw-500">Alamat</dt>
                                    <dd class="col-sm-7"><?= $pesanan["alamat_lengkap"] ?></dd>

                                </dl>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table border">
                                <tr>
                                    <th class="fs-12">INFO PRODUK</th>
                                    <th class="fs-12">JUMLAH</th>
                                    <th class="fs-12">HARGA SATUAN</th>
                                    <th class="fs-12">TOTAL HARGA</th>
                                </tr>
                                <?php foreach ($get_prod as $item) : ?>
                                    <tr>
                                        <td><?= $item["nama_produk"] ?></td>
                                        <td>1</td>
                                        <td>Rp<?= formatKeRupiah($item["harga"]) ?></td>
                                        <!-- DIAKALIN DULU -->
                                        <td>Rp<?= formatKeRupiah($item["harga"]) ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </table>
                        </div>
                        <div class="row justify-content-start justify-content-md-end border-bottom py-3">
                            <div class="col-12 col-md-6">
                                <div class="d-flex justify-content-between">
                                    <span>Total Harga (<?= $qty[0]["total"] ?> barang)</span>
                                    <span>Rp<?= formatKeRupiah($tott[0]['total']) ?></span>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <span>Biaya Ongkos Kirim</span>
                                    <span>Rp<?= formatKeRupiah($pesanan["ongkir"]) ?></span>
                                </div>
                                <div class="d-flex justify-content-between fw-500 mt-1">
                                    <span>Total Tagihan</span>
                                    <span>Rp<?= formatKeRupiah($pesanan["total_harga_belanja"]) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <span>Kurir:</span>
                                <span class="fw-500 d-block">JNE Reguler</span>
                            </div>
                            <div class="col-md-6">
                                <span>Metode Pembayaran:</span>
                                <span class="fw-500 d-block">Transfer Bank</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="asset/js/bootstrap.js"></script>
    <script src="asset/js/script.js"></script>
</body>

</html>