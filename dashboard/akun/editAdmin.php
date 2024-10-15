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
$id_user = $_GET["id_user"];
$admin = show("SELECT * FROM user WHERE id_user = '$id_user'");

if (isset($_POST["edit_admin"])) {
    // var_dump($_POST);
    // die;
    if (updateAdmin($_POST) > 0) {
        echo "
        <script>
            alert('Data admin berhasil diedit!');
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
    <title>Edit Admin - Macro Store Computer</title>
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
                            <h3>Edit Admin</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item">Admin</li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Admin</li>
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
                                            <input type="hidden" name="id_user" value="<?= $admin[0]['id_user'] ?>">
                                            <div class="mb-3">
                                                <label for="username" class="form-label fw-500">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" required autocomplete="off" value="<?= $admin[0]['username'] ?>" placeholder="username">
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label fw-500">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" required autocomplete="off" value="<?= $admin[0]['email'] ?>" placeholder="email">
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label fw-500">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" required autocomplete="off" value="<?= $admin[0]['password'] ?>" placeholder="password">
                                            </div>
                                            <div class="mb-3">
                                                <label for="password_baru" class="form-label fw-500">Password Baru</label>
                                                <input type="password" class="form-control" name="password_baru" placeholder="password baru">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="tanggal_lahir" class="form-label fw-500">Tanggal Lahir</label>
                                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required autocomplete="off" value="<?= $admin[0]['tanggal_lahir'] ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="jenis_kelamin" class="form-label fw-500">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" class="form-select" required>
                                                    <option value="<?= $admin[0]['jenis_kelamin'] ?>"><?= $admin[0]['jenis_kelamin'] ?></option>
                                                    <option value="Pria">Pria</option>
                                                    <option value="Wanita">Wanita</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nomorhp" class="form-label fw-500">Nomor HP</label>
                                                <input type="number" name="nomorhp" class="form-control" autocomplete="off" value="<?= $admin[0]['nomorhp'] ?>" placeholder="082xxx" maxlength="15" required ">
                                            </div>
                                            <div class=" mb-3">
                                                <label for="role" class="form-label fw-500">Role</label>
                                                <input type="text" name="role" class="form-control" required value="admin" readonly value="<?= $admin[0]['role'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" mt-3">
                                        <button type="submit" name="edit_admin" class="btn btn-green fw-500 fs-15">Edit Admin</button>
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