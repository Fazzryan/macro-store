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

if (isset($_POST["tambah_admin"])) {
    if (addAdmin($_POST) > 0) {
        echo "
        <script>
            alert('Admin baru berhasil ditambahkan');
            window.location.href='Admin.php';
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
    <title>Tambah Admin - Macro Store Computer</title>
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
                            <h3> Tambah Admin</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item">Admin</li>
                                    <li class="breadcrumb-item active" aria-current="page">Tambah Admin</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-12 col-md-6 text-end">
                            <a href="Admin.php" class="btn btn-gray fw-500 fs-15">Kembali ke Admin</a>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <form action="" method="post">
                                <div class="card p-3 p-lg-4 p-2 border-1 shadow-1 rounded-16 mb-3">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="username" class="form-label fw-500">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" required autocomplete="off" autofocus placeholder="username">
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label fw-500">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" required autocomplete="off" placeholder="email">
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label fw-500">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" required autocomplete="off" placeholder="password">
                                            </div>
                                            <div class="mb-3">
                                                <label for="konfirmasi_password" class="form-label fw-500">Konfirmasi Password</label>
                                                <input type="password" class="form-control" name="konfir_password" placeholder="konfirmasi password" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="tanggal_lahir" class="form-label fw-500">Tanggal Lahir</label>
                                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required autocomplete="off">
                                            </div>
                                            <div class="mb-3">
                                                <label for="jenis_kelamin" class="form-label fw-500">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" class="form-select" required>
                                                    <option value="Pria">Pria</option>
                                                    <option value="Wanita">Wanita</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nomorhp" class="form-label fw-500">Nomor HP</label>
                                                <input type="number" name="nomorhp" class="form-control" autocomplete="off" placeholder="082xxx" maxlength="15" required ">
                                            </div>
                                            <div class=" mb-3">
                                                <label for="role" class="form-label fw-500">Role</label>
                                                <input type="text" name="role" class="form-control" required value="admin" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" mt-3">
                                        <button type="submit" name="tambah_admin" class="btn btn-green fw-500 fs-15">Tambah Admin</button>
                                    </div>
                                </div>
                            </form>
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