-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Jul 2021 pada 01.02
-- Versi server: 10.1.36-MariaDB
-- Versi PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pa_ammar`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_pedas` int(11) DEFAULT NULL,
  `id_kuah` int(11) DEFAULT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `item_persediaan`
--

CREATE TABLE `item_persediaan` (
  `id` int(11) NOT NULL,
  `id_stok` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `jumlah_persediaan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kas`
--

CREATE TABLE `kas` (
  `id` int(11) NOT NULL,
  `saldo_kas` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kas`
--

INSERT INTO `kas` (`id`, `saldo_kas`) VALUES
(1, 495750000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `md_coa`
--

CREATE TABLE `md_coa` (
  `id` int(11) NOT NULL,
  `kode_akun` int(11) NOT NULL,
  `nama_akun` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `md_coa`
--

INSERT INTO `md_coa` (`id`, `kode_akun`, `nama_akun`) VALUES
(1, 111, 'Kas'),
(2, 113, 'Persediaan'),
(3, 411, 'Penjualan'),
(4, 511, 'Harga Pokok Penjualan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `md_kuah`
--

CREATE TABLE `md_kuah` (
  `id` int(11) NOT NULL,
  `nama_kuah` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `md_kuah`
--

INSERT INTO `md_kuah` (`id`, `nama_kuah`) VALUES
(1, 'Kare'),
(2, 'Oriental'),
(3, 'Tomyan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `md_lv_pedas`
--

CREATE TABLE `md_lv_pedas` (
  `id` int(11) NOT NULL,
  `lvl_pedas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `md_lv_pedas`
--

INSERT INTO `md_lv_pedas` (`id`, `lvl_pedas`) VALUES
(1, 'Kenalan'),
(2, 'Modus'),
(3, 'Baper'),
(4, 'Harkos'),
(5, 'Putus Cinta');

-- --------------------------------------------------------

--
-- Struktur dari tabel `md_menu`
--

CREATE TABLE `md_menu` (
  `id` int(11) NOT NULL,
  `id_bahan_1` int(11) NOT NULL,
  `id_bahan_2` int(11) NOT NULL,
  `id_bahan_3` int(11) DEFAULT NULL,
  `id_bahan_4` int(11) DEFAULT NULL,
  `id_bahan_5` int(11) DEFAULT NULL,
  `nama_menu` varchar(255) NOT NULL,
  `harga_menu` int(11) NOT NULL,
  `jenis_menu` enum('Makanan','Minuman','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `md_menu`
--

INSERT INTO `md_menu` (`id`, `id_bahan_1`, `id_bahan_2`, `id_bahan_3`, `id_bahan_4`, `id_bahan_5`, `nama_menu`, `harga_menu`, `jenis_menu`) VALUES
(1, 6, 16, 17, 20, 21, 'Ramen Akhir Bulan', 16900, 'Makanan'),
(2, 6, 14, 17, 16, 20, 'Tebasaki Ramen', 24700, 'Makanan'),
(3, 6, 15, 16, 17, 20, 'Karage Ramen', 24700, 'Makanan'),
(5, 6, 11, 16, 20, 17, 'Katsu Ramen', 20800, 'Makanan'),
(8, 6, 19, 16, 17, 10, 'Beef Ramen', 27300, 'Makanan'),
(9, 6, 13, 16, 17, 18, 'Seafood Ramen', 28600, 'Makanan'),
(10, 6, 12, 16, 17, 20, 'Sausage Ramen', 20800, 'Makanan'),
(11, 31, 30, 28, 27, 0, 'Esteh Manis', 5500, 'Minuman');

-- --------------------------------------------------------

--
-- Struktur dari tabel `md_pelanggan`
--

CREATE TABLE `md_pelanggan` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(15) NOT NULL,
  `customer_status` enum('Sedang Makan','Belum Makan','Selesai Makan','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `md_pelanggan`
--

INSERT INTO `md_pelanggan` (`id`, `customer_name`, `customer_phone`, `customer_status`) VALUES
(1, 'Dolken', '0825550316', 'Belum Makan'),
(2, 'rangga', '87546546645', 'Belum Makan'),
(3, 'fikri', '081324152626', 'Belum Makan'),
(4, 'hendra', '0', 'Belum Makan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `md_stok`
--

CREATE TABLE `md_stok` (
  `id` int(11) NOT NULL,
  `nama_stok` varchar(255) NOT NULL,
  `jumlah_stok` int(255) NOT NULL,
  `unit_price` int(17) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `md_stok`
--

INSERT INTO `md_stok` (`id`, `nama_stok`, `jumlah_stok`, `unit_price`) VALUES
(6, 'Mie ', 50, 5000),
(7, 'Chikua', 50, 5000),
(8, 'Batagor', 50, 2000),
(9, 'Crabstick', 50, 5000),
(10, 'Kerupuk', 50, 2000),
(11, 'Katsu', 50, 5000),
(12, 'Cocktail', 50, 5000),
(13, 'Udang', 50, 5000),
(14, 'Chiken', 50, 8000),
(15, 'Baso', 50, 8000),
(16, 'telur', 50, 3000),
(17, 'Sayur', 50, 1000),
(18, 'Cumi', 50, 8000),
(19, 'Beef', 50, 10000),
(20, 'Somay', 50, 2000),
(21, 'Tahu', 50, 2000),
(27, 'Gula', 50, 1000),
(28, 'Teh celup', 50, 2000),
(30, 'Air', 50, 1000),
(31, 'Es', 50, 1000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `md_stok_item`
--

CREATE TABLE `md_stok_item` (
  `id` int(11) NOT NULL,
  `id_stok` int(11) NOT NULL,
  `id_persediaan` int(11) NOT NULL,
  `sisa_stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `md_stok_item`
--

INSERT INTO `md_stok_item` (`id`, `id_stok`, `id_persediaan`, `sisa_stok`) VALUES
(41, 6, 57, 50),
(42, 7, 58, 50),
(43, 8, 59, 50),
(44, 9, 60, 50),
(45, 10, 61, 50),
(46, 15, 66, 50),
(47, 11, 62, 50),
(48, 12, 63, 50),
(49, 13, 64, 50),
(50, 14, 65, 50),
(51, 20, 71, 50),
(52, 19, 70, 50),
(53, 18, 69, 50),
(54, 17, 68, 50),
(55, 16, 67, 50),
(56, 27, 74, 50),
(57, 30, 73, 50),
(58, 31, 72, 50),
(59, 21, 75, 50),
(60, 28, 77, 50);

-- --------------------------------------------------------

--
-- Struktur dari tabel `md_supplier`
--

CREATE TABLE `md_supplier` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `md_supplier`
--

INSERT INTO `md_supplier` (`id`, `supplier_name`, `address`, `phone`) VALUES
(1, 'Burung Layang Terbang', ' Jl. Laswi no 90', '082219640986'),
(3, 'Miura Indonesia', ' JL. SUMBER MEKAR 27-11 SUMBERSARI INDAH ', '082234573957'),
(4, 'Moneck Refill', ' JL. TERUSAN BUAH BATU Gg. KUJANG 2 NO. 105', '082248608543'),
(5, 'Parahita', 'JL. PELAJAR PEJUANG 45 NO. 93 ', '082240957654'),
(6, 'Marga Bhakti', ' JL. KEBAKTIAN II NO 78/135 A', '082258763098');

-- --------------------------------------------------------

--
-- Struktur dari tabel `md_table`
--

CREATE TABLE `md_table` (
  `id` int(11) NOT NULL,
  `table_number` varchar(111) NOT NULL,
  `table_type` varchar(255) NOT NULL,
  `table_status` enum('Tidak Diisi','Sedang Diisi','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `md_table`
--

INSERT INTO `md_table` (`id`, `table_number`, `table_type`, `table_status`) VALUES
(1, '001', 'Untuk Berdua', 'Tidak Diisi'),
(2, '002', 'Untuk Berdua', 'Tidak Diisi'),
(3, '003', 'Untuk Berempat', 'Tidak Diisi'),
(4, '004', 'Untuk Berempat', 'Tidak Diisi'),
(5, '005', 'Untuk Berempat', 'Tidak Diisi'),
(6, '006', 'Untuk Berempat', 'Tidak Diisi'),
(7, '007', 'Untuk Berempat', 'Tidak Diisi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_jurnal`
--

CREATE TABLE `tr_jurnal` (
  `id` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL,
  `id_penjualan` int(11) DEFAULT NULL,
  `id_persediaan` int(11) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `status_jurnal` enum('Debet','Kredit','','') NOT NULL,
  `tanggal_jurnal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tr_jurnal`
--

INSERT INTO `tr_jurnal` (`id`, `id_akun`, `id_penjualan`, `id_persediaan`, `jumlah`, `status_jurnal`, `tanggal_jurnal`) VALUES
(169, 2, NULL, 57, 250000, 'Debet', '2021-07-13'),
(170, 1, NULL, 57, 250000, 'Kredit', '2021-07-13'),
(171, 2, NULL, 58, 250000, 'Debet', '2021-07-13'),
(172, 1, NULL, 58, 250000, 'Kredit', '2021-07-13'),
(173, 2, NULL, 59, 100000, 'Debet', '2021-07-13'),
(174, 1, NULL, 59, 100000, 'Kredit', '2021-07-13'),
(175, 2, NULL, 60, 250000, 'Debet', '2021-07-13'),
(176, 1, NULL, 60, 250000, 'Kredit', '2021-07-13'),
(177, 2, NULL, 61, 100000, 'Debet', '2021-07-13'),
(178, 1, NULL, 61, 100000, 'Kredit', '2021-07-13'),
(179, 2, NULL, 66, 400000, 'Debet', '2021-07-13'),
(180, 1, NULL, 66, 400000, 'Kredit', '2021-07-13'),
(181, 2, NULL, 62, 250000, 'Debet', '2021-07-13'),
(182, 1, NULL, 62, 250000, 'Kredit', '2021-07-13'),
(183, 2, NULL, 63, 250000, 'Debet', '2021-07-13'),
(184, 1, NULL, 63, 250000, 'Kredit', '2021-07-13'),
(185, 2, NULL, 64, 250000, 'Debet', '2021-07-13'),
(186, 1, NULL, 64, 250000, 'Kredit', '2021-07-13'),
(187, 2, NULL, 65, 400000, 'Debet', '2021-07-13'),
(188, 1, NULL, 65, 400000, 'Kredit', '2021-07-13'),
(189, 2, NULL, 71, 100000, 'Debet', '2021-07-13'),
(190, 1, NULL, 71, 100000, 'Kredit', '2021-07-13'),
(191, 2, NULL, 70, 500000, 'Debet', '2021-07-13'),
(192, 1, NULL, 70, 500000, 'Kredit', '2021-07-13'),
(193, 2, NULL, 69, 400000, 'Debet', '2021-07-13'),
(194, 1, NULL, 69, 400000, 'Kredit', '2021-07-13'),
(195, 2, NULL, 68, 50000, 'Debet', '2021-07-13'),
(196, 1, NULL, 68, 50000, 'Kredit', '2021-07-13'),
(197, 2, NULL, 67, 150000, 'Debet', '2021-07-13'),
(198, 1, NULL, 67, 150000, 'Kredit', '2021-07-13'),
(199, 2, NULL, 74, 50000, 'Debet', '2021-07-13'),
(200, 1, NULL, 74, 50000, 'Kredit', '2021-07-13'),
(201, 2, NULL, 73, 50000, 'Debet', '2021-07-13'),
(202, 1, NULL, 73, 50000, 'Kredit', '2021-07-13'),
(203, 2, NULL, 72, 50000, 'Debet', '2021-07-13'),
(204, 1, NULL, 72, 50000, 'Kredit', '2021-07-13'),
(205, 2, NULL, 76, 100000, 'Debet', '2021-07-13'),
(206, 1, NULL, 76, 100000, 'Kredit', '2021-07-13'),
(207, 2, NULL, 75, 100000, 'Debet', '2021-07-13'),
(208, 1, NULL, 75, 100000, 'Kredit', '2021-07-13'),
(209, 2, NULL, 76, 100000, 'Debet', '2021-07-13'),
(210, 1, NULL, 76, 100000, 'Kredit', '2021-07-13'),
(211, 2, NULL, 77, 100000, 'Debet', '2021-07-13'),
(212, 1, NULL, 77, 100000, 'Kredit', '2021-07-13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_penjualan`
--

CREATE TABLE `tr_penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_meja` int(11) NOT NULL,
  `kode_penjualan` varchar(255) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `tanggal_penjualan` datetime NOT NULL,
  `status_penjualan` enum('Show','Hide','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_persediaan`
--

CREATE TABLE `tr_persediaan` (
  `id_persediaan` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `id_stok` int(11) NOT NULL,
  `kode_pembelian` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_price` int(15) NOT NULL,
  `purchase_date` date NOT NULL,
  `expired_date` date NOT NULL,
  `status` enum('Belum Disetujui','Disetujui','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tr_persediaan`
--

INSERT INTO `tr_persediaan` (`id_persediaan`, `id_supplier`, `id_stok`, `kode_pembelian`, `jumlah`, `total_price`, `purchase_date`, `expired_date`, `status`) VALUES
(57, 1, 6, 'PMB-0001', 50, 250000, '2021-07-13', '2021-11-30', 'Disetujui'),
(58, 1, 7, 'PMB-0001', 50, 250000, '2021-07-13', '2021-11-30', 'Disetujui'),
(59, 1, 8, 'PMB-0001', 50, 100000, '2021-07-13', '2021-11-30', 'Disetujui'),
(60, 1, 9, 'PMB-0001', 50, 250000, '2021-07-13', '2021-11-30', 'Disetujui'),
(61, 1, 10, 'PMB-0001', 50, 100000, '2021-07-13', '2021-11-30', 'Disetujui'),
(62, 3, 11, 'PMB-0002', 50, 250000, '2021-07-13', '2021-11-30', 'Disetujui'),
(63, 3, 12, 'PMB-0002', 50, 250000, '2021-07-13', '2021-11-30', 'Disetujui'),
(64, 3, 13, 'PMB-0002', 50, 250000, '2021-07-13', '2021-11-30', 'Disetujui'),
(65, 3, 14, 'PMB-0002', 50, 400000, '2021-07-13', '2021-11-30', 'Disetujui'),
(66, 3, 15, 'PMB-0002', 50, 400000, '2021-07-13', '2021-11-30', 'Disetujui'),
(67, 4, 16, 'PMB-0003', 50, 150000, '2021-07-13', '2021-11-30', 'Disetujui'),
(68, 4, 17, 'PMB-0003', 50, 50000, '2021-07-13', '2021-11-30', 'Disetujui'),
(69, 4, 18, 'PMB-0003', 50, 400000, '2021-07-13', '2021-11-30', 'Disetujui'),
(70, 4, 19, 'PMB-0003', 50, 500000, '2021-07-13', '2021-11-30', 'Disetujui'),
(71, 4, 20, 'PMB-0003', 50, 100000, '2021-07-13', '2021-11-30', 'Disetujui'),
(72, 5, 31, 'PMB-0004', 50, 50000, '2021-07-13', '2021-11-30', 'Disetujui'),
(73, 5, 30, 'PMB-0004', 50, 50000, '2021-07-13', '2021-11-30', 'Disetujui'),
(74, 5, 27, 'PMB-0004', 50, 50000, '2021-07-13', '2021-11-30', 'Disetujui'),
(75, 6, 21, 'PMB-0005', 50, 100000, '2021-07-13', '2021-11-30', 'Disetujui'),
(77, 6, 28, 'PMB-0006', 50, 100000, '2021-07-13', '2021-11-30', 'Disetujui');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `role`) VALUES
(1, 'pemilik', '58399557dae3c60e23c78606771dfa3d', 'pemilik', 'superadmin'),
(12, 'karyawan', '9e014682c94e0f2cc834bf7348bda428', 'Adam', 'karyawan'),
(13, 'keuangan', 'a4151d4b2856ec63368a7c784b1f0a6e', 'Subur', 'keuangan');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_penjualan` (`id_penjualan`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indeks untuk tabel `kas`
--
ALTER TABLE `kas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `md_coa`
--
ALTER TABLE `md_coa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `md_kuah`
--
ALTER TABLE `md_kuah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `md_lv_pedas`
--
ALTER TABLE `md_lv_pedas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `md_menu`
--
ALTER TABLE `md_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `md_pelanggan`
--
ALTER TABLE `md_pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `md_stok`
--
ALTER TABLE `md_stok`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `md_stok_item`
--
ALTER TABLE `md_stok_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_stok` (`id_stok`),
  ADD KEY `id_persediaan` (`id_persediaan`);

--
-- Indeks untuk tabel `md_supplier`
--
ALTER TABLE `md_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `md_table`
--
ALTER TABLE `md_table`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tr_jurnal`
--
ALTER TABLE `tr_jurnal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tr_penjualan`
--
ALTER TABLE `tr_penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indeks untuk tabel `tr_persediaan`
--
ALTER TABLE `tr_persediaan`
  ADD PRIMARY KEY (`id_persediaan`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT untuk tabel `kas`
--
ALTER TABLE `kas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `md_coa`
--
ALTER TABLE `md_coa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `md_kuah`
--
ALTER TABLE `md_kuah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `md_lv_pedas`
--
ALTER TABLE `md_lv_pedas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `md_menu`
--
ALTER TABLE `md_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `md_pelanggan`
--
ALTER TABLE `md_pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `md_stok`
--
ALTER TABLE `md_stok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `md_stok_item`
--
ALTER TABLE `md_stok_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT untuk tabel `md_supplier`
--
ALTER TABLE `md_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `md_table`
--
ALTER TABLE `md_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `tr_jurnal`
--
ALTER TABLE `tr_jurnal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213;

--
-- AUTO_INCREMENT untuk tabel `tr_penjualan`
--
ALTER TABLE `tr_penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `tr_persediaan`
--
ALTER TABLE `tr_persediaan`
  MODIFY `id_persediaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`id_penjualan`) REFERENCES `tr_penjualan` (`id_penjualan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `md_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `md_stok_item`
--
ALTER TABLE `md_stok_item`
  ADD CONSTRAINT `md_stok_item_ibfk_1` FOREIGN KEY (`id_stok`) REFERENCES `md_stok` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `md_stok_item_ibfk_2` FOREIGN KEY (`id_persediaan`) REFERENCES `tr_persediaan` (`id_persediaan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
