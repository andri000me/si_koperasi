-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Okt 2019 pada 10.40
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
-- Struktur dari tabel `ak_rekening`
--

CREATE TABLE `ak_rekening` (
  `kode_rekening` varchar(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `inisial` varchar(3) NOT NULL,
  `saldo_awal` double NOT NULL,
  `kode_induk` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ak_rekening`
--

INSERT INTO `ak_rekening` (`kode_rekening`, `nama`, `inisial`, `saldo_awal`, `kode_induk`) VALUES
('1111.1110', 'Kas Kecil', 'KK', 10000, '1111'),
('1111.1120', 'Kas Besar', '', 0, '1111');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ak_rekening`
--
ALTER TABLE `ak_rekening`
  ADD PRIMARY KEY (`kode_rekening`),
  ADD KEY `kode_induk` (`kode_induk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
