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
(11, 'BK-1911-0010', 'asdfkj', '1120.1110', 9000000),
(10, 'BK-1911-0009', 'fgfgfgf', '1120.1110', 123123123),
(9, 'BK-1911-0008', 'gfgfg', '1120.1110', 12312321),
(8, 'BK-1911-0007', 'fdsfdf', '1120.1110', 211212),
(7, 'BK-1911-0006', 'wdsds', '1120.1110', 1222121),
(6, 'BK-1911-0005', 'flksdl;fk', '1120.1110', 2000000),
(5, 'BK-1911-0004', 'jkdsfjdsl', '1120.1110', 1000000),
(4, 'BK-1911-0003', 'jfdsklfjdsl', '1120.1110', 4000000),
(3, 'BK-1911-0002', 'uuuuuuu', '1120.1110', 5000000);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ak_detail_trx_kas`
--
ALTER TABLE `ak_detail_trx_kas`
  ADD PRIMARY KEY (`id_detail_trx_kas`),
  ADD KEY `lawan` (`lawan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `ak_detail_trx_kas`
--
ALTER TABLE `ak_detail_trx_kas`
  MODIFY `id_detail_trx_kas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
