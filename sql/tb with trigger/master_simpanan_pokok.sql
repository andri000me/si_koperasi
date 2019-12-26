-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Des 2019 pada 06.13
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
-- Struktur dari tabel `master_simpanan_pokok`
--

CREATE TABLE `master_simpanan_pokok` (
  `id_simpanan_pokok` int(11) NOT NULL,
  `no_anggota` int(11) NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `jumlah` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_simpanan_pokok`
--

INSERT INTO `master_simpanan_pokok` (`id_simpanan_pokok`, `no_anggota`, `tanggal_pembayaran`, `jumlah`, `id_user`) VALUES
(3, 1212, '2019-11-06', 5000000, 1),
(4, 1212, '2019-12-26', 60000, 1);

--
-- Trigger `master_simpanan_pokok`
--
DELIMITER $$
CREATE TRIGGER `after_insert_simp_pokok_trigger` AFTER INSERT ON `master_simpanan_pokok` FOR EACH ROW INSERT INTO log_activity(id_user, datetime, keterangan) VALUES (NEW.id_user, now(), CONCAT('Menginput simpanan pokok dari no anggota ', NEW.no_anggota, ' dengan nominal ', NEW.jumlah))
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `master_simpanan_pokok`
--
ALTER TABLE `master_simpanan_pokok`
  ADD PRIMARY KEY (`id_simpanan_pokok`),
  ADD KEY `no_anggota` (`no_anggota`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `master_simpanan_pokok`
--
ALTER TABLE `master_simpanan_pokok`
  MODIFY `id_simpanan_pokok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `master_simpanan_pokok`
--
ALTER TABLE `master_simpanan_pokok`
  ADD CONSTRAINT `master_simpanan_pokok_ibfk_1` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`),
  ADD CONSTRAINT `master_simpanan_pokok_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
