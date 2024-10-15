<?php
session_start();
include "../../db/koneksi.php";
include "../../fungsi.php";

if (empty($_SESSION["username"]) || empty($_SESSION["password"])) {
    header("Location: ../../otentikasi/login.php");
    exit();
} else if ($_SESSION["role"] != 'admin') {
    header("Location: ../../produk.php");
    exit();
}
$username = $_SESSION["username"];

if (isset($_POST["tambah"])) {
    if (addKategori($_POST) > 0) {
        echo "
        <script>
            alert('Kategori berhasil ditambahkan');
            window.location.href='Kategori.php';
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
    <title>Tambah Kategori - Macro Store Computer</title>
</head>

<body class="bg-white">

    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="">
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
                            <h3> Tambah Kategori</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item">Kategori</li>
                                    <li class="breadcrumb-item active" aria-current="page">Tambah Kategori</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-12 col-md-6 text-end">
                            <a href="Kategori.php" class="btn btn-gray fw-500 fs-15">Kembali ke Kategori</a>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 col-md-6">
                            <div class="card p-3 p-lg-4 p-2 border-1 shadow-1 rounded-16 mb-3">
                                <form action="" method="post">
                                    <div class=" mb-3">
                                        <label for="nama_kategori" class="form-label fw-500">Nama Kategori</label>
                                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required autocomplete="off" autofocus>
                                    </div>
                                    <div class=" mb-3">
                                        <label for="icon_kategori" class="form-label fw-500">Icon Kategori</label>
                                        <input type="text" class="form-control" id="icon_kategori" name="icon_kategori" required autocomplete="off" autofocus>
                                        <div class="mt-2 fs-14" style="font-style:italic;">Gunakan <a href="https://icons.getbootstrap.com/https://icons.getbootstrap.com/" class="text-primary">Bootstrap Icon.</a></div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" name="tambah" class="btn btn-green">Tambah Kategori</button>
                                    </div>
                                </form>
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