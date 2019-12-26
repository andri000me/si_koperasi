-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2019 at 05:02 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

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

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getMasterSimudaByNoAnggota` (IN `bulan_lalu` INT(2), IN `bulan_ini` INT(2), IN `tahun` YEAR, IN `noAnggota` INT)  NO SQL
SELECT 
	mrs.no_rekening_simuda, mrs.no_anggota, a.nama,
    
    IF(bulan_ini='01' OR bulan_ini='1',
    (SELECT saldo FROM support_simuda_tutup_bulan sstb WHERE sstb.no_rekening_simuda = mrs.no_rekening_simuda AND MONTH(sstb.tgl_tutup_bulan)=bulan_lalu AND YEAR(sstb.tgl_tutup_bulan)=tahun-1),
      (SELECT saldo FROM support_simuda_tutup_bulan sstb WHERE sstb.no_rekening_simuda = mrs.no_rekening_simuda AND MONTH(sstb.tgl_tutup_bulan)=bulan_lalu AND YEAR(sstb.tgl_tutup_bulan)=tahun)
      )AS saldo_bulan_lalu,

    IF((SELECT COUNT(mdrs.id_detail_rekening_simuda) FROM master_detail_rekening_simuda mdrs WHERE mdrs.no_rekening_simuda = mrs.no_rekening_simuda AND MONTH(mdrs.datetime)=bulan_ini AND YEAR(mdrs.datetime)=tahun ) =0 ,
		(SELECT saldo FROM support_simuda_tutup_bulan sstb WHERE sstb.no_rekening_simuda = mrs.no_rekening_simuda AND MONTH(sstb.tgl_tutup_bulan)=bulan_lalu AND YEAR(sstb.tgl_tutup_bulan)=tahun),
		(SELECT saldo FROM master_detail_rekening_simuda mdrs WHERE mdrs.no_rekening_simuda = mrs.no_rekening_simuda ORDER BY id_detail_rekening_simuda DESC LIMIT 1)
	) AS saldo_bulan_ini,
    
	IF((SELECT COUNT(mdrs.id_detail_rekening_simuda) FROM master_detail_rekening_simuda mdrs WHERE mdrs.no_rekening_simuda = mrs.no_rekening_simuda AND MONTH(mdrs.datetime)=bulan_ini AND YEAR(mdrs.datetime)=tahun) =0,
		(SELECT saldo FROM support_simuda_tutup_bulan sstb WHERE sstb.no_rekening_simuda = mrs.no_rekening_simuda AND MONTH(sstb.tgl_tutup_bulan)=bulan_lalu AND YEAR(sstb.tgl_tutup_bulan)=tahun),
       	(SELECT MIN(saldo) FROM master_detail_rekening_simuda mdrs WHERE mdrs.no_rekening_simuda = mrs.no_rekening_simuda AND MONTH(mdrs.datetime)=bulan_ini AND YEAR(mdrs.datetime)=tahun ORDER BY id_detail_rekening_simuda DESC LIMIT 1)
	) AS saldo_terendah
FROM master_rekening_simuda mrs JOIN anggota a ON mrs.no_anggota = a.no_anggota WHERE mrs.no_anggota=noAnggota$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `perhitungan_tutup_bulan_simuda` (IN `bulan_lalu` INT(2), IN `bulan_ini` INT(2), IN `tahun` YEAR)  NO SQL
SELECT 
	mrs.no_rekening_simuda, mrs.no_anggota, a.nama,
    
    IF(bulan_ini='01' OR bulan_ini='1',
    (SELECT saldo FROM support_simuda_tutup_bulan sstb WHERE sstb.no_rekening_simuda = mrs.no_rekening_simuda AND MONTH(sstb.tgl_tutup_bulan)=bulan_lalu AND YEAR(sstb.tgl_tutup_bulan)=tahun-1),
      (SELECT saldo FROM support_simuda_tutup_bulan sstb WHERE sstb.no_rekening_simuda = mrs.no_rekening_simuda AND MONTH(sstb.tgl_tutup_bulan)=bulan_lalu AND YEAR(sstb.tgl_tutup_bulan)=tahun)
      )AS saldo_bulan_lalu,

    IF((SELECT COUNT(mdrs.id_detail_rekening_simuda) FROM master_detail_rekening_simuda mdrs WHERE mdrs.no_rekening_simuda = mrs.no_rekening_simuda AND MONTH(mdrs.datetime)=bulan_ini AND YEAR(mdrs.datetime)=tahun ) =0 ,
		(SELECT saldo FROM support_simuda_tutup_bulan sstb WHERE sstb.no_rekening_simuda = mrs.no_rekening_simuda AND MONTH(sstb.tgl_tutup_bulan)=bulan_lalu AND YEAR(sstb.tgl_tutup_bulan)=tahun),
		(SELECT saldo FROM master_detail_rekening_simuda mdrs WHERE mdrs.no_rekening_simuda = mrs.no_rekening_simuda ORDER BY id_detail_rekening_simuda DESC LIMIT 1)
	) AS saldo_bulan_ini,
    
	IF((SELECT COUNT(mdrs.id_detail_rekening_simuda) FROM master_detail_rekening_simuda mdrs WHERE mdrs.no_rekening_simuda = mrs.no_rekening_simuda AND MONTH(mdrs.datetime)=bulan_ini AND YEAR(mdrs.datetime)=tahun) =0,
		(SELECT saldo FROM support_simuda_tutup_bulan sstb WHERE sstb.no_rekening_simuda = mrs.no_rekening_simuda AND MONTH(sstb.tgl_tutup_bulan)=bulan_lalu AND YEAR(sstb.tgl_tutup_bulan)=tahun),
       	(SELECT MIN(saldo) FROM master_detail_rekening_simuda mdrs WHERE mdrs.no_rekening_simuda = mrs.no_rekening_simuda AND MONTH(mdrs.datetime)=bulan_ini AND YEAR(mdrs.datetime)=tahun ORDER BY id_detail_rekening_simuda DESC LIMIT 1)
	) AS saldo_terendah
FROM master_rekening_simuda mrs JOIN anggota a ON mrs.no_anggota = a.no_anggota$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ak_detail_trx_bank`
--

CREATE TABLE `ak_detail_trx_bank` (
  `id_detail_trx_bank` int(11) NOT NULL,
  `kode_trx_bank` varchar(20) NOT NULL,
  `keterangan` text NOT NULL,
  `lawan` varchar(10) NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ak_detail_trx_bank`
--

INSERT INTO `ak_detail_trx_bank` (`id_detail_trx_bank`, `kode_trx_bank`, `keterangan`, `lawan`, `nominal`) VALUES
(2, 'BB-1911-0002', 'Bonus karyawan', '2220.2110', 1000000),
(3, 'BB-1911-0003', 'sklfjsdklf', '2220.2110', 4000000);

-- --------------------------------------------------------

--
-- Table structure for table `ak_detail_trx_kas`
--

CREATE TABLE `ak_detail_trx_kas` (
  `id_detail_trx_kas` int(11) NOT NULL,
  `kode_trx_kas` varchar(20) NOT NULL,
  `keterangan` text NOT NULL,
  `lawan` varchar(10) NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ak_detail_trx_kas`
--

INSERT INTO `ak_detail_trx_kas` (`id_detail_trx_kas`, `kode_trx_kas`, `keterangan`, `lawan`, `nominal`) VALUES
(3, 'BK-1911-0002', 'uuuuuuu', '1120.1110', 5000000),
(4, 'BK-1911-0003', 'jfdsklfjdsl', '1120.1110', 4000000),
(5, 'BK-1911-0004', 'jkdsfjdsl', '1120.1110', 1000000),
(6, 'BK-1911-0005', 'flksdl;fk', '1120.1110', 2000000),
(7, 'BK-1911-0006', 'wdsds', '1120.1110', 1222121),
(8, 'BK-1911-0007', 'fdsfdf', '1120.1110', 211212),
(9, 'BK-1911-0008', 'gfgfg', '1120.1110', 12312321),
(10, 'BK-1911-0009', 'fgfgfgf', '1120.1110', 123123123),
(11, 'BK-1911-0010', 'asdfkj', '1120.1110', 9000000);

-- --------------------------------------------------------

--
-- Table structure for table `ak_detail_trx_memorial`
--

CREATE TABLE `ak_detail_trx_memorial` (
  `id_detail_trx_memorial` int(11) NOT NULL,
  `kode_trx_memorial` varchar(20) NOT NULL,
  `keterangan` text NOT NULL,
  `kode_perkiraan` varchar(10) NOT NULL,
  `lawan` varchar(10) NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ak_detail_trx_memorial`
--

INSERT INTO `ak_detail_trx_memorial` (`id_detail_trx_memorial`, `kode_trx_memorial`, `keterangan`, `kode_perkiraan`, `lawan`, `nominal`) VALUES
(1, 'BM-1911-0001', 'Memo', '1120.1110', '2220.2110', 35000000);

-- --------------------------------------------------------

--
-- Table structure for table `ak_jurnal`
--

CREATE TABLE `ak_jurnal` (
  `id_jurnal` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `kode_transaksi` varchar(20) DEFAULT NULL,
  `keterangan` text NOT NULL,
  `kode` varchar(10) NOT NULL,
  `lawan` varchar(10) NOT NULL,
  `tipe` enum('K','D') NOT NULL,
  `nominal` float NOT NULL,
  `tipe_trx_koperasi` enum('SimPokok','SimWajib','Simuda','Sijaka','Kredit','Kas','Bank','Memorial') NOT NULL,
  `id_detail` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ak_jurnal`
--

INSERT INTO `ak_jurnal` (`id_jurnal`, `tanggal`, `kode_transaksi`, `keterangan`, `kode`, `lawan`, `tipe`, `nominal`, `tipe_trx_koperasi`, `id_detail`) VALUES
(6, '2019-11-13 01:35:01', 'BK-1911-0009', 'fgfgfgf', '1112.1110', '1120.1110', 'K', 123123000, 'SimPokok', 10),
(7, '2019-11-14 01:37:26', 'BK-1911-0010', 'asdfkj', '1112.1110', '1120.1110', 'D', 9000000, 'Kas', 11),
(11, '2019-11-14 22:41:37', 'BB-1911-0002', 'Bonus karyawan', '1110.1110', '2220.2110', 'K', 1000000, 'Kas', 2),
(12, '2019-11-14 22:44:02', 'BB-1911-0003', 'sklfjsdklf', '1110.1110', '2220.2110', 'K', 4000000, 'Bank', 3),
(13, '2019-11-14 00:00:12', 'BM-1911-0001', 'Memo', '1120.1110', '2220.2110', 'D', 35000000, 'Memorial', 1),
(16, '2019-12-03 00:00:00', NULL, '', '', '', 'K', 505000, 'Kredit', 0),
(17, '2019-12-26 11:11:00', NULL, '', '', '', 'K', 50000, 'Simuda', 12),
(18, '2019-12-26 11:12:00', NULL, '', '', '', 'K', 50000, 'Simuda', 13);

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
  `saldo_awal` double NOT NULL,
  `kode_induk` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ak_rekening`
--

INSERT INTO `ak_rekening` (`kode_rekening`, `nama`, `inisial`, `saldo_awal`, `kode_induk`) VALUES
('1111.1110', 'Kas Kecil', 'KK', 10000, '1111'),
('1111.1120', 'Kas Besar', '', 0, '1111');

-- --------------------------------------------------------

--
-- Table structure for table `ak_set_rekening`
--

CREATE TABLE `ak_set_rekening` (
  `id_ak_set_rekening` int(11) NOT NULL,
  `jenis_trx` varchar(15) NOT NULL,
  `rek_debet` varchar(12) NOT NULL,
  `rek_kredit` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ak_trx_bank`
--

CREATE TABLE `ak_trx_bank` (
  `kode_trx_bank` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `kode_perkiraan` varchar(10) NOT NULL,
  `tipe` enum('D','K') NOT NULL,
  `nomor` int(4) UNSIGNED ZEROFILL NOT NULL,
  `grand_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ak_trx_bank`
--

INSERT INTO `ak_trx_bank` (`kode_trx_bank`, `tanggal`, `kode_perkiraan`, `tipe`, `nomor`, `grand_total`) VALUES
('BB-1911-0002', '2019-11-14', '1110.1110', 'K', 0002, 1000000),
('BB-1911-0003', '2019-11-14', '1110.1110', 'K', 0003, 4000000);

-- --------------------------------------------------------

--
-- Table structure for table `ak_trx_kas`
--

CREATE TABLE `ak_trx_kas` (
  `kode_trx_kas` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `kode_perkiraan` varchar(10) NOT NULL,
  `tipe` enum('D','K') NOT NULL,
  `nomor` int(4) UNSIGNED ZEROFILL NOT NULL,
  `grand_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ak_trx_kas`
--

INSERT INTO `ak_trx_kas` (`kode_trx_kas`, `tanggal`, `kode_perkiraan`, `tipe`, `nomor`, `grand_total`) VALUES
('BK-1911-0002', '2019-11-07', '1112.1110', 'D', 0002, 5000000),
('BK-1911-0003', '2019-11-08', '1112.1110', 'D', 0003, 4000000),
('BK-1911-0004', '2019-11-16', '1112.1110', 'D', 0004, 1000000),
('BK-1911-0005', '2019-11-14', '1112.1110', 'D', 0005, 2000000),
('BK-1911-0006', '2019-11-08', '1112.1110', 'D', 0006, 1222121),
('BK-1911-0007', '2019-11-15', '1112.1110', 'D', 0007, 211212),
('BK-1911-0008', '2019-11-14', '1112.1110', 'D', 0008, 12312321),
('BK-1911-0009', '2019-11-13', '1112.1110', 'K', 0009, 123123123),
('BK-1911-0010', '2019-11-14', '1112.1110', 'D', 0010, 9000000);

-- --------------------------------------------------------

--
-- Table structure for table `ak_trx_memorial`
--

CREATE TABLE `ak_trx_memorial` (
  `kode_trx_memorial` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `tipe` enum('D','K') NOT NULL,
  `nomor` int(4) UNSIGNED ZEROFILL NOT NULL,
  `grand_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ak_trx_memorial`
--

INSERT INTO `ak_trx_memorial` (`kode_trx_memorial`, `tanggal`, `tipe`, `nomor`, `grand_total`) VALUES
('BM-1911-0001', '2019-11-14', 'D', 0001, 35000000);

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
(1223, 'ASCD', 'asas', '0000-00-00', 1);

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
  `jml_pokok` float NOT NULL,
  `jml_bahas` float NOT NULL,
  `denda` float NOT NULL,
  `total` float NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_detail_rekening_pembiayaan`
--

INSERT INTO `master_detail_rekening_pembiayaan` (`id_detail_rekening_pembiayaan`, `no_rekening_pembiayaan`, `tanggal_pembayaran`, `periode_tagihan`, `jml_pokok`, `jml_bahas`, `denda`, `total`, `id_user`) VALUES
(5, 20001, '2019-12-03', '12-19', 500000, 5000, 0, 505000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_detail_rekening_sijaka`
--

CREATE TABLE `master_detail_rekening_sijaka` (
  `id_detail_sijaka` int(11) NOT NULL,
  `NRSj` smallint(6) NOT NULL,
  `debet` float NOT NULL,
  `kredit` float NOT NULL,
  `saldo` float NOT NULL,
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
  `debet` float NOT NULL,
  `kredit` float NOT NULL,
  `saldo` float NOT NULL,
  `id_user` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_detail_rekening_simuda`
--

INSERT INTO `master_detail_rekening_simuda` (`id_detail_rekening_simuda`, `no_rekening_simuda`, `datetime`, `debet`, `kredit`, `saldo`, `id_user`) VALUES
(5, 1001, '2019-11-10 10:15:29', 0, 250000, 250000, 1),
(6, 1001, '2019-11-10 11:22:00', 0, 10000, 260000, 1),
(7, 1002, '2019-11-10 10:18:01', 0, 50000, 50000, 1),
(8, 1001, '2019-11-10 10:26:04', 0, 58333.3, 318333, 1),
(9, 1002, '2019-11-10 10:26:04', 0, 11666.7, 61666.7, 1),
(10, 1001, '2019-11-10 10:29:24', 0, 8333.33, 326666, 1),
(11, 1002, '2019-11-10 10:29:24', 0, 1666.67, 63333.4, 1),
(13, 1001, '2019-12-26 11:12:00', 0, 50000, 376666, 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_rekening_pembiayaan`
--

CREATE TABLE `master_rekening_pembiayaan` (
  `no_rekening_pembiayaan` int(11) NOT NULL,
  `no_anggota` int(11) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `jumlah_pembiayaan` float NOT NULL,
  `jangka_waktu_bulan` float NOT NULL,
  `jml_pokok_bulanan` float NOT NULL,
  `jml_bahas_bulanan` float NOT NULL,
  `tgl_lunas` date NOT NULL,
  `tgl_temp` date NOT NULL,
  `cicilan_terbayar` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_rekening_pembiayaan`
--

INSERT INTO `master_rekening_pembiayaan` (`no_rekening_pembiayaan`, `no_anggota`, `tgl_pembayaran`, `jumlah_pembiayaan`, `jangka_waktu_bulan`, `jml_pokok_bulanan`, `jml_bahas_bulanan`, `tgl_lunas`, `tgl_temp`, `cicilan_terbayar`) VALUES
(20001, 1212, '2019-12-02', 3000000, 6, 500000, 5000, '2020-06-02', '2020-01-02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `master_rekening_sijaka`
--

CREATE TABLE `master_rekening_sijaka` (
  `NRSj` smallint(6) NOT NULL,
  `no_anggota` int(11) NOT NULL,
  `jumlah_awal` float NOT NULL,
  `jumlah_sekarang` float NOT NULL,
  `jangka_waktu` int(2) NOT NULL,
  `tanggal_awal` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `presentase_bagi_hasil_bulanan` float NOT NULL,
  `pembayaran_bahas` enum('Tunai','Kredit Rekening') NOT NULL,
  `rekening_simuda` int(11) NOT NULL,
  `otomatis_perpanjang` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_rekening_simuda`
--

CREATE TABLE `master_rekening_simuda` (
  `no_rekening_simuda` int(11) NOT NULL,
  `no_anggota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_rekening_simuda`
--

INSERT INTO `master_rekening_simuda` (`no_rekening_simuda`, `no_anggota`) VALUES
(1001, 1212),
(1002, 1223);

-- --------------------------------------------------------

--
-- Table structure for table `master_simpanan_pokok`
--

CREATE TABLE `master_simpanan_pokok` (
  `id_simpanan_pokok` int(11) NOT NULL,
  `no_anggota` int(11) NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `jumlah` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_simpanan_pokok`
--

INSERT INTO `master_simpanan_pokok` (`id_simpanan_pokok`, `no_anggota`, `tanggal_pembayaran`, `jumlah`, `id_user`) VALUES
(3, 1212, '2019-11-06', 5000000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_simpanan_wajib`
--

CREATE TABLE `master_simpanan_wajib` (
  `id_simpanan_wajib` int(11) NOT NULL,
  `no_anggota` int(11) NOT NULL,
  `tgl_temp` date NOT NULL,
  `tgl_pembayaran` datetime NOT NULL,
  `debet` float NOT NULL,
  `kredit` float NOT NULL,
  `saldo` float NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_simpanan_wajib`
--

INSERT INTO `master_simpanan_wajib` (`id_simpanan_wajib`, `no_anggota`, `tgl_temp`, `tgl_pembayaran`, `debet`, `kredit`, `saldo`, `id_user`) VALUES
(127, 1212, '2019-11-01', '2019-11-10 10:22:00', 0, 25000, 25000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `otorisasi`
--

CREATE TABLE `otorisasi` (
  `id_otorisasi` int(11) NOT NULL,
  `tipe` enum('Simuda','Sijaka','Kredit') NOT NULL,
  `no_rek` int(11) NOT NULL,
  `nominal_debet` float NOT NULL,
  `status` enum('Open','Accepted','Declined') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `otorisasi`
--

INSERT INTO `otorisasi` (`id_otorisasi`, `tipe`, `no_rek`, `nominal_debet`, `status`) VALUES
(2, 'Simuda', 1021, 3000000, 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `support_limit_simuda`
--

CREATE TABLE `support_limit_simuda` (
  `id_limit_simuda` tinyint(1) NOT NULL,
  `nominal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `support_limit_simuda`
--

INSERT INTO `support_limit_simuda` (`id_limit_simuda`, `nominal`) VALUES
(1, 2500000);

-- --------------------------------------------------------

--
-- Table structure for table `support_simuda_tutup_bulan`
--

CREATE TABLE `support_simuda_tutup_bulan` (
  `id_support_simuda_tutup_bulan` int(11) NOT NULL,
  `no_rekening_simuda` int(11) NOT NULL,
  `tgl_tutup_bulan` datetime NOT NULL,
  `saldo` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `support_simuda_tutup_bulan`
--

INSERT INTO `support_simuda_tutup_bulan` (`id_support_simuda_tutup_bulan`, `no_rekening_simuda`, `tgl_tutup_bulan`, `saldo`) VALUES
(4, 1001, '2019-11-10 10:29:24', 326666),
(5, 1002, '2019-11-10 10:29:24', 63333.4);

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

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_simpanan_wajib`
-- (See below for the actual view)
--
CREATE TABLE `v_simpanan_wajib` (
`no_anggota` int(11)
,`nama` varchar(30)
,`saldo` float
);

-- --------------------------------------------------------

--
-- Structure for view `v_simpanan_wajib`
--
DROP TABLE IF EXISTS `v_simpanan_wajib`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_simpanan_wajib`  AS  select distinct `a`.`no_anggota` AS `no_anggota`,`a`.`nama` AS `nama`,(select `w`.`saldo` from `master_simpanan_wajib` `w` where `w`.`no_anggota` = `m`.`no_anggota` order by `w`.`id_simpanan_wajib` desc limit 1) AS `saldo` from (`anggota` `a` left join `master_simpanan_wajib` `m` on(`m`.`no_anggota` = `a`.`no_anggota`)) ;

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
  ADD PRIMARY KEY (`kode_rekening`),
  ADD KEY `kode_induk` (`kode_induk`);

--
-- Indexes for table `ak_set_rekening`
--
ALTER TABLE `ak_set_rekening`
  ADD PRIMARY KEY (`id_ak_set_rekening`);

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
-- Indexes for table `master_detail_rekening_sijaka`
--
ALTER TABLE `master_detail_rekening_sijaka`
  ADD PRIMARY KEY (`id_detail_sijaka`),
  ADD KEY `NRSj` (`NRSj`);

--
-- Indexes for table `master_detail_rekening_simuda`
--
ALTER TABLE `master_detail_rekening_simuda`
  ADD PRIMARY KEY (`id_detail_rekening_simuda`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `no_rekening_simuda` (`no_rekening_simuda`);

--
-- Indexes for table `master_rekening_pembiayaan`
--
ALTER TABLE `master_rekening_pembiayaan`
  ADD PRIMARY KEY (`no_rekening_pembiayaan`),
  ADD KEY `no_anggota` (`no_anggota`);

--
-- Indexes for table `master_rekening_sijaka`
--
ALTER TABLE `master_rekening_sijaka`
  ADD PRIMARY KEY (`NRSj`),
  ADD KEY `no_anggota` (`no_anggota`),
  ADD KEY `rekening_simuda` (`rekening_simuda`);

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
-- Indexes for table `otorisasi`
--
ALTER TABLE `otorisasi`
  ADD PRIMARY KEY (`id_otorisasi`),
  ADD KEY `no_rek` (`no_rek`);

--
-- Indexes for table `support_limit_simuda`
--
ALTER TABLE `support_limit_simuda`
  ADD PRIMARY KEY (`id_limit_simuda`);

--
-- Indexes for table `support_simuda_tutup_bulan`
--
ALTER TABLE `support_simuda_tutup_bulan`
  ADD PRIMARY KEY (`id_support_simuda_tutup_bulan`),
  ADD KEY `no_rekening_simuda` (`no_rekening_simuda`);

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
  MODIFY `id_detail_trx_bank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ak_detail_trx_kas`
--
ALTER TABLE `ak_detail_trx_kas`
  MODIFY `id_detail_trx_kas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ak_detail_trx_memorial`
--
ALTER TABLE `ak_detail_trx_memorial`
  MODIFY `id_detail_trx_memorial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ak_jurnal`
--
ALTER TABLE `ak_jurnal`
  MODIFY `id_jurnal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `ak_set_rekening`
--
ALTER TABLE `ak_set_rekening`
  MODIFY `id_ak_set_rekening` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id_detail_rekening_pembiayaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `master_detail_rekening_sijaka`
--
ALTER TABLE `master_detail_rekening_sijaka`
  MODIFY `id_detail_sijaka` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_detail_rekening_simuda`
--
ALTER TABLE `master_detail_rekening_simuda`
  MODIFY `id_detail_rekening_simuda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `master_simpanan_pokok`
--
ALTER TABLE `master_simpanan_pokok`
  MODIFY `id_simpanan_pokok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `master_simpanan_wajib`
--
ALTER TABLE `master_simpanan_wajib`
  MODIFY `id_simpanan_wajib` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `otorisasi`
--
ALTER TABLE `otorisasi`
  MODIFY `id_otorisasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `support_limit_simuda`
--
ALTER TABLE `support_limit_simuda`
  MODIFY `id_limit_simuda` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `support_simuda_tutup_bulan`
--
ALTER TABLE `support_simuda_tutup_bulan`
  MODIFY `id_support_simuda_tutup_bulan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Constraints for table `master_detail_rekening_sijaka`
--
ALTER TABLE `master_detail_rekening_sijaka`
  ADD CONSTRAINT `master_detail_rekening_sijaka_ibfk_1` FOREIGN KEY (`NRSj`) REFERENCES `master_rekening_sijaka` (`NRSj`) ON UPDATE CASCADE;

--
-- Constraints for table `master_detail_rekening_simuda`
--
ALTER TABLE `master_detail_rekening_simuda`
  ADD CONSTRAINT `master_detail_rekening_simuda_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `master_detail_rekening_simuda_ibfk_3` FOREIGN KEY (`no_rekening_simuda`) REFERENCES `master_rekening_simuda` (`no_rekening_simuda`);

--
-- Constraints for table `master_rekening_pembiayaan`
--
ALTER TABLE `master_rekening_pembiayaan`
  ADD CONSTRAINT `master_rekening_pembiayaan_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`);

--
-- Constraints for table `master_rekening_sijaka`
--
ALTER TABLE `master_rekening_sijaka`
  ADD CONSTRAINT `master_rekening_sijaka_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`) ON UPDATE CASCADE;

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
  ADD CONSTRAINT `master_simpanan_wajib_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`) ON UPDATE CASCADE;

--
-- Constraints for table `support_temp_tgl_simpanan_wajib`
--
ALTER TABLE `support_temp_tgl_simpanan_wajib`
  ADD CONSTRAINT `support_temp_tgl_simpanan_wajib_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
