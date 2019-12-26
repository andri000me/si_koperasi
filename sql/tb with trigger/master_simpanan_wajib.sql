-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Des 2019 pada 18.11
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
-- Struktur dari tabel `master_simpanan_wajib`
--

CREATE TABLE `master_simpanan_wajib` (
  `id_simpanan_wajib` int(11) NOT NULL,
  `no_anggota` int(11) NOT NULL,
  `tgl_temp` date NOT NULL,
  `tgl_pembayaran` datetime NOT NULL,
  `debet` float NOT NULL,
  `kredit` float NOT NULL,
  `saldo` float NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_simpanan_wajib`
--

INSERT INTO `master_simpanan_wajib` (`id_simpanan_wajib`, `no_anggota`, `tgl_temp`, `tgl_pembayaran`, `debet`, `kredit`, `saldo`, `id_user`) VALUES
(127, 1212, '2019-11-01', '2019-11-10 10:22:00', 0, 25000, 25000, 1);

--
-- Trigger `master_simpanan_wajib`
--
DELIMITER $$
CREATE TRIGGER `after_insert_simp_wajib_trigger` AFTER INSERT ON `master_simpanan_wajib` FOR EACH ROW INSERT INTO log_activity(id_user, datetime, keterangan) VALUES (NEW.id_user, now(), CONCAT('Menginput simpanan wajib dari no anggota ', NEW.no_anggota))
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `master_simpanan_wajib`
--
ALTER TABLE `master_simpanan_wajib`
  ADD PRIMARY KEY (`id_simpanan_wajib`),
  ADD KEY `no_anggota` (`no_anggota`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `master_simpanan_wajib`
--
ALTER TABLE `master_simpanan_wajib`
  MODIFY `id_simpanan_wajib` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `master_simpanan_wajib`
--
ALTER TABLE `master_simpanan_wajib`
  ADD CONSTRAINT `master_simpanan_wajib_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
