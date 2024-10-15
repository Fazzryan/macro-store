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
$data_user = mysqli_query($koneksi, "SELECT * FROM user WHERE username <> 'Admin' OR username <> 'admin'");

$jumlah_data = mysqli_num_rows($data_user);
$total_halaman = ceil($jumlah_data / $batas_halaman);
$nomor = $halaman_awal + 1;

$user = show("SELECT * FROM user WHERE role = 'admin' LIMIT $halaman_awal, $batas_halaman");
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
    <title>Admin - Macro Store Computer</title>
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
                            <h3>Admin</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Admin</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-12 col-md-6 text-end">
                            <a href="tambahAdmin.php" class="btn btn-green fw-500 fs-15">Tambah Admin</a>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card h-100 p-lg-4 p-2 border-1 shadow-1 rounded-16 mb-3">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover fs-15 border-bottom">
                                        <tr class="table-light border-bottom">
                                            <th class="fw-500 text-dark py-3">No</th>
                                            <th class="fw-500 text-dark py-3">Username</th>
                                            <th class="fw-500 text-dark py-3">Email</th>
                                            <th class="fw-500 text-dark py-3">Tanggal Lahir</th>
                                            <th class="fw-500 text-dark py-3">No. HP</th>
                                            <th class="fw-500 text-dark py-3">Role</th>
                                            <th class="fw-500 text-dark py-3">Aksi</th>
                                        </tr>
                                        <?php foreach ($user as $item) : ?>
                                            <tr>
                                                <td scope="row"><?= $nomor  ?></td>
                                                <td><?= $item["username"] ?></td>
                                                <td><?= $item["email"] ?></td>
                                                <td><?php echo empty($item["tanggal_lahir"]) ? '-' : $item["tanggal_lahir"] ?></td>
                                                <td><?php echo empty($item["nomorhp"]) ? '-' : $item["nomorhp"] ?></td>
                                                <td><?= $item["role"] ?></td>
                                                <td>
                                                    <a href="editAdmin.php?id_user=<?= $item["id_user"] ?>" class="btn btn-gray"><i class="bi bi-pencil"></i></a>
                                                    <!-- <a href="hapus.php?id_user=<?= $item["id_user"] ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-gray"><i class="bi bi-trash"></i></a> -->
                                                </td>
                                            </tr>
                                            <?php $nomor++ ?>
                                        <?php endforeach ?>
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
                                                    <li class="page-item  <?php if ($halaman == $i) {
                                                                                echo "active";
                                                                            } ?>">
                                                        <a class="page-link fw-500 fs-15" href="?halaman=<?= $i ?>"><?= $i ?></a>
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