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
-- Dumping data untuk tabel `master_detail_rekening_pembiayaan`
--

INSERT INTO `master_detail_rekening_pembiayaan` (`id_detail_rekening_pembiayaan`, `no_rekening_pembiayaan`, `tanggal_pembayaran`, `periode_tagihan`, `jml_pokok`, `jml_bahas`, `denda`, `total`, `id_user`) VALUES
(1, 1, '2019-12-26', '6', 8333, 83, 0, 50000, 1);

--
-- Trigger `master_detail_rekening_pembiayaan`
--
DELIMITER $$
CREATE TRIGGER `after_insert_detail_pembiayaan_trigger` AFTER INSERT ON `master_detail_rekening_pembiayaan` FOR EACH ROW INSERT INTO log_activity(id_user, datetime, keterangan) VALUES (NEW.id_user, now(), CONCAT('Menginput transaksi pembiayaan dari no rekening pembiayaan ', NEW.no_rekening_pembiayaan))
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `master_detail_rekening_pembiayaan`
--
ALTER TABLE `master_detail_rekening_pembiayaan`
  ADD PRIMARY KEY (`id_detail_rekening_pembiayaan`),
  ADD KEY `no_rekening_pembiayaan` (`no_rekening_pembiayaan`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `master_detail_rekening_pembiayaan`
--
ALTER TABLE `master_detail_rekening_pembiayaan`
  MODIFY `id_detail_rekening_pembiayaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `master_detail_rekening_pembiayaan`
--
ALTER TABLE `master_detail_rekening_pembiayaan`
  ADD CONSTRAINT `master_detail_rekening_pembiayaan_ibfk_1` FOREIGN KEY (`no_rekening_pembiayaan`) REFERENCES `master_rekening_pembiayaan` (`no_rekening_pembiayaan`),
  ADD CONSTRAINT `master_detail_rekening_pembiayaan_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
