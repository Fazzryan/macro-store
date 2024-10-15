<?php
$jmlItemCart = show("SELECT COUNT(*) AS total FROM keranjang WHERE id_user = '$user'");
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top border-bottom">
    <div class="container py-2 ">
        <a class="navbar-brand" href="index.php">
            <img src="../asset/img/logo2.png" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <!-- <li class="nav-item px-2">
                    <a class="nav-link ln-30 fw-400" aria-current="page" href="../index.php">Home</a>
                </li> -->
                <li class="nav-item px-2">
                    <a class="nav-link ln-30 fw-400" href="../produk.php">Produk</a>
                </li>
                <li class="nav-item px-2">
                    <a href="../testimoni.php" class="nav-link ln-30 fw-400">Testimoni</a>
                </li>
                <li class="nav-item px-2">
                    <a href="../about.php" class="nav-link ln-30 fw-400 <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">Tentang Kami</a>
                </li>
            </ul>
            <ul class="navbar-nav flex-row">
                <li class="nav-item me-2">
                    <a class="btn btn-gray position-relative" href="../keranjang.php">
                        <i class="bi bi-cart-fill"></i>
                        <?php if ($jmlItemCart[0]["total"] > 0) : ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="z-index: 999;">
                                <?= $jmlItemCart[0]["total"] ?>
                            </span>
                        <?php endif ?>
                    </a>
                </li>
                <?php if (isset($_SESSION["username"])) : ?>
                    <li class="nav-item">
                        <div class="dropdown">
                            <a class="btn btn-gray dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <!-- <i class="bi bi-person-fill"></i> -->
                                <img src="<?= $picture ?>" alt="pic" width="20" style="mix-blend-mode: multiply; border-radius: 50px;">
                            </a>
                            <ul class="dropdown-menu shadow-1 border rounded-8 mt-2" aria-labelledby="dropdownMenuLink">
                                <?php if ($username == "admin" || $username == "Admin") : ?>
                                    <li>
                                        <a class="dropdown-item fw-500" href="dashboard/index.php">
                                            <i class="bi bi-house me-1"></i> Dashboard
                                        </a>
                                    </li>
                                <?php endif ?>
                                <li>
                                    <a class="dropdown-item fw-500" href="setting.php">
                                        <i class="bi bi-person me-1"></i> Akun
                                    </a>
                                </li>
                                <li><a class="dropdown-item fw-500" href="../otentikasi/logout.php"><i class="bi bi-box-arrow-right me-1 "></i> Logout</a></li>
                            </ul>
                        </div>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="btn btn-gray fw-500" href="otentikasi/login.php">
                            <i class="fa-solid fa-arrow-right-to-bracket me-1"></i>
                            Login
                        </a>
                    </li>
                <?php endif ?>
                </li>
            </ul>
        </div>
    </div>
</nav>