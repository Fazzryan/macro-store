<?php
include "../../fungsi.php";
session_start();

if (empty($_SESSION["username"]) || empty($_SESSION["password"])) {
    header("Location: ../../otentikasi/login.php");
    exit();
} else if ($_SESSION["role"] != 'admin') {
    header("Location: ../../produk.php");
    exit();
}
$username = $_SESSION["username"];

$slug = $_GET["slug"];
$kategori = show("SELECT * FROM kategori");
$produk = show("SELECT * FROM produk LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori WHERE slug = '$slug'");

// var_dump($produk);
// die;

if (isset($_POST["edit"])) {
    if (editProduk($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil diupdate');
                window.location.href='Produk.php';
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
    <!-- CK Editor -->
    <script src="../../asset/library/ckeditor/ckeditor.js"></script>
    <title>Edit Produk - Dokter Komputer</title>
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
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h3>Edit Produk</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item" aria-current="page"><a href="#">Produk</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Produk</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-12 col-md-6 text-end">
                            <a href="Produk.php" class="btn btn-gray fw-500">Kembali ke Produk</a>
                        </div>
                    </div>

                    <form action="" method="post" enctype="multipart/form-data">
                        <!-- Id Produk -->
                        <input type="hidden" name="id_produk" value="<?= $produk[0]['id_produk'] ?>">
                        <div class="row mt-3 mt-md-4">
                            <div class="col-12 col-lg-12">
                                <div class="card p-2 p-md-3 border-0 shadow-1 rounded-16">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <!-- Nama Produk -->
                                            <div class="mb-3">
                                                <label for="nama_produk" class="form-label fw-500">Nama Produk</label>
                                                <input type="text" class="form-control" id="nama_produk" name="nama_produk" required autocomplete="off" value="<?= $produk[0]['nama_produk'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <!-- Slug -->
                                            <div class="mb-3">
                                                <label for="slug" class="form-label fw-500">Slug</label>
                                                <input type="text" class="form-control" id="slug" name="slug" required readonly autocomplete="off" value="<?= $produk[0]["slug"] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <!-- Kategori -->
                                            <div class="mb-3">
                                                <label for="kategori" class="form-label fw-500">Kategori</label>
                                                <select name="id_kategori" class="form-select" required>
                                                    <option value="" disabled>Pilih Kategori</option>
                                                    <option value="<?= $produk[0]["id_kategori"] ?>"><?= $produk[0]["nama_kategori"] ?></option>
                                                    <?php foreach ($kategori as $item) : ?>
                                                        <option value="<?= $item['id_kategori'] ?>"><?= $item["nama_kategori"] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <!-- Stok -->
                                            <div class="mb-3">
                                                <label for="stok" class="form-label fw-500">Stok Produk</label>
                                                <input type="number" class="form-control" id="stok" name="stok" required placeholder="Rp. " autocomplete="off" value="<?= $produk[0]["stok"] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <!-- Kondisi Produk -->
                                            <div class="mb-3">
                                                <label for="kondisi" class="form-label fw-500">Kondisi Produk</label>
                                                <select name="kondisi" class="form-select" required>
                                                    <option value="<?= $produk[0]["kondisi"] ?>"><?= $produk[0]["kondisi"] ?></option>
                                                    <option value="" disabled>Pilih Kondisi Produk</option>
                                                    <option value="Baru">Baru</option>
                                                    <option value="Bekas">Bekas</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="harga" class="form-label fw-500">Harga</label>
                                                <input type="text" class="form-control" id="harga" name="harga" required placeholder="Rp. " autocomplete="off" value="<?= $produk[0]["harga"] ?>">
                                            </div>
                                        </div>
                                        <!-- Gambar Lama-->
                                        <div class="mb-3">
                                            <label for="gambar" class="form-label fw-500 d-block">Gambar Produk Lama</label>
                                            <img src="../../fileUpload/<?= $produk[0]['gambar'] ?>" alt="Gambar Produk" width="300">
                                            <input type="hidden" value="/<?= $produk[0]['gambar'] ?>" name="gambar_lama">
                                        </div>
                                        <!-- Gambar -->
                                        <div class="mb-3">
                                            <label for="gambar" class="form-label fw-500">Gambar Produk Baru</label>
                                            <input type="file" class="dropzone" id="gambar" name="gambar">
                                        </div>
                                        <!-- Deskripsi -->
                                        <div class="mb-3">
                                            <label for="deskripsi" class="form-label fw-500">Deskripsi Produk</label>
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?= $produk[0]["deskripsi"] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="w-25">
                                        <div class="my-3">
                                            <button type="submit" name="edit" class="btn btn-green w-100">Edit Produk</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../../asset/js/bootstrap.js"></script>
    <script src="../../asset/js/script.js"></script>
    <script>
        CKEDITOR.replace('deskripsi');

        let namaProduk = document.getElementById("nama_produk");
        let slug = document.getElementById("slug");
        namaProduk.addEventListener("keyup", function() {
            let nilaiInput = namaProduk.value;
            nilaiInput = nilaiInput.replace(/\s+/g, '-').toLowerCase();
            slug.value = nilaiInput;
        });

        function formatRupiah(angka) {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }

        // let harga = document.getElementById("harga");
        //  harga sekarang
        // harga.value = formatRupiah(harga.value);
        // harga.addEventListener("keyup", function() {
        //     harga.value = formatRupiah(this.value);
        // });
    </script>
</body>

</html>