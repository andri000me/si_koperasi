-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Jan 2020 pada 11.32
-- Versi server: 10.1.37-MariaDB
-- Versi PHP: 7.3.0

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
-- Prosedur
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `getNominatifSimuda` (IN `old_month` VARCHAR(2), IN `old_year` YEAR)  NO SQL
SELECT 
	mrs.no_rekening_simuda, mrs.no_anggota, a.nama, 
    
	(SELECT saldo FROM master_detail_rekening_simuda mdrs WHERE mdrs.no_rekening_simuda=mrs.no_rekening_simuda AND MONTH(mdrs.datetime)<=old_month AND YEAR(mdrs.datetime)<=old_year ORDER BY mdrs.id_detail_rekening_simuda DESC LIMIT 1) AS 	saldo_bulan_lalu,
    
    
	(SELECT saldo_terendah FROM master_detail_rekening_simuda mdrs WHERE mdrs.no_rekening_simuda=mrs.no_rekening_simuda AND MONTH(mdrs.datetime)<=old_month AND YEAR(mdrs.datetime)<=old_year ORDER BY mdrs.id_detail_rekening_simuda DESC LIMIT 1) AS 	saldo_terendah_bulan_lalu,
    
    
    (SELECT saldo FROM master_detail_rekening_simuda mdrs WHERE mdrs.no_rekening_simuda=mrs.no_rekening_simuda ORDER BY mdrs.id_detail_rekening_simuda DESC LIMIT 1) AS saldo_bulan_ini,
    
    (SELECT saldo_terendah FROM master_detail_rekening_simuda mdrs WHERE mdrs.no_rekening_simuda=mrs.no_rekening_simuda ORDER BY mdrs.id_detail_rekening_simuda DESC LIMIT 1) AS saldo_terendah
    FROM master_rekening_simuda mrs JOIN anggota a ON mrs.no_anggota = a.no_anggota$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getNominatifSimudaByNoAnggota` (IN `noAnggota` INT, IN `old_month` INT(2), IN `old_year` YEAR)  NO SQL
SELECT 
	mrs.no_rekening_simuda, mrs.no_anggota, a.nama, 
    
	(SELECT saldo FROM master_detail_rekening_simuda mdrs WHERE mdrs.no_rekening_simuda=mrs.no_rekening_simuda AND MONTH(mdrs.datetime)=old_month AND YEAR(mdrs.datetime)=old_year ORDER BY mdrs.id_detail_rekening_simuda DESC LIMIT 1) AS 	saldo_bulan_lalu,
    
    (SELECT saldo_terendah FROM master_detail_rekening_simuda mdrs WHERE mdrs.no_rekening_simuda=mrs.no_rekening_simuda AND MONTH(mdrs.datetime)<=old_month AND YEAR(mdrs.datetime)<=old_year ORDER BY mdrs.id_detail_rekening_simuda DESC LIMIT 1) AS 	saldo_terendah_bulan_lalu,
    
    (SELECT saldo FROM master_detail_rekening_simuda mdrs WHERE mdrs.no_rekening_simuda=mrs.no_rekening_simuda ORDER BY mdrs.id_detail_rekening_simuda DESC LIMIT 1) AS saldo_bulan_ini,
    
    (SELECT saldo_terendah FROM master_detail_rekening_simuda mdrs WHERE mdrs.no_rekening_simuda=mrs.no_rekening_simuda ORDER BY mdrs.id_detail_rekening_simuda DESC LIMIT 1) AS saldo_terendah
    FROM master_rekening_simuda mrs JOIN anggota a ON mrs.no_anggota = a.no_anggota WHERE mrs.no_anggota=noAnggota$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `perhitungan_tutup_bulan_simuda` (IN `bulan_lalu` INT(2), IN `bulan_ini` INT(2), IN `tahun` YEAR)  NO SQL
SELECT 
	mrs.no_rekening_simuda, mrs.no_anggota, a.nama,
    
    IF(bulan_ini='01' OR bulan_ini='1',
    (SELECT saldo FROM support_simuda_tutup_bulan sstb WHERE sstb.no_rekening_simuda = mrs.no_rekening_simuda AND MONTH(sstb.tgl_tutup_bulan)=bulan_lalu AND YEAR(sstb.tgl_tutup_bulan)=2019),
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
-- Struktur dari tabel `ak_detail_trx_bank`
--

CREATE TABLE `ak_detail_trx_bank` (
  `id_detail_trx_bank` int(11) NOT NULL,
  `kode_trx_bank` varchar(20) NOT NULL,
  `keterangan` text NOT NULL,
  `lawan` varchar(10) NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ak_detail_trx_bank`
--

INSERT INTO `ak_detail_trx_bank` (`id_detail_trx_bank`, `kode_trx_bank`, `keterangan`, `lawan`, `nominal`) VALUES
(2, 'BB-1911-0002', 'Bonus karyawan', '2220.2110', 1000000),
(3, 'BB-1911-0003', 'sklfjsdklf', '2220.2110', 4000000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ak_detail_trx_kas`
--

CREATE TABLE `ak_detail_trx_kas` (
  `id_detail_trx_kas` int(11) NOT NULL,
  `kode_trx_kas` varchar(20) NOT NULL,
  `keterangan` text NOT NULL,
  `lawan` varchar(10) NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ak_detail_trx_kas`
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
-- Struktur dari tabel `ak_detail_trx_memorial`
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
-- Dumping data untuk tabel `ak_detail_trx_memorial`
--

INSERT INTO `ak_detail_trx_memorial` (`id_detail_trx_memorial`, `kode_trx_memorial`, `keterangan`, `kode_perkiraan`, `lawan`, `nominal`) VALUES
(1, 'BM-1911-0001', 'Memo', '1120.1110', '2220.2110', 35000000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ak_jurnal`
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
  `id_detail` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ak_jurnal`
--

INSERT INTO `ak_jurnal` (`id_jurnal`, `tanggal`, `kode_transaksi`, `keterangan`, `kode`, `lawan`, `tipe`, `nominal`, `tipe_trx_koperasi`, `id_detail`) VALUES
(30, '2020-01-12 13:05:16', NULL, '', '', '', 'D', 4900, 'Sijaka', NULL),
(31, '2020-01-12 13:48:14', NULL, '', '', '', 'D', 4900, 'Sijaka', NULL),
(32, '2020-01-12 13:48:15', NULL, '', '', '', 'D', 4900, 'Sijaka', NULL),
(33, '2020-01-12 13:48:28', NULL, '', '', '', 'D', 4900, 'Sijaka', NULL),
(34, '2020-01-12 13:48:28', NULL, '', '', '', 'D', 4900, 'Sijaka', NULL),
(35, '2020-01-12 13:48:53', NULL, '', '', '', 'D', 4900, 'Sijaka', NULL),
(36, '2020-01-12 13:48:53', NULL, '', '', '', 'D', 4900, 'Sijaka', NULL),
(37, '2020-01-12 13:52:28', NULL, '', '', '', 'D', 4900, 'Sijaka', NULL),
(38, '2020-01-12 13:54:32', NULL, '', '', '', 'D', 9900, 'Sijaka', NULL),
(39, '2020-01-12 13:56:19', NULL, '', '', '', 'K', 14800, 'Sijaka', NULL),
(40, '2020-01-12 14:07:59', NULL, '', '', '', 'D', 9900, 'Sijaka', NULL),
(41, '2020-01-12 14:08:31', NULL, '', '', '', 'D', 4900, 'Sijaka', NULL),
(42, '2020-01-12 14:11:40', NULL, '', '', '', 'K', 14800, 'Sijaka', NULL),
(43, '2020-01-12 14:14:05', NULL, '', '', '', 'D', 4900, 'Sijaka', NULL),
(44, '2020-01-12 14:15:15', NULL, '', '', '', 'D', 9900, 'Sijaka', NULL),
(45, '2020-01-12 14:16:35', NULL, '', '', '', 'K', 14800, 'Sijaka', NULL),
(46, '2020-01-12 14:16:44', NULL, '', '', '', 'D', 9900, 'Sijaka', NULL),
(47, '2020-01-12 14:19:32', NULL, '', '', '', 'K', 14800, 'Sijaka', NULL),
(48, '2020-01-12 14:20:43', NULL, '', '', '', 'K', 4900, 'Simuda', NULL),
(49, '2020-01-12 14:20:43', NULL, '', '', '', 'K', 4900, 'Simuda', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ak_kode_induk`
--

CREATE TABLE `ak_kode_induk` (
  `kode_induk` varchar(6) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tipe` enum('D','K') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ak_kode_induk`
--

INSERT INTO `ak_kode_induk` (`kode_induk`, `nama`, `tipe`) VALUES
('01.100', 'Kas', 'D'),
('01.110', 'Bank', 'D'),
('01.120', 'Piutang/Pembiayaan', 'D'),
('01.130', 'Cadangan Piutang Ragu-ragu', 'D'),
('01.140', 'Penyertaan', 'D'),
('01.150', 'Aktiva Tetap', 'D'),
('01.160', 'Penyusutan Aktiva Tetap', 'K'),
('01.170', 'Aktiva Lain-lain', 'D'),
('01.200', 'Kewajiban Segera', 'K'),
('01.210', 'Hutang Kepada Anggota', 'K'),
('01.230', 'Hutang Jangka Pendek', 'K'),
('01.240', 'Hutang Jangka Panjang', 'K'),
('01.250', 'Kewajiban Lainnya', 'K'),
('01.260', 'Modal', 'K'),
('01.270', 'SHU Tahun Lalu', 'K'),
('01.280', 'SHU Tahun Berjalan', 'K'),
('02.100', 'PENDAPATAN', 'K'),
('02.110', 'Bunga Bank', 'K'),
('02.120', 'Bahas Piutang/Pembiayaan', 'K'),
('02.130', 'Provisi & Administrasi', 'K'),
('02.140', 'Lainnya', 'K'),
('02.200', 'BIAYA - BIAYA', 'D'),
('02.210', 'Biaya Bagi Hasil Usaha', 'D'),
('02.220', 'Gaji & Honorarium', 'D'),
('02.230', 'Pendidikan Dan Pelatihan', 'D'),
('02.240', 'Sewa', 'D'),
('02.250', 'Pajak - Pajak', 'D'),
('02.260', 'Pemeliharaan & Perbaikan', 'D'),
('02.270', 'Barang Dan Jasa', 'D'),
('02.280', 'Penghapus Bukuan Piutang     ', 'D'),
('02.290', 'Penyusutan Aktiva Tetap ', 'D'),
('02.300', 'Biaya Non Operasional', 'D'),
('02.310', 'SHU Sebelum Pajak', 'K'),
('02.320', 'Pajak Penghasilan', 'D'),
('02.330', 'SISA HASIL USAHA', 'K');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ak_rekening`
--

CREATE TABLE `ak_rekening` (
  `kode_rekening` varchar(10) NOT NULL,
  `nama` varchar(60) NOT NULL,
  `saldo_awal` double NOT NULL,
  `kode_induk` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ak_rekening`
--

INSERT INTO `ak_rekening` (`kode_rekening`, `nama`, `saldo_awal`, `kode_induk`) VALUES
('01.100.10', 'Kas Kecil', 0, '01.100'),
('01.100.20', 'Kas Besar', 0, '01.100'),
('01.110.10', 'Bank BPR Jatim', 0, '01.110'),
('01.110.20', 'Bank Rakyat Indonesia', 0, '01.110'),
('01.110.30', 'Bank Jatim', 0, '01.110'),
('01.120.10', 'Pembiayaan Mudharobah', 0, '01.120'),
('01.120.30', 'Pembiayaan Murabahah', 0, '01.120'),
('01.120.40', 'Pembiayaan Lainnya', 0, '01.120'),
('01.130.10', 'Cadangan Piutang Ragu-ragu', 0, '01.130'),
('01.140.10', 'Simpanan Pokok', 0, '01.140'),
('01.140.20', 'Simpanan Wajib', 0, '01.140'),
('01.150.10', 'Tanah & Gedung', 0, '01.150'),
('01.150.20', 'Inventaris', 0, '01.150'),
('01.160.10', 'Tanah & Gedung', 0, '01.160'),
('01.160.20', 'Inventaris', 0, '01.160'),
('01.170.10', 'Biaya Dibayar Dimuka', 0, '01.170'),
('01.170.20', 'Penyediaan Dana', 0, '01.170'),
('01.170.30', 'Lainnya', 0, '01.170'),
('01.200.10', 'PPh. Pasal 21', 0, '01.200'),
('01.200.20', 'PPh. Pasal 25', 0, '01.200'),
('01.200.30', 'SHU Segera Dibayar', 0, '01.200'),
('01.200.40', 'Bagi Hasil Simuda Segera Dbyr', 0, '01.200'),
('01.200.50', 'Bagi Hasil Sijaka Segera Dbyr', 0, '01.200'),
('01.200.60', 'Lainnya', 0, '01.200'),
('01.210.10', 'Hutang Mudharabah', 0, '01.210'),
('01.210.20', 'Hutang Mudharabah Berjangka', 0, '01.210'),
('01.210.30', 'Hutang Lain-lain', 0, '01.210'),
('01.230.10', 'Hutang Jangka Pendek', 0, '01.230'),
('01.240.10', 'Hutang Pada Pemerintah', 0, '01.240'),
('01.240.20', 'Hutang Pada Bank', 0, '01.240'),
('01.240.30', 'Hutang Pada Koperasi', 0, '01.240'),
('01.250.10', 'Zakat, Infaq Dan Shodaqoh', 0, '01.250'),
('01.250.20', 'Pendapatan Diterima Dimuka', 0, '01.250'),
('01.250.30', 'Lainnya', 0, '01.250'),
('01.260.10', 'Simpanan Pokok Anggota', 0, '01.260'),
('01.260.20', 'Simpanan Wajib Anggota', 0, '01.260'),
('01.260.30', 'Donasi', 0, '01.260'),
('01.260.40', 'Cadangan Umum', 0, '01.260'),
('01.260.50', 'Cadangan Tujuan', 0, '01.260'),
('01.260.60', 'Modal Investasi Lainnya', 0, '01.260'),
('01.270.10', 'SHU Tahun Lalu', 0, '01.270'),
('01.280.10', 'SHU Tahun Berjalan', 0, '01.280'),
('02.110.10', 'Bunga Bank BPR JATIM', 0, '02.110'),
('02.110.20', 'Bunga Bank BRI', 0, '02.110'),
('02.110.30', 'Bunga Bank Jatim', 0, '02.110'),
('02.120.10', 'Bagi Hasil Pembiyaan Mudharobah', 0, '02.120'),
('02.120.20', 'Bagi Hasil Pembiyaan Murabahah', 0, '02.120'),
('02.120.30', 'Bagi Hasil Pembiyaan Lainnya', 0, '02.120'),
('02.130.10', 'Provisi & Administrasi', 0, '02.130'),
('02.140.10', 'Lainnya', 0, '02.140'),
('02.210.10', 'Simpanan Mudharabah', 0, '02.210'),
('02.210.20', 'Simpanan Berjangka', 0, '02.210'),
('02.210.30', 'Pinjaman', 0, '02.210'),
('02.210.40', 'Lainnya', 0, '02.210'),
('02.220.10', 'Honor Pengurus & BP', 0, '02.220'),
('02.220.20', 'Gaji Pegawai', 0, '02.220'),
('02.220.30', 'Lainnya', 0, '02.220'),
('02.230.10', 'Pendidikan Dan Pelatihan', 0, '02.230'),
('02.240.10', 'Sewa', 0, '02.240'),
('02.250.10', 'Pajak - Pajak', 0, '02.250'),
('02.260.10', 'Pemeliharaan & Perbaikan', 0, '02.260'),
('02.270.10', 'Rekening Tellepon', 0, '02.270'),
('02.270.20', 'Rekening Lestrik', 0, '02.270'),
('02.270.30', 'Rekening Air', 0, '02.270'),
('02.270.40', 'Administrasi Kantor (ATK)', 0, '02.270'),
('02.270.50', 'BBM', 0, '02.270'),
('02.270.60', 'Perjalanan Dinas', 0, '02.270'),
('02.270.70', 'Biaya Umum', 0, '02.270'),
('02.270.80', 'Biaya Barang & Jasa Lainnya', 0, '02.270'),
('02.280.10', 'Penghapus Bukuan Piutang     ', 0, '02.280'),
('02.290.10', 'Penyusutan Gedung', 0, '02.290'),
('02.290.20', 'Penyusutan Inventaris', 0, '02.290'),
('02.300.10', 'Biaya Non Operasional', 0, '02.300'),
('02.310.10', 'SHU Sebelum Pajak', 0, '02.310'),
('02.320.10', 'Pajak Penghasilan', 0, '02.320'),
('02.330.10', 'SISA HASIL USAHA', 0, '02.330');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ak_set_rekening`
--

CREATE TABLE `ak_set_rekening` (
  `id_ak_set_rekening` int(11) NOT NULL,
  `jenis_trx` varchar(15) NOT NULL,
  `rek_debet` varchar(12) NOT NULL,
  `rek_kredit` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ak_trx_bank`
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
-- Dumping data untuk tabel `ak_trx_bank`
--

INSERT INTO `ak_trx_bank` (`kode_trx_bank`, `tanggal`, `kode_perkiraan`, `tipe`, `nomor`, `grand_total`) VALUES
('BB-1911-0002', '2019-11-14', '1110.1110', 'K', 0002, 1000000),
('BB-1911-0003', '2019-11-14', '1110.1110', 'K', 0003, 4000000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ak_trx_kas`
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
-- Dumping data untuk tabel `ak_trx_kas`
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
-- Struktur dari tabel `ak_trx_memorial`
--

CREATE TABLE `ak_trx_memorial` (
  `kode_trx_memorial` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `tipe` enum('D','K') NOT NULL,
  `nomor` int(4) UNSIGNED ZEROFILL NOT NULL,
  `grand_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ak_trx_memorial`
--

INSERT INTO `ak_trx_memorial` (`kode_trx_memorial`, `tanggal`, `tipe`, `nomor`, `grand_total`) VALUES
('BM-1911-0001', '2019-11-14', 'D', 0001, 35000000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `no_anggota` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `tgl_daftar` date NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`no_anggota`, `nama`, `alamat`, `tgl_daftar`, `status`) VALUES
(1212, 'Dimas', 'ass', '0000-00-00', 1),
(1223, 'Ari', 'asas', '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_activity`
--

CREATE TABLE `log_activity` (
  `id_log_activity` int(11) NOT NULL,
  `id_user` int(2) NOT NULL,
  `datetime` datetime NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `log_activity`
--

INSERT INTO `log_activity` (`id_log_activity`, `id_user`, `datetime`, `keterangan`) VALUES
(1, 1, '2019-12-27 10:52:48', 'Menginput transaksi simuda dari no rekening1001'),
(2, 1, '2019-12-27 11:07:40', 'Menginput transaksi simuda dari no rekening1001'),
(3, 1, '2019-12-27 11:09:24', 'Menginput transaksi simuda dari no rekening1001'),
(4, 1, '2020-01-06 14:37:13', 'Menginput buka rekening simuda dengan no rekening simuda Dimas Yudha Pratama dengan no anggota 1212'),
(5, 1, '2020-01-06 14:37:13', 'Menginput transaksi simuda dari no rekening0'),
(6, 1, '2020-01-06 14:37:48', 'Menginput buka rekening simuda dengan no rekening simuda 1001 dengan no anggota 1212'),
(7, 1, '2020-01-06 14:37:48', 'Menginput transaksi simuda dari no rekening1001'),
(8, 1, '2020-01-06 14:39:00', 'Menginput buka rekening simuda dengan no rekening simuda 1001 dengan no anggota 1212'),
(9, 1, '2020-01-06 14:39:00', 'Menginput transaksi simuda dari no rekening1001'),
(10, 1, '2020-01-06 14:54:30', 'Menginput transaksi simuda dari no rekening1001'),
(11, 1, '2020-01-06 15:50:56', 'Menginput transaksi simuda dari no rekening1001'),
(12, 1, '2020-01-06 15:52:00', 'Menginput transaksi simuda dari no rekening1001'),
(13, 1, '2019-12-06 17:04:47', 'Menginput buka rekening simuda dengan no rekening simuda 1001 dengan no anggota 1212'),
(14, 1, '2019-12-06 17:04:47', 'Menginput transaksi simuda dari no rekening1001'),
(15, 1, '2019-12-06 17:05:05', 'Menginput transaksi simuda dari no rekening1001'),
(16, 1, '2019-12-06 17:05:20', 'Menginput transaksi simuda dari no rekening1001'),
(17, 1, '2019-12-06 17:09:24', 'Menginput buka rekening simuda dengan no rekening simuda 1001 dengan no anggota 1212'),
(18, 1, '2019-12-06 17:09:24', 'Menginput transaksi simuda dari no rekening1001'),
(19, 1, '2019-12-06 17:18:10', 'Menginput buka rekening simuda dengan no rekening simuda 1001 dengan no anggota 1212'),
(20, 1, '2019-12-06 17:18:10', 'Menginput transaksi simuda dari no rekening1001'),
(21, 1, '2019-12-06 17:18:56', 'Menginput transaksi simuda dari no rekening1001'),
(22, 1, '2019-12-06 17:19:16', 'Menginput transaksi simuda dari no rekening1001'),
(23, 1, '2020-01-06 17:20:22', 'Menginput transaksi simuda dari no rekening1001'),
(24, 1, '2020-01-06 21:29:40', 'Menginput transaksi simuda dari no rekening1001'),
(25, 1, '2020-12-06 22:27:56', 'Menginput buka rekening simuda dengan no rekening simuda 1002 dengan no anggota 1223'),
(26, 1, '2020-12-06 22:27:56', 'Menginput transaksi simuda dari no rekening1002'),
(27, 1, '2020-12-06 22:28:30', 'Menginput transaksi simuda dari no rekening1002'),
(28, 1, '2019-12-06 22:33:24', 'Menginput buka rekening simuda dengan no rekening simuda 1002 dengan no anggota 1223'),
(29, 1, '2019-12-06 22:33:24', 'Menginput transaksi simuda dari no rekening1002'),
(30, 1, '2019-12-06 22:33:55', 'Menginput transaksi simuda dari no rekening1001'),
(31, 1, '2019-12-06 22:34:53', 'Menginput transaksi simuda dari no rekening1002'),
(32, 1, '2019-12-06 22:37:11', 'Menginput transaksi simuda dari no rekening1002'),
(33, 1, '2019-12-06 23:05:59', 'Menginput transaksi simuda dari no rekening1001'),
(34, 1, '2019-12-06 23:07:13', 'Melakukan otorisasi dengan status Accepted'),
(35, 1, '2019-12-06 23:07:13', 'Menginput transaksi simuda dari no rekening1001'),
(36, 1, '2019-12-06 23:13:10', 'Melakukan otorisasi dengan status Accepted'),
(37, 1, '2019-12-06 23:13:10', 'Menginput transaksi simuda dari no rekening1001'),
(38, 1, '2019-12-06 23:16:17', 'Menginput buka rekening simuda dengan no rekening simuda 1003 dengan no anggota 1212'),
(39, 1, '2019-12-06 23:16:17', 'Menginput transaksi simuda dari no rekening1003'),
(40, 1, '2019-12-06 23:16:55', 'Melakukan otorisasi dengan status Accepted'),
(41, 1, '2019-12-06 23:16:55', 'Menginput transaksi simuda dari no rekening1003'),
(42, 1, '2020-01-08 16:59:19', 'Menginput transaksi simuda dari no rekening1001'),
(43, 1, '2020-01-08 18:10:29', 'Menginput transaksi simuda dari no rekening1001'),
(44, 1, '2020-01-08 18:10:29', 'Menginput transaksi simuda dari no rekening1003'),
(45, 1, '2020-01-08 18:10:29', 'Menginput transaksi simuda dari no rekening1002'),
(46, 1, '2020-01-08 20:28:58', 'Menginput buka rekening simuda dengan no rekening simuda 1004 dengan no anggota 1223'),
(47, 1, '2020-01-08 20:28:58', 'Menginput transaksi simuda dari no rekening1004'),
(48, 1, '2020-01-08 21:39:38', 'Menginput pembiayaan dengan no rekening 3001 dari anggota 1212 dengan nominal 1200000'),
(49, 1, '2020-01-12 14:20:26', 'Menginput transaksi simuda dari no rekening1001'),
(50, 1, '2020-01-12 14:20:26', 'Menginput transaksi simuda dari no rekening1001'),
(51, 1, '2020-01-12 14:20:43', 'Menginput transaksi simuda dari no rekening1001'),
(52, 1, '2020-01-12 14:20:43', 'Menginput transaksi simuda dari no rekening1001'),
(53, 1, '2020-01-12 17:19:42', 'Menginput transaksi simuda dari no rekening1001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_detail_rekening_pembiayaan`
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
-- Dumping data untuk tabel `master_detail_rekening_pembiayaan`
--

INSERT INTO `master_detail_rekening_pembiayaan` (`id_detail_rekening_pembiayaan`, `no_rekening_pembiayaan`, `tanggal_pembayaran`, `periode_tagihan`, `jml_pokok`, `jml_bahas`, `denda`, `total`, `id_user`) VALUES
(5, 20001, '2019-12-03', '12-19', 500000, 5000, 0, 505000, 1);

--
-- Trigger `master_detail_rekening_pembiayaan`
--
DELIMITER $$
CREATE TRIGGER `after_insert_detail_pembiayaan_trigger` AFTER INSERT ON `master_detail_rekening_pembiayaan` FOR EACH ROW INSERT INTO log_activity(id_user, datetime, keterangan) VALUES (NEW.id_user, now(), CONCAT('Menginput transaksi pembiayaan dari no rekening pembiayaan ', NEW.no_rekening_pembiayaan))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_detail_rekening_sijaka`
--

CREATE TABLE `master_detail_rekening_sijaka` (
  `id_detail_sijaka` int(11) NOT NULL,
  `NRSj` smallint(6) NOT NULL,
  `debet` float NOT NULL,
  `kredit` float NOT NULL,
  `saldo` float NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Trigger `master_detail_rekening_sijaka`
--
DELIMITER $$
CREATE TRIGGER `after_insert_detail_sijaka_trigger` AFTER INSERT ON `master_detail_rekening_sijaka` FOR EACH ROW INSERT INTO log_activity(id_user, datetime, keterangan) VALUES (NEW.id_user, now(), CONCAT('Menginput transaksi sijaka dari no rekening sijaka ', NEW.NRSj))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_detail_rekening_simuda`
--

CREATE TABLE `master_detail_rekening_simuda` (
  `id_detail_rekening_simuda` int(11) NOT NULL,
  `no_rekening_simuda` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `debet` float NOT NULL,
  `kredit` float NOT NULL,
  `saldo` float NOT NULL,
  `saldo_terendah` float NOT NULL,
  `id_user` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_detail_rekening_simuda`
--

INSERT INTO `master_detail_rekening_simuda` (`id_detail_rekening_simuda`, `no_rekening_simuda`, `datetime`, `debet`, `kredit`, `saldo`, `saldo_terendah`, `id_user`) VALUES
(1, 1001, '2019-10-06 17:18:10', 0, 30000, 15000, 10000, 1),
(2, 1001, '2019-12-06 17:18:10', 0, 20000, 20000, 20000, 1),
(3, 1001, '2019-12-06 17:18:56', 0, 50000, 70000, 20000, 1),
(4, 1001, '2019-12-06 17:19:16', 40000, 0, 30000, 20000, 1),
(9, 1002, '2019-12-06 22:33:24', 0, 50000, 50000, 50000, 1),
(11, 1002, '2019-12-06 22:34:53', 0, 10000, 60000, 50000, 1),
(12, 1002, '2019-12-06 22:37:11', 20000, 0, 40000, 40000, 1),
(13, 1001, '2019-12-06 23:05:59', 0, 100000, 130000, 20000, 1),
(14, 1001, '2019-12-06 23:07:13', 50000, 0, 80000, 80000, 1),
(16, 1003, '2019-12-06 23:16:17', 0, 100000, 100000, 100000, 1),
(17, 1003, '2019-12-06 23:16:55', 60000, 0, 40000, 40000, 1),
(18, 1001, '2020-01-08 16:59:19', 0, 70000, 150000, 150000, 1),
(19, 1001, '2020-01-08 18:10:29', 0, 12500, 162500, 150000, 1),
(20, 1003, '2020-01-08 18:10:29', 0, 6250, 46250, 46250, 1),
(21, 1002, '2020-01-08 18:10:29', 0, 6250, 46250, 46250, 1),
(22, 1004, '2020-01-08 20:28:58', 0, 100000, 100000, 100000, 1),
(23, 1001, '2020-01-12 14:20:26', 0, 4900, 167400, 150000, 1),
(24, 1001, '2020-01-12 14:20:26', 0, 4900, 172300, 150000, 1),
(25, 1001, '2020-01-12 14:20:43', 0, 4900, 177200, 150000, 1),
(26, 1001, '2020-01-12 14:20:43', 0, 4900, 182100, 150000, 1),
(27, 1001, '2020-01-12 06:26:00', 0, 50000, 0, 0, 1);

--
-- Trigger `master_detail_rekening_simuda`
--
DELIMITER $$
CREATE TRIGGER `after_insert_detail_simuda_trigger` AFTER INSERT ON `master_detail_rekening_simuda` FOR EACH ROW INSERT INTO log_activity(id_user, datetime, keterangan) VALUES (NEW.id_user, now(), CONCAT('Menginput transaksi simuda dari no rekening', NEW.no_rekening_simuda))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_rekening_pembiayaan`
--

CREATE TABLE `master_rekening_pembiayaan` (
  `no_rekening_pembiayaan` int(11) NOT NULL,
  `no_anggota` int(11) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `tipe_pembiayaan` enum('Mudharobah','Murabahah') NOT NULL,
  `jumlah_pembiayaan` float NOT NULL,
  `jangka_waktu_bulan` float NOT NULL,
  `jml_pokok_bulanan` float NOT NULL,
  `jml_bahas_bulanan` float NOT NULL,
  `tgl_lunas` date NOT NULL,
  `tgl_temp` date NOT NULL,
  `cicilan_terbayar` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_rekening_pembiayaan`
--

INSERT INTO `master_rekening_pembiayaan` (`no_rekening_pembiayaan`, `no_anggota`, `tgl_pembayaran`, `tipe_pembiayaan`, `jumlah_pembiayaan`, `jangka_waktu_bulan`, `jml_pokok_bulanan`, `jml_bahas_bulanan`, `tgl_lunas`, `tgl_temp`, `cicilan_terbayar`) VALUES
(3001, 1212, '2020-01-08', 'Mudharobah', 1200000, 6, 200000, 3000, '2020-07-08', '2020-02-08', 0),
(20001, 1212, '2019-12-02', 'Mudharobah', 3000000, 6, 500000, 5000, '2020-06-02', '2020-01-02', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_rekening_sijaka`
--

CREATE TABLE `master_rekening_sijaka` (
  `NRSj` smallint(6) NOT NULL,
  `no_anggota` int(11) NOT NULL,
  `jumlah_awal` float NOT NULL,
  `jangka_waktu` int(2) NOT NULL,
  `bulan_berjalan` int(2) NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `jumlah_bahas_bulanan` float NOT NULL,
  `pembayaran_bahas` enum('Tunai','Kredit Rek') NOT NULL,
  `rekening_simuda` int(11) DEFAULT NULL,
  `otomatis_perpanjang` enum('Y','N') NOT NULL,
  `total_bahas` float NOT NULL,
  `grandtotal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_rekening_sijaka`
--

INSERT INTO `master_rekening_sijaka` (`NRSj`, `no_anggota`, `jumlah_awal`, `jangka_waktu`, `bulan_berjalan`, `tanggal_pembayaran`, `tanggal_akhir`, `jumlah_bahas_bulanan`, `pembayaran_bahas`, `rekening_simuda`, `otomatis_perpanjang`, `total_bahas`, `grandtotal`) VALUES
(1500, 1223, 1000000, 3, 1, '2020-01-10', '2020-04-10', 9900, 'Kredit Rek', 1001, 'Y', 0, 0),
(32767, 1212, 700000, 3, 4, '2020-01-11', '2020-04-11', 4900, 'Kredit Rek', 1001, 'Y', 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_rekening_simuda`
--

CREATE TABLE `master_rekening_simuda` (
  `no_rekening_simuda` int(11) NOT NULL,
  `no_anggota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_rekening_simuda`
--

INSERT INTO `master_rekening_simuda` (`no_rekening_simuda`, `no_anggota`) VALUES
(1001, 1212),
(1003, 1212),
(1002, 1223),
(1004, 1223);

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_simpanan_pokok`
--

CREATE TABLE `master_simpanan_pokok` (
  `id_simpanan_pokok` int(11) NOT NULL,
  `no_anggota` int(11) NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `jumlah` int(11) NOT NULL,
  `status_dana` enum('Aktif','Diambil') NOT NULL DEFAULT 'Aktif',
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_simpanan_pokok`
--

INSERT INTO `master_simpanan_pokok` (`id_simpanan_pokok`, `no_anggota`, `tanggal_pembayaran`, `jumlah`, `status_dana`, `id_user`) VALUES
(3, 1212, '2019-11-06', 5000000, 'Diambil', 1);

--
-- Trigger `master_simpanan_pokok`
--
DELIMITER $$
CREATE TRIGGER `after_insert_simp_pokok_trigger` AFTER INSERT ON `master_simpanan_pokok` FOR EACH ROW INSERT INTO log_activity(id_user, datetime, keterangan) VALUES (NEW.id_user, now(), CONCAT('Menginput simpanan pokok dari no anggota ', NEW.no_anggota, ' dengan nominal ', NEW.jumlah))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_simpanan_wajib`
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
-- Dumping data untuk tabel `master_simpanan_wajib`
--

INSERT INTO `master_simpanan_wajib` (`id_simpanan_wajib`, `no_anggota`, `tgl_temp`, `tgl_pembayaran`, `debet`, `kredit`, `saldo`, `id_user`) VALUES
(127, 1212, '2019-11-01', '2019-11-10 10:22:00', 0, 25000, 25000, 1);

--
-- Trigger `master_simpanan_wajib`
--
DELIMITER $$
CREATE TRIGGER `after_insert_simp_wajib_trigger` AFTER INSERT ON `master_simpanan_wajib` FOR EACH ROW INSERT INTO log_activity(id_user, datetime, keterangan) VALUES (NEW.id_user, now(), CONCAT('Menginput simpanan wajib dari no anggota ', NEW.no_anggota))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `otorisasi`
--

CREATE TABLE `otorisasi` (
  `id_otorisasi` int(11) NOT NULL,
  `tanggal_input` datetime NOT NULL,
  `tanggal_persetujuan` datetime NOT NULL,
  `tipe` enum('Simuda','Sijaka','Kredit') NOT NULL,
  `no_rek` int(11) NOT NULL,
  `nominal_debet` float NOT NULL,
  `status` enum('Open','Accepted','Declined') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `otorisasi`
--

INSERT INTO `otorisasi` (`id_otorisasi`, `tanggal_input`, `tanggal_persetujuan`, `tipe`, `no_rek`, `nominal_debet`, `status`) VALUES
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Simuda', 1021, 3000000, 'Accepted'),
(3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Simuda', 1001, 5000000, 'Accepted'),
(4, '2019-12-27 11:07:54', '2019-12-27 11:09:24', 'Simuda', 1001, 5500000, 'Accepted'),
(5, '2019-12-06 23:06:33', '2019-12-06 23:07:13', 'Simuda', 1001, 50000, 'Accepted'),
(6, '2019-12-06 23:12:59', '2019-12-06 23:13:10', 'Simuda', 1001, 60000, 'Accepted'),
(7, '2019-12-06 23:16:41', '2019-12-06 23:16:55', 'Simuda', 1003, 60000, 'Accepted'),
(8, '2020-01-12 01:19:45', '0000-00-00 00:00:00', 'Simuda', 1001, 60000, 'Open');

-- --------------------------------------------------------

--
-- Struktur dari tabel `support_bagi_hasil_sijaka`
--

CREATE TABLE `support_bagi_hasil_sijaka` (
  `id_support_bagi_hasil` int(11) NOT NULL,
  `NRSj` smallint(6) NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `jumlah_pembayaran` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `support_bagi_hasil_sijaka`
--

INSERT INTO `support_bagi_hasil_sijaka` (`id_support_bagi_hasil`, `NRSj`, `tanggal_pembayaran`, `jumlah_pembayaran`) VALUES
(16, 32767, '2020-02-11', 4900),
(17, 1500, '2020-02-10', 9900),
(18, 32767, '2020-02-11', 4900);

-- --------------------------------------------------------

--
-- Struktur dari tabel `support_limit_simuda`
--

CREATE TABLE `support_limit_simuda` (
  `id_limit_simuda` tinyint(1) NOT NULL,
  `nominal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `support_limit_simuda`
--

INSERT INTO `support_limit_simuda` (`id_limit_simuda`, `nominal`) VALUES
(1, 50000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `support_simuda_tutup_bulan`
--

CREATE TABLE `support_simuda_tutup_bulan` (
  `id_support_simuda_tutup_bulan` int(11) NOT NULL,
  `no_rekening_simuda` int(11) NOT NULL,
  `tgl_tutup_bulan` datetime NOT NULL,
  `saldo` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `support_temp_tgl_simpanan_wajib`
--

CREATE TABLE `support_temp_tgl_simpanan_wajib` (
  `id_temp_simpanan_wajib` int(11) NOT NULL,
  `no_anggota` int(11) NOT NULL,
  `tgl_temp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
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
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_terang`, `username`, `password`, `level`, `status`) VALUES
(1, 'Hilman', 'hilman', '$2y$10$vUN0cpM38DYRV7owaLwEVu5YplgoNKRe9ENGTvxirpS.oGsCnjdO.', 'Manager', 1);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_simpanan_wajib`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_simpanan_wajib` (
`no_anggota` int(11)
,`nama` varchar(30)
,`tgl_temp` date
,`saldo` double
);

-- --------------------------------------------------------

--
-- Struktur untuk view `v_simpanan_wajib`
--
DROP TABLE IF EXISTS `v_simpanan_wajib`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_simpanan_wajib`  AS  select distinct `a`.`no_anggota` AS `no_anggota`,`a`.`nama` AS `nama`,(select `w`.`tgl_temp` from `master_simpanan_wajib` `w` where (`w`.`no_anggota` = `m`.`no_anggota`) order by `w`.`id_simpanan_wajib` desc limit 1) AS `tgl_temp`,(select `w`.`saldo` from `master_simpanan_wajib` `w` where (`w`.`no_anggota` = `m`.`no_anggota`) order by `w`.`id_simpanan_wajib` desc limit 1) AS `saldo` from (`anggota` `a` left join `master_simpanan_wajib` `m` on((`m`.`no_anggota` = `a`.`no_anggota`))) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ak_detail_trx_bank`
--
ALTER TABLE `ak_detail_trx_bank`
  ADD PRIMARY KEY (`id_detail_trx_bank`),
  ADD KEY `lawan` (`lawan`);

--
-- Indeks untuk tabel `ak_detail_trx_kas`
--
ALTER TABLE `ak_detail_trx_kas`
  ADD PRIMARY KEY (`id_detail_trx_kas`),
  ADD KEY `lawan` (`lawan`);

--
-- Indeks untuk tabel `ak_detail_trx_memorial`
--
ALTER TABLE `ak_detail_trx_memorial`
  ADD PRIMARY KEY (`id_detail_trx_memorial`),
  ADD KEY `lawan` (`lawan`),
  ADD KEY `kode_perkiraan` (`kode_perkiraan`);

--
-- Indeks untuk tabel `ak_jurnal`
--
ALTER TABLE `ak_jurnal`
  ADD PRIMARY KEY (`id_jurnal`),
  ADD KEY `lawan` (`lawan`),
  ADD KEY `kode` (`kode`),
  ADD KEY `kode_transaksi` (`kode_transaksi`);

--
-- Indeks untuk tabel `ak_kode_induk`
--
ALTER TABLE `ak_kode_induk`
  ADD PRIMARY KEY (`kode_induk`);

--
-- Indeks untuk tabel `ak_rekening`
--
ALTER TABLE `ak_rekening`
  ADD PRIMARY KEY (`kode_rekening`),
  ADD KEY `kode_induk` (`kode_induk`);

--
-- Indeks untuk tabel `ak_set_rekening`
--
ALTER TABLE `ak_set_rekening`
  ADD PRIMARY KEY (`id_ak_set_rekening`);

--
-- Indeks untuk tabel `ak_trx_bank`
--
ALTER TABLE `ak_trx_bank`
  ADD PRIMARY KEY (`kode_trx_bank`),
  ADD KEY `kode_perkiraan` (`kode_perkiraan`);

--
-- Indeks untuk tabel `ak_trx_kas`
--
ALTER TABLE `ak_trx_kas`
  ADD PRIMARY KEY (`kode_trx_kas`),
  ADD KEY `kode_perkiraan` (`kode_perkiraan`);

--
-- Indeks untuk tabel `ak_trx_memorial`
--
ALTER TABLE `ak_trx_memorial`
  ADD PRIMARY KEY (`kode_trx_memorial`);

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`no_anggota`);

--
-- Indeks untuk tabel `log_activity`
--
ALTER TABLE `log_activity`
  ADD PRIMARY KEY (`id_log_activity`);

--
-- Indeks untuk tabel `master_detail_rekening_pembiayaan`
--
ALTER TABLE `master_detail_rekening_pembiayaan`
  ADD PRIMARY KEY (`id_detail_rekening_pembiayaan`),
  ADD KEY `no_rekening_pembiayaan` (`no_rekening_pembiayaan`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `master_detail_rekening_sijaka`
--
ALTER TABLE `master_detail_rekening_sijaka`
  ADD PRIMARY KEY (`id_detail_sijaka`),
  ADD KEY `NRSj` (`NRSj`);

--
-- Indeks untuk tabel `master_detail_rekening_simuda`
--
ALTER TABLE `master_detail_rekening_simuda`
  ADD PRIMARY KEY (`id_detail_rekening_simuda`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `no_rekening_simuda` (`no_rekening_simuda`);

--
-- Indeks untuk tabel `master_rekening_pembiayaan`
--
ALTER TABLE `master_rekening_pembiayaan`
  ADD PRIMARY KEY (`no_rekening_pembiayaan`),
  ADD KEY `no_anggota` (`no_anggota`);

--
-- Indeks untuk tabel `master_rekening_sijaka`
--
ALTER TABLE `master_rekening_sijaka`
  ADD PRIMARY KEY (`NRSj`),
  ADD KEY `no_anggota` (`no_anggota`),
  ADD KEY `rekening_simuda` (`rekening_simuda`);

--
-- Indeks untuk tabel `master_rekening_simuda`
--
ALTER TABLE `master_rekening_simuda`
  ADD PRIMARY KEY (`no_rekening_simuda`),
  ADD KEY `no_anggota` (`no_anggota`);

--
-- Indeks untuk tabel `master_simpanan_pokok`
--
ALTER TABLE `master_simpanan_pokok`
  ADD PRIMARY KEY (`id_simpanan_pokok`),
  ADD KEY `no_anggota` (`no_anggota`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `master_simpanan_wajib`
--
ALTER TABLE `master_simpanan_wajib`
  ADD PRIMARY KEY (`id_simpanan_wajib`),
  ADD KEY `no_anggota` (`no_anggota`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `otorisasi`
--
ALTER TABLE `otorisasi`
  ADD PRIMARY KEY (`id_otorisasi`),
  ADD KEY `no_rek` (`no_rek`);

--
-- Indeks untuk tabel `support_bagi_hasil_sijaka`
--
ALTER TABLE `support_bagi_hasil_sijaka`
  ADD PRIMARY KEY (`id_support_bagi_hasil`),
  ADD KEY `NRSj` (`NRSj`);

--
-- Indeks untuk tabel `support_limit_simuda`
--
ALTER TABLE `support_limit_simuda`
  ADD PRIMARY KEY (`id_limit_simuda`);

--
-- Indeks untuk tabel `support_simuda_tutup_bulan`
--
ALTER TABLE `support_simuda_tutup_bulan`
  ADD PRIMARY KEY (`id_support_simuda_tutup_bulan`),
  ADD KEY `no_rekening_simuda` (`no_rekening_simuda`);

--
-- Indeks untuk tabel `support_temp_tgl_simpanan_wajib`
--
ALTER TABLE `support_temp_tgl_simpanan_wajib`
  ADD PRIMARY KEY (`id_temp_simpanan_wajib`),
  ADD KEY `no_anggota` (`no_anggota`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `ak_detail_trx_bank`
--
ALTER TABLE `ak_detail_trx_bank`
  MODIFY `id_detail_trx_bank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `ak_detail_trx_kas`
--
ALTER TABLE `ak_detail_trx_kas`
  MODIFY `id_detail_trx_kas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `ak_detail_trx_memorial`
--
ALTER TABLE `ak_detail_trx_memorial`
  MODIFY `id_detail_trx_memorial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `ak_jurnal`
--
ALTER TABLE `ak_jurnal`
  MODIFY `id_jurnal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT untuk tabel `ak_set_rekening`
--
ALTER TABLE `ak_set_rekening`
  MODIFY `id_ak_set_rekening` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `anggota`
--
ALTER TABLE `anggota`
  MODIFY `no_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30012213;

--
-- AUTO_INCREMENT untuk tabel `log_activity`
--
ALTER TABLE `log_activity`
  MODIFY `id_log_activity` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `master_detail_rekening_pembiayaan`
--
ALTER TABLE `master_detail_rekening_pembiayaan`
  MODIFY `id_detail_rekening_pembiayaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `master_detail_rekening_sijaka`
--
ALTER TABLE `master_detail_rekening_sijaka`
  MODIFY `id_detail_sijaka` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `master_detail_rekening_simuda`
--
ALTER TABLE `master_detail_rekening_simuda`
  MODIFY `id_detail_rekening_simuda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `master_simpanan_pokok`
--
ALTER TABLE `master_simpanan_pokok`
  MODIFY `id_simpanan_pokok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `master_simpanan_wajib`
--
ALTER TABLE `master_simpanan_wajib`
  MODIFY `id_simpanan_wajib` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT untuk tabel `otorisasi`
--
ALTER TABLE `otorisasi`
  MODIFY `id_otorisasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `support_bagi_hasil_sijaka`
--
ALTER TABLE `support_bagi_hasil_sijaka`
  MODIFY `id_support_bagi_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `support_limit_simuda`
--
ALTER TABLE `support_limit_simuda`
  MODIFY `id_limit_simuda` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `support_simuda_tutup_bulan`
--
ALTER TABLE `support_simuda_tutup_bulan`
  MODIFY `id_support_simuda_tutup_bulan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `support_temp_tgl_simpanan_wajib`
--
ALTER TABLE `support_temp_tgl_simpanan_wajib`
  MODIFY `id_temp_simpanan_wajib` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `master_detail_rekening_pembiayaan`
--
ALTER TABLE `master_detail_rekening_pembiayaan`
  ADD CONSTRAINT `master_detail_rekening_pembiayaan_ibfk_1` FOREIGN KEY (`no_rekening_pembiayaan`) REFERENCES `master_rekening_pembiayaan` (`no_rekening_pembiayaan`),
  ADD CONSTRAINT `master_detail_rekening_pembiayaan_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `master_detail_rekening_sijaka`
--
ALTER TABLE `master_detail_rekening_sijaka`
  ADD CONSTRAINT `master_detail_rekening_sijaka_ibfk_1` FOREIGN KEY (`NRSj`) REFERENCES `master_rekening_sijaka` (`NRSj`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `master_detail_rekening_simuda`
--
ALTER TABLE `master_detail_rekening_simuda`
  ADD CONSTRAINT `master_detail_rekening_simuda_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `master_detail_rekening_simuda_ibfk_3` FOREIGN KEY (`no_rekening_simuda`) REFERENCES `master_rekening_simuda` (`no_rekening_simuda`);

--
-- Ketidakleluasaan untuk tabel `master_rekening_pembiayaan`
--
ALTER TABLE `master_rekening_pembiayaan`
  ADD CONSTRAINT `master_rekening_pembiayaan_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`);

--
-- Ketidakleluasaan untuk tabel `master_rekening_sijaka`
--
ALTER TABLE `master_rekening_sijaka`
  ADD CONSTRAINT `master_rekening_sijaka_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `master_rekening_simuda`
--
ALTER TABLE `master_rekening_simuda`
  ADD CONSTRAINT `master_rekening_simuda_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`);

--
-- Ketidakleluasaan untuk tabel `master_simpanan_pokok`
--
ALTER TABLE `master_simpanan_pokok`
  ADD CONSTRAINT `master_simpanan_pokok_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`),
  ADD CONSTRAINT `master_simpanan_pokok_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `master_simpanan_wajib`
--
ALTER TABLE `master_simpanan_wajib`
  ADD CONSTRAINT `master_simpanan_wajib_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `support_temp_tgl_simpanan_wajib`
--
ALTER TABLE `support_temp_tgl_simpanan_wajib`
  ADD CONSTRAINT `support_temp_tgl_simpanan_wajib_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
