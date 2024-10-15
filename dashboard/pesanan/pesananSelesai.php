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

// Pagination
$batas_halaman = 10;
$halaman = isset($_GET["halaman"]) ? (int) $_GET["halaman"] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas_halaman) - $batas_halaman : 0;

$sebelumnya = $halaman - 1;
$selanjutnya = $halaman + 1;
$data_pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan LEFT JOIN user ON pesanan.id_user = user.id_user WHERE status = 'Selesai' ORDER BY id_pesanan DESC");

$jumlah_data = mysqli_num_rows($data_pesanan);
$total_halaman = ceil($jumlah_data / $batas_halaman);
$nomor = $halaman_awal + 1;

$pesanan = show("SELECT * FROM pesanan LEFT JOIN user ON pesanan.id_user = user.id_user WHERE status = 'Selesai' ORDER BY id_pesanan DESC LIMIT $halaman_awal, $batas_halaman");
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
    <title>Pesanan Selesai - Macro Store Computer</title>
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
                            <h3>Pesanan Selesai</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Dashboard</li>
                                    <li class="breadcrumb-item">Pesanan</li>
                                    <li class="breadcrumb-item active" aria-current="page">Pesanan Selesai</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card h-100 p-lg-4 p-2 border-1 shadow-1 rounded-16 mb-3">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover fs-15 border-bottom">
                                        <tr class="table-light border-bottom">
                                            <th class="fw-500 text-dark py-3">No</th>
                                            <th class="fw-500 text-dark py-3">Kode Pesanan</th>
                                            <th class="fw-500 text-dark py-3">Nama Pelanggan</th>
                                            <th class="fw-500 text-dark py-3">Tanggal</th>
                                            <th class="fw-500 text-dark py-3">Jumlah Item</th>
                                            <th class="fw-500 text-dark py-3">Total Harga</th>
                                            <th class="fw-500 text-dark py-3">Status</th>
                                            <th class="fw-500 text-dark py-3">Aksi</th>
                                        </tr>
                                        <?php if (!empty($pesanan)) : ?>
                                            <?php foreach ($pesanan as $item) : ?>
                                                <tr>
                                                    <td scope="row"><?= $nomor  ?></td>
                                                    <td><?= $item["kode_pesanan"] ?></td>
                                                    <td><?= $item["username"] ?></td>
                                                    <td><?= $item["tgl_pesanan"] ?></td>
                                                    <td><?= $item["jumlah_item"] ?></td>
                                                    <td>Rp<?= formatKeRupiah($item["total_harga_belanja"]) ?></td>
                                                    <td>
                                                        <span class="badge fw-500 p-2 fs-13
                                                            <?php
                                                            if ($item['status'] == 'Menunggu Pembayaran') {
                                                                echo 'bg-danger';
                                                            } else if ($item['status'] == 'Menunggu Konfirmasi') {
                                                                echo 'bg-info';
                                                            } else if ($item['status'] == 'Konfirmasi') {
                                                                echo 'bg-secondary';
                                                            } else if ($item['status'] == 'Dikemas') {
                                                                echo 'bg-warning';
                                                            } else if ($item['status'] == 'Dalam Pengiriman') {
                                                                echo 'bg-primary';
                                                            } else if ($item['status'] == 'Selesai') {
                                                                echo 'bg-success';
                                                            }
                                                            ?>
                                                        ">
                                                            <?= $item["status"] ?>
                                                        </span>
                                                    </td>
                                                    <td colspan="">
                                                        <a href="detailPesanan.php?kode_pesanan=<?= $item["kode_pesanan"] ?>" class="btn btn-gray"><i class="bi bi-eye"></i></a>
                                                        <a href="hapusPesanan.php?kode_pesanan=<?= $item["kode_pesanan"] ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-gray"><i class="bi bi-trash"></i></a>
                                                    </td>
                                                </tr>
                                                <?php $nomor++ ?>
                                            <?php endforeach ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="9" class="text-center py-4">Tidak ada pesanan selesai.</td>
                                            </tr>
                                        <?php endif ?>
                                    </table>
                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-end">
                                        <nav aria-label="">
                                            <ul class="pagination">
                                                <li class="page-item  <?php if ($halaman <= 1) {
                                                                            echo "disabled";
                                                                        } ?>">
                                                    <a class="page-link fw-500 fs-15" <?php if ($halaman > 1) {
                                                                                            echo "href='?halaman=$sebelumnya'";
                                                                                        } ?>>Previous</a>
                                                </li>
                                                <?php for ($i = 1; $i < $total_halaman + 1; $i++) : ?>
                                                    <li class="page-item fw-500 fs-15  <?php if ($halaman == $i) {
                                                                                            echo "active";
                                                                                        } ?>">
                                                        <a class="page-link" href="?halaman=<?= $i ?>"><?= $i ?></a>
                                                    </li>
                                                <?php endfor ?>
                                                <li class="page-item <?php if ($halaman >= $total_halaman) {
                                                                            echo "disabled";
                                                                        } ?>">
                                                    <a class="page-link fw-500 fs-15" <?php if ($halaman < $total_halaman) {
                                                                                            echo "href='?halaman=$selanjutnya'";
                                                                                        } ?>>Next</a>
                                                </li>
                                            </ul>
                                        </nav>
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
</body>

</html>