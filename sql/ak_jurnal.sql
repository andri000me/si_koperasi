-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Nov 2019 pada 18.03
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
  `id_detail` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ak_jurnal`
--

INSERT INTO `ak_jurnal` (`id_jurnal`, `tanggal`, `kode_transaksi`, `keterangan`, `kode`, `lawan`, `tipe`, `nominal`, `tipe_trx_koperasi`, `id_detail`) VALUES
(12, '2019-11-14 22:44:02', 'BB-1911-0003', 'sklfjsdklf', '1110.1110', '2220.2110', 'K', 4000000, 'Bank', 3),
(11, '2019-11-14 22:41:37', 'BB-1911-0002', 'Bonus karyawan', '1110.1110', '2220.2110', 'K', 1000000, 'Kas', 2),
(7, '2019-11-14 01:37:26', 'BK-1911-0010', 'asdfkj', '1112.1110', '1120.1110', 'D', 9000000, 'Kas', 11),
(13, '2019-11-14 00:00:12', 'BM-1911-0001', 'Memo', '1120.1110', '2220.2110', 'D', 35000000, 'Memorial', 1),
(6, '2019-11-13 01:35:01', 'BK-1911-0009', 'fgfgfgf', '1112.1110', '1120.1110', 'K', 123123000, 'SimPokok', 10);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ak_jurnal`
--
ALTER TABLE `ak_jurnal`
  ADD PRIMARY KEY (`id_jurnal`),
  ADD KEY `lawan` (`lawan`),
  ADD KEY `kode` (`kode`),
  ADD KEY `kode_transaksi` (`kode_transaksi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `ak_jurnal`
--
ALTER TABLE `ak_jurnal`
  MODIFY `id_jurnal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
