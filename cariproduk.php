<?php
session_start();
include "db/koneksi.php";
include "fungsi.php";

$url = $_SERVER["REQUEST_URI"];
$base_url = strtok($url, '?'); // Mengambil bagian URL sebelum tanda '?' (jika ada)
$urutValues = ["Tertinggi", "Terendah", "Terbaru"];

$user = !empty($_SESSION["id_user"]) ? $_SESSION["id_user"] : "";
// gambar untuk navbar
if ($user) {
    $data_user = show("SELECT * FROM user WHERE id_user = '$user'");
    if ($data_user[0]["picture"]) {
        $picture = "userPicture/" . $data_user[0]["picture"];
    } else {
        $picture = "asset/img/profile_default.png";
    }
}

$kategori = show("SELECT * FROM kategori");
$katakunci = $_GET["katakunci"];

// Pagination
$batas_halaman = 12;
$halaman = isset($_GET["halaman"]) ? (int) $_GET["halaman"] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas_halaman) - $batas_halaman : 0;

$sebelumnya = $halaman - 1;
$selanjutnya = $halaman + 1;
$data_produk = mysqli_query($koneksi, "SELECT * FROM produk LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori WHERE nama_produk LIKE '%$katakunci%'");

$jumlah_data = mysqli_num_rows($data_produk);
$total_halaman = ceil($jumlah_data / $batas_halaman);
$nomor = $halaman_awal + 1;

if (isset($_GET["urut"])) {
    $urut = $_GET["urut"];
    if ($urut == "Tertinggi") {
        $produk = show("SELECT * FROM produk LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori WHERE nama_produk LIKE '%$katakunci%' ORDER BY harga DESC LIMIT $halaman_awal, $batas_halaman");
    } else if ($urut == "Terendah") {
        $produk = show("SELECT * FROM produk LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori WHERE nama_produk LIKE '%$katakunci%' ORDER BY harga ASC LIMIT $halaman_awal, $batas_halaman");
    } else if ($urut == "Terbaru") {
        $produk = show("SELECT * FROM produk LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori WHERE nama_produk LIKE '%$katakunci%' ORDER BY id_produk DESC LIMIT $halaman_awal, $batas_halaman");
    }
} else {
    $produk = show("SELECT * FROM produk LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori  WHERE nama_produk LIKE '%$katakunci%' ORDER BY id_produk DESC LIMIT $halaman_awal, $batas_halaman");
}
$jumlah_produk = show("SELECT COUNT(*) AS jml_produk FROM produk LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori  WHERE nama_produk LIKE '%$katakunci%'");
// var_dump($jumlah_produk);
// die;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/css/bootstrap.css">
    <link rel="stylesheet" href="asset/css/style.css">
    <!-- Bs Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Produk - Dokter Komputer</title>
</head>

<body>

    <?php include "navbar.php" ?>

    <section class="produk">
        <div class="container">
            <div class="row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="produk.php">Produk</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $katakunci ?></li>
                    </ol>
                </nav>
            </div>
            <div class="row mt-4">
                <div class="col-12 col-lg-3 d-none d-lg-block">
                    <h5>Kategori</h5>
                    <div class="card p-3 border-0 shadow-1 rounded-16 mb-4">
                        <div class="d-flex flex-column">
                            <a href="produk.php" class="kategori-item">
                                <i class="bi bi-cart4"></i>
                                <span class="ms-2"">Semua Produk</span>
                            </a>
                            <?php foreach ($kategori as $item) : ?>
                                <a href=" produkberdasarkan.php?katakunci=<?= $item["nama_kategori"] ?>" class="kategori-item ">
                                    <i class="bi <?= $item['icon_kategori'] ?>"></i>
                                    <span class="ms-2"><?= $item["nama_kategori"] ?></span>
                            </a>
                        <?php endforeach ?>
                        </div>
                    </div>
                    <h5>Urut Berdasarkan</h5>
                    <div class="card p-3 border-0 shadow-1 rounded-16 mb-3">
                        <a href="<?= tambahUrutKeURL($url, 'Terbaru') ?>" class="kategori-item">
                            <i class="bi bi-bag-check"></i>
                            <span class="ms-2">Produk Terbaru</span>
                        </a>
                        <a href="<?= tambahUrutKeURL($url, 'Tertinggi') ?>" class="kategori-item">
                            <i class="bi bi-graph-down-arrow"></i>
                            <span class="ms-2">Harga Tertinggi ke Terendah</span>
                        </a>
                        <a href="<?= tambahUrutKeURL($url, 'Terendah') ?>" class="kategori-item">
                            <i class="bi bi-graph-up-arrow"></i>
                            <span class="ms-2">Harga Terendah ke Tertinggi</span>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-9">
                    <div class="card mb-4 bg-light">
                        <div class="card-body p-4 ">
                            <h2 class="mb-0">Menampilkan hasil dari "<?= $katakunci ?>"</h2>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <form action="" method="get" class="d-flex mt-2 mt-md-0">
                                <input type="text" class="form-control me-1 me-md-2" name="katakunci" id="cari_produk" maxlength="50" placeholder="Cari produk" required autocomplete="off">
                                <button type="submit" class="btn btn-green" style="border-radius: 8px;"><i class="bi bi-search"></i></button>
                            </form>
                        </div>
                        <div class="col-12 mt-3">
                            <h6 class="fs-14 text-gray">Menampilkan <span class="text-dark"><?= $jumlah_produk[0]["jml_produk"] ?></span> produk.</h6>
                        </div>
                    </div>

                    <div class="row g-2 g-md-3 row-cols-xl-4 row-cols-md-3 row-cols-2 mt-3">
                        <?php foreach ($produk as $item) : ?>
                            <div class="col-6">
                                <div class="card card-produk h-100 rounded-16">
                                    <a href="detailproduk.php?slug=<?= $item['slug'] ?>" class="mx-auto mt-3">
                                        <img src="fileUpload/<?= $item['gambar'] ?>" alt="Gambar Produk">
                                    </a>
                                    <div class="card-body h-100 mt-auto">
                                        <a href="#" class="text-secondary text-decoration-none fs-14">
                                            <?= $item["nama_kategori"] ?>
                                        </a>
                                        <h5 class="card-title fs-15 mt-2">
                                            <a href="detailproduk.php?slug=<?= $item['slug'] ?>" class="card-link fs-14">
                                                <?php if (strlen($item["nama_produk"]) >= 45) : ?>
                                                    <?= substr_replace($item["nama_produk"], '..', 45) ?>
                                                <?php else : ?>
                                                    <?= $item["nama_produk"] ?>
                                                <?php endif ?>
                                            </a>
                                        </h5>
                                        <div class="card-text fw-500 fs-15">
                                            Rp<?= formatKeRupiah($item["harga"]) ?>
                                        </div>
                                    </div>
                                    <a href="" class="btn btn-green m-3 d-none d-md-block">
                                        Tambah ke Keranjang
                                    </a>
                                    <a href="" class="btn btn-green m-3 d-block d-md-none">
                                        + Keranjang
                                    </a>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <!-- Pagination -->
                    <div class="d-flex justify-content-start mt-3">
                        <nav aria-label="">
                            <ul class="pagination">
                                <li class="page-item  <?php if ($halaman <= 1) {
                                                            echo "disabled";
                                                        } ?>">
                                    <a class="page-link" <?php if ($halaman > 1) {
                                                                echo "href='?katakunci=$katakunci&halaman=$sebelumnya'";
                                                            } ?>><i class="bi bi-chevron-left"></i></a>
                                </li>
                                <?php for ($i = 1; $i < $total_halaman + 1; $i++) : ?>
                                    <li class="page-item  <?php if ($halaman == $i) {
                                                                echo "active";
                                                            } ?>">
                                        <a class="page-link" href="?katakunci=<?= $katakunci ?>&halaman=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor ?>
                                <li class="page-item <?php if ($halaman >= $total_halaman) {
                                                            echo "disabled";
                                                        } ?>">
                                    <a class="page-link" <?php if ($halaman < $total_halaman) {
                                                                echo "href='?katakunci=$katakunci&halaman=$selanjutnya'";
                                                            } ?>><i class="bi bi-chevron-right"></i></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <?php include "footer.php" ?>

    <script src="asset/js/bootstrap.js"></script>
    <script src="asset/js/script.js"></script>
</body>

</html>