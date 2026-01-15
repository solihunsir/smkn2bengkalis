-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 15, 2026 at 07:52 AM
-- Server version: 8.4.3
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smk2bengkalis`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama_lengkap`, `created_at`) VALUES
(1, 'admin', '$2y$10$9MwWsh4dHk9ojmH7BUh1uOmhI7Rb8iziroqLz0tgsZpE/G6LYfGaa', 'Administrator', '2026-01-08 07:21:32'),
(2, 'admin2', '$2y$10$vI8P0EInXp6S.Gk7W5f5f.f8f8f8f8f8f8f8f8f8f8f8f8f8f8f8', 'admin baru', '2026-01-14 07:32:19');

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id` int NOT NULL,
  `kode_jurusan` varchar(10) NOT NULL,
  `nama_jurusan` varchar(100) NOT NULL,
  `deskripsi` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id`, `kode_jurusan`, `nama_jurusan`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'TKJ', 'Teknik Komputer dan Jaringan', 'Program keahlian yang mempelajari tentang teknologi komputer dan jaringan', '2026-01-08 07:21:32', '2026-01-08 07:21:32'),
(2, 'RPL', 'Rekayasa Perangkat Lunak', 'Program keahlian yang mempelajari tentang pemrograman dan pengembangan software', '2026-01-08 07:21:32', '2026-01-08 07:21:32'),
(3, 'MM', 'Multimedia', 'Program keahlian yang mempelajari tentang desain grafis, video editing, dan animasi', '2026-01-08 07:21:32', '2026-01-08 07:21:32'),
(4, 'AKL', 'Akuntansi dan Keuangan Lembaga', 'Program keahlian yang mempelajari tentang akuntansi dan keuangan', '2026-01-08 07:21:32', '2026-01-08 07:21:32'),
(5, 'ADP', 'Administrasi Perkantoran', 'sebuah jurusan yang fokus pada keterampilan manajemen kantor, kesekretariatan, teknologi perkantoran, dan administrasi umum, baik untuk jenjang D3 (Vokasi) maupun S1 Pendidikan Administrasi Perkantoran (P.ADP) yang membekali lulusan menjadi profesional administrasi atau guru.', '2026-01-14 07:03:54', '2026-01-14 07:03:54'),
(6, 'JJ', 'Jan', 'aaaaaaaaaaaaaaaaaaa', '2026-01-15 07:33:16', '2026-01-15 07:33:16');

-- --------------------------------------------------------

--
-- Table structure for table `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `id` int NOT NULL,
  `kode_mapel` varchar(10) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL,
  `jurusan_id` int DEFAULT NULL,
  `deskripsi` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `jurusan_id`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'TKJ-01', 'Administrasi Infrastruktur Jaringan', 1, 'Mata pelajaran yang mempelajari administrasi dan pengelolaan infrastruktur jaringan', '2026-01-08 07:21:33', '2026-01-08 07:21:33'),
(2, 'TKJ-02', 'Administrasi Sistem Jaringan', 1, 'Mata pelajaran yang mempelajari administrasi sistem operasi jaringan', '2026-01-08 07:21:33', '2026-01-08 07:21:33'),
(3, 'RPL-01', 'Pemrograman Berorientasi Objek', 2, 'Mata pelajaran yang mempelajari konsep OOP dan implementasinya', '2026-01-08 07:21:33', '2026-01-08 07:21:33'),
(4, 'RPL-02', 'Basis Data', 2, 'Mata pelajaran yang mempelajari perancangan dan pengelolaan database', '2026-01-08 07:21:33', '2026-01-08 07:21:33'),
(5, 'MM-01', 'Desain Grafis Percetakan', 3, 'Mata pelajaran yang mempelajari desain untuk media cetak', '2026-01-08 07:21:33', '2026-01-08 07:21:33'),
(6, 'MM-02', 'Animasi 2D dan 3D', 3, 'Mata pelajaran yang mempelajari teknik animasi', '2026-01-08 07:21:33', '2026-01-08 07:21:33'),
(7, 'AKL-01', 'Praktikum Akuntansi Perusahaan Jasa', 4, 'Mata pelajaran yang mempelajari praktik akuntansi perusahaan jasa', '2026-01-08 07:21:33', '2026-01-08 07:21:33'),
(8, 'AKL-02', 'Praktikum Akuntansi Lembaga', 4, 'Mata pelajaran yang mempelajari praktik akuntansi lembaga', '2026-01-08 07:21:33', '2026-01-08 07:21:33'),
(9, 'ADP-01', 'Keuangan Daerah', 5, 'sebuah jurusan yang fokus pada keterampilan manajemen kantor, kesekretariatan, teknologi perkantoran, dan administrasi umum, baik untuk jenjang D3 (Vokasi) maupun S1 Pendidikan Administrasi Perkantoran (P.ADP) yang membekali lulusan menjadi profesional administrasi atau guru.', '2026-01-14 07:05:10', '2026-01-14 07:05:10'),
(10, 'jj-01', 'Jaringan baru', 6, 'yaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2026-01-15 07:34:28', '2026-01-15 07:34:28');

-- --------------------------------------------------------

--
-- Table structure for table `profile_sekolah`
--

CREATE TABLE `profile_sekolah` (
  `id` int NOT NULL,
  `nama_sekolah` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `visi` text,
  `misi` text,
  `sejarah` text,
  `logo` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `profile_sekolah`
--

INSERT INTO `profile_sekolah` (`id`, `nama_sekolah`, `alamat`, `telepon`, `email`, `visi`, `misi`, `sejarah`, `logo`, `updated_at`) VALUES
(1, 'SMKN 3 Bengkalis', 'JL. Assalam, Kel. Kelapapati, Kec. Bengkalis, Kab. Bengkalis, Provinsi Riau.', '0766-1234567', 'smkn2@smkn2bengkalic.ac.id', 'Menjadi SMK yang unggul, berkarakter, dan berdaya saing global', '1. Meningkatkan kualitas pendidikan\r\n2. Mengembangkan kompetensi siswa\r\n3. Membangun karakter siswa yang berakhlak mulia', 'SMKN 2 Bengkalis didirikan pada tahun 1999 sebagai lembaga pendidikan kejuruan yang bertujuan menghasilkan lulusan berkualitas dan siap kerja.', NULL, '2026-01-15 07:34:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_jurusan` (`kode_jurusan`);

--
-- Indexes for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_mapel` (`kode_mapel`),
  ADD KEY `jurusan_id` (`jurusan_id`);

--
-- Indexes for table `profile_sekolah`
--
ALTER TABLE `profile_sekolah`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `profile_sekolah`
--
ALTER TABLE `profile_sekolah`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD CONSTRAINT `mata_pelajaran_ibfk_1` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
