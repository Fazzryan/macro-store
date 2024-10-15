-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Mar 2024 pada 05.23
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dokterkomputer`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alamat`
--

CREATE TABLE `alamat` (
  `id_alamat` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `label_alamat` varchar(200) NOT NULL,
  `alamat_lengkap` text NOT NULL,
  `catatan` text NOT NULL,
  `penerima` varchar(200) NOT NULL,
  `nohp_penerima` varchar(20) NOT NULL,
  `is_aktif` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `alamat`
--

INSERT INTO `alamat` (`id_alamat`, `id_user`, `label_alamat`, `alamat_lengkap`, `catatan`, `penerima`, `nohp_penerima`, `is_aktif`) VALUES
(2, 1, 'Rumah', 'Jl. Bojonghuni Rt 01 Rw 12 Kel. Maleber, Kec. Ciamis. Kab. Ciamis, Jawa Barat', 'Rumah warna kuning sebelah atas warung kakapean', 'Dinda', '087731137537', 1),
(3, 1, 'Rumah 2', 'Jl. Raya Banjar, Sindangrasa, Kec. Ciamis, Kabupaten Ciamis, Jawa Barat', 'Sebrang indomaret rumah warna hijau', 'Mayasari', '085223515126', 0),
(4, 4, 'Rumah Utama', 'Jl. Sadananya, Mangkubumi, Kec. Sadananya, Kabupaten Ciamis, Jawa Barat', 'Rumah warna kuning sebelum tower', 'Mayasari', '08223182938', 0),
(5, 4, 'Rumah 2', 'Jl. Sadananya No.16, Sukajadi, Kec. Sadananya, Kabupaten Ciamis, Jawa Barat 46256', 'Samping kanan tower', 'Mamah Maya', '085226371626', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `icon_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `icon_kategori`) VALUES
(1, 'Komputer', 'bi-pc-display'),
(5, 'Laptop', 'bi-laptop');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah_produk` int(11) NOT NULL,
  `total_harga_produk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `keranjang`
--

INSERT INTO `keranjang` (`id_keranjang`, `id_user`, `id_produk`, `jumlah_produk`, `total_harga_produk`) VALUES
(11, 4, 16, 2, 8600000),
(12, 4, 17, 1, 4500000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar`
--

CREATE TABLE `komentar` (
  `id_komentar` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `rating` varchar(100) NOT NULL,
  `pesan` varchar(255) NOT NULL,
  `tgl_pesan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `nama_bank` varchar(100) NOT NULL,
  `jml_transfer` int(11) NOT NULL,
  `rekening_tujuan` varchar(100) NOT NULL,
  `atas_nama` varchar(100) NOT NULL,
  `bukti_pembayaran` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `kode_pesanan` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_produk` varchar(100) NOT NULL,
  `id_alamat` int(11) NOT NULL,
  `jumlah_item` int(11) NOT NULL,
  `ongkir` int(11) NOT NULL,
  `jasa_pengiriman` varchar(100) NOT NULL,
  `metode_pembayaran` varchar(100) NOT NULL,
  `total_harga_belanja` int(11) NOT NULL,
  `tgl_pesanan` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Menunggu Pembayaran'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `kode_pesanan`, `id_user`, `id_produk`, `id_alamat`, `jumlah_item`, `ongkir`, `jasa_pengiriman`, `metode_pembayaran`, `total_harga_belanja`, `tgl_pesanan`, `status`) VALUES
(7, 'FDL085226371626', 4, '17', 5, 1, 12000, 'JNE', 'Bank Transfer', 4512000, '18 Maret 2024', 'Menunggu Pembayaran');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `kondisi` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `slug`, `id_kategori`, `harga`, `stok`, `kondisi`, `deskripsi`, `gambar`) VALUES
(13, 'Lenovo Thinkpad Yoga', 'lenovo-thinkpad-yoga', 1, 4000000, 5, 'Baru', '<p>Lenovo Thinkpad Yoga<br />\r\n* Intel core i5- vPro<br />\r\n* Memory 8 GB<br />\r\n* SSD 256 GB<br />\r\n* Intel HD Graphic 5500<br />\r\n* Display 12.5 inch slim<br />\r\n* Touchscreen<br />\r\n* fingerprint<br />\r\n* Backlight Keyboard (US)<br />\r\n* Pen Stylus<br />\r\n* WiFi, Webcam, Display Port, HDMI, Express Card, Audio Jack, Card Reader, Water Resistance Keyboard<br />\r\n* Baterai Normal 3-4 jam multimedia<br />\r\n* Kelengkapan Adapter Original + Tas + mouse + mousepad + Dus Laptop Costum<br />\r\n* Casing Mulus 98% Grade A+ (like new)</p>\r\n', 'Lenovo Thinkpad.jpg'),
(14, 'Lenovo Thinkpad T Series', 'lenovo-thinkpad-t-series', 5, 4000000, 10, 'Baru', '<p>Lenovo Thinkpad T Series<br />\r\n* Intel core i5- vPro<br />\r\n* Memory 8 GB<br />\r\n* SSD 256 GB<br />\r\n* Intel HD Graphic 5500<br />\r\n* Display 13. 5 inch slim<br />\r\n* Touchscreen<br />\r\n* fingerprint<br />\r\n* Backlight Keyboard (US)<br />\r\n* WiFi, Webcam, Display Port, HDMI, Express Card, Audio Jack, Card Reader, Water Resistance Keyboard<br />\r\n* Baterai Normal 3-4 jam multimedia<br />\r\n* Kelengkapan Adapter Original + Tas + mouse + mousepad + Dus Laptop Costum<br />\r\n* Casing Mulus 98% Grade A+ (like new)</p>\r\n', '/////Lenovo Thinkpad T Series.jpg'),
(15, 'Lenovo Thinkpad X Series', 'lenovo-thinkpad-x-series', 5, 4100000, 10, 'Baru', '<p>* Intel core i5- vPro<br />\r\n* Memory 8 GB<br />\r\n* SSD 256 GB<br />\r\n* Intel HD Graphic 5500<br />\r\n* Display 12.5 inch slim<br />\r\n* Backlight Keyboard (japan)<br />\r\n* WiFi, Webcam, Display Port, HDMI, Express Card, Audio Jack, Card Reader, Water Resistance Keyboard<br />\r\n* Baterai Normal 3-4 jam multimedia<br />\r\n* Kelengkapan Adapter Original + Tas + mouse + mousepad + Dus Laptop Costum<br />\r\n* Casing Mulus 98% Grade A+ (like new)</p>\r\n', 'Lenovo Thinkpad X Series.jpg'),
(16, 'DELL LATITUDE CORE I5-VPRO', 'dell-latitude-core-i5-vpro', 5, 4300000, 7, 'Baru', '<p>* Intel Core i5 vPro<br />\r\n* Memory 8 GB<br />\r\n* SSD 256 GB M2sata NVME<br />\r\n* Keyboard US ( Backlight)<br />\r\n* Baterai Tanam<br />\r\n* Intel UHD Graphich<br />\r\n* Display 14 inch slim<br />\r\n* Engsel Layar 180&deg;<br />\r\n* Fingerprint<br />\r\n* Simcard<br />\r\n* Windows 11 Pro 64bit<br />\r\n* WiFi, Webcam, Display Port HDMI, Express Card, Audio Jack, Card Reader, Water Resistance Keyboard<br />\r\n* Baterai Normal 4-5 jam multimedia<br />\r\n* Kelengkapan Adapter Original + Tas + mouse + mousepad + Dus Laptop Costum<br />\r\n* Casing Mulus 99% Grade A+ (like new)</p>\r\n', '/DELL LATITUDE.jpg'),
(17, 'DELL LATITUDE CORE I7 vPRO', 'dell-latitude-core-i7-vpro', 5, 4500000, 7, 'Baru', '<p>* Intel Core i7 vPro<br />\r\n* Memory 8 GB<br />\r\n* SSD 256 GB M2sata NVME<br />\r\n* Keyboard US ( Backlight)<br />\r\n* Baterai Tanam<br />\r\n* Intel UHD Graphich + VGA Radeon<br />\r\n* Touchscreen<br />\r\n* Display 13.6 inch slim<br />\r\n* Engsel Layar 180&deg;<br />\r\n* Fingerprint<br />\r\n* Simcard<br />\r\n* Bahan Alumunium karbon (Dingin)<br />\r\n* Windows 11 Pro 64bit<br />\r\n* WiFi, Webcam, Display Port HDMI, VGA, Express Card, Audio Jack, Card Reader, Water Resistance Keyboard<br />\r\n* Baterai Normal 4-5 jam multimedia<br />\r\n* Kelengkapan Adapter Original + Tas + mouse + mousepad + Dus Laptop Costum<br />\r\n* Casing Mulus 99% Grade A+ (like new)</p>\r\n', 'DELL LATITUDE1.jpg'),
(18, 'Dell Latitude E5450 Series', 'dell-latitude-e5450-series', 5, 3700000, 10, 'Baru', '<p>Dell Latitude E5450 Series<br />\r\n* Intel Core i5- vPro<br />\r\n* Memory 8 GB<br />\r\n* SSD 256 GB<br />\r\n* Keyboard (Backlight) Layout US<br />\r\n* Intel HD Graphics<br />\r\n* Display 14 inch slim<br />\r\n* Windows 11 pro<br />\r\n* WiFi, Webcam, Display Port, VGA, HDMI Express Card, Audio Jack, Card Reader, Water Resistance Keyboard<br />\r\n* Baterai Normal 4-5 jam multimedia<br />\r\n* Kelengkapan Adapter Original + Tas + mouse + mousepad + Dus Laptop Costum<br />\r\n* Casing Mulus 98% Grade A+ (like new)</p>\r\n', 'Dell Latitude E5450 Series.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `nomorhp` varchar(20) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `email`, `password`, `tanggal_lahir`, `jenis_kelamin`, `nomorhp`, `picture`) VALUES
(1, 'Fazryan', 'dinda@gmail.com', '594280c6ddc94399a392934cac9d80d5', '2024-03-01', 'Pria', '087731137537', 'profile1.jpg'),
(3, 'Admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', NULL, NULL, NULL, NULL),
(4, 'Mayasari', 'maya@gmail.com', 'b2693d9c2124f3ca9547b897794ac6a1', '2001-05-07', 'Wanita', '08277481238', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alamat`
--
ALTER TABLE `alamat`
  ADD PRIMARY KEY (`id_alamat`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`);

--
-- Indeks untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id_komentar`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alamat`
--
ALTER TABLE `alamat`
  MODIFY `id_alamat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
