-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2019 at 09:09 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koperasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `ak_detail_trx_bank`
--

CREATE TABLE `ak_detail_trx_bank` (
  `id_detail_trx_bank` int(11) NOT NULL,
  `kode_trx_bank` varchar(11) NOT NULL,
  `keterangan` text NOT NULL,
  `lawan` varchar(10) NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ak_detail_trx_kas`
--

CREATE TABLE `ak_detail_trx_kas` (
  `id_detail_trx_kas` int(11) NOT NULL,
  `kode_trx_kas` varchar(11) NOT NULL,
  `keterangan` text NOT NULL,
  `lawan` varchar(10) NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ak_detail_trx_memorial`
--

CREATE TABLE `ak_detail_trx_memorial` (
  `id_detail_trx_memorial` int(11) NOT NULL,
  `kode_trx_memorial` varchar(11) NOT NULL,
  `keterangan` text NOT NULL,
  `kode_perkiraan` varchar(10) NOT NULL,
  `lawan` varchar(10) NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ak_jurnal`
--

CREATE TABLE `ak_jurnal` (
  `id_jurnal` int(11) NOT NULL,
  `tanggal` int(11) NOT NULL,
  `kode_transaksi` int(11) NOT NULL,
  `keterangan` int(11) NOT NULL,
  `kode` int(11) NOT NULL,
  `lawan` int(11) NOT NULL,
  `tipe` int(11) NOT NULL,
  `nominal` int(11) NOT NULL,
  `tipe_trx_koperasi` enum('''SimPokok''','''SimWajib''','''Simuda''','''Sijaka''','''Kredit''') NOT NULL,
  `id_detail` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ak_kode_induk`
--

CREATE TABLE `ak_kode_induk` (
  `kode_induk` varchar(6) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `tipe` enum('D','K') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ak_rekening`
--

CREATE TABLE `ak_rekening` (
  `kode_rekening` varchar(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `inisial` varchar(3) NOT NULL,
  `kode_induk` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ak_trx_bank`
--

CREATE TABLE `ak_trx_bank` (
  `kode_trx_bank` varchar(11) NOT NULL,
  `tanggal` date NOT NULL,
  `kode_perkiraan` varchar(10) NOT NULL,
  `tipe` enum('D','K') NOT NULL,
  `nomor` int(11) NOT NULL,
  `grand_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ak_trx_kas`
--

CREATE TABLE `ak_trx_kas` (
  `kode_trx_kas` varchar(11) NOT NULL,
  `tanggal` date NOT NULL,
  `kode_perkiraan` varchar(10) NOT NULL,
  `tipe` enum('D','K') NOT NULL,
  `nomor` int(11) NOT NULL,
  `grand_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ak_trx_memorial`
--

CREATE TABLE `ak_trx_memorial` (
  `kode_trx_memorial` varchar(11) NOT NULL,
  `tanggal` date NOT NULL,
  `tipe` enum('D','K') NOT NULL,
  `nomor` int(11) NOT NULL,
  `grand_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `no_anggota` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `tgl_daftar` date NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`no_anggota`, `nama`, `alamat`, `tgl_daftar`, `status`) VALUES
(1212, 'Dimas', 'ass', '0000-00-00', 1),
(3002, 'Hilman', 'RT. 02 RW 07 Desa Rowoasri Kec. Rowokangkung Kab. ', '0000-00-00', 1),
(30012212, 'Dimas Yudha Pratamaasz', 'Rowokangkungs', '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `log_activity`
--

CREATE TABLE `log_activity` (
  `id_log_activity` int(11) NOT NULL,
  `id_user` int(2) NOT NULL,
  `datetime` datetime NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_detail_rekening_pembiayaan`
--

CREATE TABLE `master_detail_rekening_pembiayaan` (
  `id_detail_rekening_pembiayaan` int(11) NOT NULL,
  `no_rekening_pembiayaan` int(11) NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `periode_tagihan` varchar(7) NOT NULL,
  `jml_pokok` int(11) NOT NULL,
  `jml_bahas` int(11) NOT NULL,
  `denda` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_detail_rekening_simuda`
--

CREATE TABLE `master_detail_rekening_simuda` (
  `id_detail_rekening_simuda` int(11) NOT NULL,
  `no_rekening_simuda` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `debet` int(11) NOT NULL,
  `kredit` int(11) NOT NULL,
  `saldo` int(11) NOT NULL,
  `id_user` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_rekening_pembiayaan`
--

CREATE TABLE `master_rekening_pembiayaan` (
  `no_rekening_pembiayaan` int(11) NOT NULL,
  `no_anggota` int(11) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `jumlah_pembiayaan` int(11) NOT NULL,
  `jangka_waktu_bulan` int(11) NOT NULL,
  `jml_pokok_bulanan` int(11) NOT NULL,
  `jml_bahas_bulanan` int(11) NOT NULL,
  `tgl_lunas` date NOT NULL,
  `tgl_temp` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_rekening_simuda`
--

CREATE TABLE `master_rekening_simuda` (
  `no_rekening_simuda` int(11) NOT NULL,
  `no_anggota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_simpanan_pokok`
--

CREATE TABLE `master_simpanan_pokok` (
  `id_simpanan_pokok` int(11) NOT NULL,
  `no_anggota` int(11) NOT NULL,
  `tanggal_pembayaran` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_simpanan_wajib`
--

CREATE TABLE `master_simpanan_wajib` (
  `id_simpanan_wajib` int(11) NOT NULL,
  `no_anggota` int(11) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `jumlah` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `support_limit_simuda`
--

CREATE TABLE `support_limit_simuda` (
  `id_limit_simuda` tinyint(1) NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `support_limit_simuda`
--

INSERT INTO `support_limit_simuda` (`id_limit_simuda`, `nominal`) VALUES
(1, 2500000);

-- --------------------------------------------------------

--
-- Table structure for table `support_temp_tgl_simpanan_wajib`
--

CREATE TABLE `support_temp_tgl_simpanan_wajib` (
  `id_temp_simpanan_wajib` int(11) NOT NULL,
  `no_anggota` int(11) NOT NULL,
  `tgl_temp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(2) NOT NULL,
  `nama_terang` varchar(40) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `level` enum('Manager','Dana','Pembiayaan','Teller') NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_terang`, `username`, `password`, `level`, `status`) VALUES
(1, 'Hilman', 'hilman', '$2y$10$vUN0cpM38DYRV7owaLwEVu5YplgoNKRe9ENGTvxirpS.oGsCnjdO.', 'Manager', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ak_detail_trx_bank`
--
ALTER TABLE `ak_detail_trx_bank`
  ADD PRIMARY KEY (`id_detail_trx_bank`),
  ADD KEY `lawan` (`lawan`);

--
-- Indexes for table `ak_detail_trx_kas`
--
ALTER TABLE `ak_detail_trx_kas`
  ADD PRIMARY KEY (`id_detail_trx_kas`),
  ADD KEY `lawan` (`lawan`);

--
-- Indexes for table `ak_detail_trx_memorial`
--
ALTER TABLE `ak_detail_trx_memorial`
  ADD PRIMARY KEY (`id_detail_trx_memorial`),
  ADD KEY `lawan` (`lawan`),
  ADD KEY `kode_perkiraan` (`kode_perkiraan`);

--
-- Indexes for table `ak_jurnal`
--
ALTER TABLE `ak_jurnal`
  ADD PRIMARY KEY (`id_jurnal`),
  ADD KEY `lawan` (`lawan`),
  ADD KEY `kode` (`kode`),
  ADD KEY `kode_transaksi` (`kode_transaksi`);

--
-- Indexes for table `ak_rekening`
--
ALTER TABLE `ak_rekening`
  ADD KEY `kode_induk` (`kode_induk`);

--
-- Indexes for table `ak_trx_bank`
--
ALTER TABLE `ak_trx_bank`
  ADD PRIMARY KEY (`kode_trx_bank`),
  ADD KEY `kode_perkiraan` (`kode_perkiraan`);

--
-- Indexes for table `ak_trx_kas`
--
ALTER TABLE `ak_trx_kas`
  ADD PRIMARY KEY (`kode_trx_kas`),
  ADD KEY `kode_perkiraan` (`kode_perkiraan`);

--
-- Indexes for table `ak_trx_memorial`
--
ALTER TABLE `ak_trx_memorial`
  ADD PRIMARY KEY (`kode_trx_memorial`);

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`no_anggota`);

--
-- Indexes for table `log_activity`
--
ALTER TABLE `log_activity`
  ADD PRIMARY KEY (`id_log_activity`);

--
-- Indexes for table `master_detail_rekening_pembiayaan`
--
ALTER TABLE `master_detail_rekening_pembiayaan`
  ADD PRIMARY KEY (`id_detail_rekening_pembiayaan`),
  ADD KEY `no_rekening_pembiayaan` (`no_rekening_pembiayaan`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `master_detail_rekening_simuda`
--
ALTER TABLE `master_detail_rekening_simuda`
  ADD PRIMARY KEY (`id_detail_rekening_simuda`),
  ADD KEY `id_rekening_simuda` (`no_rekening_simuda`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `master_rekening_pembiayaan`
--
ALTER TABLE `master_rekening_pembiayaan`
  ADD PRIMARY KEY (`no_rekening_pembiayaan`),
  ADD KEY `no_anggota` (`no_anggota`);

--
-- Indexes for table `master_rekening_simuda`
--
ALTER TABLE `master_rekening_simuda`
  ADD PRIMARY KEY (`no_rekening_simuda`),
  ADD KEY `no_anggota` (`no_anggota`);

--
-- Indexes for table `master_simpanan_pokok`
--
ALTER TABLE `master_simpanan_pokok`
  ADD PRIMARY KEY (`id_simpanan_pokok`),
  ADD KEY `no_anggota` (`no_anggota`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `master_simpanan_wajib`
--
ALTER TABLE `master_simpanan_wajib`
  ADD PRIMARY KEY (`id_simpanan_wajib`),
  ADD KEY `no_anggota` (`no_anggota`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `support_limit_simuda`
--
ALTER TABLE `support_limit_simuda`
  ADD PRIMARY KEY (`id_limit_simuda`);

--
-- Indexes for table `support_temp_tgl_simpanan_wajib`
--
ALTER TABLE `support_temp_tgl_simpanan_wajib`
  ADD PRIMARY KEY (`id_temp_simpanan_wajib`),
  ADD KEY `no_anggota` (`no_anggota`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ak_detail_trx_bank`
--
ALTER TABLE `ak_detail_trx_bank`
  MODIFY `id_detail_trx_bank` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ak_detail_trx_kas`
--
ALTER TABLE `ak_detail_trx_kas`
  MODIFY `id_detail_trx_kas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ak_detail_trx_memorial`
--
ALTER TABLE `ak_detail_trx_memorial`
  MODIFY `id_detail_trx_memorial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ak_jurnal`
--
ALTER TABLE `ak_jurnal`
  MODIFY `id_jurnal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `no_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30012213;

--
-- AUTO_INCREMENT for table `log_activity`
--
ALTER TABLE `log_activity`
  MODIFY `id_log_activity` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_detail_rekening_pembiayaan`
--
ALTER TABLE `master_detail_rekening_pembiayaan`
  MODIFY `id_detail_rekening_pembiayaan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_detail_rekening_simuda`
--
ALTER TABLE `master_detail_rekening_simuda`
  MODIFY `id_detail_rekening_simuda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_simpanan_pokok`
--
ALTER TABLE `master_simpanan_pokok`
  MODIFY `id_simpanan_pokok` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_simpanan_wajib`
--
ALTER TABLE `master_simpanan_wajib`
  MODIFY `id_simpanan_wajib` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_limit_simuda`
--
ALTER TABLE `support_limit_simuda`
  MODIFY `id_limit_simuda` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `support_temp_tgl_simpanan_wajib`
--
ALTER TABLE `support_temp_tgl_simpanan_wajib`
  MODIFY `id_temp_simpanan_wajib` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `master_detail_rekening_pembiayaan`
--
ALTER TABLE `master_detail_rekening_pembiayaan`
  ADD CONSTRAINT `master_detail_rekening_pembiayaan_ibfk_1` FOREIGN KEY (`no_rekening_pembiayaan`) REFERENCES `master_rekening_pembiayaan` (`no_rekening_pembiayaan`),
  ADD CONSTRAINT `master_detail_rekening_pembiayaan_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `master_detail_rekening_simuda`
--
ALTER TABLE `master_detail_rekening_simuda`
  ADD CONSTRAINT `master_detail_rekening_simuda_ibfk_1` FOREIGN KEY (`id_detail_rekening_simuda`) REFERENCES `master_rekening_simuda` (`no_rekening_simuda`),
  ADD CONSTRAINT `master_detail_rekening_simuda_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `master_rekening_pembiayaan`
--
ALTER TABLE `master_rekening_pembiayaan`
  ADD CONSTRAINT `master_rekening_pembiayaan_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`);

--
-- Constraints for table `master_rekening_simuda`
--
ALTER TABLE `master_rekening_simuda`
  ADD CONSTRAINT `master_rekening_simuda_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`);

--
-- Constraints for table `master_simpanan_pokok`
--
ALTER TABLE `master_simpanan_pokok`
  ADD CONSTRAINT `master_simpanan_pokok_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`),
  ADD CONSTRAINT `master_simpanan_pokok_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `master_simpanan_wajib`
--
ALTER TABLE `master_simpanan_wajib`
  ADD CONSTRAINT `master_simpanan_wajib_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`),
  ADD CONSTRAINT `master_simpanan_wajib_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `support_temp_tgl_simpanan_wajib`
--
ALTER TABLE `support_temp_tgl_simpanan_wajib`
  ADD CONSTRAINT `support_temp_tgl_simpanan_wajib_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
