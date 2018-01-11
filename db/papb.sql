-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2017 at 10:09 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `aplikasi_toni`
--

DELIMITER $$
--
-- Functions
--
CREATE FUNCTION `set_pasang`(`status_p` INT) RETURNS varchar(20) CHARSET latin1
BEGIN

   DECLARE income_level varchar(20);

   IF status_p = 0 THEN
      SET income_level = 'Belum Selesai';

   ELSE
      SET income_level = 'Selesai';

   END IF;

   RETURN income_level;

END$$

CREATE FUNCTION `set_status_projek`(`status_pro` INT) RETURNS varchar(20) CHARSET latin1
BEGIN

   DECLARE status varchar(20);

   IF status_pro = 0 THEN
      SET status = 'Proses Survei';

   ELSEIF status_pro = 1 THEN
      SET status= 'Survei Selesai';
      
   ELSEIF status_pro = 2 THEN
      SET status= 'Proses Lapangan';
      
   ELSE
   	  SET status= 'Projek Selesai';
	
   END IF;

   RETURN status;

END$$

CREATE FUNCTION `set_status_rambu`(`status_ram` INT) RETURNS varchar(20) CHARSET latin1
BEGIN

   DECLARE r_level varchar(20);

   IF status_ram = 1 THEN
      SET r_level = 'Pemasangan';

   ELSE
      SET r_level = 'Perawatan';

   END IF;

   RETURN r_level;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `data_project`
--

CREATE TABLE IF NOT EXISTS `data_project` (
`id_tugas` int(5) NOT NULL,
  `id_projek` int(5) DEFAULT NULL,
  `id_penyurvei` int(5) DEFAULT NULL,
  `id_plapangan` int(5) DEFAULT '0',
  `nama_rambu` text CHARACTER SET utf16,
  `lokasi_jalan` text CHARACTER SET utf16,
  `kode_rambu` text CHARACTER SET utf16,
  `id_jenis_rambu` text CHARACTER SET utf16,
  `lebar_jalan` text CHARACTER SET utf16,
  `lebar_bahu_jalan` text CHARACTER SET utf16,
  `sisi_jalan` text CHARACTER SET utf16,
  `lat` text CHARACTER SET utf16,
  `long` text CHARACTER SET utf16,
  `keterangan` text CHARACTER SET utf16le NOT NULL,
  `foto` text CHARACTER SET utf16,
  `foto_thumb` text CHARACTER SET utf16,
  `tanggal` datetime DEFAULT CURRENT_TIMESTAMP,
  `status_rambu` int(1) DEFAULT NULL,
  `status_pasang` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
`id_projek` int(5) NOT NULL,
  `id_penyurvei` int(5) DEFAULT NULL,
  `id_plapangan` int(5) DEFAULT '0',
  `nama_daerah` text CHARACTER SET utf16,
  `nama_projek` text CHARACTER SET utf16,
  `status_projek` tinyint(1) DEFAULT '0',
  `deskripsi` text CHARACTER SET utf16,
  `tanggal_buat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `traffic_sign`
--

CREATE TABLE IF NOT EXISTS `traffic_sign` (
`id_rambu` int(5) NOT NULL,
  `id_jenis_rambu` int(5) DEFAULT NULL,
  `kode_rambu` text CHARACTER SET utf16,
  `nama_rambu` text CHARACTER SET utf16,
  `foto` text CHARACTER SET utf16,
  `foto_thumb` text CHARACTER SET utf16
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

--
-- Dumping data for table `traffic_sign`
--

INSERT INTO `traffic_sign` (`id_rambu`, `id_jenis_rambu`, `kode_rambu`, `nama_rambu`, `foto`, `foto_thumb`) VALUES
(10, 1, '1a', 'Peringatan Tikungan ke Kiri', 'uploads/sign/b24a26a2a6d737062fb68d98d1b47e6c.png', 'uploads/sign/thumbs/b24a26a2a6d737062fb68d98d1b47e6c.png'),
(11, 1, '1b', 'Peringatan Tikungan ke Kanan', 'uploads/sign/338b9414b57be1b9926c9cc3fc546e20.png', 'uploads/sign/thumbs/338b9414b57be1b9926c9cc3fc546e20.png'),
(12, 1, '1c', 'Peringatan Tikungan Ganda dengan Tikungan Pertama ke Kiri', 'uploads/sign/4ad44827c3efe4d1520e97901bb27d2f.png', 'uploads/sign/thumbs/4ad44827c3efe4d1520e97901bb27d2f.png'),
(13, 1, '1e', 'Peringatan Tikungan Tajam ke Kiri', 'uploads/sign/71f1b24c19425a110c27e9cab53339b3.png', 'uploads/sign/thumbs/71f1b24c19425a110c27e9cab53339b3.png'),
(14, 1, '1j', 'Peringatan Banyak Tikungan dengan Tikungan Pertama ke Kanan', 'uploads/sign/c17580a19d740733ce3b67f31a066078.png', 'uploads/sign/thumbs/c17580a19d740733ce3b67f31a066078.png'),
(15, 1, '1g', 'Peringatan Tikungan Tajam Ganda dengan Tikungan Pertama ke Kiri', 'uploads/sign/ff98fd9d0071dc53f7ee2293d715aa91.png', 'uploads/sign/thumbs/ff98fd9d0071dc53f7ee2293d715aa91.png'),
(16, 1, '1k', 'Peringatan Tikungan Memutar ke Kiri', 'uploads/sign/e4cd1dc4909c90ec49c407a379fcd5fb.png', 'uploads/sign/thumbs/e4cd1dc4909c90ec49c407a379fcd5fb.png'),
(17, 1, '1m', 'Peringatan Penyempitan Badan Jalan di Bagian Kiri dan Kanan', 'uploads/sign/a568e91e5bf98087d036263eac42231c.png', 'uploads/sign/thumbs/a568e91e5bf98087d036263eac42231c.png'),
(18, 1, '1p', 'Peringatan Penyempitan Badan Jalan di Bagian Kanan', 'uploads/sign/191aee0247d51f3c308956587b5d0c42.png', 'uploads/sign/thumbs/191aee0247d51f3c308956587b5d0c42.png'),
(19, 1, '1w', 'Peringatan Jembatan Peringatan Penyempitan Bagan Jalinan Jalan Tertentu', 'uploads/sign/0e1834ba8d7182db136bd0081f5229cb.png', 'uploads/sign/thumbs/0e1834ba8d7182db136bd0081f5229cb.png'),
(20, 1, '2a', 'Peringatan Turunan Landai', 'uploads/sign/4aaf91ef1a054cd9bee19bb9b427bd00.png', 'uploads/sign/thumbs/4aaf91ef1a054cd9bee19bb9b427bd00.png'),
(21, 1, '3a', 'Peringatan Permukaan Jalan yang Licin', 'uploads/sign/32cf113377efca3009c710f5da48589e.png', 'uploads/sign/thumbs/32cf113377efca3009c710f5da48589e.png'),
(22, 1, '3g', 'Peringatan Jalan Bergelombang', 'uploads/sign/ba219b47dc354700f44dbd7f636269f3.png', 'uploads/sign/thumbs/ba219b47dc354700f44dbd7f636269f3.png'),
(23, 1, '4a1', 'Peringatan Alat Pemberi Isyarat Lalu', 'uploads/sign/988432077bb717cc6c6ecba1c7617fbf.png', 'uploads/sign/thumbs/988432077bb717cc6c6ecba1c7617fbf.png'),
(24, 1, '4b1', 'Peringatan Simpang Empat Prioritas', 'uploads/sign/016fd05c234ee8f193b63bac9c2188bb.png', 'uploads/sign/thumbs/016fd05c234ee8f193b63bac9c2188bb.png'),
(25, 1, '4b3', 'Peringatan Bundaran dengan Prioritas', 'uploads/sign/332d2dadc12176ec04fb689f0d8469e2.png', 'uploads/sign/thumbs/332d2dadc12176ec04fb689f0d8469e2.png'),
(26, 1, '4b13', 'Peringatan Persimpangan Tiga Serong Kanan', 'uploads/sign/c4c3b23b2603364686100a9068569e78.png', 'uploads/sign/thumbs/c4c3b23b2603364686100a9068569e78.png'),
(27, 1, '4b18', 'Peringatan Persimpangan Tiga Tipe T', 'uploads/sign/1b8054b4d74493fdb97417a452ee341f.png', 'uploads/sign/thumbs/1b8054b4d74493fdb97417a452ee341f.png'),
(28, 1, '6a', 'Peringatan Banyak Lalu Lintas Pejalan Kaki', 'uploads/sign/3b2a45b112ce70908ea0622291ea0023.png', 'uploads/sign/thumbs/3b2a45b112ce70908ea0622291ea0023.png'),
(29, 1, '6c', 'Peringatan Banyak Lalu Lintas Pejalan Kaki Anak-anak', 'uploads/sign/940124203bd125ae0764206c5658c1dc.png', 'uploads/sign/thumbs/940124203bd125ae0764206c5658c1dc.png'),
(30, 1, '6e', 'Peringatan Banyak Lalu Lintas Sepeda', 'uploads/sign/ba93c6cc4a97a4b6dd90e90763c86c3a.png', 'uploads/sign/thumbs/ba93c6cc4a97a4b6dd90e90763c86c3a.png'),
(31, 1, '6g', 'Peringatan Banyak Hewan Liar Melintas', 'uploads/sign/f20e58643fe93fb1a992e22e266ac92e.png', 'uploads/sign/thumbs/f20e58643fe93fb1a992e22e266ac92e.png'),
(32, 1, '8a', 'Hati-hati (Ditegaskan dengan penjelasan memakai rambu tambahan)', 'uploads/sign/0b1120dadf01dfdb6708a189ac761d55.png', 'uploads/sign/thumbs/0b1120dadf01dfdb6708a189ac761d55.png'),
(33, 1, '8e', 'Peringatan Pintu Perlintasan Sebidang Kereta', 'uploads/sign/348c6be1454a1825794e17fb1e20f0af.png', 'uploads/sign/thumbs/348c6be1454a1825794e17fb1e20f0af.png'),
(34, 1, '8i', 'Peringatan Lalu Lintas Dua Arah', 'uploads/sign/2e0c1a0858ef1da8a3498dfd14d41ec8.png', 'uploads/sign/thumbs/2e0c1a0858ef1da8a3498dfd14d41ec8.png'),
(35, 1, '11d', 'Pengarah Tikungan ke Kiri', 'uploads/sign/9c3405fb063a5a3c3c92e549efe9713a.png', 'uploads/sign/thumbs/9c3405fb063a5a3c3c92e549efe9713a.png'),
(36, 1, '11e', 'Pengarah Tikungan ke Kanan', 'uploads/sign/9849b649b40e4fe54a1467f99508d340.png', 'uploads/sign/thumbs/9849b649b40e4fe54a1467f99508d340.png'),
(37, 2, '1a', 'Larangan Berjalan Terus karena Wajib Berhenti Sesaat', 'uploads/sign/aacf8371fe7f3bd7a443d75d28ba2f8c.png', 'uploads/sign/thumbs/aacf8371fe7f3bd7a443d75d28ba2f8c.png'),
(38, 2, '1b', 'Larangan Berjalan Terus karena Wajib Memberi Prioritas Kepada Arus Lalu Lintas', 'uploads/sign/9bb75a6d70a38584a8cd94b2e84280ef.png', 'uploads/sign/thumbs/9bb75a6d70a38584a8cd94b2e84280ef.png'),
(39, 2, '2a2', 'Larangan Masuk Bagi Kendaraan Bermotor dan Tidak Bermotor', 'uploads/sign/037afa5ad28777d2156b7c56492ef28c.png', 'uploads/sign/thumbs/037afa5ad28777d2156b7c56492ef28c.png'),
(40, 2, '2b1', 'Larangan Masuk bagi Sepeda Motor', 'uploads/sign/45d2ff3c15eb74c5799f1785438adc3e.png', 'uploads/sign/thumbs/45d2ff3c15eb74c5799f1785438adc3e.png'),
(41, 2, '2b3', 'Larangan Masuk bagi Mobil Penumpang', 'uploads/sign/63ee3d1ab54e2ef61d338e1d76a88bde.png', 'uploads/sign/thumbs/63ee3d1ab54e2ef61d338e1d76a88bde.png'),
(42, 2, '2b9', 'Larangan Masuk bagi Sepeda Motor dan Mobil Penumpang', 'uploads/sign/853490c686e4683c8cf498a0d37654d2.png', 'uploads/sign/thumbs/853490c686e4683c8cf498a0d37654d2.png'),
(43, 2, '2c3', 'Larangan Masuk bagi Sepeda', 'uploads/sign/c53e92785044455e978027bd224752e5.png', 'uploads/sign/thumbs/c53e92785044455e978027bd224752e5.png'),
(44, 2, '2d1', 'Larangan Masuk bagi Kendaraan Bermotor dengan Panjang Lebih dari', 'uploads/sign/bca30d70f2ed0752d301fb6a7e4a1abd.png', 'uploads/sign/thumbs/bca30d70f2ed0752d301fb6a7e4a1abd.png'),
(45, 2, '2d2', 'Larangan Masuk bagi Kendaraan Bermotor dengan Tinggi Lebih dari', 'uploads/sign/549acb01279576c8a6cb4bb32840982e.png', 'uploads/sign/thumbs/549acb01279576c8a6cb4bb32840982e.png'),
(46, 2, '2d3', 'Larangan Masuk bagi Kendaraan Bermotor dengan Lebar Lebih dari', 'uploads/sign/7d4b3d3313161b152aaaa3024959265c.png', 'uploads/sign/thumbs/7d4b3d3313161b152aaaa3024959265c.png'),
(47, 2, '3a', 'Larangan Berhenti', 'uploads/sign/b7927052f1cff9cdb83c3b541dcd1a50.png', 'uploads/sign/thumbs/b7927052f1cff9cdb83c3b541dcd1a50.png'),
(48, 2, '3b', 'Larangan Parkir', 'uploads/sign/511af7d29095641052f3d13c74c289ad.png', 'uploads/sign/thumbs/511af7d29095641052f3d13c74c289ad.png'),
(49, 2, '4a', 'Larangan Berjalan Terus', 'uploads/sign/ca7193cb91f261e91f8082e1f8a7e206.PNG', 'uploads/sign/thumbs/ca7193cb91f261e91f8082e1f8a7e206.PNG'),
(50, 2, '4b', 'Larangan Belok Kiri', 'uploads/sign/16a175726b0b4d20f849637e861067f1.PNG', 'uploads/sign/thumbs/16a175726b0b4d20f849637e861067f1.PNG'),
(51, 2, '4c', 'Larangan Belok Kanan', 'uploads/sign/45a3fec35d0b0184653dae724dda304d.PNG', 'uploads/sign/thumbs/45a3fec35d0b0184653dae724dda304d.PNG'),
(52, 2, '4d', 'Larangan Menyalip Kendaraan lain', 'uploads/sign/bf4381aed81765407d39a57b1a414b3e.PNG', 'uploads/sign/thumbs/bf4381aed81765407d39a57b1a414b3e.PNG'),
(53, 2, '4e', 'Larangan Memutar Balik', 'uploads/sign/6ac3560c65dd33aee04a70dcc632b92c.PNG', 'uploads/sign/thumbs/6ac3560c65dd33aee04a70dcc632b92c.PNG'),
(54, 2, '4g', 'Larangan Mendekati Kendaraan di Depan dengan Jarak Sama atau Kurang dari', 'uploads/sign/bb5c32513fd629d833382a594a72c5d3.png', 'uploads/sign/thumbs/bb5c32513fd629d833382a594a72c5d3.png'),
(55, 2, '4h', 'Larangan Menjalankan Kendaraan dengan Kecepatan Lebih dari yang Tertulis', 'uploads/sign/31198c5aaf63bb9280e2775ddf46c9f6.png', 'uploads/sign/thumbs/31198c5aaf63bb9280e2775ddf46c9f6.png'),
(56, 3, '1a', 'Perintah Mengikuti ke Arah Kiri', 'uploads/sign/af6b4e2d79fc8bc5547f4712b62e2ae5.png', 'uploads/sign/thumbs/af6b4e2d79fc8bc5547f4712b62e2ae5.png'),
(57, 3, '1b', 'Perintah Mengikuti ke Arah Kanan', 'uploads/sign/5da16363a13b2f540b4080a7f6565d7a.png', 'uploads/sign/thumbs/5da16363a13b2f540b4080a7f6565d7a.png'),
(58, 3, '1c', 'Perintah Belok ke Arah Kiri', 'uploads/sign/ab7e30a9a0ec36c165628a222a5862d7.png', 'uploads/sign/thumbs/ab7e30a9a0ec36c165628a222a5862d7.png'),
(59, 3, '1d', 'Perintah Belok ke Arah Kanan', 'uploads/sign/5da7d47b89b6ba7f8a130cc9cd79acca.png', 'uploads/sign/thumbs/5da7d47b89b6ba7f8a130cc9cd79acca.png'),
(60, 3, '1e', 'Perintah Berjalan Lurus', 'uploads/sign/faa3ffc2a655ad069f6decbf904bba40.png', 'uploads/sign/thumbs/faa3ffc2a655ad069f6decbf904bba40.png'),
(61, 3, '1f', 'Perintah Mengikuti Arah yang Ditunjukkan saat memasuki bundaran', 'uploads/sign/f1a7cb142e29c84465aee908b0b7a549.png', 'uploads/sign/thumbs/f1a7cb142e29c84465aee908b0b7a549.png'),
(62, 3, '3a', 'Perintah Memasuki Jalur atau Lajur Kiri yang Ditunjuk', 'uploads/sign/031877e1e70b2db45183d6dfbdf28607.png', 'uploads/sign/thumbs/031877e1e70b2db45183d6dfbdf28607.png'),
(63, 3, '3b', 'Perintah Memasuki Jalur atau Lajur Kanan yang Ditunjuk', 'uploads/sign/71cbf370c85af9d8c61d70818ff42112.png', 'uploads/sign/thumbs/71cbf370c85af9d8c61d70818ff42112.png'),
(64, 3, '3c', 'Perintah Pilihan Memasuki Salah Satu Jalur atau Lajur yang Ditunjuk', 'uploads/sign/368f9fdd038421bbf24f8861fa6a052b.png', 'uploads/sign/thumbs/368f9fdd038421bbf24f8861fa6a052b.png'),
(65, 3, '4', 'Kecepatan Minimum yang Diperintahkan', 'uploads/sign/15517cee4f83f9ca2510fd43c4e72d3b.png', 'uploads/sign/thumbs/15517cee4f83f9ca2510fd43c4e72d3b.png'),
(66, 3, '6a1', 'Perintah Menggunakan Jalur atau Lajur Lalu Lintas Khusus Sepeda Motor', 'uploads/sign/f7a2ba496df8dd5357d84b41b8a3b531.png', 'uploads/sign/thumbs/f7a2ba496df8dd5357d84b41b8a3b531.png'),
(67, 3, '6a2', 'Perintah Menggunakan Jalur atau Lajur Lalu Lintas Khusus Mobil Bus', 'uploads/sign/72c384621d67ef3dd6a504e84f2e7f5b.png', 'uploads/sign/thumbs/72c384621d67ef3dd6a504e84f2e7f5b.png'),
(68, 3, '6b1', 'Perintah Menggunakan Jalur atau Lajur Lalu Lintas Khusus Pejalan Kaki', 'uploads/sign/cc05ab7e9b6229274db3afc319b88a77.png', 'uploads/sign/thumbs/cc05ab7e9b6229274db3afc319b88a77.png'),
(69, 3, '6b3', 'Perintah Menggunakan Jalur atau Lajur Lalu Lintas Khusus Sepeda', 'uploads/sign/d563371fad10a1be4787fd25cb30e1bd.png', 'uploads/sign/thumbs/d563371fad10a1be4787fd25cb30e1bd.png'),
(70, 4, '5a1', 'Petunjuk Lokasi Terminal Kendaraan Bermotor Umum', 'uploads/sign/d1f892566f04d9382028f512f8de272c.png', 'uploads/sign/thumbs/d1f892566f04d9382028f512f8de272c.png'),
(71, 4, '5a2', 'Petunjuk Lokasi Stasiun Kereta Api', 'uploads/sign/4490ec333234f63dd2f8480e8d41aa46.png', 'uploads/sign/thumbs/4490ec333234f63dd2f8480e8d41aa46.png'),
(72, 4, '5a3', 'Petunjuk Lokasi Pelabuhan', 'uploads/sign/3561d29e6f95c9f0a4ee2f3eec3c1ba5.png', 'uploads/sign/thumbs/3561d29e6f95c9f0a4ee2f3eec3c1ba5.png'),
(73, 4, '5a4', 'Petunjuk Lokasi Bandar Udara', 'uploads/sign/106d7992960bbf385d028d0bc42efff4.png', 'uploads/sign/thumbs/106d7992960bbf385d028d0bc42efff4.png'),
(74, 4, '7b', 'Petunjuk Sistem Satu Arah ke Kiri', 'uploads/sign/8c2be8c1fae661ee6fd1ca263c145d23.png', 'uploads/sign/thumbs/8c2be8c1fae661ee6fd1ca263c145d23.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id_user` int(5) NOT NULL,
  `id_posisi` int(5) DEFAULT NULL,
  `username` text CHARACTER SET utf16,
  `password` text CHARACTER SET utf16,
  `nama_petugas` text CHARACTER SET utf16,
  `email` text CHARACTER SET utf16,
  `no_telp` text CHARACTER SET utf16,
  `alamat` text CHARACTER SET utf16,
  `foto` text CHARACTER SET utf16,
  `foto_thumb` text CHARACTER SET utf16,
  `tanggal_user` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reg_id` text CHARACTER SET ucs2
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `id_posisi`, `username`, `password`, `nama_petugas`, `email`, `no_telp`, `alamat`, `foto`, `foto_thumb`, `tanggal_user`, `reg_id`) VALUES
(1, 2, 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 'admin', 'admin2@papb.com', '082923544321', 'sidoarjo, jawa timur', 'uploads/user/19a363d88817cc948ba2fc06cddcb0e6.png', 'uploads/user/thumbs/19a363d88817cc948ba2fc06cddcb0e6.png', '0000-00-00 00:00:00', NULL),
(2, 1, 'roman', '827ccb0eea8a706c4c34a16891f84e7b', 'roman camelo aaa', 'roman@gmail.com', '087233211089', 'mergojoyo ,malang, jawa timur', 'uploads/user/0a0ef21271f9530d341b8a4b20be3afe.jpg', 'uploads/user/thumbs/0a0ef21271f9530d341b8a4b20be3afe.jpg', '0000-00-00 00:00:00', 'cknZJf9Q7m0:APA91bGWuuRUu-_amhoB7qN1X6cn1KQDEIsqg1-88lFY3_CujJJjd0gC-oq9ohFaxjSmWq4jjc5tgsxpMWKul9i-FarUXR4LrWO4r-4TZ-mq84mq1kM3So8S8IS2fh5RvDuwCJ9jmt8H'),
(3, 1, 'walcoot', 'b67d80c4d0c1c3675653b06a0a5b846b', 'walcoot', 'walcoot@gmail.com', '098733244543', 'surabaya, jawa timur', 'uploads/user/2c4d615d6d675a0e5cbc9f31509ec1de.jpg', 'uploads/user/thumbs/2c4d615d6d675a0e5cbc9f31509ec1de.jpg', '0000-00-00 00:00:00', 'dRm52QirD9w:APA91bGKH_sD8FkmOkLiDV4oIco53sVYtoXtUu9-4yfM_qU1tSJIozVyOlbgURtOBQEOzX5YO7K8bB1BWf7MsrfEP9aPemGcyiVAQJgpnzfBRmkzbvNFsHkxZK7pViccWA-KxkL9GeZ6'),
(4, 3, 'ramsey', 'a7aa509c34aad08c76b46bd205955d4b', 'ramsey xa', 'ramsey@gmail.com', '087655433211', 'malang, jawa timur', 'uploads/user/5ed2522b20cd51c74196e836945463d7.jpg', 'uploads/user/thumbs/5ed2522b20cd51c74196e836945463d7.jpg', '0000-00-00 00:00:00', 'cknZJf9Q7m0:APA91bGWuuRUu-_amhoB7qN1X6cn1KQDEIsqg1-88lFY3_CujJJjd0gC-oq9ohFaxjSmWq4jjc5tgsxpMWKul9i-FarUXR4LrWO4r-4TZ-mq84mq1kM3So8S8IS2fh5RvDuwCJ9jmt8H'),
(5, 3, 'giroud', '561f6e33ca3bfe95cdde815c4fb61af7', 'giroud', 'giroud@gmail.com', '085644322112', 'banyuwangi, jawa timur', 'uploads/user/bb8cff47908e23c554e6fb46c19cc374.jpg', 'uploads/user/thumbs/bb8cff47908e23c554e6fb46c19cc374.jpg', '0000-00-00 00:00:00', 'dRm52QirD9w:APA91bGKH_sD8FkmOkLiDV4oIco53sVYtoXtUu9-4yfM_qU1tSJIozVyOlbgURtOBQEOzX5YO7K8bB1BWf7MsrfEP9aPemGcyiVAQJgpnzfBRmkzbvNFsHkxZK7pViccWA-KxkL9GeZ6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_project`
--
ALTER TABLE `data_project`
 ADD PRIMARY KEY (`id_tugas`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
 ADD PRIMARY KEY (`id_projek`);

--
-- Indexes for table `traffic_sign`
--
ALTER TABLE `traffic_sign`
 ADD PRIMARY KEY (`id_rambu`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_project`
--
ALTER TABLE `data_project`
MODIFY `id_tugas` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
MODIFY `id_projek` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `traffic_sign`
--
ALTER TABLE `traffic_sign`
MODIFY `id_rambu` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
