-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Des 2019 pada 06.14
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
-- Dumping data untuk tabel `master_detail_rekening_sijaka`
--

INSERT INTO `master_detail_rekening_sijaka` (`id_detail_sijaka`, `NRSj`, `debet`, `kredit`, `saldo`, `id_user`) VALUES
(1, 1, 0, 100000, 100000, 1);

--
-- Trigger `master_detail_rekening_sijaka`
--
DELIMITER $$
CREATE TRIGGER `after_insert_detail_sijaka_trigger` AFTER INSERT ON `master_detail_rekening_sijaka` FOR EACH ROW INSERT INTO log_activity(id_user, datetime, keterangan) VALUES (NEW.id_user, now(), CONCAT('Menginput transaksi sijaka dari no rekening sijaka ', NEW.NRSj))
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `master_detail_rekening_sijaka`
--
ALTER TABLE `master_detail_rekening_sijaka`
  ADD PRIMARY KEY (`id_detail_sijaka`),
  ADD KEY `NRSj` (`NRSj`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `master_detail_rekening_sijaka`
--
ALTER TABLE `master_detail_rekening_sijaka`
  MODIFY `id_detail_sijaka` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `master_detail_rekening_sijaka`
--
ALTER TABLE `master_detail_rekening_sijaka`
  ADD CONSTRAINT `master_detail_rekening_sijaka_ibfk_1` FOREIGN KEY (`NRSj`) REFERENCES `master_rekening_sijaka` (`NRSj`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
