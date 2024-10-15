<?php
include "../fungsi.php";
include "../db/koneksi.php";
session_start();

if (empty($_SESSION["username"]) || empty($_SESSION["password"])) {
    header("Location: ../otentikasi/login.php");
    exit();
} else if ($_SESSION["role"] != 'admin') {
    header("Location: ../produk.php");
    exit();
}
$username = $_SESSION["username"];

$total_produk = show("SELECT COUNT(*) AS total FROM produk");
$total_kategori = show("SELECT COUNT(*) AS total FROM kategori");
$pesanan = show("SELECT COUNT(*) AS total FROM pesanan");
$pelanggan = show("SELECT COUNT(*) AS total FROM user WHERE role != 'admin'");
$akun_admin = show("SELECT COUNT(*) AS total FROM user WHERE role != 'user'");



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
    <title>Dashboard - Macro Store Computer</title>
</head>

<body class="bg-white">
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="">
            <!-- <hr class="text-secondary"> -->
            <ul class="navbar-nav">
                <div class="side-header">
                    <a href="../index.php" class="fs-20 fw-500">Macro Store Computer</a>
                    <button type="button" class="btn-close d-xl-none" aria-label="Close"></button>
                </div>
                <li class="nav-item">
                    <a href="../" class="side-link on"><i class="bi bi-house me-2"></i> Dashboard</a>
                </li>
                <li class="nav-item my-3 ps-3">
                    <span class="nav-label">STORE MANAGEMENTS</span>
                </li>
                <li class="nav-item">
                    <a href="produk/Produk.php" class="side-link"><i class="bi bi-cart me-2"></i> Produk</a>
                </li>
                <li class="nav-item">
                    <a href="kategori/Kategori.php" class="side-link"><i class="bi bi-list-ul me-2"></i> Kategori</a>
                </li>
                <li class="nav-item">
                    <a href="pesanan/Pesanan.php" class="side-link"><i class="bi bi-bag me-2"></i> Pesanan</a>
                </li>
                <li class="nav-item">
                    <a class="side-link <?php echo basename($_SERVER['PHP_SELF']) == 'pesananMasuk.php' ? 'on' : ''; ?>" href="pesanan/pesananMasuk.php">
                        <i class="bi bi-arrow-return-right me-2"></i>
                        Pesanan Masuk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="side-link <?php echo basename($_SERVER['PHP_SELF']) == 'pesananDikonfirmasi.php' ? 'on' : ''; ?>" href="pesanan/pesananDikonfirmasi.php">
                        <i class="bi bi-arrow-return-right me-2"></i>
                        Pesanan Dikonfirmasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="side-link <?php echo basename($_SERVER['PHP_SELF']) == 'pesananDikemas.php' ? 'on' : ''; ?>" href="pesanan/pesananDikemas.php">
                        <i class="bi bi-arrow-return-right me-2"></i>
                        Pesanan Dikemas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="side-link <?php echo basename($_SERVER['PHP_SELF']) == 'pesananDikirim.php' ? 'on' : ''; ?>" href="pesanan/pesananDikirim.php">
                        <i class="bi bi-arrow-return-right me-2"></i>
                        Pesanan Dalam Pengiriman
                    </a>
                </li>
                <li class="nav-item">
                    <a class="side-link <?php echo basename($_SERVER['PHP_SELF']) == 'pesananSelesai.php' ? 'on' : ''; ?>" href="pesanan/pesananSelesai.php">
                        <i class="bi bi-arrow-return-right me-2"></i>
                        Pesanan Selesai
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pelanggan/Pelanggan.php" class="side-link"><i class="bi bi-people me-2"></i> Pelanggan</a>
                </li>
                <li class="nav-item my-3 ps-3">
                    <span class="nav-label">ACCOUNT</span>
                </li>
                <li class="nav-item">
                    <a href="akun/Admin.php" class="side-link <?php echo basename($_SERVER['PHP_SELF']) == 'Admin.php' || basename($_SERVER['PHP_SELF']) == 'tambahAdmin.php' || basename($_SERVER['PHP_SELF']) == 'editAdmin.php' ? 'on' : ''; ?>"><i class="bi bi-person-gear me-2"></i> Admin</a>
                </li>
                <!-- 
    <li class="nav-item">
        <a href="#" class="side-link"><i class="bi bi-images me-2"></i> Media</a>
    </li>
    <li class="nav-item">
        <a href="#" class="side-link"><i class="bi bi-gear me-2"></i> Pengaturan Toko</a>
    </li> -->
            </ul>
        </nav>

        </nav>

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar content-header">
                <div class="container-fluid px-4">
                    <button type="button" id="sidebarCollapse" class="btn btn-gray d-xl-none">
                        <span>
                            <i class="bi bi-list"></i>
                        </span>
                    </button>
                    <div class="dropdown">
                        <a class="btn btn-gray dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- <img src="<?= $picture ?>" alt="pic" width="20" style="mix-blend-mode: multiply; border-radius: 50px;"> -->
                            <span>Selamat datang <?= $username ?></span>
                        </a>
                        <ul class="dropdown-menu shadow-1 border rounded-8 mt-2" aria-labelledby="dropdownMenuLink">
                            <li>
                                <a class="dropdown-item fw-500" href="../produk.php" target="_blank">
                                    <i class="bi bi-house me-1"></i> Home
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item fw-500" href="akun/setting.php">
                                    <i class="bi bi-person me-1"></i> Akun
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item fw-500" href="../otentikasi/logout.php"><i class="bi bi-box-arrow-right me-1 "></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="content-body">
                <div class="container-fluid">
                    <div class="row mb-4">
                        <div class="col-12">
                            <!-- <img src="../asset/img/laptop-baner.jpg" class="w-100" alt="baner"> -->
                            <div class="card bg-light border-0 rounded-16" style="background-image: url(../asset/img/laptop-baner.jpg); background-repeat: no-repeat; background-size: cover; background-position: right">
                                <div class="card-body p-lg-5">
                                    <h1>Selamat Datang! Macro Store Computer</h1>
                                    <p>Makro Store Computer menawarkan berbagai pilihan laptop berkualitas untuk Anda.</p>
                                    <a href="produk/tambahProduk.php" class="btn btn-green fs-15 fw-500">Tambah Produk</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 col-xl-4">
                            <a href="produk/Produk.php" class="dashb-card">
                                <div class="card shadow-1 rounded-16">
                                    <div class="card-body px-4 pb-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">PRODUK</h5>
                                            <div class="d-flex justify-content-center align-items-center text-center bg-primary bg-gradient text-white rounded-circle" style="width: 2.5rem; height:2.5rem;">
                                                <i class="bi bi-cart"></i>
                                            </div>
                                        </div>
                                        <h2><?= $total_produk[0]["total"] ?></h2>
                                        <p class="fw-500 fs-14 text-muted"><i class="bi bi-arrow-up"></i> Jumlah produk yang tersedia</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <a href="pesanan/Pesanan.php" class="dashb-card">
                                <div class="card shadow-1 rounded-16">
                                    <div class="card-body px-4 pb-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">PESANAN</h5>
                                            <div class="d-flex justify-content-center align-items-center text-center bg-success bg-gradient text-white rounded-circle" style="width: 2.5rem; height:2.5rem;">
                                                <i class="bi bi-bar-chart-fill"></i>
                                            </div>
                                        </div>
                                        <h2><?= $pesanan[0]["total"] ?></h2>
                                        <p class="fw-500 fs-14 text-muted"><i class="bi bi-arrow-up"></i> Jumlah pesanan yang diterima</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- KATEGORI -->
                        <div class="col-md-6 col-xl-4">
                            <a href="kategori/Kategori.php" class="dashb-card">
                                <div class="card shadow-1 rounded-16">
                                    <div class="card-body px-4 pb-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title ">KATEGORI</h5>
                                            <div class="d-flex justify-content-center align-items-center text-center bg-secondary text-white bg-gradient rounded-circle" style="width: 2.5rem; height:2.5rem;">
                                                <i class="bi bi-list-ul"></i>
                                            </div>
                                        </div>
                                        <h2><?= $total_kategori[0]["total"] ?></h2>
                                        <p class="fw-500 fs-14 text-muted"><i class="bi bi-arrow-up"></i> Jumlah kategori yang tersedia</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- PELANGGAN -->
                        <div class="col-md-6 col-xl-4">
                            <a href="pelanggan/Pelanggan.php" class="dashb-card">
                                <div class="card shadow-1 rounded-16">
                                    <div class="card-body px-4 pb-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title ">PELANGGAN</h5>
                                            <div class="d-flex justify-content-center align-items-center text-center bg-info text-white bg-gradient rounded-circle" style="width: 2.5rem; height:2.5rem;">
                                                <i class="bi bi-people"></i>
                                            </div>
                                        </div>
                                        <h2><?= $pelanggan[0]["total"] ?></h2>
                                        <p class="fw-500 fs-14 text-muted"><i class="bi bi-arrow-up"></i> Pelanggan yang terdaftar</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- ADMIN -->
                        <div class="col-md-6 col-xl-4">
                            <a href="akun/Admin.php" class="dashb-card">
                                <div class="card shadow-1 rounded-16">
                                    <div class="card-body px-4 pb-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title ">ADMIN</h5>
                                            <div class="d-flex justify-content-center align-items-center text-center bg-danger text-white bg-gradient rounded-circle" style="width: 2.5rem; height:2.5rem;">
                                                <i class="bi bi-person-gear"></i>
                                            </div>
                                        </div>
                                        <h2><?= $akun_admin[0]["total"] ?></h2>
                                        <p class="fw-500 fs-14 text-muted"><i class="bi bi-arrow-up"></i> Jumlah yang terdaftar</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="../asset/js/bootstrap.js"></script>
    <script src="../asset/js/script.js"></script>
</body>

</html>