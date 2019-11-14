-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Nov 2019 pada 18.05
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
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `ak_detail_trx_bank`
--
ALTER TABLE `ak_detail_trx_bank`
  MODIFY `id_detail_trx_bank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
