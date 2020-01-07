-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Jan 2020 pada 16.11
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
  `nama` varchar(60) NOT NULL,
  `saldo_awal` double NOT NULL,
  `kode_induk` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ak_rekening`
--

INSERT INTO `ak_rekening` (`kode_rekening`, `nama`, `saldo_awal`, `kode_induk`) VALUES
('01.100.10', 'Kas Kecil', 0, '01.100'),
('01.100.20', 'Kas Besar', 0, '01.100'),
('01.110.10', 'Bank BPR Jatim', 0, '01.110'),
('01.110.20', 'Bank Rakyat Indonesia', 0, '01.110'),
('01.110.30', 'Bank Jatim', 0, '01.110'),
('01.120.10', 'Pembiayaan Mudharobah', 0, '01.120'),
('01.120.30', 'Pembiayaan Murabahah', 0, '01.120'),
('01.120.40', 'Pembiayaan Lainnya', 0, '01.120'),
('01.140.10', 'Simpanan Pokok', 0, '01.140'),
('01.140.20', 'Simpanan Wajib', 0, '01.140'),
('01.150.10', 'Tanah & Gedung', 0, '01.150'),
('01.150.20', 'Inventaris', 0, '01.150'),
('01.160.10', 'Tanah & Gedung', 0, '01.160'),
('01.160.20', 'Inventaris', 0, '01.160'),
('01.170.10', 'Biaya Dibayar Dimuka', 0, '01.170'),
('01.170.20', 'Penyediaan Dana', 0, '01.170'),
('01.170.30', 'Lainnya', 0, '01.170'),
('01.200.10', 'PPh. Pasal 21', 0, '01.200'),
('01.200.20', 'PPh. Pasal 25', 0, '01.200'),
('01.200.30', 'SHU Segera Dibayar', 0, '01.200'),
('01.200.40', 'Bagi Hasil Simuda Segera Dbyr', 0, '01.200'),
('01.200.50', 'Bagi Hasil Sijaka Segera Dbyr', 0, '01.200'),
('01.200.60', 'Lainnya', 0, '01.200'),
('01.210.10', 'Hutang Mudharabah', 0, '01.210'),
('01.210.20', 'Hutang Mudharabah Berjangka', 0, '01.210'),
('01.210.30', 'Hutang Lain-lain', 0, '01.210'),
('01.240.10', 'Hutang Pada Pemerintah', 0, '01.240'),
('01.240.20', 'Hutang Pada Bank', 0, '01.240'),
('01.240.30', 'Hutang Pada Koperasi', 0, '01.240'),
('01.250.10', 'Zakat, Infaq Dan Shodaqoh', 0, '01.250'),
('01.250.20', 'Pendapatan Diterima Dimuka', 0, '01.250'),
('01.250.30', 'Lainnya', 0, '01.250'),
('01.260.10', 'Simpanan Pokok Anggota', 0, '01.260'),
('01.260.20', 'Simpanan Wajib Anggota', 0, '01.260'),
('01.260.30', 'Donasi', 0, '01.260'),
('01.260.40', 'Cadangan Umum', 0, '01.260'),
('01.260.50', 'Cadangan Tujuan', 0, '01.260'),
('01.260.60', 'Modal Investasi Lainnya', 0, '01.260'),
('02.110.10', 'Bunga Bank BPR JATIM', 0, '02.110'),
('02.110.20', 'Bunga Bank BRI', 0, '02.110'),
('02.110.30', 'Bunga Bank Jatim', 0, '02.110'),
('02.120.10', 'Bagi Hasil Pembiyaan Mudharobah', 0, '02.120'),
('02.120.20', 'Bagi Hasil Pembiyaan Murabahah', 0, '02.120'),
('02.120.30', 'Bagi Hasil Pembiyaan Lainnya', 0, '02.120'),
('02.210.10', 'Simpanan Mudharabah', 0, '02.210'),
('02.210.20', 'Simpanan Berjangka', 0, '02.210'),
('02.210.30', 'Pinjaman', 0, '02.210'),
('02.210.40', 'Lainnya', 0, '02.210'),
('02.220.10', 'Honor Pengurus & BP', 0, '02.220'),
('02.220.20', 'Gaji Pegawai', 0, '02.220'),
('02.220.30', 'Lainnya', 0, '02.220'),
('02.270.10', 'Rekening Tellepon', 0, '02.270'),
('02.270.20', 'Rekening Lestrik', 0, '02.270'),
('02.270.30', 'Rekening Air', 0, '02.270'),
('02.270.40', 'Administrasi Kantor (ATK)', 0, '02.270'),
('02.270.50', 'BBM', 0, '02.270'),
('02.270.60', 'Perjalanan Dinas', 0, '02.270'),
('02.270.70', 'Biaya Umum', 0, '02.270'),
('02.270.80', 'Biaya Barang & Jasa Lainnya', 0, '02.270'),
('02.290.10', 'Penyusutan Gedung', 0, '02.290'),
('02.290.20', 'Penyusutan Inventaris', 0, '02.290'),
('1111.1110', 'Kas Kecil', 10000, '1111'),
('1111.1120', 'Kas Besar', 0, '1111');

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
