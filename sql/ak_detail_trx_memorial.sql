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

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ak_detail_trx_memorial`
--
ALTER TABLE `ak_detail_trx_memorial`
  ADD PRIMARY KEY (`id_detail_trx_memorial`),
  ADD KEY `lawan` (`lawan`),
  ADD KEY `kode_perkiraan` (`kode_perkiraan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `ak_detail_trx_memorial`
--
ALTER TABLE `ak_detail_trx_memorial`
  MODIFY `id_detail_trx_memorial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
