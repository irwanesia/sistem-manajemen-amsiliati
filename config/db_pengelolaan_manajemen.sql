-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2025 at 02:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pengelolaan_manajemen`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int(11) NOT NULL,
  `kelas_jilid_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('H','I','A') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `kelas_jilid_id`, `tanggal`, `status`) VALUES
(1, 3, '2025-08-10', 'H'),
(2, 4, '2025-08-10', 'I'),
(3, 5, '2025-08-10', 'A'),
(4, 6, '2025-08-10', 'H'),
(9, 3, '2025-08-11', 'H'),
(10, 4, '2025-08-11', 'H'),
(11, 5, '2025-08-11', 'H'),
(12, 6, '2025-08-11', 'I');

-- --------------------------------------------------------

--
-- Table structure for table `asrama`
--

CREATE TABLE `asrama` (
  `id_asrama` int(11) NOT NULL,
  `nama_asrama` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asrama`
--

INSERT INTO `asrama` (`id_asrama`, `nama_asrama`, `keterangan`) VALUES
(1, 'Asrama A', 'tidak ada -'),
(2, 'Asrama B', '- test');

-- --------------------------------------------------------

--
-- Table structure for table `evaluasi_santri`
--

CREATE TABLE `evaluasi_santri` (
  `id_evaluasi` int(11) NOT NULL,
  `id_santri` int(11) DEFAULT NULL,
  `periode` varchar(20) DEFAULT NULL,
  `hasil_evaluasi` text DEFAULT NULL,
  `evaluasi_oleh` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jilid`
--

CREATE TABLE `jilid` (
  `id_jilid` int(11) NOT NULL,
  `nama_jilid` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jilid`
--

INSERT INTO `jilid` (`id_jilid`, `nama_jilid`, `deskripsi`) VALUES
(1, 'Jilid A', 'Deskripsi Jilid A Full'),
(2, 'Jilid B', 'test  des');

-- --------------------------------------------------------

--
-- Table structure for table `kamar`
--

CREATE TABLE `kamar` (
  `id_kamar` int(11) NOT NULL,
  `id_asrama` int(11) DEFAULT NULL,
  `nama_kamar` varchar(50) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kamar`
--

INSERT INTO `kamar` (`id_kamar`, `id_asrama`, `nama_kamar`, `keterangan`) VALUES
(1, 1, 'Kamar A', 'test'),
(2, 1, 'Kamar B', '-'),
(3, 1, 'Kamar C', '-'),
(4, 2, 'Kamar D', 'test -');

-- --------------------------------------------------------

--
-- Table structure for table `kelas_jilid`
--

CREATE TABLE `kelas_jilid` (
  `id_kelas_jilid` int(11) NOT NULL,
  `santri_id` int(11) NOT NULL,
  `jilid_id` int(11) NOT NULL,
  `ustadzah_id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) NOT NULL,
  `tanggal_mulai` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas_jilid`
--

INSERT INTO `kelas_jilid` (`id_kelas_jilid`, `santri_id`, `jilid_id`, `ustadzah_id`, `tahun_ajaran_id`, `tanggal_mulai`) VALUES
(1, 2, 1, 2, 3, NULL),
(2, 1, 1, 2, 3, NULL),
(3, 1, 2, 1, 3, NULL),
(4, 2, 2, 1, 3, NULL),
(5, 3, 2, 1, 3, NULL),
(6, 4, 2, 1, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kenaikan`
--

CREATE TABLE `kenaikan` (
  `id_kenaikan` int(11) NOT NULL,
  `id_santri` int(11) DEFAULT NULL,
  `dari_jilid` int(11) DEFAULT NULL,
  `ke_jilid` int(11) DEFAULT NULL,
  `tanggal_kenaikan` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kepala_kamar`
--

CREATE TABLE `kepala_kamar` (
  `id_kepala_kamar` int(11) NOT NULL,
  `id_kamar` int(11) NOT NULL,
  `nama_kepala` varchar(100) NOT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `tanggal_diangkat` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kepala_kamar`
--

INSERT INTO `kepala_kamar` (`id_kepala_kamar`, `id_kamar`, `nama_kepala`, `no_hp`, `tanggal_diangkat`) VALUES
(1, 1, 'Si A', '08778906xxxx', '2025-07-08');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_triwulan`
--

CREATE TABLE `laporan_triwulan` (
  `id_laporan` int(11) NOT NULL,
  `id_santri` int(11) DEFAULT NULL,
  `periode` varchar(20) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `dibuat_oleh` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legger`
--

CREATE TABLE `legger` (
  `id_legger` int(11) NOT NULL,
  `id_santri` int(11) DEFAULT NULL,
  `id_tahun` int(11) DEFAULT NULL,
  `hasil_akhir` text DEFAULT NULL,
  `nilai_total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_log` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `aktivitas` varchar(255) DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id_log`, `user_id`, `aktivitas`, `tanggal`) VALUES
(41, 1, 'irwan src melakukan login ke sistem', '2025-07-10 12:19:59'),
(42, 1, 'irwan src melakukan login ke sistem', '2025-07-10 20:56:03'),
(43, 1, 'admin menambah data asrama', '2025-08-03 10:20:23'),
(44, 1, 'admin mengubah data asrama', '2025-08-03 10:21:21'),
(45, 1, 'admin menambah data kamar', '2025-08-03 10:21:59'),
(46, 1, 'admin mengubah data asrama', '2025-08-03 10:25:26'),
(47, 1, 'admin menambah data kamar', '2025-08-03 10:28:22'),
(48, 1, 'admin menambah data kamar', '2025-08-03 10:28:52'),
(49, 1, 'admin mengubah data kamar', '2025-08-03 10:29:04'),
(50, 1, 'admin menambah data asrama', '2025-08-03 10:32:07'),
(51, 1, 'admin menambah data kamar', '2025-08-03 10:32:23'),
(52, 1, 'admin menambah data kepala kamar', '2025-08-03 10:34:32'),
(53, 1, 'admin mengubah data kepala kamar', '2025-08-03 10:40:25'),
(54, 1, 'admin menghapus data kepala kamar', '2025-08-03 10:40:53'),
(55, 1, 'admin menghapus data kepala kamar', '2025-08-03 10:40:57'),
(56, 1, 'admin menghapus data kepala kamar', '2025-08-03 10:41:47'),
(57, 1, 'admin mengubah data kepala kamar', '2025-08-03 10:47:51'),
(58, 1, 'admin menambah data santri', '2025-08-03 11:10:55'),
(59, 1, 'admin menambah data ustadzah', '2025-08-03 23:07:34'),
(60, 1, 'admin mengubah data ustadzah', '2025-08-03 23:07:47'),
(61, 1, 'admin menambah data jilid', '2025-08-03 23:15:50'),
(62, 1, 'admin mengubah data jilid', '2025-08-03 23:15:56'),
(63, 1, 'admin menambah data tahun ajaran 2023 Semester Ganjil', '2025-08-03 23:35:50'),
(64, 1, 'admin mengubah data tahun ajaran 2023 Semester Ganjil', '2025-08-03 23:36:12'),
(65, 1, 'admin mengubah data tahun ajaran 2023 Semester Ganjil', '2025-08-03 23:37:07'),
(66, 1, 'admin menambah data pendaftar', '2025-08-04 00:08:24'),
(67, 1, 'admin mengubah data pendaftar', '2025-08-04 00:09:09'),
(68, 1, 'Putri menambah data user', '2025-08-04 03:32:37'),
(69, 1, 'Putri S mengubah data user', '2025-08-04 03:43:34'),
(70, 1, 'Andi Santoso menambah data user', '2025-08-04 08:09:45'),
(71, 1, 'Aira S menambah data user', '2025-08-04 08:10:13'),
(72, 1, 'irwan src melakukan login ke sistem', '2025-08-05 23:04:34'),
(73, 1, 'irwan src melakukan login ke sistem', '2025-08-06 02:36:18'),
(74, 4, 'Aira S melakukan login ke sistem', '2025-08-06 08:30:13'),
(75, 1, 'irwan src melakukan login ke sistem', '2025-08-06 11:36:24'),
(76, 1, 'irwan src melakukan login ke sistem', '2025-08-08 21:36:15'),
(77, 1, 'irwan src menambah data tahun ajaran 2024 Semester Ganjil', '2025-08-08 22:02:29'),
(78, 1, 'irwan src menambah data tahun ajaran 2024 Semester Genap', '2025-08-08 22:02:39'),
(79, 1, 'irwan src mengubah data tahun ajaran 2025 Semester Genap', '2025-08-08 22:02:56'),
(80, 1, 'irwan src menambah data jilid', '2025-08-08 22:03:16'),
(81, 1, 'irwan src menambah data santri', '2025-08-08 22:04:05'),
(82, 1, 'irwan src menambah data santri', '2025-08-08 22:04:38'),
(83, 1, 'irwan src menambah data santri', '2025-08-08 22:12:41'),
(84, 1, 'irwan src menambah data kelas jilid', '2025-08-08 22:29:33'),
(85, 1, 'irwan src mengubah data kelas jilid', '2025-08-08 22:44:44'),
(86, 1, 'irwan src mengubah data kelas jilid', '2025-08-08 22:44:51'),
(87, 4, 'Aira S melakukan login ke sistem', '2025-08-08 22:48:48'),
(88, 1, 'irwan src menambah data kelas jilid', '2025-08-09 01:20:50'),
(89, 1, 'irwan src menambah data kelas jilid', '2025-08-09 01:27:38'),
(90, 1, 'irwan src menambah data kelas jilid', '2025-08-09 01:27:50'),
(91, 1, 'irwan src menambah data kelas jilid', '2025-08-09 01:28:04'),
(92, 1, 'irwan src menambah data kelas jilid', '2025-08-09 01:28:29'),
(93, NULL, ' menambah data absensi', '2025-08-09 02:07:47'),
(94, NULL, ' menambah data absensi', '2025-08-09 02:12:53'),
(95, NULL, ' menambah data absensi', '2025-08-09 02:15:02'),
(96, NULL, ' mengubah data absensi', '2025-08-09 02:16:01'),
(97, 1, 'irwan src melakukan login ke sistem', '2025-08-09 03:18:59'),
(98, 1, 'irwan src mengubah data user', '2025-08-09 16:11:25'),
(99, 1, 'irwan src mengubah data user', '2025-08-09 16:12:20'),
(100, 1, 'irwan src mengubah data user', '2025-08-09 16:12:37'),
(101, 4, ' melakukan login ke sistem', '2025-08-09 23:32:38'),
(102, 4, ' melakukan login ke sistem', '2025-08-09 23:58:18'),
(103, 1, 'irwan src menambah data ustadzah', '2025-08-09 23:59:31'),
(104, NULL, ' menambah data absensi', '2025-08-10 01:11:36'),
(105, NULL, ' menambah data absensi', '2025-08-10 01:13:22'),
(106, NULL, ' menambah data absensi', '2025-08-10 01:14:01'),
(107, 4, ' menambah data absensi', '2025-08-10 01:14:47'),
(108, 4, ' mengubah data absensi', '2025-08-10 01:15:07'),
(109, 4, ' mengubah data absensi', '2025-08-10 01:15:12'),
(110, 4, ' menambah data absensi', '2025-08-10 08:39:37'),
(111, 4, ' menambah data absensi', '2025-08-10 08:43:04'),
(112, 4, ' melakukan login ke sistem', '2025-08-10 10:16:20'),
(113, 4, ' melakukan login ke sistem', '2025-08-10 20:36:51'),
(114, 1, 'irwan src melakukan login ke sistem', '2025-08-10 21:28:52'),
(115, 1, 'irwan src menambah data materi', '2025-08-10 23:15:43'),
(116, 1, 'irwan src mengubah data materi', '2025-08-10 23:23:23'),
(117, 1, 'irwan src menambah data materi', '2025-08-10 23:23:53'),
(118, 1, 'irwan src menambah data materi', '2025-08-10 23:24:51'),
(119, 1, 'irwan src menghapus data materi', '2025-08-10 23:24:53'),
(120, 4, ' mengubah data absensi', '2025-08-11 03:55:45'),
(121, 4, 'aira mengubah data skor', '2025-08-11 05:44:37'),
(122, 4, 'aira mengubah data skor', '2025-08-11 05:47:48'),
(123, 4, 'aira mengubah data skor', '2025-08-11 05:56:25'),
(124, NULL, ' menghapus data skor', '2025-08-11 06:48:22'),
(125, 4, 'aira mengubah data skor', '2025-08-11 06:48:45'),
(126, NULL, ' menghapus data skor', '2025-08-11 06:49:04'),
(127, 4, 'aira mengubah data skor', '2025-08-11 06:52:11'),
(128, 1, 'irwan src melakukan login ke sistem', '2025-08-11 11:15:18'),
(129, 1, 'irwan src mengubah data materi', '2025-08-11 11:15:34'),
(130, 1, 'irwan src mengubah data materi', '2025-08-11 11:15:52'),
(131, 1, 'irwan src melakukan login ke sistem', '2025-08-11 18:34:49'),
(132, 1, 'irwan src melakukan login ke sistem', '2025-08-11 18:40:55'),
(133, 1, 'irwan src melakukan login ke sistem', '2025-08-11 18:42:38'),
(134, 1, 'irwan src melakukan login ke sistem', '2025-08-11 18:50:50');

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id_materi` int(11) NOT NULL,
  `id_jilid` int(11) NOT NULL,
  `nama_materi` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `urutan` int(11) DEFAULT 0,
  `aktif` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`id_materi`, `id_jilid`, `nama_materi`, `deskripsi`, `urutan`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 'Surat Al-Fatihah', 'deskripsi a', 1, 1, '2025-08-11 04:15:43', '2025-08-11 16:15:34'),
(2, 2, 'Surat Al-Baqarah', 'deskripsi BCA', 2, 1, '2025-08-11 04:23:53', '2025-08-11 16:15:52');

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int(11) NOT NULL,
  `kelas_jilid_id` int(11) NOT NULL,
  `nilai_angka` decimal(5,2) NOT NULL,
  `predikat` enum('A','B','C','D') NOT NULL,
  `status_lulus` tinyint(1) DEFAULT 0,
  `catatan` text DEFAULT NULL,
  `tanggal_penilaian` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftar`
--

CREATE TABLE `pendaftar` (
  `id_pendaftar` int(11) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `tanggal_daftar` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendaftar`
--

INSERT INTO `pendaftar` (`id_pendaftar`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `no_hp`, `tanggal_daftar`) VALUES
(1, 'irwan', 'Cirebon Timur', '1992-06-04', 'L', 'Jl. Irigasi Blok Cobek RT/RW 001/004 Ds. Mulyasari Losari Cirebon', '087789066666', '2025-08-04');

-- --------------------------------------------------------

--
-- Table structure for table `rekap_nilai`
--

CREATE TABLE `rekap_nilai` (
  `id_rekap` int(11) NOT NULL,
  `id_santri` int(11) DEFAULT NULL,
  `id_tahun` int(11) DEFAULT NULL,
  `total_nilai` int(11) DEFAULT NULL,
  `rata_rata` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `santri`
--

CREATE TABLE `santri` (
  `id_santri` int(11) NOT NULL,
  `nis` varchar(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kamar_id` int(11) DEFAULT NULL,
  `status_aktif` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `santri`
--

INSERT INTO `santri` (`id_santri`, `nis`, `nama`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `kamar_id`, `status_aktif`) VALUES
(1, 'NIS123XXXX', 'Santri A', '2010-02-02', 'L', 'jl test', 3, 1),
(2, 'NIS1231321', 'Santri B', '0000-00-00', 'P', 'sds', 3, 1),
(3, 'NIS1234443', 'Santri C', '0000-00-00', 'L', 'asda', 1, 1),
(4, '1234', 'Santri E', '2001-04-21', 'L', 'sadd', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `skor`
--

CREATE TABLE `skor` (
  `id_skor` int(11) NOT NULL,
  `kelas_jilid_id` int(11) NOT NULL,
  `materi_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `poin` decimal(5,2) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skor`
--

INSERT INTO `skor` (`id_skor`, `kelas_jilid_id`, `materi_id`, `tanggal`, `poin`, `kategori`, `keterangan`, `created_at`) VALUES
(1, 3, 2, '2025-08-11', 90.00, 'bacaan', 'baik perlu ditingkatkan', '2025-08-11 10:44:37'),
(2, 4, 2, '2025-08-11', 85.00, 'bacaan', 'masih harus banyak belajar', '2025-08-11 10:47:48'),
(5, 6, 2, '2025-08-11', 85.00, 'bacaan', 'test habis di hapus', '2025-08-11 11:52:11');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id_tahun` int(11) NOT NULL,
  `tahun` varchar(9) DEFAULT NULL,
  `semester` enum('Ganjil','Genap') DEFAULT NULL,
  `is_aktif` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id_tahun`, `tahun`, `semester`, `is_aktif`) VALUES
(1, '2023', 'Ganjil', 1),
(2, '2024', 'Ganjil', 1),
(3, '2025', 'Genap', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `id_ustadzah` int(11) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `id_ustadzah`, `nama_lengkap`, `username`, `password`, `role`) VALUES
(1, NULL, 'irwan src', 'admin', '$2y$10$guybURT0srL2keLZkGh/mOcOq48tu6UNAsxrQv7nY2PCKQE22OrXu', 'Admin'),
(2, NULL, 'Putri S', 'putri', '$2y$10$1MDzOiURFwIdBzcTTcHv3.yKBVspVC.WxOayj28n.vnCsDH7xvJuq', 'Koordinator'),
(3, NULL, 'Andi Santoso', 'andi', '$2y$10$p8jOPYEbpXlN8oHDdgyeluwqHQIrZeDIBNvszdqsmtlR.cnCovkwi', 'Wali Kelas'),
(4, 1, NULL, 'aira', '$2y$10$gIV02HChSyo.pS77bhhMROgdx7kWEUz512Agz.d5HkySIKuyuNYHi', 'Ustadzah');

-- --------------------------------------------------------

--
-- Table structure for table `ustadzah`
--

CREATE TABLE `ustadzah` (
  `id_ustadzah` int(11) NOT NULL,
  `nama_ustadzah` varchar(100) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ustadzah`
--

INSERT INTO `ustadzah` (`id_ustadzah`, `nama_ustadzah`, `no_hp`, `alamat`) VALUES
(1, 'Ustadzah A', '0877863783', 'Jl. Alamat A No. 21'),
(2, 'Ustadzah B', '0812xxx', 'jl test');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `kelas_jilid_id` (`kelas_jilid_id`);

--
-- Indexes for table `asrama`
--
ALTER TABLE `asrama`
  ADD PRIMARY KEY (`id_asrama`);

--
-- Indexes for table `evaluasi_santri`
--
ALTER TABLE `evaluasi_santri`
  ADD PRIMARY KEY (`id_evaluasi`),
  ADD KEY `id_santri` (`id_santri`);

--
-- Indexes for table `jilid`
--
ALTER TABLE `jilid`
  ADD PRIMARY KEY (`id_jilid`);

--
-- Indexes for table `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`id_kamar`),
  ADD KEY `id_asrama` (`id_asrama`);

--
-- Indexes for table `kelas_jilid`
--
ALTER TABLE `kelas_jilid`
  ADD PRIMARY KEY (`id_kelas_jilid`),
  ADD KEY `santri_id` (`santri_id`),
  ADD KEY `jilid_id` (`jilid_id`),
  ADD KEY `ustadzah_id` (`ustadzah_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`);

--
-- Indexes for table `kenaikan`
--
ALTER TABLE `kenaikan`
  ADD PRIMARY KEY (`id_kenaikan`),
  ADD KEY `id_santri` (`id_santri`),
  ADD KEY `dari_jilid` (`dari_jilid`),
  ADD KEY `ke_jilid` (`ke_jilid`);

--
-- Indexes for table `kepala_kamar`
--
ALTER TABLE `kepala_kamar`
  ADD PRIMARY KEY (`id_kepala_kamar`),
  ADD KEY `id_kamar` (`id_kamar`);

--
-- Indexes for table `laporan_triwulan`
--
ALTER TABLE `laporan_triwulan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_santri` (`id_santri`);

--
-- Indexes for table `legger`
--
ALTER TABLE `legger`
  ADD PRIMARY KEY (`id_legger`),
  ADD KEY `id_santri` (`id_santri`),
  ADD KEY `id_tahun` (`id_tahun`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`),
  ADD KEY `fk_materi_jilid` (`id_jilid`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `fk_nilai_kelasjilid` (`kelas_jilid_id`);

--
-- Indexes for table `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD PRIMARY KEY (`id_pendaftar`);

--
-- Indexes for table `rekap_nilai`
--
ALTER TABLE `rekap_nilai`
  ADD PRIMARY KEY (`id_rekap`),
  ADD KEY `id_santri` (`id_santri`),
  ADD KEY `id_tahun` (`id_tahun`);

--
-- Indexes for table `santri`
--
ALTER TABLE `santri`
  ADD PRIMARY KEY (`id_santri`);

--
-- Indexes for table `skor`
--
ALTER TABLE `skor`
  ADD PRIMARY KEY (`id_skor`),
  ADD KEY `fk_skor_kelasjilid` (`kelas_jilid_id`),
  ADD KEY `fk_skor_materi` (`materi_id`);

--
-- Indexes for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id_tahun`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `fk_id_ustadzah_user` (`id_ustadzah`);

--
-- Indexes for table `ustadzah`
--
ALTER TABLE `ustadzah`
  ADD PRIMARY KEY (`id_ustadzah`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `asrama`
--
ALTER TABLE `asrama`
  MODIFY `id_asrama` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `evaluasi_santri`
--
ALTER TABLE `evaluasi_santri`
  MODIFY `id_evaluasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jilid`
--
ALTER TABLE `jilid`
  MODIFY `id_jilid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kamar`
--
ALTER TABLE `kamar`
  MODIFY `id_kamar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kelas_jilid`
--
ALTER TABLE `kelas_jilid`
  MODIFY `id_kelas_jilid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kenaikan`
--
ALTER TABLE `kenaikan`
  MODIFY `id_kenaikan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kepala_kamar`
--
ALTER TABLE `kepala_kamar`
  MODIFY `id_kepala_kamar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `laporan_triwulan`
--
ALTER TABLE `laporan_triwulan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legger`
--
ALTER TABLE `legger`
  MODIFY `id_legger` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pendaftar`
--
ALTER TABLE `pendaftar`
  MODIFY `id_pendaftar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rekap_nilai`
--
ALTER TABLE `rekap_nilai`
  MODIFY `id_rekap` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `santri`
--
ALTER TABLE `santri`
  MODIFY `id_santri` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `skor`
--
ALTER TABLE `skor`
  MODIFY `id_skor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id_tahun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ustadzah`
--
ALTER TABLE `ustadzah`
  MODIFY `id_ustadzah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`kelas_jilid_id`) REFERENCES `kelas_jilid` (`id_kelas_jilid`);

--
-- Constraints for table `evaluasi_santri`
--
ALTER TABLE `evaluasi_santri`
  ADD CONSTRAINT `evaluasi_santri_ibfk_1` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id_santri`);

--
-- Constraints for table `kamar`
--
ALTER TABLE `kamar`
  ADD CONSTRAINT `kamar_ibfk_1` FOREIGN KEY (`id_asrama`) REFERENCES `asrama` (`id_asrama`) ON DELETE CASCADE;

--
-- Constraints for table `kelas_jilid`
--
ALTER TABLE `kelas_jilid`
  ADD CONSTRAINT `kelas_jilid_ibfk_1` FOREIGN KEY (`santri_id`) REFERENCES `santri` (`id_santri`),
  ADD CONSTRAINT `kelas_jilid_ibfk_2` FOREIGN KEY (`jilid_id`) REFERENCES `jilid` (`id_jilid`),
  ADD CONSTRAINT `kelas_jilid_ibfk_3` FOREIGN KEY (`ustadzah_id`) REFERENCES `ustadzah` (`id_ustadzah`),
  ADD CONSTRAINT `kelas_jilid_ibfk_4` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id_tahun`);

--
-- Constraints for table `kenaikan`
--
ALTER TABLE `kenaikan`
  ADD CONSTRAINT `kenaikan_ibfk_1` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id_santri`),
  ADD CONSTRAINT `kenaikan_ibfk_2` FOREIGN KEY (`dari_jilid`) REFERENCES `jilid` (`id_jilid`),
  ADD CONSTRAINT `kenaikan_ibfk_3` FOREIGN KEY (`ke_jilid`) REFERENCES `jilid` (`id_jilid`);

--
-- Constraints for table `kepala_kamar`
--
ALTER TABLE `kepala_kamar`
  ADD CONSTRAINT `kepala_kamar_ibfk_1` FOREIGN KEY (`id_kamar`) REFERENCES `kamar` (`id_kamar`) ON DELETE CASCADE;

--
-- Constraints for table `laporan_triwulan`
--
ALTER TABLE `laporan_triwulan`
  ADD CONSTRAINT `laporan_triwulan_ibfk_1` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id_santri`);

--
-- Constraints for table `legger`
--
ALTER TABLE `legger`
  ADD CONSTRAINT `legger_ibfk_1` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id_santri`),
  ADD CONSTRAINT `legger_ibfk_2` FOREIGN KEY (`id_tahun`) REFERENCES `tahun_ajaran` (`id_tahun`);

--
-- Constraints for table `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `fk_materi_jilid` FOREIGN KEY (`id_jilid`) REFERENCES `jilid` (`id_jilid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `fk_nilai_kelasjilid` FOREIGN KEY (`kelas_jilid_id`) REFERENCES `kelas_jilid` (`id_kelas_jilid`);

--
-- Constraints for table `rekap_nilai`
--
ALTER TABLE `rekap_nilai`
  ADD CONSTRAINT `rekap_nilai_ibfk_1` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id_santri`),
  ADD CONSTRAINT `rekap_nilai_ibfk_2` FOREIGN KEY (`id_tahun`) REFERENCES `tahun_ajaran` (`id_tahun`);

--
-- Constraints for table `skor`
--
ALTER TABLE `skor`
  ADD CONSTRAINT `fk_skor_kelasjilid` FOREIGN KEY (`kelas_jilid_id`) REFERENCES `kelas_jilid` (`id_kelas_jilid`),
  ADD CONSTRAINT `fk_skor_materi` FOREIGN KEY (`materi_id`) REFERENCES `materi` (`id_materi`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_id_ustadzah_user` FOREIGN KEY (`id_ustadzah`) REFERENCES `ustadzah` (`id_ustadzah`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
