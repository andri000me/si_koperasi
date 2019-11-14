-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Nov 2019 pada 18.04
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

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ak_trx_memorial`
--
ALTER TABLE `ak_trx_memorial`
  ADD PRIMARY KEY (`kode_trx_memorial`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
