-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Feb 2020 pada 00.10
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
(1001, 'Ali Rahmatullah', 'Belakang Pasar Randuagung', '0000-00-00', 1),
(1002, 'Riyo Andika', 'Pasar Randuagung', '0000-00-00', 1);

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
  `datetime` datetime NOT NULL,
  `nominal` float NOT NULL,
  `tipe_penarikan` enum('Kredit Simuda','Tunai') NOT NULL,
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_rekening_sijaka`
--

CREATE TABLE `master_rekening_sijaka` (
  `NRSj` smallint(6) NOT NULL,
  `no_anggota` int(11) NOT NULL,
  `jumlah_simpanan` float NOT NULL,
  `jangka_waktu` int(2) NOT NULL,
  `bulan_berjalan` int(2) NOT NULL,
  `progress_bahas` int(2) NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `jumlah_bahas_bulanan` float NOT NULL,
  `pembayaran_bahas` enum('Tunai','Kredit Rek') NOT NULL,
  `rekening_simuda` int(11) DEFAULT NULL,
  `status_dana` enum('Belum Diambil','Diambil') NOT NULL DEFAULT 'Belum Diambil',
  `otomatis_perpanjang` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_rekening_simuda`
--

CREATE TABLE `master_rekening_simuda` (
  `no_rekening_simuda` int(11) NOT NULL,
  `no_anggota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 500000);

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
(1, 'Hilman', 'hilman', '$2y$10$vUN0cpM38DYRV7owaLwEVu5YplgoNKRe9ENGTvxirpS.oGsCnjdO.', 'Manager', 1),
(2, 'Angga', 'angga', '$2y$10$CXgVWS9KdmXXLuhoIVNbJefXIo1zdvy6YzxnA7qgDWyf0F0bUxjPe', 'Dana', 1),
(3, 'Rofik', 'rofik', '$2y$10$VmAqTXLKftvTxHf8VQEUhONkxrwonJoqmz.LCfnGGRYmIwv6aK2g2', 'Teller', 1);

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
  MODIFY `id_detail_trx_bank` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ak_detail_trx_kas`
--
ALTER TABLE `ak_detail_trx_kas`
  MODIFY `id_detail_trx_kas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ak_detail_trx_memorial`
--
ALTER TABLE `ak_detail_trx_memorial`
  MODIFY `id_detail_trx_memorial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ak_jurnal`
--
ALTER TABLE `ak_jurnal`
  MODIFY `id_jurnal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ak_set_rekening`
--
ALTER TABLE `ak_set_rekening`
  MODIFY `id_ak_set_rekening` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `anggota`
--
ALTER TABLE `anggota`
  MODIFY `no_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1003;

--
-- AUTO_INCREMENT untuk tabel `log_activity`
--
ALTER TABLE `log_activity`
  MODIFY `id_log_activity` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `master_detail_rekening_pembiayaan`
--
ALTER TABLE `master_detail_rekening_pembiayaan`
  MODIFY `id_detail_rekening_pembiayaan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `master_detail_rekening_sijaka`
--
ALTER TABLE `master_detail_rekening_sijaka`
  MODIFY `id_detail_sijaka` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `master_detail_rekening_simuda`
--
ALTER TABLE `master_detail_rekening_simuda`
  MODIFY `id_detail_rekening_simuda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `master_simpanan_pokok`
--
ALTER TABLE `master_simpanan_pokok`
  MODIFY `id_simpanan_pokok` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `master_simpanan_wajib`
--
ALTER TABLE `master_simpanan_wajib`
  MODIFY `id_simpanan_wajib` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `otorisasi`
--
ALTER TABLE `otorisasi`
  MODIFY `id_otorisasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `support_bagi_hasil_sijaka`
--
ALTER TABLE `support_bagi_hasil_sijaka`
  MODIFY `id_support_bagi_hasil` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id_user` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
