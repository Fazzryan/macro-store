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

$id_alamat = $_GET["id_alamat"];
$alamat = show("SELECT * FROM alamat WHERE id_alamat = '$id_alamat'");

if (isset($_POST["edit_alamat"])) {
    if (editAlamat($_POST) > 0) {
        echo "
            <script>
                alert('Alamat berhasil diubah');
                window.location.href='alamat.php'
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Alamat gagal diubah');
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
    <title>Alamat - Macro Store Computer</title>
</head>

<body>

    <?php include "navbar.php" ?>

    <section id="hero">
        <div class="container mb-3">
            <div class="row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Akun</li>
                        <li class="breadcrumb-item active" aria-current="page">Biodata Diri</li>
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
                        <div class="row mb-3 justify-content-between align-items-center">
                            <div class="col-8">
                                <h4>Tambah Alamat</h4>
                            </div>
                            <div class="col-4 text-end ">
                                <a href="alamat.php" class="btn btn-gray fw-500">Kembali</a>
                            </div>
                        </div>
                        <form action="" method="post">
                            <div class="row row-cols-1 row-cols-lg-2 g-2 g-lg-3 mb-3">
                                <input type="hidden" name="id_alamat" value="<?= $alamat[0]['id_alamat'] ?>">
                                <input type="hidden" name="id_user" value="<?= $user ?>">
                                <div class="col">
                                    <label for="label_alamat" class="fw-500 mb-2">Label Alamat</label>
                                    <input type="text" name="label_alamat" id="label_alamat" class="form-control" maxlength="20" required autocomplete="off" value="<?= $alamat[0]['label_alamat'] ?>">
                                </div>
                                <div class="col">
                                    <label for="catatan" class="fw-500 mb-2">Catatan untuk kurir (opsional)</label>
                                    <input type="text" name="catatan" id="catatan" class="form-control" maxlength="60" autocomplete="off" value="<?= $alamat[0]['catatan'] ?>">
                                    <small class="fw-500 fs-13 text-gray">Warna rumah, patokan, pesan khusus, dll.</small>
                                </div>
                            </div>
                            <div class="row row-cols-1 g-2 g-lg-3 mb-3">
                                <div class="col">
                                    <label for="alamat_lengkap" class="fw-500 mb-2">Alamat Lengkap</label>
                                    <textarea name="alamat_lengkap" class="form-control" id="alamat_lengkap" cols="30" rows="10" autocomplete="off" maxlength="200" required><?= $alamat[0]['alamat_lengkap'] ?></textarea>
                                </div>
                            </div>
                            <div class="row row-cols-1 row-cols-lg-2 g-2 g-lg-3 mb-3">
                                <div class="col">
                                    <label for="penerima" class="fw-500 mb-2">Nama Penerima</label>
                                    <input type="text" name="penerima" id="penerima" class="form-control" maxlength="30" autocomplete="off" required value="<?= $alamat[0]['penerima'] ?>">
                                </div>
                                <div class="col">
                                    <label for="nohp_penerima" class="fw-500 mb-1">Nomor HP</label>
                                    <input type="number" name="nohp_penerima" id="nohp_penerima" class="form-control" autocomplete="off" required value="<?= $alamat[0]['nohp_penerima'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <button type="submit" name="edit_alamat" class="btn btn-green fw-500 fs-14 w-100 d-lg-none d-block">Simpan</button>
                                    <button type="submit" name="edit_alamat" class="btn btn-green fw-500 fs-14 w-50 d-none d-lg-inline">Simpan</button>
                                </div>
                            </div>
                        </form>
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