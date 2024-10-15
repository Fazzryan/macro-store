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

$alamat = show("SELECT * FROM alamat WHERE id_user = '$user'");

if (isset($_POST["hapus_alamat"])) {
    if (deleteAlamat($_POST) > 0) {
        echo "
            <script>
                alert('Alamat berhasil dihapus');
                window.location.href='alamat.php'
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Alamat gagal dihapus');
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
                            <div class="col-6">
                                <h4>Alamat</h4>
                            </div>
                            <div class="col-6 text-end ">
                                <a href="tambahalamat.php" class="btn btn-green fs-15 fw-500">Tambah Alamat</a>
                            </div>
                        </div>
                        <?php if ($alamat) : ?>
                            <div class="row row-cols-1 row-cols-lg-2 g-2 g-lg-3">
                                <?php foreach ($alamat as $item) : ?>
                                    <div class="col">
                                        <div class="card rounded-16 p-1 <?php if ($item['is_aktif'] == 1) {
                                                                            echo 'border-success';
                                                                        } ?>">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <h6 class="card-subtitle text-muted"><?= $item["label_alamat"] ?></h6>
                                                    <?php if ($item["is_aktif"] == 0) : ?>
                                                        <a href="ubah_alamat_aktif.php?id_alamat=<?= $item['id_alamat'] ?>&id_user=<?= $user ?>" class="fs-14 text-black">Jadikan Alamat Aktif</a>
                                                    <?php else : ?>
                                                        <span class="text-green fw-500 fs-14">Alamat Aktif</span>
                                                    <?php endif ?>
                                                </div>
                                                <h5 class="card-title"><?= $item["penerima"] ?></h5>
                                                <span class="card-subtitle"><?= $item["nohp_penerima"] ?></span>
                                                <p class="card-text"><?= $item["alamat_lengkap"] ?> (<?= $item["catatan"] ?>)</p>
                                                <a href="editalamat.php?id_alamat=<?= $item['id_alamat'] ?>" class="btn btn-green fs-14 fw-500 me-1">Edit Alamat</a>
                                                <form action="" method="post" class="d-inline">
                                                    <input type="hidden" name="id_alamat" value="<?= $item['id_alamat'] ?>">
                                                    <input type="hidden" name="id_user" value="<?= $user ?>">
                                                    <button type="submit" name="hapus_alamat" class="btn btn-gray fs-14 fw-500 border" onclick="return confirm('Yakin hapus alamat?')">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        <?php else : ?>
                            <div class="row row-cols-1 g-2 g-lg-3 justify-content-center mt-3">
                                <div class="col text-center address">
                                    <img src="../asset/img/address.svg" alt="icon">
                                    <h5 class="mt-4">Oh tidak! Alamat pengiriman Anda masih kosong</h5>
                                    <p>Segera tambahkan alamat agar kami dapat mengantarkan pesanan Anda dengan sukses.</p>
                                </div>
                            </div>
                        <?php endif ?>
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