<div class="card p-3 border-0 shadow-1 rounded-16 mb-3">
    <a href="setting.php" class="kategori-item <?php echo basename($_SERVER['PHP_SELF']) == 'setting.php' || basename($_SERVER['PHP_SELF']) == 'editbiodata.php' ? 'on' : ''; ?>">
        <i class="bi bi-person-fill"></i>
        <span class="ms-2">Biodata Diri</span>
    </a>
    <a href="alamat.php" class="kategori-item <?php echo basename($_SERVER['PHP_SELF']) == 'alamat.php' || basename($_SERVER['PHP_SELF']) == 'editalamat.php' ? 'on' : ''; ?>">
        <i class="bi bi-geo-alt-fill"></i>
        <span class="ms-2">Alamat</span>
    </a>
    <a href="pesanan.php" class="kategori-item <?php echo basename($_SERVER['PHP_SELF']) == 'pesanan.php' || basename($_SERVER['PHP_SELF']) == 'detail_pesanan.php' ? 'on' : ''; ?>">
        <i class="bi bi-bag-check-fill"></i>
        <span class="ms-2">Pesanan</span>
    </a>
    <a href="pembayaran.php" class="kategori-item <?php echo basename($_SERVER['PHP_SELF']) == 'pembayaran.php' || basename($_SERVER['PHP_SELF']) == 'detail_pembayaran.php' ? 'on' : ''; ?>">
        <i class="bi bi-stripe"></i>
        <span class="ms-2">Pembayaran</span>
    </a>
    <!-- <a href="transaksi.php" class="kategori-item <?php echo basename($_SERVER['PHP_SELF']) == 'transaksi.php' || basename($_SERVER['PHP_SELF']) == 'transaksi.php' ? 'on' : ''; ?>">
        <i class="bi bi-credit-card-fill"></i>
        <span class="ms-2">Transaksi</span>
    </a> -->
</div>