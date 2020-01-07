-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Jan 2020 pada 16.12
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
('02.130', 'Provisi & Administrasi', 'D'),
('02.140', 'Lainnya', 'D'),
('02.200', 'BIAYA - BIAYA', 'D'),
('02.210', 'Biaya Bagi Hasil Usaha', 'D'),
('02.220', 'Gaji & Honorarium', 'D'),
('02.230', 'Pendidikan Dan Pelatihan', 'D'),
('02.240', 'Sewa', 'D'),
('02.250', 'Pajak - Pajak', 'D'),
('02.260', 'Pemeliharaan & Perbaikan', 'D'),
('02.270', 'Barang Dan Jasa', 'D'),
('02.280', 'Penghapus Bukuan Piutang     ', 'D'),
('02.290', 'Penyusutan Aktiva Tetap ', 'K'),
('02.300', 'Biaya Non Operasional', 'D'),
('02.310', 'SHU Sebelum Pajak', 'K'),
('02.320', 'Pajak Penghasilan', 'D'),
('02.330', 'SISA HASIL USAHA', 'K');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ak_kode_induk`
--
ALTER TABLE `ak_kode_induk`
  ADD PRIMARY KEY (`kode_induk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
