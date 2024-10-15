<div class="container-fluid px-4">
    <button type="button" id="sidebarCollapse" class="btn btn-gray d-xl-none">
        <span>
            <i class="bi bi-list"></i>
        </span>
    </button>
    <div class="dropdown">
        <a class="btn btn-gray dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
            <!-- <img src="<?= $picture ?>" alt="pic" width="20" style="mix-blend-mode: multiply; border-radius: 50px;"> -->
            <span>Selamat datang <?= $username ?></span>
        </a>
        <ul class="dropdown-menu shadow-1 border rounded-8 mt-2" aria-labelledby="dropdownMenuLink">
            <li>
                <a class="dropdown-item fw-500" href="../../produk.php" target="_blank">
                    <i class="bi bi-house me-1"></i> Home
                </a>
            </li>
            <li>
                <a class="dropdown-item fw-500" href="akun/setting.php">
                    <i class="bi bi-person me-1"></i> Akun
                </a>
            </li>
            <li>
                <a class="dropdown-item fw-500" href="../../otentikasi/logout.php"><i class="bi bi-box-arrow-right me-1 "></i> Logout
                </a>
            </li>
        </ul>
    </div>
</div>