<?php
session_start();
include "db/koneksi.php";
include "fungsi.php";

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
$produk = show("SELECT * FROM keranjang 
LEFT JOIN produk 
ON keranjang.id_produk = produk.id_produk
LEFT JOIN user
ON keranjang.id_user = user.id_user
WHERE keranjang.id_user = '$user'
");

$total_produk = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM keranjang WHERE id_user = '$user'");
$jumlah_produk = mysqli_fetch_row($total_produk);

foreach ($jumlah_produk as $x) {
    $harga = mysqli_query($koneksi, "SELECT SUM(jumlah_produk * total_harga_produk) AS total FROM keranjang WHERE id_user = '$user'");
    $total_harga = mysqli_fetch_row($harga);
    $qty = show("SELECT SUM(jumlah_produk) AS total FROM keranjang WHERE id_user = '$user'");
}

if (isset($_POST["hapus_keranjang"])) {
    // var_dump($_POST);
    // die;
    if (deleteKeranjang($_POST) > 0) {
        echo "
        <script>
            alert('Produk berhasil dihapus');
            window.location.href='keranjang.php';
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
    <link rel="stylesheet" href="asset/css/bootstrap.css">
    <link rel="stylesheet" href="asset/css/style.css">
    <!-- Bs Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Keranjang - Macro Store Computer</title>
</head>

<body style="background-color:#F0F3F7;">

    <?php include "navbar.php" ?>
    <!-- Hero -->
    <section class="keranjang">
        <div class="container h-100">
            <div class="row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Keranjang</li>
                    </ol>
                </nav>
            </div>
            <div class="row justify-content-center mt-3 mt-md-4">
                <?php if ($jumlah_produk[0] < 1) : ?>
                    <div class="col-12 col-lg-9 col-xl-7 text-center">
                        <img src="asset/img/empty_cart.svg" class="w-50" alt="icon">
                        <div class="mt-4 empty-cart">
                            <h3>Wah, keranjang belanjamu kosong</h3>
                            <p>Yuk, mulai belanja dan lengkapi kebutuhanmu di Macro Store Computer!</p>
                            <a href="produk.php" class="btn btn-green px-5  fw-500">Mulai Belanja</a>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col-12 col-lg-8">
                        <?php foreach ($produk as $item) : ?>
                            <div class="border rounded-8 mt-1 p-3 p-lg-4 shadow-1 bg-white">
                                <div class="row align-items-center">
                                    <div class="col-md-1 text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input product-checkbox" name="selected_products[]" value="<?= $item['id_produk'] ?>" data-price="<?= $item['total_harga_produk'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3 my-3">
                                        <img src="fileUpload/<?= $item['gambar'] ?>" class="keranjang_img rounded-8" alt="produk">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="px-lg-2">
                                            <h5 class=""><?= $item["nama_produk"] ?></h5>
                                            <div class="">Jumlah : <h6 class="d-inline"><?= $item["jumlah_produk"] ?></h6>
                                            </div>
                                            <div class=" ">Harga Satuan : <h6 class="d-inline">Rp<?= formatKeRupiah($item["harga"]) ?></h6>
                                            </div>
                                            <div class=" ">Total Harga : <h6 class="d-inline">Rp<?= formatKeRupiah($item["total_harga_produk"]) ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- hapus keranjang -->
                                    <div class="col-md-2 text-end">
                                        <form action="" method="post">
                                            <input type="hidden" name="id_keranjang" value="<?= $item['id_keranjang'] ?>">
                                            <input type="hidden" name="id_user" value="<?= $item['id_user'] ?>">
                                            <button type="submit" name="hapus_keranjang" class="btn btn-danger fs-14"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <div class="col-12 col-lg-4 mt-3 mt-lg-0">
                        <div class="border rounded-8 mt-1 p-3 p-lg-4 shadow-1 bg-white">
                            <div class="fs-16 fw-500">Ringkasan Belanja</div>
                            <div class="d-flex justify-content-between fs-14 my-3" id="selected-products-summary">
                                <span>Total Harga (0 barang)</span>
                                <span>Rp. 0</span>
                            </div>
                            <div class="d-flex justify-content-between border-top">
                                <span class="fw-500 mt-3">Total Harga</span>
                                <span class="fw-500 mt-3" id="total-price">Rp. 0</span>
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-green w-100 fw-500" id="btnBeli">Beli (0)</button>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include "footer.php" ?>

    <script src="asset/js/bootstrap.js"></script>
    <script src="asset/js/script.js"></script>
    <script>
        const checkboxes = document.querySelectorAll('.product-checkbox');
        const totalPriceSpan = document.getElementById('total-price');
        const btnBeli = document.getElementById('btnBeli');
        const selectedProductsSummary = document.getElementById('selected-products-summary');

        let totalSelectedPrice = 0;
        let totalSelectedProducts = 0;

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const price = parseFloat(checkbox.getAttribute('data-price'));
                if (checkbox.checked) {
                    totalSelectedPrice += price;
                    totalSelectedProducts++;
                } else {
                    totalSelectedPrice -= price;
                    totalSelectedProducts--;
                }

                selectedProductsSummary.innerHTML = `<span>Total Harga (${totalSelectedProducts} barang)</span><span>Rp. ${totalSelectedPrice.toFixed(2)}</span>`;
                btnBeli.innerHTML = `<span>Beli (${totalSelectedProducts})`;
                totalPriceSpan.innerText = `Rp. ${totalSelectedPrice.toFixed(2)}`;
            });
        });

        btnBeli.addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.product-checkbox:checked');
            const selectedProducts = [];

            checkboxes.forEach(checkbox => {
                selectedProducts.push(checkbox.value);
            });

            if (selectedProducts.length > 0) {
                const checkoutURL = `checkout.php?selected_products=${selectedProducts.join(',')}`;
                window.location.href = checkoutURL;
            } else {
                alert('Pilih setidaknya satu produk untuk dibeli.');
            }
        });
    </script>
</body>

</html>