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
-- Struktur dari tabel `master_detail_rekening_simuda`
--

CREATE TABLE `master_detail_rekening_simuda` (
  `id_detail_rekening_simuda` int(11) NOT NULL,
  `no_rekening_simuda` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `debet` float NOT NULL,
  `kredit` float NOT NULL,
  `saldo` float NOT NULL,
  `id_user` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_detail_rekening_simuda`
--

INSERT INTO `master_detail_rekening_simuda` (`id_detail_rekening_simuda`, `no_rekening_simuda`, `datetime`, `debet`, `kredit`, `saldo`, `id_user`) VALUES
(5, 1001, '2019-11-10 10:15:29', 0, 250000, 250000, 1),
(6, 1001, '2019-11-10 11:22:00', 0, 10000, 260000, 1),
(7, 1002, '2019-11-10 10:18:01', 0, 50000, 50000, 1),
(8, 1001, '2019-11-10 10:26:04', 0, 58333.3, 318333, 1),
(9, 1002, '2019-11-10 10:26:04', 0, 11666.7, 61666.7, 1),
(10, 1001, '2019-11-10 10:29:24', 0, 8333.33, 326666, 1),
(11, 1002, '2019-11-10 10:29:24', 0, 1666.67, 63333.4, 1),
(12, 1001, '2019-12-26 09:40:00', 0, 10000, 336666, 1);

--
-- Trigger `master_detail_rekening_simuda`
--
DELIMITER $$
CREATE TRIGGER `after_insert_detail_simuda_trigger` AFTER INSERT ON `master_detail_rekening_simuda` FOR EACH ROW INSERT INTO log_activity(id_user, datetime, keterangan) VALUES (NEW.id_user, now(), CONCAT('Menginput transaksi simuda dari no rekening', NEW.no_rekening_simuda))
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `master_detail_rekening_simuda`
--
ALTER TABLE `master_detail_rekening_simuda`
  ADD PRIMARY KEY (`id_detail_rekening_simuda`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `no_rekening_simuda` (`no_rekening_simuda`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `master_detail_rekening_simuda`
--
ALTER TABLE `master_detail_rekening_simuda`
  MODIFY `id_detail_rekening_simuda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `master_detail_rekening_simuda`
--
ALTER TABLE `master_detail_rekening_simuda`
  ADD CONSTRAINT `master_detail_rekening_simuda_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `master_detail_rekening_simuda_ibfk_3` FOREIGN KEY (`no_rekening_simuda`) REFERENCES `master_rekening_simuda` (`no_rekening_simuda`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
