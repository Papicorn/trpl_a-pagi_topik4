-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 17, 2023 at 05:25 AM
-- Server version: 10.2.44-MariaDB-cll-lve
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `molg1696_kitapeduli`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktivitas`
--

CREATE TABLE `aktivitas` (
  `id` int(11) NOT NULL,
  `aktivitas` varchar(150) NOT NULL,
  `id_user` int(11) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aktivitas`
--

INSERT INTO `aktivitas` (`id`, `aktivitas`, `id_user`, `waktu`) VALUES
(9, 'Keluar dari komunitas Anak Alam Batam Center', 69, '2023-12-16 19:13:58'),
(10, 'Bergabung pada kegiatan Sekolah Advokasi', 70, '2023-12-16 21:33:37'),
(11, 'Memberikan ulasan pada kegiatan Sekolah Advokasi', 70, '2023-12-16 21:33:41');

-- --------------------------------------------------------

--
-- Table structure for table `community`
--

CREATE TABLE `community` (
  `id_community` int(11) NOT NULL,
  `nama_komunitas` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `password` varchar(250) NOT NULL,
  `id_user` int(11) NOT NULL,
  `no_telpon` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profile_picture` varchar(50) NOT NULL,
  `sertifikat` varchar(250) NOT NULL,
  `status` enum('belum disetujui','disetujui') NOT NULL,
  `tgl_bergabung` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `community`
--

INSERT INTO `community` (`id_community`, `nama_komunitas`, `deskripsi`, `password`, `id_user`, `no_telpon`, `email`, `profile_picture`, `sertifikat`, `status`, `tgl_bergabung`) VALUES
(37, 'Anak Alam Batam Center', '121221212121', '$2y$10$hYyhII2fsHoidVWHuqQiMOBvx9MRxZqg.4m0vm0Jt0/QryhbH4rcS', 70, '082234435324', 'aabc@gmail.com', 'komunitas1.jpg', 'Sertifikat.pdf', 'disetujui', '2023-12-11');

-- --------------------------------------------------------

--
-- Table structure for table `gabung_community`
--

CREATE TABLE `gabung_community` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_community` int(11) NOT NULL,
  `status` enum('disetujui','belum disetujui') NOT NULL DEFAULT 'belum disetujui',
  `tgl_gabung` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gabung_community`
--

INSERT INTO `gabung_community` (`id`, `id_user`, `id_community`, `status`, `tgl_gabung`) VALUES
(59, 70, 37, 'disetujui', '2023-12-11');

-- --------------------------------------------------------

--
-- Table structure for table `gabung_kegiatan`
--

CREATE TABLE `gabung_kegiatan` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_kegiatan` int(11) NOT NULL,
  `waktu_bergabung` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gabung_kegiatan`
--

INSERT INTO `gabung_kegiatan` (`id`, `id_user`, `id_kegiatan`, `waktu_bergabung`) VALUES
(44, 70, 49, '2023-12-16 20:57:25');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id_kegiatan` int(11) NOT NULL,
  `judul_kegiatan` varchar(50) NOT NULL,
  `isi_kegiatan` text NOT NULL,
  `lokasi` varchar(250) NOT NULL,
  `id_community` int(11) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `banner` varchar(100) NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id_kegiatan`, `judul_kegiatan`, `isi_kegiatan`, `lokasi`, `id_community`, `kategori`, `banner`, `waktu_mulai`, `waktu_selesai`, `tgl_mulai`, `tgl_selesai`, `tgl_dibuat`) VALUES
(49, 'Sekolah Advokasi', 'Ini adalah sekolah advokasi, yang dimana kegiatan ini bertujuan untuk mensosialisasikan teman\" yang mengikuti kegiatan ini. Untuk mengikuti kegiatan ini tolong share link berikut https://kitapeduli.molba.xyz bye bye', 'Politeknik Negeri Batam', 37, 'Sosialisasi', 'kegiatan-7.jpg', '04:00:00', '04:15:00', '2023-12-17', '2023-12-17', '2023-12-16 21:11:20');

-- --------------------------------------------------------

--
-- Table structure for table `kode_otp`
--

CREATE TABLE `kode_otp` (
  `kode` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` enum('terpakai','belum terpakai') NOT NULL DEFAULT 'belum terpakai',
  `time` time NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `id_komentar` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_news` int(11) NOT NULL,
  `komentar` varchar(200) NOT NULL,
  `tgl_komentar` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id_news` int(11) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `isi_news` text NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `hastag` varchar(100) NOT NULL,
  `banner` varchar(250) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_login`
--

CREATE TABLE `riwayat_login` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `jam` time NOT NULL,
  `tgl_login` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `riwayat_login`
--

INSERT INTO `riwayat_login` (`id`, `id_user`, `ip`, `jam`, `tgl_login`) VALUES
(152, 69, '139.194.10.103', '02:07:59', '2023-12-17'),
(153, 70, '139.194.10.103', '02:16:09', '2023-12-17'),
(154, 69, '139.194.10.103', '02:18:08', '2023-12-17'),
(155, 69, '139.194.10.103', '02:41:34', '2023-12-17'),
(156, 69, '139.194.10.103', '02:57:44', '2023-12-17'),
(157, 70, '139.194.10.103', '02:57:52', '2023-12-17'),
(158, 69, '139.194.10.103', '03:09:35', '2023-12-17'),
(159, 70, '139.194.10.103', '03:13:37', '2023-12-17'),
(160, 69, '139.194.10.103', '03:19:36', '2023-12-17'),
(161, 69, '139.194.10.103', '03:21:59', '2023-12-17');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_telpon` varchar(50) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `description`, `email`, `no_telpon`, `alamat`) VALUES
(1, 'kitapeduli.id', 'kitapeduli.id adalah tempat terbaik untuk mencari kegiatan sukarelawan atau pun mencari sukarelawan dengan cepat, aman dan nyaman. Sudah diapakai sebanyak 1000+ sukarelawan!', 'admin@kitapeduli.molba.xyz', '08564473628', 'Jl. Habibi Blok K20 B');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `id_ulasan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `ulasan` text NOT NULL,
  `id_kegiatan` int(11) NOT NULL,
  `tgl_ulasan` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ulasan`
--

INSERT INTO `ulasan` (`id_ulasan`, `id_user`, `ulasan`, `id_kegiatan`, `tgl_ulasan`) VALUES
(10, 70, 'Kegiatan nya sangat seru dan banyak ilmu yang di dapat. tetapi untuk konsumsi kurang puas, harusnya dikasih nasi padang', 49, '2023-12-16 21:16:27');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(125) NOT NULL,
  `alamat` text NOT NULL,
  `nik` int(16) DEFAULT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `kelamin` enum('pria','wanita') DEFAULT NULL,
  `id_community` int(11) DEFAULT NULL,
  `biodata` varchar(250) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `no_telpon` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` enum('Aktif','Nonaktif','','') NOT NULL,
  `level` enum('admin','user') NOT NULL DEFAULT 'user',
  `tgl_bergabung` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `alamat`, `nik`, `nama_lengkap`, `kelamin`, `id_community`, `biodata`, `tgl_lahir`, `no_telpon`, `email`, `status`, `level`, `tgl_bergabung`) VALUES
(69, 'admin123', '$2y$10$qxjB26FUmM1puLOMmHr/GOfrF2PhgjqWGftM.ZxL35ZPu.kCqwpZu', 'Eden Park', 2147483647, 'Admin Demo', 'pria', NULL, '', '2023-12-17', '085646643646', 'admin@gmail.com', 'Aktif', 'admin', '2023-12-17'),
(70, 'user123', '$2y$10$Qi1UzIPtLfGbV2/HXZKbg.nj4lR.qu/ziFDbT7m9Xt3y5qkjkNkb6', 'Jalan Gergas, No.4, Dabo Lama, Singkep, Lingga', 2147483647, 'User Demo', 'pria', 37, 'Ini adalah biodata saya ya gesss', '2023-12-11', '085646643646', 'user@gmail.com', 'Aktif', 'user', '2023-12-17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktivitas`
--
ALTER TABLE `aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aktivitas_ibfk_1` (`id_user`);

--
-- Indexes for table `community`
--
ALTER TABLE `community`
  ADD PRIMARY KEY (`id_community`),
  ADD KEY `community_ibfk_1` (`id_user`);

--
-- Indexes for table `gabung_community`
--
ALTER TABLE `gabung_community`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gabung_community_ibfk_1` (`id_user`),
  ADD KEY `gabung_community_ibfk_2` (`id_community`);

--
-- Indexes for table `gabung_kegiatan`
--
ALTER TABLE `gabung_kegiatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gabung_kegiatan_ibfk_1` (`id_user`),
  ADD KEY `gabung_kegiatan_ibfk_2` (`id_kegiatan`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`),
  ADD KEY `id_komunitas` (`id_community`);

--
-- Indexes for table `kode_otp`
--
ALTER TABLE `kode_otp`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id_komentar`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_news` (`id_news`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id_news`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `riwayat_login`
--
ALTER TABLE `riwayat_login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alamat` (`alamat`(768)),
  ADD KEY `no_telpon` (`no_telpon`),
  ADD KEY `alamat_2` (`alamat`(768)),
  ADD KEY `email` (`email`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id_ulasan`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_kegiatan` (`id_kegiatan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `nama_komunitas` (`id_community`),
  ADD KEY `id_komunitas` (`id_community`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktivitas`
--
ALTER TABLE `aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `community`
--
ALTER TABLE `community`
  MODIFY `id_community` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `gabung_community`
--
ALTER TABLE `gabung_community`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `gabung_kegiatan`
--
ALTER TABLE `gabung_kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_kegiatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `kode_otp`
--
ALTER TABLE `kode_otp`
  MODIFY `kode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=926665;

--
-- AUTO_INCREMENT for table `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id_news` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `riwayat_login`
--
ALTER TABLE `riwayat_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id_ulasan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aktivitas`
--
ALTER TABLE `aktivitas`
  ADD CONSTRAINT `aktivitas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `community`
--
ALTER TABLE `community`
  ADD CONSTRAINT `community_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gabung_community`
--
ALTER TABLE `gabung_community`
  ADD CONSTRAINT `gabung_community_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gabung_community_ibfk_2` FOREIGN KEY (`id_community`) REFERENCES `community` (`id_community`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gabung_kegiatan`
--
ALTER TABLE `gabung_kegiatan`
  ADD CONSTRAINT `gabung_kegiatan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gabung_kegiatan_ibfk_2` FOREIGN KEY (`id_kegiatan`) REFERENCES `kegiatan` (`id_kegiatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `kegiatan_ibfk_1` FOREIGN KEY (`id_community`) REFERENCES `community` (`id_community`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentar_ibfk_2` FOREIGN KEY (`id_news`) REFERENCES `news` (`id_news`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `riwayat_login`
--
ALTER TABLE `riwayat_login`
  ADD CONSTRAINT `riwayat_login_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `ulasan_ibfk_1` FOREIGN KEY (`id_kegiatan`) REFERENCES `kegiatan` (`id_kegiatan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ulasan_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_community`) REFERENCES `community` (`id_community`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
