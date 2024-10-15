<ul class="navbar-nav">
    <div class="side-header">
        <a href="../../index.php" class="fs-20 fw-500">Macro Store Computer</a>
        <button type="button" class="btn-close d-xl-none" aria-label="Close"></button>
    </div>
    <li class="nav-item">
        <a href="../" class="side-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'on' : ''; ?>"><i class="bi bi-house me-2"></i> Dashboard</a>
    </li>
    <li class="nav-item my-3 ps-3">
        <span class="nav-label">STORE MANAGEMENTS</span>
    </li>
    <li class="nav-item">
        <a href="../produk/Produk.php" class="side-link <?php echo basename($_SERVER['PHP_SELF']) == 'Produk.php' || basename($_SERVER['PHP_SELF']) == 'tambahProduk.php' || basename($_SERVER['PHP_SELF']) == 'editProduk.php' ? 'on' : ''; ?>"><i class="bi bi-cart me-2"></i> Produk</a>
    </li>
    <li class="nav-item">
        <a href="../kategori/Kategori.php" class="side-link <?php echo basename($_SERVER['PHP_SELF']) == 'Kategori.php' || basename($_SERVER['PHP_SELF']) == 'tambahKategori.php' || basename($_SERVER['PHP_SELF']) == 'editKategori.php' ? 'on' : ''; ?>"><i class="bi bi-list-ul me-2"></i> Kategori</a>
    </li>
    <li class="nav-item">
        <a href="../pesanan/Pesanan.php" class="side-link <?php echo basename($_SERVER['PHP_SELF']) == 'Pesanan.php' ? 'on' : ''; ?>"><i class="bi bi-bag me-2"></i> Pesanan</a>
    </li>
    <!-- || basename($_SERVER['PHP_SELF']) == 'detailPesanan.php' -->
    <li class="nav-item">
        <a class="side-link <?php echo basename($_SERVER['PHP_SELF']) == 'pesananMasuk.php' ? 'on' : ''; ?>" href="../pesanan/pesananMasuk.php">
            <i class="bi bi-arrow-return-right me-2"></i>
            Pesanan Masuk
        </a>
    </li>
    <li class="nav-item">
        <a class="side-link <?php echo basename($_SERVER['PHP_SELF']) == 'pesananDikonfirmasi.php' ? 'on' : ''; ?>" href="../pesanan/pesananDikonfirmasi.php">
            <i class="bi bi-arrow-return-right me-2"></i>
            Pesanan Dikonfirmasi
        </a>
    </li>
    <li class="nav-item">
        <a class="side-link <?php echo basename($_SERVER['PHP_SELF']) == 'pesananDikemas.php' ? 'on' : ''; ?>" href="../pesanan/pesananDikemas.php">
            <i class="bi bi-arrow-return-right me-2"></i>
            Pesanan Dikemas
        </a>
    </li>
    <li class="nav-item">
        <a class="side-link <?php echo basename($_SERVER['PHP_SELF']) == 'pesananDikirim.php' ? 'on' : ''; ?>" href="../pesanan/pesananDikirim.php">
            <i class="bi bi-arrow-return-right me-2"></i>
            Pesanan Dalam Pengiriman
        </a>
    </li>
    <li class="nav-item">
        <a class="side-link <?php echo basename($_SERVER['PHP_SELF']) == 'pesananSelesai.php' ? 'on' : ''; ?>" href="../pesanan/pesananSelesai.php">
            <i class="bi bi-arrow-return-right me-2"></i>
            Pesanan Selesai
        </a>
    </li>

    <li class="nav-item">
        <a href="../pelanggan/Pelanggan.php" class="side-link <?php echo basename($_SERVER['PHP_SELF']) == 'Pelanggan.php' ? 'on' : ''; ?>"><i class="bi bi-people me-2"></i> Pelanggan</a>
    </li>
    <li class="nav-item my-3 ps-3">
        <span class="nav-label">ACCOUNT</span>
    </li>
    <li class="nav-item">
        <a href="../akun/Admin.php" class="side-link <?php echo basename($_SERVER['PHP_SELF']) == 'Admin.php' || basename($_SERVER['PHP_SELF']) == 'tambahAdmin.php' || basename($_SERVER['PHP_SELF']) == 'editAdmin.php' ? 'on' : ''; ?>"><i class="bi bi-person-gear me-2"></i> Admin</a>
    </li>
    <!-- <li class="nav-item">
        <a href="#" class="side-link"><i class="bi bi-images me-2"></i> Media</a>
    </li>
    <li class="nav-item">
        <a href="#" class="side-link"><i class="bi bi-gear me-2"></i> Pengaturan Toko</a>
    </li> -->
</ul>
</nav>