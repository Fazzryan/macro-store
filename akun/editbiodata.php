<?php
session_start();
include "../db/koneksi.php";
include "../fungsi.php";

if (empty($_SESSION["username"]) || empty($_SESSION["email"]) || empty($_SESSION["password"])) {
    header("Location: ../index.php");
}
// untuk keranjang dinavbar
$user = !empty($_SESSION["id_user"]) ? $_SESSION["id_user"] : "";
$username = !empty($_SESSION["username"]) ? $_SESSION["username"] : "";

$id_user = $_GET["id_user"];

$data_user = show("SELECT * FROM user WHERE id_user = '$id_user'");
if ($data_user[0]["picture"]) {
    $picture = "../userPicture/" . $data_user[0]["picture"];
} else {
    $picture = "../asset/img/profile_default.png";
}
if (isset($_POST["simpan"])) {
    // var_dump($_POST);
    // die;
    if (updateUser($_POST) > 0) {
        echo "
        <script>
            alert('Data berhasil diupdate');
            window.location.href='setting.php';
        </script>
    ";
    } else {
        echo "
        <script>
            alert('Gagal update');
            // window.location.href='setting.php';
        </script>
    ";
    }
    // var_dump($_POST);
    // die;
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
    <title>Setting - Macro Store Computer</title>
</head>

<body class="">

    <?php include "navbar.php" ?>

    <section id="hero" class="pb-5">
        <div class="container mb-3">
            <div class="row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Akun</li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Biodata Diri</li>
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
                    <div class="card py-3 px-4 border-0 shadow-1 rounded-16 mb-3">
                        <h4>Edit Biodata Diri</h4>
                        <form action="" method="post" enctype="multipart/form-data" class="mt-3">
                            <!-- Id User -->
                            <input type="hidden" name="id_user" value="<?= $id_user ?>">

                            <div class="row align-items-center mb-3">
                                <div class="col-4 col-lg-3 fw-500">Username</div>
                                <div class="col-8 col-lg-9">
                                    <input type="text" name="username" class="form-control" value="<?= $data_user[0]['username'] ?>" required>
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-4 col-lg-3 fw-500">Tanggal Lahir</div>
                                <div class="col-8 col-lg-9">
                                    <input type="date" name="tanggal_lahir" class="form-control" required value="<?php $tgl = $data_user[0]["tanggal_lahir"] ? $data_user[0]["tanggal_lahir"] : "";
                                                                                                                    echo $tgl ?>">
                                </div>
                            </div>
                            <div class=" row align-items-center mb-3">
                                <div class="col-4 col-lg-3 fw-500">Jenis kelamin</div>
                                <div class="col-8 col-lg-9">
                                    <select name="jenis_kelamin" class="form-select" required>
                                        <option value="<?= $data_user[0]["jenis_kelamin"] ?>"><?= $data_user[0]["jenis_kelamin"] ?></option>
                                        <option value="Pria">Pria</option>
                                        <option value="Wanita">Wanita</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-4 col-lg-3 fw-500">Email</div>
                                <div class="col-8 col-lg-9">
                                    <input type="email" name="email" class="form-control" value="<?= $data_user[0]['email'] ?>" required>
                                </div>
                            </div>
                            <div class="row align-items-center mb-4">
                                <div class="col-4 col-lg-3 fw-500">Nomor HP</div>
                                <div class="col-8 col-lg-9">
                                    <input type="text" name="nomorhp" class="form-control" autocomplete="off" placeholder="082xxx" maxlength="15" required value="<?php $nohp = $data_user[0]["nomorhp"] ? $data_user[0]["nomorhp"] : "";
                                                                                                                                                                    echo $nohp ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4 col-lg-3 fw-500">Foto</div>
                                <div class="col-8 col-lg-9">
                                    <img src="<?= $picture ?>" alt="profile" class="w-25" style="border-radius: 6px; aspect-ratio: auto;">
                                    <input type="hidden" name="gambar_sekarang" value="<?= $data_user[0]['picture'] ?>">
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-4 col-lg-3 fw-500">Foto Baru</div>
                                <div class="col-8 col-lg-9">
                                    <input type="file" name="gambar_baru" class="form-control">
                                </div>
                            </div>
                            <button type="submit" name="simpan" class="btn btn-green fw-500 fs-15">Simpan</button>
                            <a href="setting.php" class="btn btn-gray border fw-500 fs-15 ms-1">Batal</a>
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