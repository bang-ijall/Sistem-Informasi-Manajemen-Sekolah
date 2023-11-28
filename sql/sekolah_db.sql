-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Nov 2023 pada 18.17
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sekolah_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `nisn` int(10) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Hadir','Tidak Hadir') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`nisn`, `tanggal`, `status`) VALUES
(1234567890, '2023-11-22', 'Hadir'),
(1234567890, '2023-11-23', 'Hadir'),
(1234567890, '2023-11-28', 'Hadir');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pelajaran`
--

CREATE TABLE `data_pelajaran` (
  `nisn` int(11) NOT NULL,
  `pelajaran` varchar(50) NOT NULL,
  `hari` varchar(10) NOT NULL,
  `jam` time NOT NULL,
  `guru` varchar(50) NOT NULL,
  `nilai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_pelajaran`
--

INSERT INTO `data_pelajaran` (`nisn`, `pelajaran`, `hari`, `jam`, `guru`, `nilai`) VALUES
(1234567890, 'IPA', 'Senin', '10:00:00', 'Muhammad Ibnu', NULL),
(1234567890, 'Matematika', 'Senin', '08:00:00', 'Adam Optimizer', NULL),
(1234567890, 'IPS', 'Selasa', '08:00:00', 'Muhammad Sumbul', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_siswa`
--

CREATE TABLE `data_siswa` (
  `nisn` int(10) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(13) DEFAULT NULL,
  `kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `agama` varchar(20) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_siswa`
--

INSERT INTO `data_siswa` (`nisn`, `tanggal_lahir`, `foto`, `nama_lengkap`, `nik`, `email`, `no_hp`, `kelamin`, `tempat_lahir`, `agama`, `alamat`) VALUES
(1234567890, '2002-12-14', NULL, 'Arrijalul Khairi', '1234561412020001', 'ijall@gmail.com', '0895600006146', 'Laki-laki', 'Langsa', 'Islam', 'BTN BSP BLOK C NO. 27 C, Matang Seulimeng, Langsa Barat, Kota Langsa, Aceh, 24413');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD KEY `fk_nisn` (`nisn`);

--
-- Indeks untuk tabel `data_pelajaran`
--
ALTER TABLE `data_pelajaran`
  ADD KEY `fk_nisn_pelajaran` (`nisn`);

--
-- Indeks untuk tabel `data_siswa`
--
ALTER TABLE `data_siswa`
  ADD PRIMARY KEY (`nisn`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `fk_nisn` FOREIGN KEY (`nisn`) REFERENCES `data_siswa` (`nisn`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `data_pelajaran`
--
ALTER TABLE `data_pelajaran`
  ADD CONSTRAINT `fk_nisn_pelajaran` FOREIGN KEY (`nisn`) REFERENCES `data_siswa` (`nisn`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
